<?php

use App\Http\Middleware\EncryptCookies;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->validateCsrfTokens(except: [
            'admin/*',
        ]);
        $middleware->encryptCookies(except: ['device_id',]);
    })
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(append: [
            HandleInertiaRequests::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
//        $exceptions->render(function (\League\Flysystem\CorruptedPathDetected $exception) {
//            return redirect()->back()->withCookie(cookie(''));
//        });
//        $exceptions->render(function (\Symfony\Component\HttpFoundation\File\Exception\FileException $exception) {
//            return redirect()->back();
//        });
    })->create();

