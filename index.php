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

// Create an F3 (Fat-Free Framework) object
$f3 = Base::instance();

$f3->route('GET /', function() {
    // Display a view page
    $view = new Template();
    echo $view->render('views/home.html');
});


$f3->route('GET|POST /information', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $state = $_POST['state'];
        $mailingListOptIn = isset($_POST['mailingListOptIn']) ? $_POST['mailingListOptIn'] : 0;

        // Validation checks
        if (!validName($firstName)) {
            $f3->set('errors["firstName"]', "First name is invalid");
        }
        if (!validName($lastName)) {
            $f3->set('errors["lastName"]', "Last name is invalid");
        }
        if (!validEmail($email)) {
            $f3->set('errors["email"]', "Email is invalid");
        }
        if (!validPhone($phone)) {
            $f3->set('errors["phone"]', "Phone is invalid");
        }

        // If there are no errors
        if (empty($f3->get('errors'))) {
            // Check if user wants to subscribe to mailing list
            $subscribe = $mailingListOptIn == 1;

            if ($subscribe) {
                $applicant = new Applicant_SubscribedToLists(
                    $firstName,
                    $lastName,
                    $email,
                    $state,
                    $phone
                );
            } else {
                $applicant = new Applicant(
                    $firstName,
                    $lastName,
                    $email,
                    $state,
                    $phone
                );
            }

            // Store the applicant object in the session
            $f3->set('SESSION.applicant', serialize($applicant));

            // Redirect to Experience page
            $f3->reroute('/experience');
        }
    }

    // Display a view page
    $view = new Template();
    echo $view->render('views/information.html');
});




// Define a route for the Information page
//$f3->route('GET|POST /information', function($f3) {
//    if ($_SERVER['REQUEST_METHOD'] == "POST") {
//        $firstName = $_POST['firstName'];
//        $lastName = $_POST['lastName'];
//        $email = $_POST['email'];
//        $phone = $_POST['phone'];
//        $state = $_POST['state'];
//
//
//
//        // Validation checks
//        if (!validName($firstName)) {
//            $f3->set('errors["firstName"]', "First name is invalid");
//        }
//        if (!validName($lastName)) {
//            $f3->set('errors["lastName"]', "Last name is invalid");
//        }
//        if (!validEmail($email)) {
//            $f3->set('errors["email"]', "Email is invalid");
//        }
//        if (!validPhone($phone)) {
//            $f3->set('errors["phone"]', "Phone is invalid");
//        }
//
//
//        // If there are no errors
//        if (empty($f3->get('errors'))) {
//            // Store the data in the session array
//            $f3->set('SESSION.firstName', $firstName);
//            $f3->set('SESSION.lastName', $lastName);
//            $f3->set('SESSION.email', $email);
//            $f3->set('SESSION.phone', $phone);
//            $f3->set('SESSION.state', $state);
//
//            // Redirect to Experience page
//            $f3->reroute('/experience');
//        }
//    }
//
//    // Display a view page
//    $view = new Template();
//    echo $view->render('views/information.html');
//});

// /experience route
$f3->route('GET|POST /experience', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $yearsExperience = $_POST['yearsExperience'] ?? null;
        $desc = $_POST['description'] ?? null;
        $githubLink = $_POST['githubLink'] ?? null;
        $relocateStatus = $_POST['relocateStatus'] ?? null;

        // Validation checks
        if (!validExperience($yearsExperience)) {
            $f3->set('errors["yearsExperience"]', "Experience is invalid");
        }

        if (!validDescription($desc)) {
            $f3->set('errors["description"]', "Description is invalid");
        }
        if (!validGithub($githubLink)) {
            $f3->set('errors["githubLink"]', "GitHub link is invalid");
        }

        if (!validExperience($yearsExperience)) {
            $f3->set('errors["yearsExperience"]', "Please select your years of experience");
        }

        if (!validRelocate($relocateStatus)) {
            $f3->set('errors["relocateStatus"]', "Please select if you're willing to relocate or not");
        }

        // If there are no errors
        if (empty($f3->get('errors'))) {
            $applicant = unserialize($f3->get('SESSION.applicant'));

            $applicant->setExperience($yearsExperience);
            $applicant->setBio($desc);
            $applicant->setGithub($githubLink); // Corrected here
            $applicant->setRelocate($relocateStatus); // Corrected here

            // Store the data in the session array
            $f3->set('SESSION.applicant', serialize($applicant));
            $f3->reroute('/mailingList');
        }
    }

    // Display a view page
    $view = new Template();
    echo $view->render('views/experienceV2.html');
});

