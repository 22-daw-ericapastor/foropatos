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
            // Check the fields exist
            if (isset($_REQUEST['rcp_title']) && isset($_REQUEST['description']) && isset($_REQUEST['difficulty']) && isset($_FILES['img_src'])) {
                // Check fields are not empty
                if ($_REQUEST['rcp_title'] !== '' && $_REQUEST['description'] !== '' && $_REQUEST['difficulty'] !== '') {
                    $recipesdir = 'assets/imgs/recipes/';
                    $target_dir = publicdir . $recipesdir; // need the final slash or else it uploads in the parent directory
                    // Check file is an image
                    if (getimagesize($_FILES["img_src"]["tmp_name"]) !== false) {
                        // Check if file already exists
                        $target_file = $target_dir . basename($_FILES["img_src"]["name"]);
                        if (!file_exists($target_file)) {
                            // Check file size
                            if ($_FILES["img_src"]["size"] < 500000) {
                                // Check file format
                                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                                    // Everything is ok at this point -> try to upload the file
                                    if (move_uploaded_file($_FILES['img_src']['tmp_name'], $target_file)) {
                                        // Here the image is uploaded
                                        $src = $recipesdir . basename($_FILES["img_src"]["name"]);
                                        $title = validate($_REQUEST['rcp_title']);
                                        $description = validate($_REQUEST['description']);
                                        $difficulty = intval($_REQUEST['difficulty']);
                                        if (model('Recipes')->add_recipe($src, $title, $description, $difficulty)) {
                                            $data['response'] = '<p class="text-success">¡Se añadió la receta!</p>';
                                        } else {
                                            $data['response'] = '<p class="text-danger">Hubo un problema interno. Soluciónalo, pendeja.</p>';
                                        }
                                    } else {
                                        $data['response'] = '<p class="text-danger">La imagen no se ha podido subir. Problema interno.</p>';
                                    }
                                } else {
                                    $data['response'] = '<p class="text-danger">Solo se admiten imágenes PNG, JPEG o JPG.</p>';
                                }
                            } else {
                                $data['response'] = '<p class="text-danger">La imagen es demasiado grande.</p>';
                            }
                        } else {
                            $data['response'] = '<p class="text-danger">El nombre de imagen ya existe en este directorio.</p>';
                        }
                    } else {
                        $data['response'] = '<p class="text-danger">El archivo no es una imagen.</p>';
                    }
                } else {
                    $data['response'] = '<p class="text-danger">Hay campos vacíos.</p>';
                }
            } // No {else} here, this if is set for when the page is loaded for the first time
        } else {
            // User is not signed in
            $this->home();
            return;
        }
        template('pages/addrcp', $data);
    }

    function recipe_manage()
    {
        // call to get_recipes in Recipes Model
    }

}