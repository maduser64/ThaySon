<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Roles
 *
 * @author NgoCo
 */
class Roles {
    private $roleid;
    private $rolename;
    private $description;
    function __construct() {    
    }
    
    function getRoleid() {
        return $this->roleid;
    }

    function getRolename() {
        return $this->rolename;
    }

    function getDescription() {
        return $this->description;
    }

    function setRoleid($roleid) {
        $this->roleid = $roleid;
    }

    function setRolename($rolename) {
        $this->rolename = $rolename;
    }

    function setDescription($description) {
        $this->description = $description;
    }



}
