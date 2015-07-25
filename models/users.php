<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author NgoCo
 */
class Users {

    private $userid;
    private $username;
    private $password;
    private $fullname;
    private $address;
    private $birthday;
    private $phonenumber;
    private $gender;
    private $email;
    private $createtime;
    private $updatetime;
    private $groupid;

    function getUserid() {
        return $this->userid;
    }

    function getUsername() {
        return $this->username;
    }

    function getPassword() {
        return $this->password;
    }

    function getFullname() {
        return $this->fullname;
    }

    function getAddress() {
        return $this->address;
    }

    function getBirthday() {
        return $this->birthday;
    }

    function getPhonenumber() {
        return $this->phonenumber;
    }

    function getGender() {
        return $this->gender;
    }

    function getEmail() {
        return $this->email;
    }

    function getCreatetime() {
        return $this->createtime;
    }

    function getUpdatetime() {
        return $this->updatetime;
    }

    function getGroupid() {
        return $this->groupid;
    }

    function setUserid($userid) {
        $this->userid = $userid;
    }

    function setUsername($username) {
        $this->username = $username;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    function setAddress($address) {
        $this->address = $address;
    }

    function setBirthday($birthday) {
        $this->birthday = $birthday;
    }

    function setPhonenumber($phonenumber) {
        $this->phonenumber = $phonenumber;
    }

    function setGender($gender) {
        $this->gender = $gender;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCreatetime($createtime) {
        $this->createtime = $createtime;
    }

    function setUpdatetime($updatetime) {
        $this->updatetime = $updatetime;
    }

    function setGroupid($groupid) {
        $this->groupid = $groupid;
    }

    function __construct1($userid, $username, $password, $fullname, $address, $birthday, $phonenumber, $gender, $email, $createtime, $updatetime, $groupid) {
        $this->userid = $userid;
        $this->username = $username;
        $this->password = $password;
        $this->fullname = $fullname;
        $this->address = $address;
        $this->birthday = $birthday;
        $this->phonenumber = $phonenumber;
        $this->gender = $gender;
        $this->email = $email;
        $this->createtime = $createtime;
        $this->updatetime = $updatetime;
        $this->groupid = $groupid;
    }

    function __construct() {
        
    }

}
