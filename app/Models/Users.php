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
        $query = "SELECT * FROM $this->table where username=?";
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
                            'is_active' => $result['is_active'],
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

    function get_users()
    {
        $query = "SELECT * from $this->table;";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $json = [];
                while ($row = $result->fetch_assoc()) {
                    $json[] = [
                        'username' => $row['username'],
                        'is_active' => $this->format_is_active($row['is_active']),
                        'permissions' => $this->format_permissions($row['permissions']),
                        'toggle_active' => $row['is_active'],
                        'toggle_permissions' => $row['permissions']
                    ];
                }
                return $json;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    function change_username($old_username, $new_username)
    {
        $query = "UPDATE $this->table SET username=? WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ss', $new_username, $old_username);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    function change_passwd($username, $passwd)
    {
        $query = "UPDATE $this->table SET passwd=? WHERE username=?;";
        try {
            $passwd = password_hash($passwd, PASSWORD_DEFAULT);
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ss', $passwd, $username);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    function acc_deactivate($username): bool
    {
        $query = "UPDATE $this->table SET is_active=? WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('is', $is_active, $username);
            $is_active = 0;
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    function format_is_active($is_active): string
    {
        $active = $is_active == 1 ? "Si" : "No";
        $status = $is_active === 1 ? "Desactivar" : "Activar";
        return '
        <div class="d-flex justify-content-center align-items-center user-table-option">' .
            '<div class="user_active">' . $active . '</div>' .
            '<div><button type="button" class="btn btn-primary toggle-user_active"">' .
            $status .
            '</button></div>' .
            '</div>
        ';
    }

    function format_permissions($permissions): string
    {
        $typeofuser = $permissions == 1 ? 'Administrador' : 'Ususario';
        $level = $permissions == 1 ? 'Bajar de nivel' : 'Subir de nivel';
        return '
        <div class="d-flex justify-content-center align-items-center user-table-option">' .
            '<div class="col-4 text-end user_permissions">' . $typeofuser . '</div>' .
            '  <div><button type="button" class="btn btn-primary toggle-user_permissions">' . $level . '</button></div>' .
            '</div>
        ';
    }

    function toggle_active($is_active, $username)
    {
        $query = "INSERT INTO $this->table SET is_active=? WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('is', $is_active, $username);
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    function toggle_permissions($permissions, $username)
    {
        $query = "INSERT INTO $this->table SET permissions=? WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('is', $permissions, $username);
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

}