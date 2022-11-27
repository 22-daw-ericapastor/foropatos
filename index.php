<?php

/**
 * Base url constant
 * ---------------------------------------------------------------------------------------------------------------------
 */
const baseurl = 'http://localhost/web_recetas/public/';

/**
 * View directory
 * ---------------------------------------------------------------------------------------------------------------------
 */
const viewdir = __DIR__ . '/app/Views/';

/**
 * App directory
 * ---------------------------------------------------------------------------------------------------------------------
 */
const appdir = __DIR__ . '/app/';

// Require Config file
require_once appdir . 'Config/Config.php';

// Start session
session_start();

// Use main controller
use \Controllers\BaseController as go;

// Declare route
$route = array_keys($_GET)[0] ?? 'home';

// Go to route
new go($route);