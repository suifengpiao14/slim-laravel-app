<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\8\4 0004
 * Time: 15:36.
 */

// hello
$app->get('/backend/v1/example/hello', 'App\\Controllers\\Backend\v1\\ExampleController:hello')->setName('example.hello');
