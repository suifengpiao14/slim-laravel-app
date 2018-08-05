<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/8/4 0004
 * Time: 21:11
 */
use Dotenv\Dotenv;
use App\App;
use Illuminate\Database\Capsule\Manager as Capsule;
use Noodlehaus\Config;
session_start();
require __DIR__ . '/../vendor/autoload.php';
//Gestion des variables d'environnement
$dotenv = new Dotenv(__DIR__ . '/../');
$dotenv->load();
$app = new App();
$container = $app->getContainer();
$config = new Config(__DIR__ . '/../config/database.php');
$db = $config->get('db');
// Gestion de la base de donnees avec Eloquent
$capsule = new Capsule();
$capsule->addConnection($db);
$capsule->setAsGlobal();
$capsule->bootEloquent();
require __DIR__ . '/../routes/api.php';
