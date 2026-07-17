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

// Charge members who opted into automatic renewal. Runs before the reminders
// below so a member who renews here is no longer nagged to renew by hand.
Schedule::command('membership:auto-renew')
    ->dailyAt('08:45')
    ->withoutOverlapping();

// Email members whose membership is expiring soon (or just expired) once a day.
Schedule::command('membership:send-renewal-reminders')
    ->dailyAt('09:00')
    ->withoutOverlapping();

// Email Vital Boost subscribers whose subscription is due to renew once a day.
Schedule::command('vital-boost:send-renewal-reminders')
    ->dailyAt('09:15')
    ->withoutOverlapping();

Schedule::command('queue:work --stop-when-empty')->everyMinute();
