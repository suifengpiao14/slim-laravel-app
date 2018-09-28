<?php

$appEnv = $_SERVER['APP_ENV'] ?? 'prod';
defined('APP_ENV') or define('APP_ENV', $appEnv);
defined('APP_ENV_DEV') or define('APP_ENV_DEV', 'dev' == $appEnv);
defined('APP_ENV_TEST') or define('APP_ENV_TEST', 'test' == $appEnv);
defined('APP_ENV_PROD') or define('APP_ENV_PROD', 'prod' == $appEnv || !$appEnv);

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH.'/vendor/autoload.php';

/**
 * 加载环境变量.
 */
$envFile = '.env';
// 开发、测试环境加载对应的环境变量文件
APP_ENV_PROD or $envFile = $envFile.'.'.$appEnv;
$dotenv = new Dotenv\Dotenv(__DIR__.'/../', $envFile);
$dotenv->load();

// Timezone.
date_default_timezone_set(env('TIMEZONE', 'Asia/Shanghai'));
// Encoding.
mb_internal_encoding('UTF-8');

// Instantiate the app.
$settings = require BASE_PATH.'/config/settings.php';
$app = app($settings);

$container = container($app);
// Set up dependencies.
require BASE_PATH.'/config/dependencies.php';

// Register middleware.
require BASE_PATH.'/config/middleware.php';

// Register routes.
require BASE_PATH.'/routes/api.php';
require BASE_PATH.'/routes/backend.php';
