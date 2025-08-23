<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('health:dispatch')->everyMinute()->withoutOverlapping();

        // Housekeeping: prune old checks (keep 14 days)
        $schedule->call(function () {
            \App\Models\Check::where('created_at', '<', now()->subDays(14))->delete();
        })->dailyAt('00:30');
    }
}
