<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\UserIsVerified;
use App\Http\Middleware\UserIsUnverified;
use App\Http\Middleware\UserIsNotRestricted;
use App\Http\Middleware\UserIsRestricted;
use App\Http\Middleware\UserIsAdmin;
use App\Http\Middleware\UserIsStudent;
use App\Http\Middleware\UserIsTeacher;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'user-verified' => UserIsVerified::class,
            'user-unverified' => UserIsUnverified::class,
            'unrestricted' => UserIsNotRestricted::class,
            'restricted' => UserIsRestricted::class,
            'admin' => UserIsAdmin::class,
            'student' => UserIsStudent::class,
            'teacher' => UserIsTeacher::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
