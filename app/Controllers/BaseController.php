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
        if (isset($_SESSION['__user']) && $_SESSION['__user']['is_active'] === 0) {
            session_re_start();
        }
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
            $model = model('Users');
            if (isset($_POST['username']) && $_POST['username'] != '' &&
                isset($_POST['email']) && $_POST['email'] != '' &&
                isset($_POST['passwd']) && $_POST['passwd'] != '' &&
                isset($_POST['passwd_repeat']) && $_POST['passwd_repeat'] != '') {
                $username = validate($_POST['username']);
                $email = validate($_POST['email']);
                $passwd = validate($_POST['passwd']);
                $passwd_repeat = validate($_POST['passwd_repeat']);
                if (!$model->get_user($username)) {
                    if ($passwd === $passwd_repeat) {
                        if ($model->new_user($username, $email, $passwd)) {
                            $data ['signup_success'] = 'El formulario se envió con éxito.';
                            template('session/successful.signup', $data);
                            return;
                        } else {
                            $data ['response'] = 'El formulario no pudo enviarse, disculpe las molestias.';
                        }
                    } else {
                        $data ['response'] = 'Las contraseñas no coinciden.';
                    }
                } else {
                    $data['response'] = '¡Ups! Escoge otro nombre de usuario, ya está en uso.';
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
                $username = validate($_POST['username']);
                $passwd = validate($_POST['passwd']);
                $model = model('Users');
                if ($model->get_user($username)) {
                    if ($model->get_user($username, $passwd) && $model->get_user($username, $passwd)['is_active'] === 1) {
                        $_SESSION['__user'] = $model->get_user($username, $passwd);
                        $this->home();
                        return;
                    } else {
                        $data['response'] = 'La contraseña no es correcta o tu cuenta fue desactivada.';
                    }
                } else {
                    $data['response'] = 'El usuario no es correcto.';
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
        session_re_start();
        $this->signin();
    }

    /**
     * Manage users page redirection
     * =================================================================================================================
     * @return void
     */
    function user_manage()
    {
        if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1) {
            template('pages/user.manage', ['page' => 'user_manage']);
        } else {
            $this->home();
        }
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
        if (isset($_SESSION['__user']) && $_SESSION['__user']['is_active'] === 1) {
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

    function get_messages()
    {
        controller('Messages')->get_messages();
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

    function msg_is_read()
    {
        controller('Messages')->msg_is_read();
    }

    /**
     * Change username
     * =================================================================================================================
     * Redirect to the same named method in the Users controller.
     *
     * @return void
     */
    function change_username()
    {
        controller('Users')->change_username();
    }

    /**
     * Change password
     * =================================================================================================================
     * Redirect to the same named method in the Users controller.
     *
     * @return void
     */
    function change_passwd()
    {
        controller('Users')->change_passwd();
    }

    /**
     * Deactivate account
     * =================================================================================================================
     * Redirect to the same named method in the Users controller.
     *
     * @return void
     */
    function acc_deactivate()
    {
        controller('Users')->acc_deactivate();
    }

    function get_users()
    {
        controller('Users')->get_users();
    }

    function toggle_active()
    {
        controller('Users')->toggle_active();
    }

    function toggle_permissions()
    {
        controller('Users')->toggle_permissions();
    }

}