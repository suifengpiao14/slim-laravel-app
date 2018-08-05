<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4 0004
 * Time: 21:46
 */
return [
    'db'=> [
        'driver'    => 'mysql',
        'host'      => env('DB_HOST','localhost'),
        'database'  => env('DB_DATABASE','test'),
        'username'  => env('DB_USERNAME','root'),
        'password'  => env('DB_PASSWORD',''),
        'charset'   => 'utf8',
        'collation' => 'utf8_unicode_ci',
        'prefix'    => '',
    ],
];