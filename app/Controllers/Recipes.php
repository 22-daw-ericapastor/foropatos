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
                if ($_REQUEST['rcp_title'] !== '' && $_REQUEST['description'] !== '') {
                    $recipesdir = 'assets/imgs/recipes/';
                    $target_dir = publicdir . $recipesdir; // need the final slash or else it uploads in the parent directory
                    // Check file is an image
                    if (getimagesize($_FILES["img_src"]["tmp_name"]) !== false) {
                        // Get the extension of the file
                        $imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["img_src"]["name"]), PATHINFO_EXTENSION));
                        // Rename the file with the extension
                        $_FILES["img_src"]["name"] = time() . '.' . $imageFileType;
                        // Keep the full target file link
                        $target_file = $target_dir . basename($_FILES["img_src"]["name"]);
                        // Check file size
                        if ($_FILES["img_src"]["size"] < 500000) {
                            // Check file format
                            if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                                // Everything is ok at this point -> try to upload the file
                                if (move_uploaded_file($_FILES['img_src']['tmp_name'], $target_file)) {
                                    // Here the image is uploaded
                                    $src = $recipesdir . basename($_FILES["img_src"]["name"]);
                                    $title = validate($_REQUEST['rcp_title']);
                                    $description = validate($_REQUEST['description']);
                                    $admixtures = validate($_REQUEST['admixtures']);
                                    $making = validate($_REQUEST['making']);
                                    $difficulty = intval($_REQUEST['difficulty']);
                                    if (model('Recipes')->add_recipe($src, $title, $description, $admixtures, $making, $difficulty)) {
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