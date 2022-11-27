<?php

// Require common functions file
require_once appdir . 'Common.php';

/**
 * Files in Controllers folder
 * ---------------------------------------------------------------------------------------------------------------------
 */
$controllers = scandir(appdir . 'Controllers');

// Require each controller
foreach ($controllers as $controller) {
    if ($controller !== '.' && $controller !== '..') {
        require_once appdir . 'Controllers/' . $controller;
    }
}

/**
 * Files in the Models folder
 * ---------------------------------------------------------------------------------------------------------------------
 */
$models = scandir(appdir . 'Models');

// Require each model
foreach ($models as $model) {
    if ($model !== '.' && $model !== '..') {
        require_once appdir . 'Models/' . $model;
    }
}
