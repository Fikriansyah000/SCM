<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Service Extension Auto-Approval
|--------------------------------------------------------------------------
|
| Process pending service extensions every 15 minutes. Extensions that
| have been pending for 24 hours without buyer response will be
| automatically approved.
|
*/
Schedule::command('services:process-extensions')
    ->everyFifteenMinutes()
    ->withoutOverlapping()
    ->appendOutputTo(storage_path('logs/extensions.log'));
