<?php

class Applicant {
    private $_fname;
    private $_lname;
    private $_email;
    private $_state;
    private $_phone;
    private $_github;
    private $_experience;
    private $_relocate;
    private $_bio;

    public function __construct($fname, $lname, $email, $state, $phone) {
        $this->_fname = $fname;
        $this->_lname = $lname;
        $this->_email = $email;
        $this->_state = $state;
        $this->_phone = $phone;
    }

    public function setGithub($github) {
        $this->_github = $github;
    }

    public function getGithub() {
        return $this->_github;
    }

    public function setExperience($experience) {
        $this->_experience = $experience;
    }

    public function getExperience() {
        return $this->_experience;
    }

    public function setRelocate($relocate) {
        $this->_relocate = $relocate;
    }

    public function getRelocate() {
        return $this->_relocate;
    }

    public function setBio($bio) {
        $this->_bio = $bio;
    }

    public function getBio() {
        return $this->_bio;
    }

    public function getFname() {
        return $this->_fname;
    }

    public function getLname() {
        return $this->_lname;
    }

    public function getEmail() {
        return $this->_email;
    }

    public function getState() {
        return $this->_state;
    }

    public function getPhone() {
        return $this->_phone;
    }
}
