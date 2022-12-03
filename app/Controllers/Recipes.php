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
        // Check the user is logged
        if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1) {
            // Check the fields exist by checking the clicked button
            if (isset($_REQUEST['addrcp'])) {
                // Check fields are not empty
                // Upload image and save response
                $src = $this->upload_image('assets/imgs/recipes/');
                if (preg_match('/imgs/', $src)) {
                    $params = [
                        'src' => $src,
                        'title' => validate($_REQUEST['rcp_title']),
                        'description' => validate($_REQUEST['description']),
                        'admixtures' => validate($_REQUEST['admixtures']),
                        'making' => validate($_REQUEST['making']),
                        'difficulty' => intval($_REQUEST['difficulty'])
                    ];
                    if (model('Recipes')->add_recipe($params)) {
                        $data['response'] = '<p class="text-success">¡Se añadió la receta!</p>';
                    } else {
                        $data['response'] = '<p class="text-danger">Hubo un problema interno. Soluciónalo, pendeja.</p>';
                    }
                } else {
                    $data['response'] = $src;
                }
            } // No {else} here, this if is set for when the page is loaded for the first time
        } else {
            // User is not signed in
            $this->home();
            return;
        }
        template('pages/addrcp', $data);
    }

    function updt_rcp()
    {
        $data['page'] = 'recipe_manage';
        // Check the user is signed in
        if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1) {
            if (isset($_REQUEST['updtrcp'])) { // this checks that the button submit was pressed
                $src = null;
                if ($_FILES['full_path']) {
                    $src = $this->upload_image('/assets/imgs/recipes/');
                    if (!preg_match('/imgs/', $src)) {
                        $data['response'] = $src;
                    }
                } else {
                    $src = model('Recipes')->get_recipes($_REQUEST['updtrcp'])[0]['src'];
                }
                if (!$data['response'] && isset($src)) {
                    $params = [
                        'slug' => $_REQUEST['updtrcp'],
                        'src' => $src,
                        'title' => validate($_REQUEST['rcp_title']),
                        'description' => validate($_REQUEST['description']),
                        'admixtures' => validate($_REQUEST['admixtures']),
                        'making' => validate($_REQUEST['making']),
                        'difficulty' => intval($_REQUEST['difficulty'])
                    ];
                    if (model('Recipes')->updt_rcp($params)) {
                        $data['response'] = '<p class="text-success">¡Se actualizó la receta!</p>';
                    } else {
                        $data['response'] = '<p class="text-danger">Hubo un problema interno. Avisa a Effy, o déjalo.</p>';
                    }
                }
            } // No {else} here, bc it means the page was loaded for the first time
        } else {
            // User is not signed in, redirect home
            $this->home();
            return;
        }
        template('pages/recipe.manage', $data);
    }

    function delete_recipe()
    {
        if (isset($_GET['delete_recipe']) && $_GET['delete_recipe'] != '') {
            if (model('Recipes')->delete_recipe($_GET['delete_recipe'])) {
                echo '<p class="text-success">Receta eliminada.</p>';
            } else {
                echo '<p class="text-danger">Algo fue mal, no se pudo eliminar la receta.</p>';
            }
        } else {
            echo '<p class="text-danger">Algo fue mal, faltan datos.</p>';
        }
    }

    function recipe_manage()
    {
        // call to get_recipes in Recipes Model
    }

}