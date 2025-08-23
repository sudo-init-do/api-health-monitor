<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('services', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->string('method')->default('GET'); // GET/POST
            $t->string('url');
            $t->json('headers')->nullable();
            $t->json('body')->nullable(); // for POST or query params
            $t->unsignedSmallInteger('expected_status')->default(200);
            $t->unsignedInteger('max_latency_ms')->default(1500);
            $t->string('cron')->default('*/5 * * * *'); // every 5 minutes
            $t->boolean('enabled')->default(true);
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
