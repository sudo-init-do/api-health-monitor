<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Models\Service;

class CheckController extends Controller
{
    use RespondsWithJson;

    public function index(Service $service)
    {
        $checks = $service->checks()
            ->latest()
            ->paginate(10) // keep pagination small for demo
            ->through(function ($check) {
                return [
                    'id'         => $check->id,
                    'status'     => $check->status,         // success/failed
                    'http_code'  => $check->http_status,    // 200, 500, etc.
                    'latency_ms' => $check->latency_ms,
                    'error'      => $check->error,
                    'created_at' => $check->created_at,
                ];
            });

        return $this->paginated($checks);
    }
}
