<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_role
 *
 * @author NgoCo
 */
class User_role {

    private $userroleid;
    private $roleid;
    private $userid;
    function __construct() {
        
    }
    function getUserroleid() {
        return $this->userroleid;
    }

    function getRoleid() {
        return $this->roleid;
    }

    function getUserid() {
        return $this->userid;
    }

    function setUserroleid($userroleid) {
        $this->userroleid = $userroleid;
    }

    function setRoleid($roleid) {
        $this->roleid = $roleid;
    }

    function setUserid($userid) {
        $this->userid = $userid;
    }




}
