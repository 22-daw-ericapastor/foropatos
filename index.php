<?php

const baseurl = 'http://localhost/web_recetas/public/';
const viewdir = __DIR__ . '/app/Views/';
const appdir = __DIR__ . '/app/';

require_once appdir . 'Common.php';
require_once appdir . 'Controllers/BaseController.php';
require_once appdir . 'Models/BaseModel.php';

use \Controllers\BaseController as go;

// declare route
$route = array_keys($_GET)[0] ?? 'home';
// session check
if (!isset($_SESSION['id_user'])) {
    if ($route != 'signin' && $route != 'login') $route = 'login';
} else {
    if ($route == 'login') $route = 'home';
}

// go to route
new go($route);