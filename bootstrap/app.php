<?php

use App\Middlewares\Localization;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append([
            Localization::class,
        ]);
        $middleware->web(append: [
            // Web middleware
        ]);

        $middleware->api(append: [
            // API middleware
        ]);

        $middleware->alias([
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
