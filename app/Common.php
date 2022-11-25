<?php

function template($page, array $data = null)
{
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

function model($modelname)
{
    if (is_file(appdir . 'Models/' . $modelname . '.php')) {
        $class = '\\Models\\' . $modelname;
        return new $class();
    }
}

function validate(string $str): string
{
    return trim(htmlspecialchars($str));
}