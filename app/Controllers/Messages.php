<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Messages extends controller
{

    function get_messages()
    {
        if (isset($_SESSION['__user'])) {
            if (!model('Messages')->get_messages($_SESSION['__user']['username'])) {
                echo json_encode(['null' => 'No tienes mensajes']);
            } else {
                echo json_encode(model('Messages')->get_messages());
            }
        } else {
            echo json_encode(['null' => 'No estás loggeado.']);
        }
    }

    function message()
    {
        $data['page'] = 'home';
        // send a message into db
        if (isset($_SESSION['__user'])) {
            //if (model('Messages')->send_message(/*$_GET parameters here*/)) {
            /*    echo '<p class="text-success">¡Comentario enviado con éxito!<br/>Recarga la página para poder verlo.</p>';
            } else {
                echo '<p class="text-danger">Ha habido un problema al enviar tu comentario...<br/>No vuelvas a intentarlo.</p>';
            }
            */
            $data['response'] = '<p class="h6 mt-3 text-success text-center">Wiiiii</p>';
            template('pages/home', $data);
        }
    }

}