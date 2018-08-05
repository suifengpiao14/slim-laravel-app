<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4 0004
 * Time: 21:44
 */

use Interop\Container\ContainerInterface;
use DI\Container;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Http\Headers;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Interfaces\RouterInterface;
return [
    RouterInterface::class  => function (ContainerInterface $c) {
        return $c->get('router');
    },
    ResponseInterface::class => function (Container $c) {
        $headers = new Headers(['Content-Type' => 'application/json; charset=UTF-8']);
        $response = new Response(200, $headers);
        return $response->withProtocolVersion($c->get('settings')['httpVersion']);
    },
    ServerRequestInterface::class => function (Container $c) {
        return Request::createFromEnvironment($c->get('environment'));
    },
];