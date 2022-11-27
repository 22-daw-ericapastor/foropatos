<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Comments extends controller
{

    function comment()
    {
        if (isset($_SESSION['__user']) && isset($_GET['comment']) && isset($_GET['slug'])) {
            $username = $_SESSION['__user']['username'];
            $slug = $_GET['slug'];
            $comment = validate($_GET['comment']);
            if ($comment != '') {
                if (model('Comments')->publish_comment($username, $slug, $comment)) {
                    echo '<p class="text-success">¡Comentario enviado con éxito!';
                } else {
                    echo '<p class="text-danger">Ha habido un problema al enviar tu comentario...<br/>No vuelvas a intentarlo.</p>';
                }
            } else {
                echo '<p class="text-warning">No puedes enviar un comentario vacío, pedazo de bárbaro. ^^</p>';
            }
        } else {
            echo '<p class="text-danger">Tienes que loggearte para poder publicar comentarios.</p>';
        }
    }

    function comments_list()
    {
        $model = model('Comments');
        if ($results = $model->get_comments($_GET['slug'])) {
            echo json_encode($results);
        } else {
            echo json_encode(['null' => '<p class="text-center text-primary">Todavia no hay comentarios, ¡sé el primero!</p>']);
        }
    }

}