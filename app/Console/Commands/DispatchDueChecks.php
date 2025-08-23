<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Service;
use Cron\CronExpression;
use App\Jobs\RunServiceCheck;

class DispatchDueChecks extends Command
{
    protected $signature = 'health:dispatch';
    protected $description = 'Dispatch queued checks for services due by cron expression';

    public function handle(): int
    {
        $now = now();
        Service::where('enabled', true)->get()->each(function ($svc) use ($now) {
            $cron = new CronExpression($svc->cron);
            if ($cron->isDue($now)) {
                RunServiceCheck::dispatch($svc->id);
                $this->info("Queued check for {$svc->name} (#{$svc->id})");
            }
        });

        return self::SUCCESS;
    }
}
