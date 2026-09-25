<?php

/*
 * Vercel serverless entrypoint: forward all requests to Laravel's front controller.
 */

// Serverless filesystem is read-only except /tmp — make sure compiled views have a home.
if (! is_dir('/tmp/views')) {
    @mkdir('/tmp/views', 0755, true);
}

require __DIR__ . '/../public/index.php';
