<?php

const baseurl = 'http://localhost/web_recetas/public/';
const viewdir = __DIR__ . '/app/Views/';
const appdir = __DIR__ . '/app/';

require_once appdir . 'Config/Config.php';

use \Controllers\BaseController as go;

session_start();

// declare route
$route = array_keys($_GET)[0] ?? 'home';
// session check
if (!isset($_SESSION['user'])) {
    if ($route != 'signin' && $route != 'login') $route = 'login';
} else {
    if ($route == 'login') $route = 'home';
}

// go to route
new go($route);

var_dump($_SESSION);