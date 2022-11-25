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

    function recipes(): void
    {
        echo json_encode(model('Recipes')->get_recipes());
    }

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