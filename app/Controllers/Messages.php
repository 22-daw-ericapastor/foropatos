<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Messages extends controller
{

    function get_messages()
    {
        if (isset($_SESSION['__user']['username'])) {
            $username = $_SESSION['__user']['username'];
            echo json_encode(['data' => model('Messages')->get_messages($username)]);
        }
    }

    function message()
    {
        // send a message into db
        if (isset($_SESSION['__user']) && isset($_SESSION['__user']['username'])) {
            if (isset($_GET['title']) && isset($_GET['message'])
                && $_GET['title'] !== '' && $_GET['message'] !== '') {
                $username = $_SESSION['__user']['username'];
                $title = validate($_GET['title']);
                $msg = validate($_GET['message']);
                if (model('Messages')->send_message($username, $title, $msg)) {
                    echo '<h6 class="text-success text-center">¡Mensaje enviado con éxito!
                        <br/>Lo tendremos muy, muy, muy, muy, ¡muy en cuenta! (No.)</h6>';
                } else {
                    echo '<h6 class="text-danger text-center">Ha habido un problema al enviar tu comentario...
                        <br/>No vuelvas a intentarlo.</h6>';
                }
            }
        } else {
            echo '<h6 class="text-danger text-center">Rellena todos los campos.</h6>';
        }
    }

}