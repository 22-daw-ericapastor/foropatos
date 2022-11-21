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

    function signin()
    {
        $data ['page'] = 'signin';
        if (isset($_POST['username']) && isset($_POST['email'])
            && isset($_POST['passwd']) && isset($_POST['passwd_repeat'])) {
            $username = trim(htmlspecialchars($_POST['username']));
            $email = trim(htmlspecialchars($_POST['email']));
            $passwd = trim(htmlspecialchars($_POST['passwd']));
            $passwd_repeat = trim(htmlspecialchars($_POST['passwd_repeat']));
            model('Users');
        } else {
            $data['session_error'] = 'No se completaron todos los campos';
        }
        template('signin', $data);
    }

    function login()
    {
        $data ['page'] = 'login';
        if (isset($_POST['username']) && isset($_POST['passwd'])) {
            $username = trim(htmlspecialchars($_POST['username']));
            $passwd = trim(htmlspecialchars($_POST['passwd']));
            // check validity of user
        } else {
            $data['session_error'] = 'No se completaron todos los campos';
        }
        template('login', $data);
    }

}