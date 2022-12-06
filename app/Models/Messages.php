<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Messages extends model
{
    /**
     * Database table name
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @var string
     */
    private string $table = 'messages';

    /**
     * Toggle message is_read
     * -----------------------------------------------------------------------------------------------------------------
     * See {@link \Controllers\Messages { msg_is_read()} }
     *
     * @param $is_read
     * @param $username
     * @param $slug
     * @return bool
     */
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

    /**
     * Insert message
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $username
     * @param $issue
     * @param $text
     * @return bool
     */
    function send_message($username, $issue, $text): bool
    {
        $query = "INSERT INTO $this->table (username, issue, issue_slug, msg_text) VALUES (?, ?, ?, ?);";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssss', $username, $issue, $slug, $text);
            $slug = (strtolower(str_replace(' ', '-', $issue)));
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Delete message
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $slug
     * @return bool
     */
    function delmsg($slug): bool
    {
        $query = "DELETE FROM $this->table WHERE issue_slug=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $slug);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Get all messages
     * -----------------------------------------------------------------------------------------------------------------
     * The array with the data is formatted in a specific way to be read from Javascript and fit into a CSS style.
     * See: {@link format_msg()} and {@link format_isread()}.
     *
     * @return array|false
     */
    function get_messages()
    {
        $query = "SELECT * FROM $this->table ORDER BY date_time DESC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $res = $stmt->get_result();
            $json = [];
            while ($row = $res->fetch_assoc()) {
                $json[] = [
                    'username' => '<div class="msg-container remitter">' . ($row['username']) . '</div>',
                    'title' => '<div class="msg-container">' . $this->format_msg(($row['issue'])) . '</div>',
                    'slug' => $row['issue_slug'],
                    'datetime' => '<div class="msg-container">' . ($row['date_time']) . '</div>',
                    'msg_text' => '<div class="msg-container">' . ($row['msg_text']) . '</div>',
                    'toggle_read' => '<div class="msg-container">' . $this->format_isread() . '</div>',
                    'is_read' => $row['is_read'],
                    'delete' => '<div class="msg-container"><div class="btn btn-danger del_msg-btn">Borrar</div></div>'
                ];
            }
            return $json;
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Format HTML message title container
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $issue
     * @return string
     */
    function format_msg($issue): string
    {
        return '<div class="table-message-container">' .
            '       <button class="btn btn-primary toggle-msg">' . $issue . '</button>' .
            '    </div>';
    }

    /**
     * Format HTML button to toggle is_read
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @return string
     */
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