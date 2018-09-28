<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018\8\4 0004
 * Time: 15:51.
 */

namespace App\Controllers;

use Slim\Container;

/**
 * Class Controller.
 */
class Controller
{
    protected $container = null;

    public function __construct(Container $container = null)
    {
        $this->container = $container;
    }
}
