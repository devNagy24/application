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

$f3->route('GET /', function() {
    // Display a view page
    $view = new Template();
    echo $view->render('views/home.html');
});


// Define a route for the Personal Information page (GET/POST request)
$f3->route('GET|POST /information', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        var_dump($_POST);
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $state = $_POST['state'];

        // Store the data in the session array
        $f3->set('SESSION.firstName', $firstName);
        $f3->set('SESSION.lastName', $lastName);
        $f3->set('SESSION.email', $email);
        $f3->set('SESSION.phone', $phone);
        $f3->set('SESSION.state', $state);

        // Redirect to Experience page
        $f3->reroute('/experience');

    }

    // Display a view page
    $view = new Template();
    echo $view->render('views/information.html');
});

$f3->route('GET|POST /experience', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        var_dump($_POST);
        $yearsExperience = $_POST['yearsExperience'] ?? null;
        $skills = $_POST['skills'] ?? null;
        $desc = $_POST['description'] ?? null;

        $f3->set('SESSION.yearsExperience', $yearsExperience);
        $f3->set('SESSION.skills', $skills);
        $f3->set('SESSION.description', $desc);


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
    echo $view->render('views/experienceV2.html');
});



// Define a route for the Mailing Lists page (GET/POST request)
$f3->route('GET|POST /mailingList', function($f3) {

    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Get the POST data
        $devSkills = $_POST['devSkills'];
        $industries = $_POST['industries'];

        // Implode arrays into comma-separated strings
        $devSkillsStr = implode(", ", $devSkills);
        $industriesStr = implode(", ", $industries);

        // Store the data in the session array
        $f3->set('SESSION.devSkills', $devSkillsStr);
        $f3->set('SESSION.industries', $industriesStr);


        // Redirect to the success page
        $f3->reroute('/summary');

    }
    // Display a view page
    $view = new Template();
    echo $view->render('views/mailingList.html');
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


// Summary Page route
$f3->route('GET /summary', function() {
    // Display a view page
    $view = new Template();
    echo $view->render('views/summary.html');

    session_destroy();

});

// Run Fat-Free
$f3->run();