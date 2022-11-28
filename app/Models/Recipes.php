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

    function rating($slug, $comment_rating): bool
    {
        // get the recipe from database
        $recipe = $this->get_recipes($slug);
        // get the number of ratings that the recipe has already
        $num_ratings = $recipe[0]['ratings'] ?? 0;
        // get the points that it has, this is a media of points / ratings
        $points_media = $recipe[0]['points'] ?? 0;
        // the old points
        $old_points = $points_media * $num_ratings;
        // summ 1 to the ratings that the recipe has
        $num_ratings++;
        // calculate the new points
        $new_points = $old_points + $comment_rating;
        // calculate the new media of points / ratings
        $points_media = $new_points / $num_ratings;
        $query = "UPDATE $this->table SET ratings=?, points=? WHERE slug=?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('dds', $num_ratings, $points_media, $slug);
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