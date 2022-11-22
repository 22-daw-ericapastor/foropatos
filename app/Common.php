<?php

function template($page, array $data = null)
{
    view('template/header', $data);
    view($page, $data);
    view('template/footer', $data);
}

function view($page, array $data = null)
{
    $file = viewdir . $page . '.php';
    if (is_file($file)) {
        include viewdir . $page . '.php';
    }
}

function model($modelname)
{
    if (is_file(appdir.'Models/' . $modelname . '.php')) {
        $class = '\\Models\\' . $modelname;
        return new $class();
    }
}