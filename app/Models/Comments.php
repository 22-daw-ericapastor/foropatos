<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Comments extends model
{

    private string $table = 'comments';

    public function comment($username, $slug, $rating, $comment): bool
    {
        $query = "INSERT INTO $this->table (username, recipe_slug, recipe_rating, comment_text) VALUES (?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssss', $username, $slug, $rating, $comment);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    public function get_comments($slug)
    {
        $query = "SELECT * FROM $this->table WHERE recipe_slug=?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('s', $slug);
            $stmt->execute();
            $res = $stmt->get_result();
            $results = [];
            while ($row = $res->fetch_assoc()) {
                $results[] = [
                    'username' => utf8_encode($row['username']),
                    'rating' => $row['recipe_rating'],
                    'comment' => utf8_encode($row['comment_text']),
                    'datetime' => utf8_encode($row['date_time'])
                ];
            }
            return $results;
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

}