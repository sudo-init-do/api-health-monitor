<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = ['service_id','state','opened_at','resolved_at','last_error','downtime_seconds'];

    protected $casts = [
        'opened_at' => 'datetime',
        'resolved_at'=> 'datetime',
    ];

    public function service() { return $this->belongsTo(Service::class); }
}
