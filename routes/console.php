<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $url = config('app.heartbeat_link');
    if ($url) {
        try {
            $response = Http::get($url);
            $this->info('Heartbeat sent to ' . $url . ': ' . $response->status());
        } catch (\Exception $e) {
            $this->error('Failed to send heartbeat to ' . $url . ': ' . $e->getMessage());
        }
    }
})->everyTwoMinutes();