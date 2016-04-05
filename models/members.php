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
    private $name;
    private $administrator;
    private $groupId;
    private $realName;
    private $address1;
    private $address2;
    private $birthday;
    private $phoneNumber1;
    private $phoneNumber2;
    private $email;
    private $gender;
    private $class;
    private $school;
    private $facebookLink;
    private $facebookProfileId;
    private $createTime;
    private $updateTime;

    function __construct() {
        
    }

    function getFacebookLink() {
        return $this->facebookLink;
    }

    function setFacebookLink($facebookLink) {
        $this->facebookLink = $facebookLink;
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

    function getRealName() {
        return $this->realName;
    }

    function getAddress1() {
        return $this->address1;
    }

    function getAddress2() {
        return $this->address2;
    }

    function getBirthday() {
        return $this->birthday;
    }

    function getPhoneNumber1() {
        return $this->phoneNumber1;
    }

    function getPhoneNumber2() {
        return $this->phoneNumber2;
    }

    function getEmail() {
        return $this->email;
    }

    function getGender() {
        return $this->gender;
    }

    function getClass() {
        return $this->class;
    }

    function getSchool() {
        return $this->school;
    }

    function getFacebookProfileId() {
        return $this->facebookProfileId;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function getUpdateTime() {
        return $this->updateTime;
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

    function setRealName($realName) {
        $this->realName = $realName;
    }

    function setAddress1($address1) {
        $this->address1 = $address1;
    }

    function setAddress2($address2) {
        $this->address2 = $address2;
    }

    function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    function setPhoneNumber1($phoneNumber1) {
        $this->phoneNumber1 = $phoneNumber1;
    }

    function setPhoneNumber2($phoneNumber2) {
        $this->phoneNumber2 = $phoneNumber2;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setClass($class) {
        $this->class = $class;
    }

    function setSchool($school) {
        $this->school = $school;
    }

    function setFacebookProfileId($facebookProfileId) {
        $this->facebookProfileId = $facebookProfileId;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;
    }

}

?>
