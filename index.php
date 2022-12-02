<?php

/**
 * Base url
 * ---------------------------------------------------------------------------------------------------------------------
 */
const baseurl = 'http://localhost/foropatos/public/';

/**
 * Public directory
 * ---------------------------------------------------------------------------------------------------------------------
 */
const publicdir = __DIR__ . '/public/';

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

/**
 * Time out for session
 * ---------------------------------------------------------------------------------------------------------------------
 */
const timeout = 300; // time is in seconds

// Require Config file
require_once appdir . 'Config/Config.php';

// Start session
session_re_start();

// Use main controller
use \Controllers\BaseController as go;

// Declare route
$route = array_keys($_GET)[0] ?? 'home';

// Go to route
new go($route);

// phpinfo();

// var_dump($_SESSION);