<?php

defined('ROOT_PATH') or define('ROOT_PATH', realpath(dirname(__FILE__)));
$autoload = ROOT_PATH . '/vendor/autoload.php';
if (is_file($autoload)) {
    require $autoload;
}

use Magma\Application\Application;
use Magma\Session\SessionManager;

$app = new Application(ROOT_PATH);

/*
var_dump($_SERVER);
die();
*/

$app->run()
->setSession()
->setRouteHandler();
//BJR ->setRouteHandler(trim($_SERVER['REQUEST_URI'], '/'));
//BJR Dit was ->setRouteHandler($_SERVER['QUERY_STRING']);