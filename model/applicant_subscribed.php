<?php

class Applicant_SubscribedToLists extends Applicant {
    private $_selectionsJobs = [];
    private $_selectionsVerticals = [];

    public function __construct($fname, $lname, $email, $state, $phone) {
        parent::__construct($fname, $lname, $email, $state, $phone);
    }

    /**
     * Get the value of _selectionsJobs
     */
    public function getSelectionsJobs() {
        return $this->_selectionsJobs;
    }

    /**
     * Set the value of _selectionsJobs
     *
     * @return  self
     */
    public function setSelectionsJobs($selectionsJobs) {
        $this->_selectionsJobs = $selectionsJobs;

        return $this;
    }

    /**
     * Get the value of _selectionsVerticals
     */
    public function getSelectionsVerticals() {
        return $this->_selectionsVerticals;
    }

    /**
     * Set the value of _selectionsVerticals
     *
     * @return  self
     */
    public function setSelectionsVerticals($selectionsVerticals) {
        $this->_selectionsVerticals = $selectionsVerticals;

        return $this;
    }
}
