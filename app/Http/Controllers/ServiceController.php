<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    use RespondsWithJson;

    public function index()
    {
        return $this->paginated(Service::latest()->paginate(20));
    }

    public function store(Request $r)
    {
        $data = $r->validate([
            'name'            => 'required|string|max:120',
            'method'          => 'in:GET,POST',
            'url'             => 'required|url',
            'headers'         => 'array',
            'body'            => 'array',
            'expected_status' => 'integer|min:100|max:599',
            'max_latency_ms'  => 'integer|min:1|max:60000',
            'cron'            => 'required|string',
            'enabled'         => 'boolean',
        ]);
        $service = Service::create($data);
        return $this->created($service);
    }

    public function show(Service $service) { return $this->ok($service); }

    public function update(Request $r, Service $service)
    {
        $service->update($r->all());
        return $this->ok($service->fresh());
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return $this->ok(null);
    }
}
