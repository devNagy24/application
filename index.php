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
require_once('model/validation.php');
require_once('model/applicant.php');
require_once('model/applicant_subscribed.php');
require_once('controllers/controller.php'); 

// Create an F3 (Fat-Free Framework) object
$f3 = Base::instance();

// Create the Controller
$controller = new Controller();

// Define the routes
$f3->route('GET /', function() use ($controller) {
    $controller->home();
});

$f3->route('GET|POST /information', function() use ($controller) {
    $controller->information();
});

$f3->route('GET|POST /experience', function() use ($controller) {
    $controller->experience();
});

$f3->route('GET|POST /mailingList', function() use ($controller) {
    $controller->mailingList();
});

// FA Icons Route
$icons = [
    'devSkills' => [
        'JavaScript' => '<i class="fa-brands fa-square-js" style="color: #c6b60c;"></i> JavaScript',
        'HTML5' => '<i class="fa-brands fa-html5" style="color: #e20303;"></i> HTML5',
        'CSS' => '<i class="fa-brands fa-css3-alt" style="color: #3d68b3;"></i> CSS',
        'PHP' => '<i class="fa-brands fa-php" style="color: #5d5bf1;"></i> PHP',
        'Java' => '<i class="fa-brands fa-java" style="color: #d36d0d;"></i> Java',
        'Python' => '<i class="fa-brands fa-python"></i> Python',
        'React Native' => '<i class="fa-brands fa-react" style="color: #5f8ddd;"></i> React Native',
        'NodeJS' => '<i class="fa-brands fa-node" style="color: #1cb011;"></i> NodeJS',
    ],
    'industries' => [
        'SASS' => '<i class="fa-brands fa-sass" style="color: #c816d4;"></i> SASS',
        'Industrial Tech' => '<i class="fa-solid fa-industry" style="color: #224177;"></i> Industrial Tech',
        'Health Tech' => '<i class="fa-solid fa-notes-medical" style="color: #96272c;"></i> Health Tech',
        'AG Tech' => '<i class="fa-solid fa-leaf" style="color: #2a8a24;"></i> AG Tech',
        'HR Tech' => '<i class="fa-solid fa-person-through-window" style="color: #bc600b;"></i> HR Tech',
        'Cybersecurity' => '<i class="fa-solid fa-shield-halved" style="color: #3d73d1;"></i> Cybersecurity',
    ],
];

$f3->set('icons', $icons);

$f3->route('GET /summary', function() use ($controller) {
    $controller->summary();
});


// Run Fat-Free
$f3->run();