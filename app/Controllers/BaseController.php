<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4 0004
 * Time: 20:12
 */

namespace App\Controllers;

use Slim\Router;
use Slim\Http\Request;
use Slim\Http\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
class BaseController
{
    /**
     * @var Router
     */
    protected $router;
    /**
     * @var Response
     */
    protected $response;
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Router $router, ResponseInterface $response, ServerRequestInterface $request)
    {
        $this->router = $router;
        $this->response = $response;
        $this->request = $request;
    }

}