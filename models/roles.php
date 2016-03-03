<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Roles
 *
 * @author TriTueViet
 */
class Roles {

    private $roleId;
    private $roleName;
    private $description;

    function __construct() {
        
    }

    function getRoleId() {
        return $this->roleId;
    }

    function getRoleName() {
        return $this->roleName;
    }

    function getDescription() {
        return $this->description;
    }

    function setRoleId($roleId) {
        $this->roleId = $roleId;
    }

    function setRoleName($roleName) {
        $this->roleName = $roleName;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
