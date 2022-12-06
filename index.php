<?php

// Require Config file
require_once 'app/Config/Config.php';

// Start session
session_re_start();

// set a timeout

// Use main controller
use \Controllers\BaseController as go;

// Declare route
$route = array_keys($_GET)[0] ?? 'home';

// Go to route
new go($route);

// phpinfo();

// var_dump($_SESSION);
