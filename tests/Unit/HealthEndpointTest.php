<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthEndpointTest extends TestCase
{
    public function test_api_health_returns_success(): void
    {
        $res = $this->withHeaders([
            'X-API-Key' => env('HEALTH_API_KEY', 'abcd1234'),
            'Accept'    => 'application/json',
        ])->get('/api/health');

        $res->assertOk()
            ->assertJsonStructure(['status', 'timestamp', 'data' => ['ok']]);
    }
}
