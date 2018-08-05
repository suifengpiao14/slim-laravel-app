<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/7/29 0029
 * Time: 13:43
 */

require '../vendor/autoload.php';

date_default_timezone_set("Asia/Shanghai");
defined("APP_ENV") or define("APP_ENV",$_SERVER['APP_ENV']??'prod');

define('ROOT',__DIR__);
require __DIR__ . '/../bootstrap/app.php';
$app->run();

