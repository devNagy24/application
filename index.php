<?php
/*
 * @Author: Devon Nagy
 * @Version: 1.0
 */

/*
 * Controller of application project
 */
session_start();
// Turn on error reporting
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Require the autoload file
require_once('vendor/autoload.php');

// Create an F3 (Fat-Free Framework) object
$f3 = Base::instance();

// Define a route for the home page
$f3->route('GET /', function() {
    // Display a view page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a route for the Personal Information page (GET request)
$f3->route('GET /personal-info', function() {
    // Display a view page
    $view = new Template();
    echo $view->render('views/information.html');
});

// Define a route for the Personal Information page
$f3->route('POST /information', function() {
    $_SESSION['information'] = $_POST;
    // Display a view page
    $view = new Template();
    echo $view->render('views/experience.html');
});

// Define a route for the Experience page
$f3->route('POST /experience', function() {
    $_SESSION['experience'] = $_POST;
    // Display a view page
    $view = new Template();
    echo $view->render('views/mailingLists.html');
});

// Define a route for the Mailing Lists page
$f3->route('POST /mailingLists', function() {
    $_SESSION['mailingLists'] = $_POST;
    // Handle form data or redirect to another page
});

// Run Fat-Free
$f3->run();