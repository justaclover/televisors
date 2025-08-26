<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    $url = config('app.heartbeat_link');
    $response = Http::get($url);
    if (!$response->ok()) {
        throw new Exception($response->getStatusCode());
    }
})->everyTwoMinutes();