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
        if (!isset($_SESSION['__user'])) {
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
                            template('session/successful.signup', $data);
                            return;
                        } else {
                            $data ['session_error'] = 'El formulario no pudo enviarse, disculpe las molestias.';
                        }
                    } else {
                        $data ['session_error'] = 'Las contraseñas no coinciden.';
                    }
                } else {
                    $num = model('Users')->get_user($username);
                    $data['usernum'] = $num;
                    $data['session_error'] = '¡Ups! Escoge otro nombre de usuario, ya está en uso.';
                }
            }
            template('session/signup', $data);
        } else {
            $this->home();
        }
    }

    function signin()
    {
        if (!isset($_SESSION['__user'])) {
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
        } else {
            $this->home();
        }
    }

    function signout()
    {
        session_unset();
        session_destroy();
        session_start();
        $this->home();
    }

    function is_logged(): void
    {
        if (isset($_SESSION['__user'])) {
            echo json_encode(['response' => true]);
        } else {
            echo json_encode(['response' => false]);
        }
    }

}