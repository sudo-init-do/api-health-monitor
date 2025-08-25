<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>API Health Monitor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Arial,sans-serif;margin:2rem;background:#0b1220;color:#e6edf3}
    .wrap{max-width:980px;margin:0 auto}
    .card{background:#111a2b;border:1px solid #1e2a42;border-radius:12px;padding:16px;margin-bottom:12px}
    .row{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap}
    .badge{padding:.2rem .5rem;border-radius:999px;font-size:.8rem}
    .ok{background:#043c2e;color:#7ee787;border:1px solid #155e52}
    .down{background:#3c0912;color:#ff7b72;border:1px solid #6e1423}
    .muted{color:#9da7b3}
    a{color:#7aa7ff;text-decoration:none}
    small{color:#9da7b3}
  </style>
</head>
<body>
<div class="wrap">
  <h1>API Health Monitor</h1>
  <p class="muted">Simple cron + queue based monitoring with incidents & Slack alerts.</p>

  @forelse($services as $svc)
  @php
    $last = $svc->checks->first();
    $incident = $svc->incidents->first();
    $ok = $last?->ok ?? false;
  @endphp

  <div class="card">
    <div class="row">
      <div>
        <h3 style="margin:.2rem 0">{{ $svc->name }}</h3>
        <small>{{ $svc->method }} — <a href="{{ $svc->url }}" target="_blank">{{ $svc->url }}</a></small>
        <div class="muted" style="margin-top:.3rem">
          Expected: {{ $svc->expected_status }}, SLO: ≤ {{ $svc->max_latency_ms }}ms, Cron: {{ $svc->cron }}
        </div>
      </div>
      <div>
        @if($last)
          @if($ok)
            <span class="badge ok">Healthy</span>
          @else
            <span class="badge down">Fail</span>
          @endif
        @else
          <span class="badge muted">No checks yet</span>
        @endif
      </div>
    </div>

    <div class="row" style="margin-top:.5rem">
      <div>
        <small>Last check:
          @if($last)
            status {{ $last->http_status ?? 'n/a' }},
            {{ $last->latency_ms ?? 'n/a' }}ms,
            {{ $last->finished_at?->diffForHumans() ?? 'pending' }}
          @else
            none
          @endif
        </small>
      </div>
      <div>
        <small>Incident:
          @if($incident && $incident->state === 'open')
            OPEN — {{ $incident->opened_at->diffForHumans() }} — {{ \Illuminate\Support\Str::limit($incident->last_error, 60) }}
          @else
            none
          @endif
        </small>
      </div>
    </div>
  </div>
  @empty
  <div class="card">
    <p>No services yet. Create one via API then refresh.</p>
  </div>
  @endforelse
</div>
</body>
</html>
