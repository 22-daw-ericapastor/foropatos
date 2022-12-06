<?php

/**
 * View template
 * ---------------------------------------------------------------------------------------------------------------------
 * Uses the function {@link view()} to mount header, body and footer upon the body file given as parameter, and giving
 * this function the param {$data} wether it's empty or not. This is so the array can be used inside the Views
 * alongside the HTML.
 *
 * @param string $page
 * @param array|null $data
 * @return void
 */
function template(string $page, array $data = null)
{
    if (!is_file(viewdir . $page . '.php')) {
        $page = 'pages/home';
    }
    view('templates/header', $data);
    view($page, $data);
    view('templates/footer', $data);
}

/**
 * Include a view
 * ---------------------------------------------------------------------------------------------------------------------
 * If the file exists it in the view directory it will be included.
 *
 * @param string $page
 * @param array|null $data
 * @return void
 */
function view(string $page, array $data = null)
{
    $file = viewdir . $page . '.php';
    if (is_file($file)) {
        include $file;
    }
}

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * If the file exists in the Models namespace, an instance of the Model class given as parameter will be returned.
 *
 * @param string $class
 * @return mixed|null
 */
function model(string $class)
{
    if (is_file(appdir . 'Models/' . $class . '.php')) {
        $model = '\\Models\\' . $class;
        return new $model();
    }
    return null;
}

/**
 * ---------------------------------------------------------------------------------------------------------------------
 * If the file exists in the Controllers namespace, an instance of the Controller class given as parameter will be returned.
 *
 * @param string $class
 * @return mixed|null
 */
function controller(string $class)
{
    if (is_file(appdir . 'Controllers/' . $class . '.php')) {
        $controller = '\\Controllers\\' . $class;
        return new $controller();
    }
    return null;
}

/**
 * Cleanse string
 * ---------------------------------------------------------------------------------------------------------------------
 * Returns the string given after applying {@link trim()} and {@link specialchars()} to it.
 *
 * @param string $str
 * @return string
 */
function validate(string $str): string
{
    return trim(htmlspecialchars($str));
}

/**
 * Start or restart the session
 * ---------------------------------------------------------------------------------------------------------------------
 * If the session is set it will be unset and destroy. It will start in any case.
 *
 * @return void
 */
function session_re_start()
{
    if (isset($_SESSION)) {
        session_unset();
        session_destroy();
    }
    session_start();
}

/**
 * Time out for session
 * ---------------------------------------------------------------------------------------------------------------------
 */
const timeout = 5 * 60; // Measure is in seconds
/**
 * Check user's activity
 * ---------------------------------------------------------------------------------------------------------------------
 * Checks a parameter in {@link $_SESSION} called ´last_acted_on´, which will be keeping the time of the last time the
 * user interacted with the App. This ´last_acted_on´ has to be set for the first time when the user signs in, after
 * that it will be set in this method everytime an interaction is made and the timeout isn't passed.
 *
 * If the timeout is passed the session will be restarted by {@link session_re_start()}
 *
 * @return void
 */
function check_user_activity()
{
    if ((isset($_SESSION['__user']) && $_SESSION['__user']['is_active'] === 0)
        || (isset($_SESSION['last_acted_on']) && (time() - $_SESSION['last_acted_on'] > timeout))) {
        session_re_start();
    } else {
        session_regenerate_id(true);
        $_SESSION['last_acted_on'] = time();
    }
}