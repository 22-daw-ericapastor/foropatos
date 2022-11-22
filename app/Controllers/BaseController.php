<?php

namespace Controllers;

class BaseController
{

    function __construct($route)
    {
        $this->$route();
    }

    function home()
    {
        $data['page'] = 'home';
        // add here db request to get recipes to fill page and pass it to $data
        template('pages/home', $data);
    }

    function signup()
    {
        $data ['page'] = 'signup';
        if (isset($_POST['username']) && $_POST['username'] != '' &&
            isset($_POST['email']) && $_POST['email'] != '' &&
            isset($_POST['passwd']) && $_POST['passwd'] != '' &&
            isset($_POST['passwd_repeat']) && $_POST['passwd_repeat'] != '') {
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(htmlspecialchars($_POST['email']));
            $passwd = trim(htmlspecialchars($_POST['passwd']));
            $passwd_repeat = trim(htmlspecialchars($_POST['passwd_repeat']));
            if (model('Users')->get_user($username) === 0) {
                if ($passwd === $passwd_repeat) {
                    if (model('Users')->new_user($username, $email, $passwd)) {
                        $data ['signup_success'] = 'El formulario se envió con éxito.';
                    } else {
                        $data ['session_error'] = 'El formulario no pudo enviarse, disculpe las molestias.';
                    }
                } else {
                    $data ['session_error'] = 'Las contraseñas no coinciden.';
                }
            } else {
                $data['session_error'] = '¡Ups! Escoge otro nombre de usuario, ya está en uso.';
            }
        }
        template('session/signup', $data);
    }

    function signin()
    {
        $data ['page'] = 'signin';
        if (isset($_POST['username']) && isset($_POST['passwd'])) {
            $username = trim(htmlspecialchars($_POST['username']));
            $passwd = trim(htmlspecialchars($_POST['passwd']));
            $model = model('Users');
            if ($model->get_user($username)) {
                $_SESSION['__user'] = $model->get_user($username, $passwd);
                $this->home();
                return;
            } else {
                $data['session_error'] = 'El usuario o contraseña no es correcto.';
            }
        }
        template('session/signin', $data);
    }

    function signout()
    {
        session_unset();
        session_destroy();
        session_start();
        $this->home();
    }

    function recetas()
    {
        // get all recipes from db to fill in recipes grid in body
        // must return a json
    }

    function comment()
    {
        if (isset($_SESSION['__user'])) {
            if (model('Comments')->publish_comment(/*$_GET parameters here*/)) {
                echo '<p class="text-success">¡Comentario enviado con éxito!<br/>Recarga la página para poder verlo.</p>';
            } else {
                echo '<p class="text-danger">Ha habido un problema al enviar tu comentario...<br/>No vuelvas a intentarlo.</p>';
            }
        } else {
            echo '<p class="text-danger">Tienes que loggearte para poder publicar comentarios.</p>';
        }
    }

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