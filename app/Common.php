<?php

function template($page, array $data = null)
{
    view('header', $data);
    view($page);
    view('footer');
}

function view($page, array $data = null)
{
    include viewdir . "$page.php";
}