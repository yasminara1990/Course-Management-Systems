<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registration
 *
 * @author Jezzie
 */
class Registration {
    private $fullName;
    private $gender;
    private $dob;
    private $email;
    private $regType;
    private $password;
    private $confirmPassword;
    
    function getFullName() {
        return $this->fullName;
    }

    function getGender() {
        return $this->gender;
    }

    function getDob() {
        return $this->dob;
    }

    function getEmail() {
        return $this->email;
    }

    function getRegType() {
        return $this->regType;
    }

    function getPassword() {
        return $this->password;
    }

    function getConfirmPassword() {
        return $this->confirmPassword;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setDob($dob) {
        $this->dob = $dob;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setRegType($regType) {
        $this->regType = $regType;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setConfirmPassword($confirmPassword) {
        $this->confirmPassword = $confirmPassword;
    }
}
?>
