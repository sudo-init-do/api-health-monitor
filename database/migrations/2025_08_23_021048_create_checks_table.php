<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('checks', function (Blueprint $t) {
            $t->id();
            $t->foreignId('service_id')->constrained()->cascadeOnDelete();
            $t->timestamp('started_at')->nullable();
            $t->timestamp('finished_at')->nullable();
            $t->unsignedInteger('latency_ms')->nullable();
            $t->unsignedSmallInteger('http_status')->nullable();
            $t->boolean('ok')->default(false);
            $t->string('status')->default('queued'); // queued|running|success|failed
            $t->text('error')->nullable();
            $t->json('response')->nullable(); // trimmed body/headers
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checks');
    }
};
