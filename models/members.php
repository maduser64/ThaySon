<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Members
 *
 * @author TriTueViet
 */
class Members {

    private $memberId;
    private $facebookIdMember;
    private $facebookProfileId;
    private $name;
    private $administrator;
    private $groupId;
    private $fullname;
    private $address1;
    private $address2;
    private $phoneNumber1;
    private $phoneNumber2;
    private $class;
    private $school;
    private $email;

    function __construct() {
        
    }
    function getFacebookProfileId() {
        return $this->facebookProfileId;
    }

    function setFacebookProfileId($facebookProfileId) {
        $this->facebookProfileId = $facebookProfileId;
    }

        function getFullname() {
        return $this->fullname;
    }

    function getClass() {
        return $this->class;
    }

    function getEmail() {
        return $this->email;
    }

    function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    function setClass($class) {
        $this->class = $class;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getMemberId() {
        return $this->memberId;
    }

    function getFacebookIdMember() {
        return $this->facebookIdMember;
    }

    function getName() {
        return $this->name;
    }

    function getAdministrator() {
        return $this->administrator;
    }

    function getGroupId() {
        return $this->groupId;
    }

    function setMemberId($memberId) {
        $this->memberId = $memberId;
    }

    function setFacebookIdMember($facebookIdMember) {
        $this->facebookIdMember = $facebookIdMember;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setAdministrator($administrator) {
        $this->administrator = $administrator;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }
    function getAddress1() {
        return $this->address1;
    }

    function getAddress2() {
        return $this->address2;
    }

    function getPhoneNumber1() {
        return $this->phoneNumber1;
    }

    function getPhoneNumber2() {
        return $this->phoneNumber2;
    }

    function getSchool() {
        return $this->school;
    }

    function setAddress1($address1) {
        $this->address1 = $address1;
    }

    function setAddress2($address2) {
        $this->address2 = $address2;
    }

    function setPhoneNumber1($phoneNumber1) {
        $this->phoneNumber1 = $phoneNumber1;
    }

    function setPhoneNumber2($phoneNumber2) {
        $this->phoneNumber2 = $phoneNumber2;
    }

    function setSchool($school) {
        $this->school = $school;
    }
}

?>
