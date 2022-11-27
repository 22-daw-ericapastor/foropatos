<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Recipes extends model
{

    private string $table = 'recipes';

    function get_recipes($slug = null): ?array
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
                        'slug' => $row['slug'],
                        'src' => $row['src'],
                        'title' => $row['title'],
                        'short_description' => $row['short_description'],
                        'description' => $row['description'],
                    ];
                }
                return $json;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    function add_recipe(array $params): bool
    {
        $query = "INSERT INTO $this->table (slug, src, title, short_description, description) VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('sssss', $param['slug'], $param['src'], $param['title'], $param['short_decription'], $param['description']);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

}