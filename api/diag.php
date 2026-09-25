<?php

header('Content-Type: text/plain');

$base = dirname(__DIR__);

$checks = [
    'vendor/autoload.php' => file_exists($base . '/vendor/autoload.php'),
    'bootstrap/app.php' => file_exists($base . '/bootstrap/app.php'),
    'public/video.mp4' => file_exists($base . '/public/video.mp4'),
    'APP_KEY env' => (bool) getenv('APP_KEY'),
];

foreach ($checks as $k => $v) {
    echo $k . ': ' . ($v ? 'YES' : 'NO') . "\n";
}
