<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\CheckController;
use App\Http\Controllers\IncidentController;
use App\Jobs\RunServiceCheck;

Route::get('/health', function () {
    return response()->json([
        'status'    => 'success',
        'timestamp' => now()->toIso8601String(),
        'data'      => ['ok' => true],
    ]);
});

Route::middleware('api.key')->group(function () {
    // Services CRUD
    Route::apiResource('services', ServiceController::class)
        ->only(['index','store','show','update','destroy']);

    // Trigger a one-off check for a service
    Route::post('/services/{service}/check', function (\App\Models\Service $service) {
        RunServiceCheck::dispatch($service->id);

        return response()->json([
            'status'    => 'success',
            'timestamp' => now()->toIso8601String(),
            'data'      => [
                'queued'     => true,
                'service_id' => $service->id,
            ],
        ]);
    });

    // Checks & Incidents listing
    Route::get('/services/{service}/checks', [CheckController::class, 'index']);
    Route::get('/services/{service}/incidents', [IncidentController::class, 'index']);
});
