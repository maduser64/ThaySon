<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of User_role
 *
 * @author TriTueViet
 */
class User_role {

    private $userRoleId;
    private $roleId;
    private $userId;
    function __construct() {
        
    }
    function getUserRoleId() {
        return $this->userRoleId;
    }

    function getRoleId() {
        return $this->roleId;
    }

    function getUserId() {
        return $this->userId;
    }

    function setUserRoleId($userRoleId) {
        $this->userRoleId = $userRoleId;
    }

    function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }


}
