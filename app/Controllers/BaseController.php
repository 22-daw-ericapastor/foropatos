<?php

namespace Controllers;

use Error;
use Exception;

class BaseController
{
    /**
     * Main controller construct
     * -----------------------------------------------------------------------------------------------------------------
     * It launches the method received as string parameter.
     * If the method doesn't exist, it launches the {@link home()} method.
     *
     * @param $route string|null
     */
    function __construct(string $route = null)
    {
        // Check user activity as any controller is created
        check_user_activity();
        // Route to a method
        if (isset($route)) {
            try {
                $this->$route();
            } catch (Exception|Error $e) {
                $this->home();
                //echo $e->getMessage();
            }
        }
    }

    /**
     * Home
     * -----------------------------------------------------------------------------------------------------------------
     * @return void
     */
    function home()
    {
        $data['page'] = 'home';
        template('pages/home', $data);
    }


    /**
     * Signup
     * -----------------------------------------------------------------------------------------------------------------
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
                if (preg_match('/^[0-9A-Za-z_-]+$/', $username)) { // Check there are no special chars
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
                } else {
                    $data['response'] = 'No puedes escribir carácteres especiales. Permitidos: Guión alto y bajo, letras y números.';
                }
            }
            template('session/signup', $data);
        } else {
            $this->home();
        }
    }

    /**
     * Sign in
     * -----------------------------------------------------------------------------------------------------------------
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
                        $_SESSION['last_acted_on'] = time();
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
     * -----------------------------------------------------------------------------------------------------------------
     * Resets the session on the website and goes back to {@link home()}.
     *
     * @return void
     */
    function signout()
    {
        session_re_start();
        check_user_activity();
        $this->signin();
    }

    /**
     * Manage users page redirection
     * -----------------------------------------------------------------------------------------------------------------
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
     * Manage recipes page redirection
     * -----------------------------------------------------------------------------------------------------------------
     * @return void
     */
    function recipe_manage()
    {
        if (isset($_SESSION['__user']) && $_SESSION['__user']['permissions'] === 1) {
            template('pages/recipe.manage', ['page' => 'recipe_manage']);
        } else {
            $this->home();
        }
    }

    /**
     * User is logged check
     * -----------------------------------------------------------------------------------------------------------------
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
     * -----------------------------------------------------------------------------------------------------------------
     * Show the account view if the user is logged, or go back to {@link home()} if it isn't.
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

    function upload_image($recipesdir): string
    {
        $target_dir = publicdir . $recipesdir; // need the final slash or else it uploads in the parent directory
        // Check file is an image
        if (getimagesize($_FILES["img_src"]["tmp_name"]) !== false) {
            // Get the extension of the file
            $imageFileType = strtolower(pathinfo($target_dir . basename($_FILES["img_src"]["name"]), PATHINFO_EXTENSION));
            // Rename the file with the extension
            $_FILES["img_src"]["name"] = time() . '.' . $imageFileType;
            // Keep the full target file link
            $target_file = $target_dir . basename($_FILES["img_src"]["name"]);
            // Check file size
            if ($_FILES["img_src"]["size"] < 500000) {
                // Check file format
                if ($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                    // Everything is ok at this point -> try to upload the file
                    if (move_uploaded_file($_FILES['img_src']['tmp_name'], $target_file)) {
                        return $recipesdir . basename($_FILES["img_src"]["name"]);
                    } else {
                        return '<p class="text-danger">La imagen no se ha podido subir. Problema interno.</p>';
                    }
                } else {
                    return '<p class="text-danger">Solo se admiten imágenes PNG, JPEG o JPG.</p>';
                }
            } else {
                return '<p class="text-danger">La imagen es demasiado grande.</p>';
            }
        } else {
            return '<p class="text-danger">El archivo no es una imagen.</p>';
        }
    }

    /**
     * Routing methods
     * =================================================================================================================
     * The following methods redirect to the children of this class.
     */

    /**
     * Recipes methods
     * =================================================================================================================
     * Redirect to the same named method in the Recipes controller.
     *
     * @return void
     */

