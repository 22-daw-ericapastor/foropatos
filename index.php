<?php

const baseurl = 'http://localhost/web_recetas/public/';
const viewdir = __DIR__ . '/app/Views/';
const appdir = __DIR__ . '/app/';

require_once appdir . 'Config/Config.php';

use \Controllers\BaseController as go;

session_start();

// declare route
$route = array_keys($_GET)[0] ?? 'home';

// go to route
new go($route);

echo password_hash('druid', PASSWORD_DEFAULT);