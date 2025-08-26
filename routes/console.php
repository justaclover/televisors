<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $url = config('app.heartbeat_link');
    $response = Http::get($url);
    if (!$response->json('ok') != true) {
        throw new Exception($response->json('msg'));
    }
})->everyTwoMinutes();

Artisan::command('heartbeat:send', function () {
    $url = config('app.heartbeat_link');
    $response = Http::get($url);

    $this->info($response->body());
});