<?php

//function validName($name) {
//    return ctype_alpha(str_replace(' ', '', $name));
//}
//
//// Validate description: we assume a valid description is non-empty
//function validDescription($description) {
//    // trim whitespace from beginning and end of string
//    $trimmedDescription = trim($description);
//
//    // check if the trimmed string is not empty and not just whitespace
//    return !empty($trimmedDescription) && ctype_graph($trimmedDescription);
//}
//
//// valid GitHub URL starts with 'https://github.com/'
//function validGithub($url) {
//    return filter_var($url, FILTER_VALIDATE_URL);
//}
//
//function validExperience($experience) {
//    $validExperiences = ["0-2", "2-4", "4-6", "6+"];
//
//    // Check if the submitted experience value is in the list of valid experiences
//    return in_array($experience, $validExperiences);
//}
//
//function validPhone($phone) {
//    // valid phone number contains only numbers and has length of 10
//    return preg_match("/^[0-9]{10}$/", $phone);
//}
//
//function validEmail($email) {
//    return filter_var($email, FILTER_VALIDATE_EMAIL);
//}
//
//
//
//function validRelocate($relocate) {
//    $validRelocateStatuses = ["yes", "no"];
//
//    // Check if the submitted relocate status is in the list of valid statuses
//    return in_array($relocate, $validRelocateStatuses);
//}
//
//function validSelectionsJobs($selectedSkills) {
//    // This checks each selected dev skill against a list of valid options
//    $validSkills = ["JavaScript", "HTML5", "CSS", "PHP", "Java", "Python", "React Native", "NodeJS"];
//    foreach ($selectedSkills as $skill) {
//        if (!in_array($skill, $validSkills)) {
//            return false;
//        }
//    }
//    return true;
//}
//
//function validSelectionsVerticals($selectedIndustries) {
//    // This checks each selected industry against a list of valid options
//    $validIndustries = ["SASS", "Industrial Tech", "Health Tech", "AG Tech", "HR Tech", "Cybersecurity"];
//    foreach ($selectedIndustries as $industry) {
//        if (!in_array($industry, $validIndustries)) {
//            return false;
//        }
//    }
//    return true;
//}
//
//
//


class ValidationModel
{

    public static function validName($name)
    {
        return ctype_alpha(str_replace(' ', '', $name));
    }

    public static function validDescription($description)
    {
        $trimmedDescription = trim($description);
        return !empty($trimmedDescription) && ctype_graph($trimmedDescription);
    }

    public static function validGithub($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL);
    }

    public static function validExperience($experience)
    {
        $validExperiences = ["0-2", "2-4", "4-6", "6+"];
        return in_array($experience, $validExperiences);
    }

    public static function validPhone($phone)
    {
        return preg_match("/^[0-9]{10}$/", $phone);
    }

    public static function validEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    public static function validRelocate($relocate)
    {
        $validRelocateStatuses = ["yes", "no"];
        return in_array($relocate, $validRelocateStatuses);
    }

    public static function validSelectionsJobs($selectedSkills)
    {
        $validSkills = ["JavaScript", "HTML5", "CSS", "PHP", "Java", "Python", "React Native", "NodeJS"];
        foreach ($selectedSkills as $skill) {
            if (!in_array($skill, $validSkills)) {
                return false;
            }
        }
        return true;
    }

    public static function validSelectionsVerticals($selectedIndustries)
    {
        $validIndustries = ["SASS", "Industrial Tech", "Health Tech", "AG Tech", "HR Tech", "Cybersecurity"];
        foreach ($selectedIndustries as $industry) {
            if (!in_array($industry, $validIndustries)) {
                return false;
            }
        }
        return true;
    }
}
