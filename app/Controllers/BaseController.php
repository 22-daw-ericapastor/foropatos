<?php

namespace Controllers;

use Error;
use Exception;

class BaseController
{

    /**
     * Main controller construct
     * =================================================================================================================
     * It launches the method received as string parameter.
     * If the method doesn't exist, it launches the {@link home()} method.
     *
     * @param $route string|null
     */
    function __construct(string $route = null)
    {
        if (isset($route)) {
            try {
                $this->$route();
            } catch (Exception|Error $e) {
                $this->home();
            }
        }
    }

    /**
     * Home
     * =================================================================================================================
     * @return void
     */
    function home()
    {
        $data['page'] = 'home';
        // add here db request to get recipes to fill page and pass it to $data
        template('pages/home', $data);
    }


    /**
     * Signup
     * =================================================================================================================
     * If the user is already in session this method will launch {@link home}. If not, it will check the post array
     * searching for parameters to sign up a new user. If post is empty or doesn't have all the necessary items, it
     * redirects to the session form. It the paremeters are correct, it attempts to insert a new user into the database.
     *
     * @return void
     */
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

    /**
     * Sign in
     * =================================================================================================================
     * If the user is already in session this method will launch {@link home}. If not, it will check the post array
     * searching for parameters to compare with the existing users in database. On a successfull search the user will be
     * added to session, if not, an error message will appear and the user will still be in the Signin view.
     *
     * @return void
     */
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

    /**
     * Sign out
     * =================================================================================================================
     * Resets the session on the website and goes back to {@link home()}.
     *
     * @return void
     */
    function signout()
    {
        session_unset();
        session_destroy();
        session_start();
        $this->home();
    }

    /**
     * User is logged check
     * =================================================================================================================
     * If the parameter $__user is on the session array it returns a json array with true as $response, and false if it
     * is not. This method is used in an asynchronous call from Javascript.
     *
     * @return void
     */
    function is_logged(): void
    {
        if (isset($_SESSION['__user'])) {
            echo json_encode(['response' => true]);
        } else {
            echo json_encode(['response' => false]);
        }
    }

    /**
     * Account page
     * =================================================================================================================
     * Show the account view if the user is logged, or go back to {@link home()} if it's not.
     *
     * @return void
     */
    function account()
    {
        if (isset($_SESSION['__user'])) {
            template('pages/account', ['page' => 'my_account']);
        } else {
            $this->home();
        }
    }

    /**
     * Get recipes
     * =================================================================================================================
     * Redirect to the same named method in the Recipes controller.
     *
     * @return void
     */
    function get_recipes(): void
    {
        controller('Recipes')->get_recipes();
    }

    /**
     * Get recipes
     * =================================================================================================================
     * Redirect to the same named method in the Recipes controller.
     *
     * @return void
     */
    function add_recipe()
    {
        controller('Recipes')->add_recipes();
    }

    /**
     * Get comments list
     * =================================================================================================================
     * Redirect to the same named method in the Comments controller.
     *
     * @return void
     */
    function comments_list()
    {
        controller('Comments')->comments_list();
    }

    /**
     * Publish a comment
     * =================================================================================================================
     * Redirect to the same named method in the Comments controller.
     *
     * @return void
     */
    function comment(): void
    {
        controller('Comments')->comment();
    }

    /**
     * Send message
     * =================================================================================================================
     * Redirect to the same named method in the Messages controller.
     *
     * @return void
     */
    function message()
    {
        controller('Messages')->message();
    }

}