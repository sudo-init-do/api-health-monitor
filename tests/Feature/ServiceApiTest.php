<?php

namespace Tests\Feature;

use Tests\TestCase;

class ServiceApiTest extends TestCase
{
    public function test_can_create_and_trigger_check(): void
    {
        $res = $this->withHeaders([
            'X-API-Key' => env('HEALTH_API_KEY', 'abcd1234'),
            'Accept'    => 'application/json',
        ])->postJson('/api/services', [
            'name' => 'Demo',
            'method' => 'GET',
            'url' => 'https://jsonplaceholder.typicode.com/todos/1',
            'expected_status' => 200,
            'max_latency_ms' => 1500,
            'cron' => '*/2 * * * *',
            'enabled' => true,
        ]);

        $res->assertCreated()->assertJsonPath('status', 'success');
        $id = $res->json('data.id');

        $res2 = $this->withHeaders([
            'X-API-Key' => env('HEALTH_API_KEY', 'abcd1234'),
            'Accept'    => 'application/json',
        ])->postJson("/api/services/{$id}/check");

        $res2->assertOk()->assertJsonPath('data.queued', true);
    }
}
