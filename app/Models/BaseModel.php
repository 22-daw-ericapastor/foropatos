<?php

namespace Models;

class BaseModel
{

    protected $conn;
    private string $host = '127.0.0.1';
    private string $user = 'root';
    private string $passwd = '';
    private string $db = 'web_recetas';

    function __construct()
    {
        try {
            $this->conn = mysqli_connect($this->host, $this->user, $this->passwd, $this->db);
        } catch (\mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }

}
