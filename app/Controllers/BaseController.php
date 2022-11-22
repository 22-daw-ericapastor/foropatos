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
        template('home', ['page' => 'home']);
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
            if ($user = model('Users')->get_user($username, $passwd)) {
                $_SESSION['user'] = $user;
                $data['user'] = $user;
                template('home', $data);
                return;
            }
        } else {
            $data['session_error'] = 'No se completaron todos los campos';
        }
        template('session/signin', $data);
    }

}