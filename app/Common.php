<?php

function template($page, array $data = null)
{
    if (!is_file(viewdir . $page . '.php')) {
        $page = 'pages/home';
    }
    view('templates/header', $data);
    view($page, $data);
    view('templates/footer', $data);
}

function view($page, array $data = null)
{
    $file = viewdir . $page . '.php';
    if (is_file($file)) {
        include $file;
    }
}

function model($class)
{
    if (is_file(appdir . 'Models/' . $class . '.php')) {
        $model = '\\Models\\' . $class;
        return new $model();
    }
    return false;
}

function controller($class)
{
    if (is_file(appdir . 'Controllers/' . $class . '.php')) {
        $controller = '\\Controllers\\' . $class;
        return new $controller();
    }
    return false;
}

function validate(string $str): string
{
    return trim(htmlspecialchars($str));
}

function session_re_start()
{
    if (isset($_SESSION)) {
        session_unset();
        session_destroy();
    }
    session_start();
}