<?php

namespace Models;

use \Models\BaseModel as model;

class DeletedUsers extends model
{
    /**
     * Database table name
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @var string
     */
    private string $table = 'deleted_users';

    /**
     * Insert a deleted user
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param array $user
     * @return bool
     */
    function insert(array $user): bool
    {
        $query = "INSERT INTO $this->table (username, email, passwd, permissions) values (?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssi', $username, $email, $passwd, $permissions);
            $username = $user['username'];
            $email = $user['email'];
            $passwd = $user['passwd'];
            $permissions = $user['permissions'];
            if ($stmt->execute()) {
                return true;
            }
        } catch (\mysqli_sql_exception $e) {
            return $e->getMessage();
        }
        return false;
    }

}