<?php

$allowedOrigins = array_values(
    array_filter(
        array_map(
            "trim",
            explode(
                ",",
                (string) env(
                    "CORS_ALLOWED_ORIGINS",
                    "https://travelumroh-v1.netlify.app,http://localhost:8080,http://localhost:8081,http://localhost:5173",
                ),
            ),
        ),
    ),
);

return [
    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | The public API is consumed by the Netlify-hosted frontend, so the browser
    | origin must be explicitly allowed. Override CORS_ALLOWED_ORIGINS in .env
    | (comma separated) without touching this file, e.g.
    |
    |   CORS_ALLOWED_ORIGINS="https://travelumroh-v1.netlify.app,https://asellatravel.id"
    |
    */

    "paths" => ["api/*"],

    "allowed_methods" => ["GET", "HEAD", "OPTIONS"],

    "allowed_origins" => $allowedOrigins,

    "allowed_origins_patterns" => [
        // Netlify branch & deploy preview URLs for this site
        "#^https://([a-z0-9-]+--)?travelumroh-v1\.netlify\.app$#",
    ],

    "allowed_headers" => ["*"],

    "exposed_headers" => [
        "X-RateLimit-Limit",
        "X-RateLimit-Remaining",
        "Retry-After",
    ],

    "max_age" => 86400,

    "supports_credentials" => false,
];
