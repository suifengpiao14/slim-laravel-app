<?php

return [
    // Slim Settings.
    // 'httpVersion' => '1.1',
    // 'responseChunkSize' => 4096,
    // 'outputBuffering' => 'append',
    // 'determineRouteBeforeAppMiddleware' => false,
    'displayErrorDetails' => env('APP_DEBUG', false),
    // 'addContentLengthHeader' => true,
    'routerCacheFile' => env('APP_ROUTER_CACHE', false) ? BASE_PATH.'/storage/cache/routes/routes.cache' : false,
    'app_url' => 'http://domain.com', //网站链接地址，发送邮件内容含绝对地址

    // DB settings.
    'db' => [
        'driver' => env('DB_CONNECTION', 'mysql'),
        'host' => env('DB_HOST', 'localhost'),
        'port' => env('DB_PORT', 3306),
        'database' => env('DB_DATABASE', ''),
        'username' => env('DB_USERNAME', ''),
        'password' => env('DB_PASSWORD', ''),
        'charset' => env('DB_CHARSET', 'utf8'),
        'collation' => env('DB_COLLATION', 'utf8_unicode_ci'),
        'prefix' => env('DB_PREFIX', ''),
    ],
    'redis' => [
        'host' => env('REDIS_HOST', '127.0.0.1'),
        'port' => env('REDIS_PORT', 6379),
        'password' => env('REDIS_PASSWORD', null),
    ],
    // Monolog settings
    'logger' => [
        'name' => 'api-logger',
        'path' => BASE_PATH.'/storage/logs/'.date('Ymd').'.log',
    ],
];