    function get_recipes(): void
    { /* This is used by Javascript form an AJAX call to fill HTML content.
        This means it doesn't need to check user's activity or session as it has already been checked. */
        controller('Recipes')->get_recipes();
    }

    function datatable_recipes()
    { /* This is used by Javascript form an AJAX call to fill HTML content.
        This means it doesn't need to check user's activity or session as it has already been checked. */
        controller('Recipes')->datatable_recipes();
    }

    function add_recipe()
    {
        controller('Recipes')->add_recipe();
    }

    function updt_rcp()
    {
        controller('Recipes')->updt_rcp();
    }

    function delete_recipe()
    {
        controller('Recipes')->delete_recipe();
    }


    /**
     * Comments methods
     * =================================================================================================================
     * Redirect to the same named method in the Comments controller.
     *
     * @return void
     */

    function comments_list()
    { /* This is used by Javascript form an AJAX call to fill HTML content.
        This means it doesn't need to check user's activity or session as it has already been checked. */
        controller('Comments')->comments_list();
    }

    function comment(): void
    {
        controller('Comments')->comment();
    }

    /**
     * Messages methods
     * =================================================================================================================
     * Redirect to the same named method in the Messages controller.
     *
     * @return void
     */

    function get_messages()
    { /* This is used by Javascript form an AJAX call to fill HTML content.
        This means it doesn't need to check user's activity or session as it has already been checked. */
        controller('Messages')->get_messages();
    }

    function message()
    {
        if (isset($_SESSION['__user'])) {
            controller('Messages')->message();
        } else {
            echo '<span class="text-danger">Parece que el tiempo de tu sesión ha caducado.
                <br/>Serás redirigido en unos segundos para que vuelvas a loggearte.</span>';
        }
    }

    function msg_is_read()
    {
        if (isset($_SESSION['__user'])) {
            controller('Messages')->msg_is_read();
        } else {
            echo json_encode(['response' => '<span class="text-danger">Tiempo de sesion caducado.
                <br/>Serás redirigido al login en unos segundos.</span>']);
        }
    }

    function delmsg()
    {
        if (isset($_SESSION['__user'])) {
            controller('Messages')->delmsg();
        } else {
            echo '<span class="text-danger">Parece que el tiempo de tu sesión ha caducado.
                <br/>Serás redirigido en unos segundos para que vuelvas a loggearte.</span>';
        }
    }

    /**
     * User methods
     * =================================================================================================================
     * Redirect to the same named method in the Users controller.
     *
     * @return void
     */

    function change_username()
    {
        controller('Users')->change_username();
    }

    function change_passwd()
    {
        controller('Users')->change_passwd();
    }

    function acc_deactivate()
    {
        if (isset($_SESSION['__user'])) {
            controller('Users')->acc_deactivate();
        } else {
            echo '<p class="text-danger">Parece que el tiempo de tu sesión ha caducado.
                <br/>Serás redirigido en unos segundos para que vuelvas a loggearte.</p>';
        }
    }

    function datatable_users()
    { // JSON type of data process
        controller('Users')->datatable_users();
    }

    function toggle_active()
    {
        if (isset($_SESSION['__user'])) {
            controller('Users')->toggle_active();
        } else {
            echo '<p class="text-danger">Parece que el tiempo de tu sesión ha caducado.
                <br/>Serás redirigido en unos segundos para que vuelvas a loggearte.</p>';
        }
    }

    function toggle_permissions()
    {
        if (isset($_SESSION['__user'])) {
            controller('Users')->toggle_permissions();
        } else {
            echo '<p class="text-danger">Parece que el tiempo de tu sesión ha caducado.
                <br/>Serás redirigido en unos segundos para que vuelvas a loggearte.</p>';
        }
    }

    function delete_user()
    {
        if (isset($_SESSION['__user'])) {
            controller('Users')->delete_user();
        } else {
            echo '<p class="text-danger">Parece que el tiempo de tu sesión ha caducado.
                <br/>Serás redirigido en unos segundos para que vuelvas a loggearte.</p>';
        }
    }

}