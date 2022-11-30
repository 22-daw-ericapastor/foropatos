<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Messages extends model
{

    private string $table = 'messages';

    function msg_is_read($is_read, $username, $slug): bool
    {
        $query = "UPDATE $this->table SET is_read=? WHERE username=? AND issue_slug=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('iss', $is_read, $username, $slug);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function send_message($username, $issue, $text): bool
    {
        $query = "INSERT INTO $this->table (username, issue, issue_slug, msg_text) VALUES (?, ?, ?, ?);";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssss', $username, $issue, $issue_slug, $text);
            $issue_slug = strtolower(str_replace(' ', '-', $issue));
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function get_messages()
    {
        $query = "SELECT * FROM $this->table";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();
            $json = [];
            while ($row = $res->fetch_assoc()) {
                $json[] = [
                    'username' => '<div class="msg-container remitter">' . utf8_encode($row['username']) . '</div>',
                    'title' => '<div class="msg-container">' . $this->format_msg(utf8_encode($row['issue'])) . '</div>',
                    'slug' => $row['issue_slug'],
                    'datetime' => '<div class="msg-container">' . utf8_encode($row['date_time']) . '</div>',
                    'msg_text' => '<div class="msg-container">' . utf8_encode($row['msg_text']) . '</div>',
                    'toggle_read' => '<div class="msg-container">' . $this->format_isread() . '</div>',
                    'is_read' => $row['is_read']
                ];
            }
            return $json;
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function format_msg($issue): string
    {
        return '<div class="table-message-container">' .
            '       <button class="btn btn-primary toggle-msg">' . $issue . '</button>' .
            '    </div>';
    }

    function format_isread(): string
    {
        return '
        <div class="d-flex justify-content-center align-items-center">' .
            '<div class="d-flex justify-content-center align-items-center">' .
            '    <button class="rounded-circle btn p-1 toggle-is_read"></button>' .
            '</div>
        </div>';
    }

}