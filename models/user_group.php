<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class User_group {

    private $userGroupId;
    private $userId;
    private $groupId;

    function __construct() {
        
    }

    function getUserGroupId() {
        return $this->userGroupId;
    }

    function getUserId() {
        return $this->userId;
    }

    function getGroupId() {
        return $this->groupId;
    }

    function setUserGroupId($userGroupId) {
        $this->userGroupId = $userGroupId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

}

?>