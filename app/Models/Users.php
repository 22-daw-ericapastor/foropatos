<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Users extends model
{
    /**
     * Database table name
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @var string
     */
    private string $table = 'users';

    /**
     * Insert new user
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $username
     * @param $email
     * @param $passwd
     * @param $permissions
     * @return bool
     */
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

    /**
     * Get user partially
     * -----------------------------------------------------------------------------------------------------------------
     * If password isn't set, returns the number of rows of the result of the username, if it's set and correct, attempts
     * to return some data to later insert it into the @param $username
     * @param $passwd
     * @return array|false|string
     * @link $_SESSION superglobal.
     *
     */
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

    /**
     * Get all parameters from a user
     * -----------------------------------------------------------------------------------------------------------------
     * Attempts to get all parameters from a user, no matter what.
     *
     * @param $username
     * @return array|false|string|null
     */
    function get_all_from_user($username)
    {
        $query = "SELECT * FROM $this->table where username=?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $res = $stmt->get_result();
            if ($res->num_rows === 1) {
                return $res->fetch_assoc();
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    /**
     * Change username
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $old_username
     * @param $new_username
     * @return bool|string
     */
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

    /**
     * Change password
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $username
     * @param $passwd
     * @return bool|string
     */
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

    /**
     * Toggle is_active
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param string $username
     * @param int $is_active
     * @return bool
     */
    function toggle_active(string $username, int $is_active = 0): bool
    {
        try {
            if ($is_active === 0) {
                $query = "UPDATE $this->table SET is_active=?, permissions=? WHERE username=?;";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('iis', $is_active, $is_active, $username);
            } else {
                $query = "UPDATE $this->table SET is_active=? WHERE username=?;";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('is', $is_active, $username);
            }
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    /**
     * Toggle permissions
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param int $permissions
     * @param string $username
     * @return bool|string
     */
    function toggle_permissions(int $permissions, string $username)
    {
        $query = "UPDATE $this->table SET permissions=? WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('is', $permissions, $username);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    /**
     * Delete user
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param string $username
     * @return bool
     */
    function delete_user(string $username): bool
    {
        $query = "DELETE FROM $this->table WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $username);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    /**
     * Get users for Datatable
     * -----------------------------------------------------------------------------------------------------------------
     * Attempts to return an array formatter in HTML with the info of users for a Datatable from Database.
     *
     * @return array|false|string
     */
    function datatable_users()
    {
        $query = "SELECT * from $this->table;";
        try {
            $stmt = $this->conn->prepare($query);
            if ($stmt->execute()) {
                $result = $stmt->get_result();
                $json = [];
                while ($row = $result->fetch_assoc()) {
                    $json[] = [
                        'username' => '<div class="username user-cell">' . $row['username'] . '</div>',
                        'toggle_active' => '<div class="user-cell">' . $this->format_is_active($row['is_active']) . '</div>',
                        'toggle_permissions' => '<div class="user-cell">' . $this->format_permissions($row['permissions']) . '</div>',
                        'delete_user' => '<div class="user-cell">' . $this->format_delete() . '</div>',
                        'is_active' => $row['is_active'],
                        'permissions' => $row['permissions']
                    ];
                }
                return $json;
            }
        } catch (mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

    /**
     * Format is_active cell for Datatable
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $is_active
     * @return string
     */
    function format_is_active($is_active): string
    {
        $status = $is_active === 1 ? "Desactivar" : "Activar";
        $is_active = $is_active === 1 ? '<b class="text-pink">Activo</b>' : '<b class="text-danger">Inactivo</b>';
        return
            '<div class="d-flex justify-content-center align-items-center user-table-option column">' .
            '    <div>' . $is_active . '</div>' .
            '    <div class="text-muted text-hover-secondary cursor-pointer toggle-user_active"">' . $status . '</div>' .
            '</div>';
    }

    /**
     * Format permissions cell for Datatable
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $permissions
     * @return string
     */
    function format_permissions($permissions): string
    {
        $level = $permissions == 1 ? 'Bajar de nivel' : 'Subir de nivel';
        $permissions = $permissions == 1 ? '<b class="text-indigo">Administrador</b>' : '<b class="text-blue">Usuario</b>';
        return
            '<div class="d-flex justify-content-center align-items-center user-table-option column">' .
            '    <div>' . $permissions . '</div>' .
            '    <div class="text-muted text-hover-primary cursor-pointer toggle-user_permissions">' . $level . '</div>' .
            '</div>';
    }

    /**
     * Format delete cell for Datatable
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @return string
     */
    function format_delete(): string
    {
        return
            '<div class="d-flex justify-content-center align-items-center user-table-option">' .
            '    <div>' .
            '        <div class="text-muted text-hover-secondary cursor-pointer delete_user">Eliminar usuario</div>' .
            '    </div>' .
            '</div>';
    }

    /**
     * Count how many admins there are
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @return mixed
     */
    function count_admins()
    {
        $query = "SELECT COUNT(*) from $this->table WHERE permissions=1 GROUP BY username;";
        $stmt = $this->conn->query($query);
        return $stmt->num_rows;
    }

}