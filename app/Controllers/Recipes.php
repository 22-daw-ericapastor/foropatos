<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Recipes extends controller
{

    /**
     * Get recipes for Home page
     * -----------------------------------------------------------------------------------------------------------------
     * Retrieve all recipes stored in Database to fill the main page. This method is called form Javascript by an AJAX
     * call and it is encoded in .json so it can be read easily.
     */
    function get_recipes(): void
    {
        echo json_encode(['response' => model('Recipes')->get_recipes()]);
    }

    /**
     * Get recipes for Datatable
     * -----------------------------------------------------------------------------------------------------------------
     * Retrieve all recipes in a special format to fill a Datatable in the recipes manage admin page.
     *
     * @return void
     */
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
                // check if title has special chars
                $title = validate($_REQUEST['rcp_title']);
                if (preg_match('/^[A-Za-z ]+$/', $title)) {
                    // Create slug and check it doesn´t repeat
                    $slug = strtolower(str_replace(' ', '-', validate($_REQUEST['rcp_title'])));
                    if (model('Recipes')->get_recipes($slug) === false) {
                        // Upload image and save response
                        $src = $this->upload_image('assets/imgs/recipes/');
                        if (preg_match('/imgs/', $src)) {
                            $params = [
                                'slug' => $slug,
                                'src' => $src,
                                'title' => $title,
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
                    } else {
                        $data['response'] = '<p class="text-danger">Ya hay una receta con ese nombre.</p>';
                    }
                } else {
                    $data['response'] = '<p class="h6 mt-3 text-danger text-center">El título solamente puede contener letras mayúsculas y minúsculas.</p>';
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
                $title = validate($_REQUEST['rcp_title']);
                if (preg_match('/^[A-Za-z ]+$/', $title)) {
                    // declare slug recipe
                    $original_slug = $_REQUEST['updtrcp'];

                    $new_slug = strtolower(str_replace(' ', '-', validate($_REQUEST['rcp_title'])));
                    if ($original_slug !== $new_slug) {
                        if (model('Recipes')->get_recipes($new_slug) !== false) {
                            $data['response'] = '<p class="text-danger">Ya hay una receta con ese nombre.</p>';
                        }
                    }
                    if (!isset($data['response']) && isset($_FILES['full_path'])) {
                        $src = $this->upload_image('/assets/imgs/recipes/');
                        if (!preg_match('/imgs/', $src)) {
                            $data['response'] = $src;
                        }
                    } else {
                        $src = model('Recipes')->get_recipes($original_slug)[0]['src'];
                    }
                    if (!isset($data['response']) && isset($src)) {
                        $params = [
                            'old_slug' => $original_slug,
                            'new_slug' => $new_slug,
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
                    } // here response would be already set
                } else {
                    $data['response'] = '<p class="h6 mt-3 text-danger text-center">El título solamente puede contener letras mayúsculas y minúsculas.</p>';
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