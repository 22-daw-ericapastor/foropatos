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
        echo json_encode(['response' => model('Recipes')->get_recipes()]);
    }

    function datatable_recipes()
    {
        echo json_encode(['response' => model('Recipes')->datatable_recipes()]);
    }

    /**
     * @return void
     */
    function add_recipe(): void
    {
        $data['page'] = 'addrcp';
        if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1) {
            if (isset($_REQUEST['rcp_title']) && isset($_REQUEST['short_description']) && isset($_REQUEST['difficulty']) && isset($_REQUEST['img_src'])) {
                $data['request'] = $_REQUEST;
                if ($_REQUEST['rcp_title'] !== '' && $_REQUEST['short_description'] !== '' && $_REQUEST['difficulty'] !== '' && $_REQUEST['img_src'] !== '') {
                    $src = $_REQUEST['img_src'];
                    $title = validate($_REQUEST['rcp_title']);
                    $sd = validate($_REQUEST['short_description']);
                    $difficulty = intval($_REQUEST['difficulty']);
                    if (model('Recipes')->add_recipe($src, $title, $sd, $difficulty)) {
                        $data['response'] = '<p class="text-success">¡Se añadió la receta!</p>';
                    } else {
                        $data['response'] = '<p class="text-danger">Hubo un problema interno. Soluciónalo, pendeja.</p>';
                    }
                } else {
                    $data['response'] = '<p class="text-danger">Hay campos vacíos.</p>';
                }
            }
        } else {
            $this->home();
            return;
        }
        template('pages/addrcp', $data);
        var_dump($_REQUEST);
    }

    function recipe_manage()
    {
        // call to get_recipes in Recipes Model
    }

}