//$f3->route('GET|POST /experience', function($f3) {
//    if ($_SERVER['REQUEST_METHOD'] == "POST") {
//        $yearsExperience = $_POST['yearsExperience'] ?? null;
//        $desc = $_POST['description'] ?? null;
//        $githubLink = $_POST['githubLink'] ?? null;
//        $relocateStatus = $_POST['relocateStatus'] ?? null;
//
//        // Validation checks
//        if (!validExperience($yearsExperience)) {
//            $f3->set('errors["yearsExperience"]', "Experience is invalid");
//        }
//
//        if (!validDescription($desc)) {
//            $f3->set('errors["description"]', "Description is invalid");
//        }
//        if (!validGithub($githubLink)) {
//            $f3->set('errors["githubLink"]', "GitHub link is invalid");
//        }
//
//        if (!validExperience($yearsExperience)) {
//            $f3->set('errors["yearsExperience"]', "Please select your years of experience");
//        }
//
//        if (!validRelocate($relocateStatus)) {
//            $f3->set('errors["relocateStatus"]', "Please select if you're willing to relocate or not");
//        }
//
//
//        // If there are no errors
//        if (empty($f3->get('errors'))) {
//            $f3->set('SESSION.yearsExperience', $yearsExperience);
//            $f3->set('SESSION.description', $desc);
//            $f3->set('SESSION.githubLink', $githubLink);
//            $f3->set('SESSION.relocateStatus', $relocateStatus);
//
//            // Process dynamic experience fields
//            $experienceData = [];
//            $index = 0;
//            while (isset($_POST['company' . $index])) {
//                $experience = [
//                    'company' => $_POST['company' . $index],
//                    'position' => $_POST['position' . $index],
//                    'startDate' => $_POST['startDate' . $index],
//                    'endDate' => $_POST['endDate' . $index],
//                    'description' => $_POST['description' . $index]
//                ];
//                $experienceData[] = $experience;
//                $index++;
//            }
//            $f3->set('SESSION.experienceData', $experienceData);
//            $f3->reroute('/mailingList');
//
//        }
//
//    }
//
//// Display a view page
//        $view = new Template();
//        echo $view->render('views/experienceV2.html');
//    });
//


// /mailingList route
$f3->route('GET|POST /mailingList', function($f3) {
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        // Get the data
        $devSkills = [];

        if (isset($_POST['devSkills'])) {
            $devSkills = $_POST['devSkills'];
        }
        $industries = [];
        if (isset($_POST['industries'])) {
            $industries = $_POST['industries'];
        }

        // Validate the data
        if (!validSelectionsJobs($devSkills)) {
            $f3->set('errors["devSkills"]', 'Invalid skill selection');
        }

        if (!validSelectionsVerticals($industries)) {
            $f3->set('errors["industries"]', 'Invalid industry selection');
        }

        var_dump($devSkills);
        var_dump($industries);
        // If there are no errors, reroute to the summary page
        if (empty($f3->get('errors'))) {
            $applicant = unserialize($f3->get('SESSION.applicant'));
            if ($applicant instanceof Applicant_SubscribedToLists) {
                $applicant->setSelectionsJobs($devSkills);
                $applicant->setSelectionsVerticals($industries);
                var_dump($devSkills);
                var_dump($industries);
            }

            // Store the data in the session array
            $f3->set('SESSION.applicant', serialize($applicant));
            $f3->reroute('/summary');
        }
    }

    // Display the form view
    $view = new Template();
    echo $view->render('views/mailingList.html');
});



