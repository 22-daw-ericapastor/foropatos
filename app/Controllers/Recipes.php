<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Recipes extends controller
{

    /**
     * Retrieve all recipes stored in Database to fill the main page.
     */
    function get_recipes(): void
    {
        echo json_encode(model('Recipes')->get_recipes());
    }

    /**
     * @return void
     */
    function add_recipe(): void
    {
        if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1) {
            $params = [
                'slug' => validate($_GET['slug']),
                'src' => $_GET['src'],
                'title' => validate($_GET['title']),
                'short_description' => validate($_GET['short_description']),
                'description' => validate('description')
            ];
            if (model('Recipes')->add_recipe($params)) {
                echo json_encode(['response' => true]);
            } else {
                echo json_encode(['response' => false]);
            }
        }
    }

}