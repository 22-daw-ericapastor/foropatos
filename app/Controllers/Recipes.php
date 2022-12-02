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
            if (isset($_REQUEST['rcp_title']) && isset($_REQUEST['short_description']) && isset($_REQUEST['difficulty']) && isset($_FILES['img_src'])) {
                // Check fields are not empty
                if ($_REQUEST['rcp_title'] !== '' && $_REQUEST['short_description'] !== '' && $_REQUEST['difficulty'] !== '') {
                    $target_dir = publicdir . '/assets/imgs/recipes';
                    $target_file = $target_dir . basename($_FILES["img_src"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
                    // Check file is an image
                    if (getimagesize($_FILES["img_src"]["tmp_name"])!==false) {
                        // Check if file already exists
                        if (!file_exists($target_file)) {
                            // Check file size
                            if (!$_FILES["img_src"]["size"] > 500000) {
                                // Check file format
                                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                                    // Everything is ok at this point -> try to upload the file
                                    if (move_uploaded_file($_FILES['img_src']['tmp_name'], $target_file)) {
                                        $data['response'] = '<p class="text-success">El archivo' . htmlspecialchars(basename($_FILES['img_src']['name'])) . 'se ha subido.</p>';
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
                        /*
                        $src = $_REQUEST['img_src'];
                        $title = validate($_REQUEST['rcp_title']);
                        $sd = validate($_REQUEST['short_description']);
                        $difficulty = intval($_REQUEST['difficulty']);
                        if (model('Recipes')->add_recipe($src, $title, $sd, $difficulty)) {
                            $data['response'] = '<p class="text-success">¡Se añadió la receta!</p>';
                        } else {
                            $data['response'] = '<p class="text-danger">Hubo un problema interno. Soluciónalo, pendeja.</p>';
                        }*/
                    } else {
                        $data['response'] = '<p class="text-danger">El archivo no es una imagen.</p>';
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
    }

    function recipe_manage()
    {
        // call to get_recipes in Recipes Model
    }

}