<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Messages extends model
{

    private string $table = 'messages';

    function get_messages($username): ?array
    {
        $query = "SELECT * FROM $this->table WHERE remitter=? OR receiver=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ss', $username, $username);
            $stmt->execute();
            $res = $stmt->get_result();
            $json = [];
            while ($row = $res->fetch_assoc()) {
                $json[] = [
                    'remitter' => utf8_encode($row['remitter']),
                    'receiver' => utf8_encode($row['receiver']),
                    'msg_text' => utf8_encode($row['msg_text']),
                    'datetime' => utf8_encode($row['date_time'])
                ];
            }
            return $json;
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    function message($username, $issue, $text)
    {

    }

}