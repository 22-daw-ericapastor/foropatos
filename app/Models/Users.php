<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Users extends model
{

    private string $table = 'users';

    function new_user($username, $email, $passwd, $permissions = null): bool
    {
        if (!isset($permissions)) $permissions = 0;
        $query = "INSERT INTO $this->table (username, email, passwd, permissions) VALUES (?, ?, ?, ?);";
        try {
            $passwd = password_hash($passwd, PASSWORD_DEFAULT);
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
        $query = "SELECT * FROM $this->table WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $res = $stmt->get_result();
            if (!isset($passwd)) {
                return $res->num_rows;
            } else {
                if ($res->num_rows === 1) {
                    $result = $res->fetch_assoc();
                    if (password_verify($passwd, $result['passwd'])) {
                        return [
                            'username' => $result['username'],
                            'email' => $result['email'],
                            'permissions' => $result['permissions']
                        ];
                    }
                }
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

}