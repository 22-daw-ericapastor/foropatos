<?php

namespace Models;

use mysqli_sql_exception;

class BaseModel
{

    protected $conn;
    private string $host = '127.0.0.1';
    private string $user = 'root';
    private string $passwd = '';
    private string $db = 'foropatos';

    /**
     * All the children of this class will receive {@link $conn} and will be able to access Database by only creating
     * an object of those classes.
     */
    function __construct()
    {
        try {
            $this->conn = mysqli_connect($this->host, $this->user, $this->passwd, $this->db);
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }

}
