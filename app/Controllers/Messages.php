<?php

namespace Controllers;

use \Controllers\BaseController as controller;
use Exception;

class Messages extends controller
{

    function msg_is_read()
    {
            if (isset($_GET['msg_is_read']) && isset($_GET['user']) && isset($_GET['slug'])) {
                $is_read = intval($_GET['msg_is_read']);
                $user = $_GET['user'];
                $slug = $_GET['slug'];
                if (model('Users')->get_user($user) === 1) {
                    if (model('Messages')->msg_is_read($is_read, $user, $slug)) {
                        echo json_encode(['response' => true]);
                    } else {
                        echo json_encode(['response' => 'No se pudo actualizar la información.']);
                    }
                } else {
                    echo json_encode(['response' => 'El usuario no existe.']);
                }
            } else {
                echo json_encode(['response' => 'Falta información.']);
            }
    }

    function message()
    {
        // send a message into db
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
        } else {
            echo '<h6 class="text-danger text-center">Rellena todos los campos.</h6>';
        }
    }

    function get_messages()
    {
        echo json_encode(['data' => model('Messages')->get_messages()]);
    }

    function delmsg()
    {
            if (isset($_GET['delmsg']) && $_GET['delmsg'] !== '') {
                if (model('Messages')->delmsg($_GET['delmsg'])) {
                    echo '<span class="text-success">Se borró el mensaje con éxito.</span>';
                } else {
                    echo '<span class="text-danger">Hubo un fallo interno del programa.</span>';
                }
            } else {
                echo '<span class="text-danger">Falta información.</span>';
            }
    }

}

