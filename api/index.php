<?php

/*
 * Vercel serverless entrypoint: forward all requests to Laravel's front controller.
 */

// Serverless filesystem is read-only except /tmp — make sure compiled views have a home.
if (! is_dir('/tmp/views')) {
    @mkdir('/tmp/views', 0755, true);
}

// vercel.json "env" is ignored for functions, so serverless-safe defaults live here.
// Real environment variables (Vercel dashboard) always win via the getenv() check.
foreach ([
    'APP_ENV' => 'production',
    'APP_DEBUG' => 'false',
    'LOG_CHANNEL' => 'stderr',
    'SESSION_DRIVER' => 'array',
    'CACHE_DRIVER' => 'array',
    'VIEW_COMPILED_PATH' => '/tmp',
] as $key => $value) {
    if (getenv($key) === false) {
        putenv($key . '=' . $value);
        $_ENV[$key] = $value;
        $_SERVER[$key] = $value;
    }
}

require __DIR__ . '/../public/index.php';
