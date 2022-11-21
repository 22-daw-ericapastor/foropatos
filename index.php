<?php

const baseurl = 'http://localhost/web_recetas/public/';

const publicdir = __DIR__ . '/public/';

const viewdir = __DIR__ . '/app/Views/';

const appdir = __DIR__ . '/app/';

require appdir . 'Common.php';

// session check

if (!isset($_SESSION['id_user'])) {

    template('login', ['title' => 'Home']);

}