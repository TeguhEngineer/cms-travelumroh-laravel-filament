<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Routing\Middleware\ThrottleRequests;

$trustedProxies = array_values(
    array_filter(
        array_map(
            "trim",
            explode(",", (string) env("TRUSTED_PROXIES", "127.0.0.1")),
        ),
    ),
);

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . "/../routes/web.php",
        api: __DIR__ . "/../routes/api.php",
        commands: __DIR__ . "/../routes/console.php",
        health: "/up",
    )
    ->withMiddleware(function (Middleware $middleware) use ($trustedProxies) {
        // The app sits behind Nginx (and possibly Cloudflare) on the VPS, so
        // forwarded headers must be trusted. Without this, Laravel thinks every
        // request is plain HTTP and generates http:// asset and redirect URLs,
        // which browsers block as mixed content on the HTTPS Netlify frontend.
        $middleware->trustProxies(at: $trustedProxies ?: null);

        $middleware->api(
            prepend: [HandleCors::class],
            append: [ThrottleRequests::class . ":api"],
        );
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->create();
