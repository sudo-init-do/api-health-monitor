<?php

namespace Tests\Feature;

use Tests\TestCase;

class HealthEndpointTest extends TestCase
{
    public function test_health_endpoint_returns_success(): void
    {
        $res = $this->withHeaders([
            'X-API-Key' => env('HEALTH_API_KEY', 'abcd1234'),
            'Accept'    => 'application/json',
        ])->get('/api/health');

        $res->assertOk()
            ->assertJsonPath('status', 'success')
            ->assertJsonPath('data.ok', true);
    }
}
