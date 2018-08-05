<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4 0004
 * Time: 21:31
 */

namespace App;


use DI\Bridge\Slim\App as DIBridge;
use DI\ContainerBuilder;

class App extends DIBridge{
    protected function configureContainer(ContainerBuilder $builder) {
        $builder->addDefinitions([
            'settings.displayErrorDetails' => true,
        ]);
        $builder->addDefinitions(__DIR__.'/../config/container.php');
    }
}