<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public API Rate Limiting
    |--------------------------------------------------------------------------
    |
    | The API is public and unauthenticated, so requests are throttled per IP.
    | The limit is generous enough for normal browsing (the frontend fires
    | around 8 requests per page view) while still protecting the VPS and the
    | database from abuse.
    |
    */

    "rate_limit" => (int) env("API_RATE_LIMIT", 120),

];
