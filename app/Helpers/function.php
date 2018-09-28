<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\8\4 0004
 * Time: 16:03.
 */
function app($config = null, $container = [])
{
    static $app = null;
    if (is_null($app)) {
        $container['settings'] = $config;
        $app = new \Slim\App($container);
    }

    return $app;
}

function container()
{
    static $container = null;
    if (is_null($container)) {
        $container = app()->getContainer();
    }

    return $container;
}

function service($name)
{
    return container()->get($name);
}

function settings($key)
{
    static $settings = null;
    if (is_null($settings)) {
        $settings = container()->get('settings');
    }

    return $settings[$key] ?? null;
}

function responseSuccess(Slim\Http\Response $response, $data = [])
{
    $data = [
        'message' => 'ok',
        'status_code ' => 0,
        'data' => $data,
    ];

    return $response->withJson($data, 200);
}

function responseSuccessMessage(Slim\Http\Response $response, $message = 'ok', $statusCode = 1)
{
    $data = [
        'message' => $message,
        'status_code' => $statusCode,
        'data' => null,
    ];

    return $response->withJson($data, 200);
}

/**
 * 统一返回参数错误格式.
 *
 * @param $message
 * @param int   $errorCode
 * @param array $data
 * @SuppressWarnings(PHPMD)
 *
 * @return static
 */
function responseErrorWithParameter($message, $errorCode = 400, $data = null)
{
    $response = new Slim\Http\Response(400); //http code 统一返回400
    $data = [
        'message' => $message,
        'error_code' => $errorCode,
        'data' => $data,
    ];

    return $response->withJson($data)->withStatus(400, $message);
}

function getClientIp()
{
    if (env('HTTP_CLIENT_IP') && strcasecmp(env('HTTP_CLIENT_IP'), 'unknown')) {
        $clientIp = env('HTTP_CLIENT_IP');
    } elseif (env('HTTP_X_FORWARDED_FOR') && strcasecmp(env('HTTP_X_FORWARDED_FOR'), 'unknown')) {
        $clientIp = env('HTTP_X_FORWARDED_FOR');
    } elseif (env('REMOTE_ADDR') && strcasecmp(env('REMOTE_ADDR'), 'unknown')) {
        $clientIp = env('REMOTE_ADDR');
    } else {
        $clientIp = '';
    }

    return $clientIp;
}

/**
 * @param $key
 * @param int|string $expired  int标识缓存多久，string标识缓存到的时间点
 * @param Closure    $callback
 *
 * @return mixed
 */
function remember($key, $expired, Closure $callback)
{
    static $cache = null;
    if (is_null($cache)) {
        /** @var \Symfony\Component\Cache\Adapter\RedisAdapter $cache */
        $cache = app()->getContainer()->get('cache');
    }
    /** @var \Symfony\Component\Cache\CacheItem $cacheItem */
    $cacheItem = $cache->getItem($key);
    if (!$cacheItem->isHit()) {
        $result = $callback();
        if (is_int($expired)) {//$expired为时间差
            $cacheItem->expiresAfter($expired);
        } else {
            $expiration = new \DateTime($expired); //设置时间点过期
            $cacheItem->expiresAt($expiration);
        }
        $cacheItem->set($result);
        $cache->save($cacheItem);
    }
    $output = $cacheItem->get();

    return $output;
}

function web_path()
{
    return root_path().DIRECTORY_SEPARATOR.'public';
}

function root_path()
{
    return __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'..';
}

function app_path()
{
    return root_path().DIRECTORY_SEPARATOR.'app';
}

function config_path()
{
    return root_path().DIRECTORY_SEPARATOR.'config';
}

function storage_path()
{
    return root_path().DIRECTORY_SEPARATOR.'storage';
}
function logs_path()
{
    return storage_path().DIRECTORY_SEPARATOR.'logs';
}
function cache_path()
{
    return storage_path().DIRECTORY_SEPARATOR.'cache';
}

function source_path()
{
    return root_path().DIRECTORY_SEPARATOR.'resources';
}
function view_path()
{
    return source_path().DIRECTORY_SEPARATOR.'views';
}

/**
 * 拼接文件路径.
 *
 * @return string
 */
function get_dir()
{
    return implode(DIRECTORY_SEPARATOR, func_get_args());
}

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);

        if (false === $value) {
            return value($default);
        }
        $value = trim($value, '"\'');
        $lowerValue = strtolower($value);
        $map = [
            'true' => true,
            '(true)' => true,
            'false' => false,
            '(false)' => false,
            'empty' => '',
            '(empty)' => '',
            'null' => null,
            '(null)' => null,
        ];
        if (isset($map[$lowerValue])) {
            return $map[$lowerValue];
        }

        return $value;
    }
}

if (!function_exists('value')) {
    /**
     * Return the default value of the given value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    function value($value)
    {
        return $value instanceof Closure ? $value() : $value;
    }
}

/**
 * 根据parse_url格式的数组生成完整的url.
 *
 * @param string|array      $url
 * @param string|array|null $parts
 * @SuppressWarnings(PHPMD)
 *
 * @return string
 */
function http_build_url($url = null, $parts = null)
{
    is_string($url) and $url = parse_url($url);
    is_string($parts) and parse_str($parts, $parts);
    if (isset($url['query']) && isset($parts['query'])) {//query部分做二级合并
        is_string($url['query']) and parse_str($url['query'], $url['query']);
        is_string($parts['query']) and parse_str($parts['query'], $parts['query']);
        $url['query'] = array_merge((array) $url['query'], (array) $parts['query']);
        unset($parts['query']);
    }
    $urlArr = array_merge((array) $url, (array) $parts);
    $output = strtr('{scheme}://{host}{port}{path}{query}{fragment}', [
        '{scheme}' => $urlArr['scheme'] ?? 'http',
        '{host}' => $urlArr['host'] ?? '',
        '{port}' => isset($urlArr['port']) && '80' != $urlArr['port'] ? ':'.$urlArr['port'] : '',
        '{path}' => $urlArr['path'] ?? '',
        '{query}' => isset($urlArr['query']) ? '?'.http_build_query($urlArr['query']) : '',
        '{fragment}' => isset($urlArr['fragment']) ? '#'.$urlArr['fragment'] : '',
    ]);

    return $output;
}

//创建一个GUID(全局唯一标识符)
function create_guid()
{
    if (function_exists('com_create_guid')) {
        return com_create_guid();
    } else {
        mt_srand((float) microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45); // "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid, 12, 4).$hyphen
            .substr($charid, 16, 4).$hyphen
            .substr($charid, 20, 12);

        return $uuid;
    }
}
