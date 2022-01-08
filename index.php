<?php
session_start();
require __DIR__ . '/vendor/autoload.php';
use Config\Db;

//  require_once 'config/db.php';
use Route\Route;

//define controller and action
$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'index';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

//завантажуємо об’єкт роутінга
$routing = new Route();
//завантажуємо об'єкт моделі
$db = new Db();

$routing->loadPage($db, $controllerName, $actionName);
