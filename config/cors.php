<?php
return [

    /*
    |----------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |----------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],  // Enable CORS for API routes and CSRF cookie route

    'allowed_methods' => ['*'],  // Allow all HTTP methods (GET, POST, etc.)

    'allowed_origins' => ['*'],  // L'origine du frontend

    'allowed_origins_patterns' => [],  // Optional pattern matching (empty for now)

    'allowed_headers' => ['*'],  // Allow all headers (Content-Type, Authorization, etc.)

    'exposed_headers' => [],  // Optional headers to expose to JavaScript (leave empty if not needed)

    'max_age' => 0,  // Cache duration for CORS preflight request (set to 0 if you want no caching)

    'supports_credentials' => true,   // Allow cookies and credentials to be sent with requests

];
