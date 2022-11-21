<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Users extends model
{

    private string $table = 'usuarios';

    function new_user($username, $email, $passwd, $permissions = null)
    {
        if (!isset($permissions)) $permissions = 0;
        $query = "INSERT INTO $this->table (username, email, passwd, permisos) VALUES (?, ?, ?, ?);";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssi', $username, $email, $passwd, $permissions);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }
}