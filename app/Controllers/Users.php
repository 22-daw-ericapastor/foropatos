<?php

namespace Controllers;

use \Controllers\BaseController as controller;

class Users extends controller
{
    function change_username()
    {
        $data['page'] = 'my_account';
        if (isset($_SESSION['__user'])) {
            if (isset($_POST['username']) && $_POST['username'] !== '') {
                $model = model('Users');
                $old_username = $_SESSION['__user']['username'];
                $new_username = validate($_POST['username']); // This is the one written by the person.
                if ($new_username !== $old_username) {
                    if (!$model->get_user($new_username)) {
                        if ($model->change_username($old_username, $new_username)) {
                            $data ['response'] = '<p class="h6 mt-3 text-success text-center">¡Todo listo! Tu nombre de usuario cambió.</p>';
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
                $data['response'] = '<p class="h6 mt-3 text-danger text-center">Rellena todos los campos.</p>';
            }
        } else {
            $this->signin();
            return;
        }
        template('pages/account', $data);
    }

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

    function acc_deactivate()
    {
        if (isset($_SESSION['__user'])) {
            $model=model('Users');
            $model->acc_deactivate();
        }
    }

}