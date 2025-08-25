<?php

use Illuminate\Support\Facades\Route;
use App\Models\Service;

Route::get('/', function () {
    $services = Service::with(['checks' => fn($q) => $q->latest()->limit(1),
                               'incidents' => fn($q) => $q->latest()->limit(1)])
                        ->latest()->get();

    return view('dashboard', compact('services'));
});
