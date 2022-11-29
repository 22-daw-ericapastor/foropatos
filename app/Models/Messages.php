<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Messages extends model
{

    private string $table = 'messages';

    function get_messages($username)
    {
        $query = "SELECT * FROM $this->table WHERE username=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $username);
            $stmt->execute();
            $res = $stmt->get_result();
            $json = [];
            while ($row = $res->fetch_assoc()) {
                $json[] = [
                    'username' => utf8_encode($row['username']),
                    'msg' => $this->format_msg(utf8_encode($row['issue']), utf8_encode($row['msg_text'])),
                    'datetime' => utf8_encode($row['date_time']),
                    'is_read' => $this->format_isread($row['is_read'])
                ];
            }
            return $json;
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function send_message($username, $issue, $text): bool
    {
        $query = "INSERT INTO $this->table (username, issue, msg_text) VALUES (?, ?, ?);";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sss', $username, $issue, $text);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function format_msg($issue, $msg): string
    {
        return '<div class="table-message-container">' .
            '       <button class="btn btn-primary toggle-msg">' . $issue . '</button>' .
            '       <div class="collapse table-msg_text">' . $msg . '</div>' .
            '    </div>';
    }

    function format_isread($is_read): string
    {
        $read = '';
        if ($is_read === 0) {
            $read = '<div class="d-flex justify-content-center align-items-center">' .
                '       <button class="rounded-circle btn btn-danger p-1">&#x2715;</button>' .
                '  </div>';
        } else {
            $read = '<div class="d-flex justify-content-center align-items-center">' .
                '       <button class="rounded-circle btn btn-light p-1">&#x2713;</button>' .
                '  </div>';
        }
        return '<div class="d-flex justify-content-center align-items-center"><span>' . $read . '</span></div>';
    }

}