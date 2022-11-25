<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Recipes extends model
{

    private string $table = 'recipes';

    function get_recipes($slug = null)
    {
        try {
            if (isset($slug)) {
                $query = "SELECT * FROM $this->table WHERE slug=?";
                $stmt = $this->conn->prepare($query);
                $stmt->bind_param('s', $slug);
            } else {
                $query = "SELECT * FROM $this->table";
                $stmt = $this->conn->prepare($query);
            }
            $stmt->execute();
            if ($res = $stmt->get_result()) {
                $json = [];
                while ($row = $res->fetch_assoc()) {
                    $json[] = [
                        'slug' => utf8_encode($row['slug']),
                        'src' => utf8_encode($row['src']),
                        'title' => utf8_encode($row['title']),
                        'short_description' => utf8_encode($row['short_description']),
                        'description' => utf8_encode($row['description']),
                    ];
                }
                return $json;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
    }
}