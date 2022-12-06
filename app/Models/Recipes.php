<?php

namespace Models;

use \Models\BaseModel as model;
use mysqli_sql_exception;

class Recipes extends model
{
    /**
     * Database table name
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @var string
     */
    private string $table = 'recipes';

    /**
     * Get all recipes in raw
     * -----------------------------------------------------------------------------------------------------------------
     * Attempts to return a raw array from the {@link fetch_assoc()} method.
     *
     * @param $slug
     * @return array|false
     */
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

    /**
     * Get all recipes for Datatable
     * -----------------------------------------------------------------------------------------------------------------
     * Attempts to return an HTML formatted array with the recipes info for a Datatable.
     *
     * @return array|false
     */
    function datatable_recipes()
    {
        $query = "SELECT * FROM $this->table ORDER BY uploaded_date DESC;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $results = $stmt->get_result();
            if ($results->num_rows > 0) {
                $json = [];
                while ($row = $results->fetch_assoc()) {
                    $json[] = [
                        'title' => '<div class="username user-cell">' . $row['title'] . '</div>',
                        'update' => '<div class="user-cell">' .
                            '            <button class="btn btn-primary py-2 update_recipe" type="button" data-bs-target="#modal" data-bs-toggle="modal">' .
                            '                Editar receta' .
                            '            </button>' .
                            '        </div>',
                        'delete' => '<div class="user-cell"><a class="text-secondary text-hover-secondary cursor-pointer delete_recipe">Borrar receta</a></div>',
                        'slug' => $row['slug'],
                        'description' => $row['description'],
                        'difficulty' => $row['difficulty'],
                        'making' => $row['making'],
                        'admixtures' => $row['admixtures'],
                        'src' => $row['src'],
                    ];
                }
                return $json;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Update rating
     * -----------------------------------------------------------------------------------------------------------------
     * It makes a calculation to update the rating by calling {@link get_ratings} and then attempts to update the Database.
     *
     * @param $slug
     * @param $comment_rating
     * @return bool
     */
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

    /**
     * Calculate new rating
     * -----------------------------------------------------------------------------------------------------------------
     * @param $slug
     * @param $comment_rating
     * @return array
     */
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

    /**
     * Insert a recipe
     * -----------------------------------------------------------------------------------------------------------------
     * @param $params
     * @return bool
     */
    function add_recipe($params): bool
    {
        $query = "INSERT INTO $this->table (slug, src, title, description, admixtures, making, difficulty) VALUES (?, ?, ?, ?, ?, ?, ?)";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssssssi', $slug, $src, $title, $description, $admixtures, $making, $difficulty);
            $src = $params['src'];
            $title = $params['title'];
            $description = $params['description'];
            $admixtures = $params['admixtures'];
            $making = $params['making'];
            $difficulty = $params['difficulty'];
            $slug = $params['slug'];
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Update a recipe
     * -----------------------------------------------------------------------------------------------------------------
     * @param $params
     * @return bool
     */
    function updt_rcp($params): bool
    {
        $query = "UPDATE $this->table SET slug=?, src=?, title=?, description=?, admixtures=?, making=?, difficulty=? WHERE slug=?;";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bind_param('ssssssis', $new_slug, $src, $title, $description, $admixtures, $making, $difficulty, $old_slug);
            $new_slug = $params['new_slug'];
            $src = $params['src'];
            $title = $params['title'];
            $description = $params['description'];
            $admixtures = $params['admixtures'];
            $making = $params['making'];
            $difficulty = $params['difficulty'];
            $old_slug = $params['old_slug'];
            if ($stmt->execute()) {
                return true;
            }
        } catch (mysqli_sql_exception $e) {
            echo $e->getMessage();
        }
        return false;
    }

    /**
     * Delete a recipe
     * -----------------------------------------------------------------------------------------------------------------
     * @param $slug
     * @return bool
     */
    function delete_recipe($slug): bool
    {
        $query = "DELETE FROM $this->table WHERE slug=?;";
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

}