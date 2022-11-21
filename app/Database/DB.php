<?php

class DB
{

    private $conn;
    private string $db = '';
    private string $host = '127.0.0.1';
    private string $user = 'root';
    private string $passwd = '';
    private array $tables = ['usuarios', 'recetas'];

    function __construct()
    {

    }

}