//// Define a route for the Mailing Lists page (GET/POST request)
//$f3->route('GET|POST /mailingList', function($f3) {
//
//    if ($_SERVER['REQUEST_METHOD'] == "POST") {
//
//           // Ensures these variables are properly defined
////        $yearsExperience = $_POST['yearsExperience'] ?? null;
////        $relocateStatus = $_POST['relocateStatus'] ?? null;
//
//
//        // Get the data
//        $devSkills = [];
//        if (isset($_POST['devSkills'])) {
//            $devSkills = $_POST['devSkills'];
//        }
//        $industries = [];
//        if (isset($_POST['industries'])) {
//            $industries = $_POST['industries'];
//        }
//
//        // Validate the data
//        if (!validSelectionsJobs($devSkills)) {
//            $f3->set('errors["devSkills"]', 'Invalid skill selection');
//        } else {
//            // Convert the array into a string for storage
//            $f3->set('SESSION.devSkills', implode(", ", $devSkills));
//        }
//
//        if (!validSelectionsVerticals($industries)) {
//            $f3->set('errors["industries"]', 'Invalid industry selection');
//        } else {
//            // Convert the array into a string for storage
//            $f3->set('SESSION.industries', implode(", ", $industries));
//        }
//
//
//        // If there are no errors, reroute to the summary page
//        if (empty($f3->get('errors'))) {
//            $f3->reroute('/summary');
//        }
//    }
//
//    // Display the form view
//    $view = new Template();
//    echo $view->render('views/mailingList.html');
//});


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

$f3->route('GET /summary', function($f3) {
    $applicant = unserialize($f3->get('SESSION.applicant'));

    $f3->set('firstName', $applicant->getFname());
    $f3->set('lastName', $applicant->getLname());
    $f3->set('email', $applicant->getEmail());
    $f3->set('phone', $applicant->getPhone());
    $f3->set('state', $applicant->getState());
    $f3->set('yearsExperience', $applicant->getExperience());
    $f3->set('description', $applicant->getBio());

    if ($applicant instanceof Applicant_SubscribedToLists) {
        $f3->set('devSkills', $applicant->getSelectionsJobs());
        $f3->set('industries', $applicant->getSelectionsVerticals());
    }

    // Display the form view
    $view = new Template();
    echo $view->render('views/summary.html');
});

//// Summary Page route
//$f3->route('GET /summary', function($f3) {
//    // Display a view page
//    $view = new Template();
//    echo $view->render('views/summary.html');
//    // FA Icons Route
//    $icons = [
//        'devSkills' => [
//            'JavaScript' => '<i class="fa-brands fa-square-js" style="color: #c6b60c;"></i> JavaScript',
//            'HTML5' => '<i class="fa-brands fa-html5" style="color: #e20303;"></i> HTML5',
//            'CSS' => '<i class="fa-brands fa-css3-alt" style="color: #3d68b3;"></i> CSS',
//            'PHP' => '<i class="fa-brands fa-php" style="color: #5d5bf1;"></i> PHP',
//            'Java' => '<i class="fa-brands fa-java" style="color: #d36d0d;"></i> Java',
//            'Python' => '<i class="fa-brands fa-python"></i> Python',
//            'React Native' => '<i class="fa-brands fa-react" style="color: #5f8ddd;"></i> React Native',
//            'NodeJS' => '<i class="fa-brands fa-node" style="color: #1cb011;"></i> NodeJS',
//        ],
//        'industries' => [
//            'SASS' => '<i class="fa-brands fa-sass" style="color: #c816d4;"></i> SASS',
//            'Industrial Tech' => '<i class="fa-solid fa-industry" style="color: #224177;"></i> Industrial Tech',
//            'Health Tech' => '<i class="fa-solid fa-notes-medical" style="color: #96272c;"></i> Health Tech',
//            'AG Tech' => '<i class="fa-solid fa-leaf" style="color: #2a8a24;"></i> AG Tech',
//            'HR Tech' => '<i class="fa-solid fa-person-through-window" style="color: #bc600b;"></i> HR Tech',
//            'Cybersecurity' => '<i class="fa-solid fa-shield-halved" style="color: #3d73d1;"></i> Cybersecurity',
//        ],
//    ];
//
//    $f3->set('icons', $icons);
//
//
//    session_destroy();
//
//});




// Run Fat-Free
$f3->run();