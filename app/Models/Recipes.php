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
                        'description' => $row['description'],
                        'admixtures' => $row['admixtures'],
                        'making' => $row['making'],
                        'ratings' => $row['ratings'] ?? 0,
                        'points' => $row['points'] ?? 0,
                        'difficulty' => $row['difficulty']
                    ];
                }
                return $json;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return null;
    }

    function rating($slug, $rating): bool
    {
        echo $rating;
        $recipe = $this->get_recipes($slug);
        $ratings = $recipe[0]['ratings'] ?? 0;
        if (isset($recipe[0]['points'])) $old_points = $recipe[0]['ratings'] * $ratings;
        else $old_points = 0;
        $ratings++;
        echo "$ratings<br>";
        $new_points = $old_points + $rating;
        echo "$new_points<br>";
        $new_points = $new_points / $ratings;
        echo "$new_points<br>";
        $query = "UPDATE $this->table SET ratings=?, points=? WHERE slug=?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('dds', $ratings, $new_points, $slug);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
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