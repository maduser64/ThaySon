<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author TriTueViet
 */
class Users {

    private $userId;
    private $userName;
    private $password;
    private $fullName;
    private $address1;
    private $address2;
    private $birthday;
    private $avatar;
    private $phoneNumber1;
    private $phoneNumber2;
    private $gender;
    private $email;
    private $school;
    private $class;
    private $createTime;
    private $updateTime;

    function __construct() {
        
    }
    function getAvatar() {
        return $this->avatar;
    }

    function setAvatar($avatar) {
        $this->avatar = $avatar;
    }

        function getAddress1() {
        return $this->address1;
    }
    function getSchool() {
        return $this->school;
    }

    function getClass() {
        return $this->class;
    }

    function setSchool($school) {
        $this->school = $school;
    }

    function setClass($class) {
        $this->class = $class;
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

        function getUserId() {
        return $this->userId;
    }

    function getUserName() {
        return $this->userName;
    }

    function getPassword() {
        return $this->password;
    }

    function getFullName() {
        return $this->fullName;
    }
    function getBirthday() {
        return $this->birthday;
    }
    function getGender() {
        return $this->gender;
    }

    function getEmail() {
        return $this->email;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function getUpdateTime() {
        return $this->updateTime;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setUserName($userName) {
        $this->userName = $userName;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setFullName($fullName) {
        $this->fullName = $fullName;
    }
    function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;
    }

}
