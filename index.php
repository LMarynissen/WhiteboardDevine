<?php
session_start();


define('DS', DIRECTORY_SEPARATOR);
define('WWW_ROOT', __DIR__ . DS);

$routes = array(
    'home' => array(
        'controller' => 'Projects',
        'action' => 'index'
    ),
    'detail' => array(
        'controller' => 'Projects',
        'action' => 'view'
    ),
    'add' => array(
        'controller' => 'Projects', 
        'action' => 'add'
    ),
    'addItem' => array(
        'controller' => 'Projects', 
        'action' => 'addItem'
    ),
    'delete' => array(
        'controller' => 'Projects', 
        'action' => 'delete'
    ),
    'deleteItem' => array(
        'controller' => 'Projects', 
        'action' => 'deleteItem'
    ),
    'moveItem' => array(
        'controller' => 'Projects', 
        'action' => 'moveItem'
    ),
    'invitePerson' => array(
        'controller' => 'Users', 
        'action' => 'invitePerson'
    ),
    'register' => array(
        'controller' => 'Users',
        'action' => 'register'
    ),
    'login' => array(
        'controller' => 'Users',
        'action' => 'login'
    ),
    'logout' => array(
        'controller' => 'Users',
        'action' => 'logout'
    ),
);

if(empty($_GET['page'])) {
    $_GET['page'] = 'home';
}
if(empty($routes[$_GET['page']])) {
    header('Location: index.php');
    exit();
}

$route = $routes[$_GET['page']];
$controllerName = $route['controller'] . 'Controller';

require_once WWW_ROOT . 'controller' . DS . $controllerName . ".php";

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();