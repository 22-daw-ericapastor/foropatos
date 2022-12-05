<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Comments extends controller
{

    /**
     * Publish comment
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @return void
     */
    function comment(): void
    {
        if (isset($_SESSION['__user']) && isset($_GET['comment']) && isset($_GET['slug'])) {
            $username = $_SESSION['__user']['username'];
            $slug = $_GET['slug'];
            $rating = $_GET['rating'];
            $comment = validate($_GET['comment']);
            if ($comment != '') {
                if ($rating != "0") {
                    if (!model('Comments')->get_comment($username, $slug)) {
                        if (model('Comments')->comment($username, $slug, $rating, $comment) && model('Recipes')->rating($slug, $rating)) {
                            echo '<p class="text-success">¡Comentario enviado con éxito!';
                        } else {
                            echo '<p class="text-danger">Ha habido un problema al enviar tu comentario...<br/>No vuelvas a intentarlo.</p>';
                        }
                    } else {
                        echo '<p class="text-danger">¡Ya has valorado esta receta! Disculpa las molestias y vete a hacer otra cosa.</p>';
                    }
                } else {
                    echo '<p class="text-danger">Selecciona una valoración.</p>';
                }
            } else {
                echo '<p class="text-danger">No puedes enviar un comentario vacío, pedazo de bárbaro. ^^</p>';
            }
        } else {
            echo '<p class="text-danger">Parece que el tiempo de tu sesión ha caducado.
                <br/>Serás redirigido en unos segundos para que vuelvas a loggearte.</p>';
        }
    }

    /**
     * Get comments list
     * -----------------------------------------------------------------------------------------------------------------
     * Retrieve all the comments stored in Database
     *
     * @return void
     */
    function comments_list()
    {
        $model = model('Comments');
        if ($results = $model->get_comments($_GET['slug'])) {
            echo json_encode($results);
        } else {
            echo json_encode(['null' => '<p class="text-primary text-start pb-3">Todavia no hay comentarios, ¡sé el primero!</p>']);
        }
    }

}