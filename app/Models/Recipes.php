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
                if ($res->num_rows > 0) {
                    $json = [];
                    while ($row = $res->fetch_assoc()) {
                        $json[] = $row;
                    }
                    return $json;
                }
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function rating($slug, $comment_rating): bool
    {
        $rate = $this->get_ratings($slug, $comment_rating);
        $query = "UPDATE $this->table SET ratings=?, points=? WHERE slug=?";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('dds', $rate['ratings'], $rate['points'], $slug);
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function get_ratings($slug, $comment_rating): array
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
        return ['ratings' => $num_ratings, 'points' => $points_media];
    }

    function add_recipe($src, $title, $short_description, $difficulty): bool
    {
        $query = "INSERT INTO $this->table (slug, src, title, short_description, difficulty) VALUES (?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssssi', $slug, $src, $title, $short_description, $difficulty);
            $slug = (strtolower(str_replace(' ', '-', $title)));
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function datatable_recipes()
    {
        $query = "SELECT * FROM $this->table";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->get_result();
            if ($results->num_rows > 0) {
                $json = [];
                while ($row = $results->fetch_assoc()) {
                    $json[] = [
                        'title' => '<div class="username user-cell">' . $row['title'] . '</div>',
                        'update' => $this->format_link('Modificar receta'),
                        'delete' => $this->format_link('Borrar receta'),
                    ];
                }
                return $json;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    function format_link(string $link): string
    {
        return '
            <div class="username user-cell">
                <div class="text-muted text-hover-secondary cursor-pointer toggle-user_active">' . $link . '</div>
            </div>
            ';
    }

}