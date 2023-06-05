<?php

class Controller {
private $f3; //hold the f3 instance
private $validator; // hold the validator instance

function __construct() {
$this->f3 = Base::instance(); //get the f3 instance from the base
$this->validator = new ValidationModel();
}

function home() {
// Display a view page
$view = new Template();
echo $view->render('views/home.html');
}

function information() {
if ($_SERVER['REQUEST_METHOD'] == "POST") {
$firstName = $_POST['firstName'];
$lastName = $_POST['lastName'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$state = $_POST['state'];
$mailingListOptIn = isset($_POST['mailingListOptIn']) ? $_POST['mailingListOptIn'] : 0;

// Validation checks
if (!$this->validator->validName($firstName)) {
$this->f3->set('errors["firstName"]', "First name is invalid");
}
if (!$this->validator->validName($lastName)) {
$this->f3->set('errors["lastName"]', "Last name is invalid");
}
if (!$this->validator->validEmail($email)) {
$this->f3->set('errors["email"]', "Email is invalid");
}
if (!$this->validator->validPhone($phone)) {
$this->f3->set('errors["phone"]', "Phone is invalid");
}

// If there are no errors
if (empty($this->f3->get('errors'))) {
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
$this->f3->set('SESSION.applicant', serialize($applicant));

// Redirect to Experience page
$this->f3->reroute('/experience');
}
}

// Display a view page
$view = new Template();
echo $view->render('views/information.html');
}

// experience
    function experience() {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $yearsExperience = $_POST['yearsExperience'] ?? null;
            $desc = $_POST['description'] ?? null;
            $githubLink = $_POST['githubLink'] ?? null;
            $relocateStatus = $_POST['relocateStatus'] ?? null;

            // Validation checks
            if (!$this->validator->validExperience($yearsExperience)) {
                $this->f3->set('errors["yearsExperience"]', "Experience is invalid");
            }

            if (!$this->validator->validDescription($desc)) {
                $this->f3->set('errors["description"]', "Description is invalid");
            }
            if (!$this->validator->validGithub($githubLink)) {
                $this->f3->set('errors["githubLink"]', "GitHub link is invalid");
            }

            if (!$this->validator->validExperience($yearsExperience)) {
                $this->f3->set('errors["yearsExperience"]', "Please select your years of experience");
            }

            if (!$this->validator->validRelocate($relocateStatus)) {
                $this->f3->set('errors["relocateStatus"]', "Please select if you're willing to relocate or not");
            }

            // If there are no errors
            if (empty($this->f3->get('errors'))) {
                $applicant = unserialize($this->f3->get('SESSION.applicant'));

                $applicant->setExperience($yearsExperience);
                $applicant->setBio($desc);
                $applicant->setGithub($githubLink);
                $applicant->setRelocate($relocateStatus);

                // Store the data in the session array
                $this->f3->set('SESSION.applicant', serialize($applicant));
                $this->f3->reroute('/mailingList');
            }
        }

        // Display a view page
        $view = new Template();
        echo $view->render('views/experienceV2.html');
    }

    function mailingList() {
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
            if (!$this->validator->validSelectionsJobs($devSkills)) {
                $this->f3->set('errors["devSkills"]', 'Invalid skill selection');
            }

            if (!$this->validator->validSelectionsVerticals($industries)) {
                $this->f3->set('errors["industries"]', 'Invalid industry selection');
            }

            // If there are no errors, reroute to the summary page
            if (empty($this->f3->get('errors'))) {
                $applicant = unserialize($this->f3->get('SESSION.applicant'));
                if ($applicant instanceof Applicant_SubscribedToLists) {
                    $applicant->setSelectionsJobs($devSkills);
                    $applicant->setSelectionsVerticals($industries);
                }

                // Store the data in the session array
                $this->f3->set('SESSION.applicant', serialize($applicant));
                $this->f3->reroute('/summary');
            }
        }

        // Display the form view
        $view = new Template();
        echo $view->render('views/mailingList.html');
    }

    function summary() {
        $applicant = unserialize($this->f3->get('SESSION.applicant'));

        $this->f3->set('firstName', $applicant->getFname());
        $this->f3->set('lastName', $applicant->getLname());
        $this->f3->set('email', $applicant->getEmail());
        $this->f3->set('phone', $applicant->getPhone());
        $this->f3->set('state', $applicant->getState());
        $this->f3->set('yearsExperience', $applicant->getExperience());
        $this->f3->set('description', $applicant->getBio());

        if ($applicant instanceof Applicant_SubscribedToLists) {
            $this->f3->set('devSkills', $applicant->getSelectionsJobs());
            $this->f3->set('industries', $applicant->getSelectionsVerticals());
        }

        // Display the form view
        $view = new Template();
        echo $view->render('views/summary.html');
    }

}
