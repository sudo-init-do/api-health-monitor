<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Check extends Model
{
    protected $fillable = [
        'service_id','started_at','finished_at','latency_ms','http_status','ok','status','error','response'
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'finished_at'=> 'datetime',
        'ok' => 'boolean',
        'response' => 'array',
    ];

    public function service() { return $this->belongsTo(Service::class); }
}
