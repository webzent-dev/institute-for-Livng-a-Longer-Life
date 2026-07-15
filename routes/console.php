<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('shipping:test-shippo', function () {
    $this->info('Testing Shippo API integration...');
    // This will be handled by the TestShippoIntegration command
})->purpose('Test Shippo API integration');

// Email members whose membership is expiring soon (or just expired) once a day.
Schedule::command('membership:send-renewal-reminders')
    ->dailyAt('09:00')
    ->withoutOverlapping();

// Email Vital Boost subscribers whose subscription is due to renew once a day.
Schedule::command('vital-boost:send-renewal-reminders')
    ->dailyAt('09:15')
    ->withoutOverlapping();
