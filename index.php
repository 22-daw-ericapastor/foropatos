<?php

const baseurl = 'http://localhost/web_recetas/public/';

const publicdir = __DIR__ . '/public/';

const viewdir = __DIR__ . '/app/Views/';

const appdir = __DIR__ . '/app/';

require appdir . 'Common.php';

$route = array_keys($_GET)[0] ?? 'home';

// session check
if (!isset($_SESSION['id_user'])) {

    if ($route != 'session_signin' && $route != 'session_login') $route = 'session_login';

} else {

    if ($route == 'login') $route = 'home';

}

template($route, ['title' => $route]);