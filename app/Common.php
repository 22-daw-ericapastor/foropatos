<?php

function template($page, array $data = null)
{
    view('header', $data);
    view($page);
    view('footer');
}

function view($page, array $data = null)
{
    $file = viewdir . $page . '.php';
    if (is_file($file)) {
        include viewdir . $page . '.php';
    }
}