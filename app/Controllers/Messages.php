<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Messages extends controller
{

    function message()
    {
        // send a message into db
        if (isset($_SESSION['__user'])) {
            if (model('Messages')->send_message(/*$_GET parameters here*/)) {
                echo '<p class="text-success">¡Comentario enviado con éxito!<br/>Recarga la página para poder verlo.</p>';
            } else {
                echo '<p class="text-danger">Ha habido un problema al enviar tu comentario...<br/>No vuelvas a intentarlo.</p>';
            }
        } else {
            echo '<p class="text-danger">Tienes que loggearte para poder publicar comentarios.</p>';
        }
    }

}