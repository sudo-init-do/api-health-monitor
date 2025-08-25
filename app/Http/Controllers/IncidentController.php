<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\RespondsWithJson;
use App\Models\Service;

class IncidentController extends Controller
{
    use RespondsWithJson;

    public function index(Service $service)
    {
        $incidents = $service->incidents()
            ->latest()
            ->paginate(10)
            ->through(function ($incident) {
                return [
                    'id'              => $incident->id,
                    'status'          => $incident->status,
                    'error'           => $incident->last_error,
                    'downtime_seconds'=> $incident->downtime_seconds,
                    'opened_at'       => $incident->opened_at,
                    'resolved_at'     => $incident->resolved_at,
                ];
            });

        return $this->paginated($incidents);
    }
}
