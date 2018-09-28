<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\8\4 0004
 * Time: 15:51.
 */

namespace App\Controllers\Api\v1;

use App\Controllers\Controller;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Container;

/**
 * Class ExampleController.
 *
 * @SuppressWarnings(PHPMD)
 */
class ExampleController extends Controller
{

    public function __construct(Container $container = null)
    {
        parent::__construct($container);
    }

    public function index(Request $request, Response $response)
    {
        $message="hello world";
        return $response->write($message);
    }
}
