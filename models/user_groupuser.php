<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_GroupUser {

    private $userGroupUserId;
    private $userId;
    private $groupUserId;

    function __construct() {
        
    }

    function getUserGroupUserId() {
        return $this->userGroupUserId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getGroupUserId() {
        return $this->groupUserId;
    }

    function setUserGroupUserId($userGroupUserId) {
        $this->userGroupUserId = $userGroupUserId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setGroupUserId($groupUserId) {
        $this->groupUserId = $groupUserId;
    }

}

?>