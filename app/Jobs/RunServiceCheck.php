<?php

namespace App\Jobs;

use App\Models\Service;
use App\Models\Check;
use App\Models\Incident;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\{InteractsWithQueue, SerializesModels};
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class RunServiceCheck implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 15;

    public function __construct(public int $serviceId) {}

    public function handle(): void
    {
        $service = Service::findOrFail($this->serviceId);

        $check = Check::create([
            'service_id' => $service->id,
            'started_at' => now(),
            'status'     => 'running',
        ]);

        $t0 = microtime(true);

        try {
            $req = Http::timeout(15)->withHeaders($service->headers ?? []);
            $resp = match (strtoupper($service->method)) {
                'POST' => $req->post($service->url, $service->body ?? []),
                default => $req->get($service->url, $service->body ?? []),
            };

            $latency = (int) round((microtime(true) - $t0) * 1000);
            $okStatus = (int)$resp->status() === (int)$service->expected_status;
            $okLatency = $latency <= (int)$service->max_latency_ms;
            $passed = $okStatus && $okLatency;

            $check->update([
                'finished_at' => now(),
                'latency_ms'  => $latency,
                'http_status' => $resp->status(),
                'ok'          => $passed,
                'status'      => $passed ? 'success' : 'failed',
                'response'    => [
                    'headers' => $resp->headers(),
                    'body'    => Str::limit($resp->body(), 2000, '…'),
                ],
            ]);

            $this->updateIncidentState($service, $passed, $resp->status(), null);
            if (!$passed) {
                throw new \RuntimeException("SLO failure (status/latency).");
            }

        } catch (\Throwable $e) {
            $latency = (int) round((microtime(true) - $t0) * 1000);
            $check->update([
                'finished_at' => now(),
                'latency_ms'  => $latency,
                'status'      => 'failed',
                'error'       => $e->getMessage(),
            ]);

            $this->updateIncidentState($service, false, $check->http_status, $e->getMessage());
            throw $e;
        }
    }

    protected function updateIncidentState(Service $service, bool $passed, ?int $status, ?string $error): void
    {
        $open = Incident::where('service_id', $service->id)->where('state', 'open')->first();

        if ($passed) {
            if ($open) {
                $open->update([
                    'state' => 'resolved',
                    'resolved_at' => now(),
                    'downtime_seconds' => $open->opened_at->diffInSeconds(now()),
                ]);
                $this->notify("✅ RESOLVED: {$service->name}", "Back healthy. Status {$service->expected_status}, latency ≤ {$service->max_latency_ms}ms.");
            }
            return;
        }

        if (!$open) {
            Incident::create([
                'service_id' => $service->id,
                'state'      => 'open',
                'opened_at'  => now(),
                'last_error' => $error,
            ]);
            $msg = "❌ DOWN: {$service->name}\nURL: {$service->url}\nStatus: ".($status ?? 'n/a')."\nError: ".($error ?? 'n/a');
            $this->notify("Incident opened", $msg);
        } else {
            $open->update(['last_error' => $error]);
        }
    }

    protected function notify(string $title, string $text): void
    {
        $hook = config('services.alerts.slack_webhook');
        if ($hook) {
            try {
                Http::timeout(5)->post($hook, ['text' => "*{$title}*\n{$text}"]);
            } catch (\Throwable $e) {
                // ignore alert errors
            }
        }
    }
}
