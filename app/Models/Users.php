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

    function get_user($username, $passwd = null)
    {
        if (!isset($passwd)) {
            $query = "SELECT * FROM $this->table WHERE username=?;";
            try {
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('ss', $username);
                $stmt->execute();
                return $stmt->num_rows();
            } catch (mysqli_sql_exception $e) {
                echo $e->getMessage();
            }
        } else {
            $query = "SELECT * FROM $this->table WHERE username=? AND passwd=?;";
            try {
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('ss', $username, $passwd);
                $stmt->execute();
                if ($stmt->num_rows() == 1) {
                    $res = $stmt->get_result();
                    var_dump($res->fetch_assoc());
                    return $res->fetch_assoc();
                }
            } catch (mysqli_sql_exception $e) {
                echo $e->getMessage();
            }
        }
        return false;
    }

}