<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Users extends controller
{

    /**
     * Change username
     * -----------------------------------------------------------------------------------------------------------------
     * Checks username doesn't have any special characters, if the username changed or not, and if the new username
     * is not already taken by another user; then attempts to update the Database.
     *
     * @return void
     */
    function change_username()
    {
        $data['page'] = 'my_account';
        if (isset($_SESSION['__user'])) {
            if (isset($_POST['username']) && $_POST['username'] !== '') {
                $new_username = validate($_POST['username']); // This is the one written by the person.
                if (preg_match('/^[0-9A-Za-z_-]+$/', $new_username)) { // Check there are no special chars
                    $model = model('Users');
                    $old_username = $_SESSION['__user']['username'];
                    if ($new_username !== $old_username) {
                        if (!$model->get_user($new_username)) {
                            if ($model->change_username($old_username, $new_username)) {
                                $_SESSION['__user']['username'] = $new_username;
                            } else {
                                $data['response'] = '<p class="h6 mt-3 text-danger text-center">Ha habido algún fallo interno,
                                escriba un mensaje a un administrador y vuelva a intentarlo mañana.</p>';
                            }
                        } else {
                            $data['response'] = '<p class="h6 mt-3 text-danger text-center">Parece que ese nombre de usuario ya está cogido.</p>';
                        }
                    } else {
                        $data['response'] = '<p class="h6 mt-3 text-danger text-center">Ese es el mismo nombre de usuario que ya tienes.</p>';
                    }
                } else {
                    $data['response'] = '<p class="h6 mt-3 text-danger text-center">No puedes escribir carácteres especiales. Permitidos: Guión alto y bajo, letras y números.</p>';
                }
            } else {
                $data['response'] = '<p class="h6 mt-3 text-danger text-center">Rellena todos los campos.</p>';
            }
        } else {
            $this->signin();
            return;
        }
        template('pages/account', $data);
    }

    /**
     * Change password
     * -----------------------------------------------------------------------------------------------------------------
     * Checks that the old password is correct, that it's not the same as the old one, that the new one has 6 or more
     * characters, and that the repeat password is equal to the new one. Then attempts to update the Database.
     *
     * @return void
     */
    function change_passwd()
    {
        $data['page'] = 'my_account';
        if (isset($_SESSION['__user'])) {
            if (isset($_POST['passwd-old']) && isset($_POST['passwd']) && isset($_POST['passwd-repeat'])
                && $_POST['passwd-old'] !== '' && $_POST['passwd'] !== '' && $_POST['passwd-repeat'] !== '') {
                $model = model('Users');
                $username = $_SESSION['__user']['username'];
                $passwd_old = validate($_POST['passwd-old']);
                if ($model->get_user($username, $passwd_old)) {
                    $passwd = validate($_POST['passwd']);
                    $passwd_repeat = validate($_POST['passwd-repeat']);
                    if ($passwd_old !== $passwd) {
                        if (strlen($passwd) >= 6 && strlen($passwd_repeat) >= 6 && $passwd === $passwd_repeat) {
                            if ($model->change_passwd($username, $passwd)) {
                                $data = [
                                    'response' => '<p class="h6 mt-3 text-success text-center">¡Todo listo!
                                    Tu contraseña cambió. Vuelve a loggearte para continuar.</p>',
                                    'page' => 'signin'
                                ];
                                session_re_start();
                                template('session/signin', $data);
                            } else {
                                $data['response'] = '<p class="h6 mt-3 text-danger text-center">Ha habido algún fallo interno,
                                escriba un mensaje a un administrador y vuelva a intentarlo mañana.</p>';
                            }
                        } else {
                            $data['response'] = '<p class="h6 mt-3 text-danger text-center">La contraseña debe tener seis 
                            dígitos o más y ser idénticas.</p>';
                        }
                    } else {
                        $data['response'] = '<p class="h6 mt-3 text-danger text-center">La contraseña nueva no puede ser 
                            igual que la antigua.</p>';
                    }
                } else {
                    $data['response'] = '<p class="h6 mt-3 text-danger text-center">La contraseña antigua no es correcta.</p>';
                }
            } else {
                $data['response'] = '<p class="h6 mt-3 text-danger text-center">Rellena todos los campos.</p>';
            }
        } else {
            $this->signin();
            return;
        }
        template('pages/account', $data);
    }

    /**
     * Deactivate account
     * -----------------------------------------------------------------------------------------------------------------
     * Set is_active field from users table in Database to 0, checking that it's not the last admin user.
     *
     * @return void
     */
    function acc_deactivate()
    {
        $username = $_SESSION['__user']['username'];
        if ($user = model('Users')->get_all_from_user($username)) {
            // check user admin
            if (($user['permissions'] === 1 && model('Users')->count_admins() > 1) || $user['permissions'] === 0) {
                if (model('Users')->toggle_active($username) === true) {
                    $_SESSION['__user']['is_active'] = 0;
                    echo '<p class="text-success">¡Tu cuenta se ha desactivado con éxito!<br/>En unos segundos se te sacará de la aplicación.</p>';
                } else {
                    echo '<p class="text-danger">Ha habido un problema dando de baja tu cuenta. Vuelve a intentarlo más tarde.</p>';
                }
            } else {
                echo '<p class="text-danger">' . $username . ' es el único administrador. Configura otro para poder dar de baja a este usuario.</p>';
            }
        } else {
            echo '<p class="text-danger">No se encuentra el usuario.</p>';
        }
    }

    /**
     * Get users for datatable
     * -----------------------------------------------------------------------------------------------------------------
     *
     * @return void
     */
    function datatable_users()
    {
        echo json_encode(['data' => model('Users')->datatable_users()]);
    }

    /**
     * Toggle user activity
     * -----------------------------------------------------------------------------------------------------------------
     * Set is_active field from users table in Database to 1 or 0 depending on the $_GET parameter received. It won't
     * set to 0 if the user is the last admin.
     *
     * @return void
     */
    function toggle_active()
    {
        if (isset($_GET['toggle_active']) && isset($_GET['user'])) {
            $is_active = intval($_GET['toggle_active']);
            $username = $_GET['user'];
            if ($user = model('Users')->get_all_from_user($username)) {
                // check user admin
                if (($user['permissions'] === 1 && model('Users')->count_admins() > 1) || $user['permissions'] === 0) {
                    if (model('Users')->toggle_active($username, $is_active) === true) {
                        $_SESSION['__user']['is_active'] = $is_active;
                        if ($is_active === 1) {
                            echo '<p class="text-success">¡' . $username . ' ya está activo de nuevo!</p>';
                        } else {
                            echo '<p class="text-success">¡' . $username . ' fue desactivado!</p>';
                        }
                    } else {
                        echo '<p class="text-danger">No fue posible actualizar a ' . $username .
                            '.<br/>Contacte con Effy para que lo resuelva.</p>';
                    }
                } else {
                    echo '<p class="text-danger">' . $username . ' es el único administrador. Configura otro para poder dar de baja a este usuario.</p>';
                }
            } else {
                echo '<p class="text-danger">No se encuentra el usuario.</p>';
            }
        } else {
            echo '<p class="text-danger">No hay datos para buscar al usuario.</p>';
        }
    }

    /**
     * Toggle users permissions
     * -----------------------------------------------------------------------------------------------------------------
     * Set permissions to 0 or 1 in the users table from Database depending on the $_GET parameter received. It won't set
     * to 0 if the user is the last admin.
     *
     * @return void
     */
    function toggle_permissions()
    {
        if (isset($_GET['toggle_permissions']) && isset($_GET['user'])) {
            $permissions = intval($_GET['toggle_permissions']);
            $username = $_GET['user'];
            if ($user = model('Users')->get_all_from_user($username)) {
                // check user admin
                if (($user['permissions'] === 1 && model('Users')->count_admins() > 1) || $user['permissions'] === 0) {
                    if (model('Users')->toggle_permissions($permissions, $username) === true) {
                        if ($permissions === 1) {
                            echo '<p class="text-success">¡' . $username . ' subió de nivel!</p>';
                        } else {
                            echo '<p class="text-success">¡' . $username . ' bajó de nivel!</p>';
                        }
                    } else {
                        echo '<p class="text-danger">No fue posible actualizar a ' . $username .
                            '.<br/>Contacte con Effy para que lo resuelva.</p>';
                    }
                } else {
                    echo '<p class="text-danger">' . $username . ' es el único administrador. Configura otro para bajar de nivel a este usuario.</p>';
                }
            } else {
                echo '<p class="text-danger">No se encuentra el usuario.</p>';
            }
        } else {
            echo '<p class="text-danger">No hay datos para buscar al usuario.</p>';
        }
    }

    /**
     * Delete user
     * -----------------------------------------------------------------------------------------------------------------
     * If the user is not the last admin, attempts to delete it from Database, first inserting it into the deleted_users
     * table.
     *
     * @return void
     */
    function delete_user()
    {
        if (isset($_GET['delete_user'])) {
            $username = $_GET['delete_user'];
            if ($user = model('Users')->get_all_from_user($username)) {
                // check user admin
                if (($user['permissions'] === 1 && model('Users')->count_admins() > 1) || $user['permissions'] === 0) {
                    if (model('DeletedUsers')->insert($user) && model('Users')->delete_user($username)) {
                        echo '<p class="text-success">' . $username . ' fue eliminado con éxito.</p>';
                    } else {
                        echo '<p class="text-danger">' . $username . ' no pudo ser eliminado.' .
                            '<br/>Contacte con Effy para que lo resuelva.</p>';
                    }
                } else {
                    echo '<p class="text-danger">' . $username . ' es el único administrador. Configura otro para poder eliminar este usuario.</p>';
                }
            } else {
                echo '<p class="text-danger">No se encuentra el usuario.</p>';
            }
        } else {
            echo '<p class="text-danger">No se encuentra el usuario.</p>';
        }
    }

}