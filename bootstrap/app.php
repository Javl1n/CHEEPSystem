<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserIsVerified;
use App\Http\Middleware\UserIsUnverified;
use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\UserIsStudent;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user-verified' => UserIsVerified::class,
            'admin' => UserIsAdmin::class,
            'student' => UserIsStudent::class,
            'user-unverified' => UserIsUnverified::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
