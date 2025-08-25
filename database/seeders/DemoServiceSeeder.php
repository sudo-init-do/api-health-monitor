<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class DemoServiceSeeder extends Seeder
{
    public function run(): void
    {
        Service::firstOrCreate(
            ['url' => 'https://jsonplaceholder.typicode.com/todos/1'],
            [
                'name' => 'JSONPlaceholder',
                'method' => 'GET',
                'expected_status' => 200,
                'max_latency_ms' => 1500,
                'cron' => '*/2 * * * *', // every 2 minutes
                'enabled' => true,
            ]
        );
    }
}
