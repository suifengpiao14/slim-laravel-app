<?php

// DIC configuration

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------

// Api View.
$container['view'] = function ($c) {
    // Simple Content Negotiation (json and xml).
    $defaultMediaType = 'application/json';
    $outputParam = 'output';
    $checkHeader = true;

    return new \App\Renders\ApiView($defaultMediaType, $outputParam, $checkHeader);
};

// Database.
$container['db'] = function ($c) {
    $config = $c->get('settings')['db'];
    $driver = $config['driver'];
    $host = $config['host'];
    $port = $config['port'];
    $database = $config['database'];
    $user = $config['username'];
    $password = $config['password'];
    $charset = $config['charset'];
    $debug = $c->get('settings')['debug'];
    $dsn = isset($port)
        ? "{$driver}:host={$host};port={$port};dbname={$database};charset={$charset}"
        : "{$driver}:host={$host};dbname={$database};charset={$charset}";

    try {
        $pdo = new \PDO($dsn, $user, $password);
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        // If you want to use a Repository.
        //$apiRepo = new \App\Db\ApiRepository($pdo, $debug);
        //$apiRepo->appRouter = $c->get('router');
        //return $apiRepo;
        return $pdo;
    } catch (\PDOException $e) {
        throw $e;
    }
};

$container['cache'] = function ($c) {
    if (APP_ENV_DEV) {//开发环境使用虚拟缓存
        return new \Symfony\Component\Cache\Adapter\NullAdapter();
    }
    $config = $c->get('settings')['redis'];
    $redis = new \Redis();
    $redis->connect($config['host'], $config['port'], 2); //2秒连接不上就报错
    $config['password'] and $redis->auth($config['password']);

    return new Symfony\Component\Cache\Adapter\RedisAdapter($redis);
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// Monolog.
$container['logger'] = function ($c) {
    $config = $c->get('settings')['logger'];
    $logger = new \Monolog\Logger($config['name']);
    $formatter = new \Monolog\Formatter\LineFormatter(
        "[%datetime%] [%level_name%]: %message% %context%\n",
        null,
        true,
        true
    );
    /* Log to timestamped files */
    $rotating = new \Monolog\Handler\RotatingFileHandler($config['path'], 0, \Monolog\Logger::DEBUG);
    $rotating->setFormatter($formatter);
    $logger->pushHandler($rotating);

    return $logger;
};

// -----------------------------------------------------------------------------
// Error Handlers
// -----------------------------------------------------------------------------

// Override the default Error Handler. To trap PHP Exceptions.
$container['errorHandler'] = function ($c) {
    return new \App\Handlers\ApiError($c['view'], $c['logger'], $c->get('settings')['displayErrorDetails']);
};

// Override the default error handler for PHP 7+ Throwables.
$container['phpErrorHandler'] = function ($c) {
    return new \App\Handlers\ApiPhpError($c['view'], $c['logger'], $c->get('settings')['displayErrorDetails']);
};

// Override the default 404 Not Found Handler.
$container['notFoundHandler'] = function ($c) {
    return new \App\Handlers\ApiNotFound($c['view']);
};

// Override the default 405 Not Allowed Handler
$container['notAllowedHandler'] = function ($c) {
    return new \App\Handlers\ApiNotAllowed($c['view']);
};
// add 400
$container['invalidArgumentHandler'] = function ($c) {
    return new \App\Handlers\ApiInvalidArgument($c['view']);
};

