<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Comments extends model
{

    /**
     * Database table name
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @var string
     */
    private string $table = 'comments';

    /**
     * Insert comment
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $username
     * @param $slug
     * @param $rating
     * @param $comment
     * @return bool
     */
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

    /**
     * Get a comment from a user
     * -----------------------------------------------------------------------------------------------------------------
     * If any coincidences found, it will return true, otherwise false.
     *
     * @param $username
     * @param $slug
     * @return bool
     */
    public function get_comment($username, $slug): bool
    {
        $query = "SELECT * FROM $this->table WHERE username=? AND recipe_slug=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ss', $username, $slug);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Get all comments from Database.
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @param $slug
     * @return array|false
     */
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
                    'username' => $row['username'],
                    'rating' => $row['recipe_rating'],
                    'comment' => $row['comment_text'],
                    'datetime' => $row['date_time']
                ];
            }
            return $results;
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

}