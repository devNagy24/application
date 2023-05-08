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
$f3->route('GET /home', function() {
    // Display a view page
    $view = new Template();
    echo $view->render('views/home.html');
});

// Define a route for the Personal Information page (GET/POST request)
$f3->route('GET|POST /information', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];

        // Store the data in the session array
        $f3->set('SESSION.firstName', $firstName);
        $f3->set('SESSION.lastName', $lastName);
        $f3->set('SESSION.email', $email);
        $f3->set('SESSION.phone', $phone);

        // Redirect to Experience page
        $f3->reroute('/experience');

    }

    // Display a view page
    $view = new Template();
    echo $view->render('views/information.html');
});

$f3->route('GET|POST /experience', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $yearsExperience = $_POST['yearsExperience'] ?? null;
        $skills = $_POST['skills'] ?? null;

        $f3->set('SESSION.yearsExperience', $yearsExperience);
        $f3->set('SESSION.skills', $skills);

        // Process dynamic experience fields
        $experienceData = [];
        $index = 0;
        while (isset($_POST['company' . $index])) {
            $experience = [
                'company' => $_POST['company' . $index],
                'position' => $_POST['position' . $index],
                'startDate' => $_POST['startDate' . $index],
                'endDate' => $_POST['endDate' . $index],
                'description' => $_POST['description' . $index]
            ];
            $experienceData[] = $experience;
            $index++;
        }
        $f3->set('SESSION.experienceData', $experienceData);

        $f3->reroute('/mailingList');
    }

    // Display a view page
    $view = new Template();
    echo $view->render('views/experience.html');
});



// Define a route for the Mailing Lists page (GET/POST request)
$f3->route('GET|POST /mailingList', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $mailingListEmail = $_POST['mailingListEmail'];
        $newsletterCheck = isset($_POST['newsletterCheck']) ? true : false;

        $f3->set('SESSION.mailingListEmail', $mailingListEmail);
        $f3->set('SESSION.newsletterCheck',$newsletterCheck);

        $f3->reroute('/');

    }

    // Display a view page
    $view = new Template();
    echo $view->render('views/mailingList.html');
});

//
$f3->route('GET /success', function() {
    // Display a view page
    $view = new Template();
    echo $view->render('views/successView.html');
});



// Run Fat-Free
$f3->run();