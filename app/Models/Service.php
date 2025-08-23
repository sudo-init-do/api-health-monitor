<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name','method','url','headers','body','expected_status','max_latency_ms','cron','enabled'
    ];

    protected $casts = [
        'headers' => 'array',
        'body' => 'array',
        'enabled' => 'boolean',
    ];

    public function checks() { return $this->hasMany(Check::class); }
    public function incidents() { return $this->hasMany(Incident::class); }
}
