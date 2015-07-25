<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Status
 *
 * @author NgoCo
 */
class Status {
    private $statusid;
    private $name;
    private $description;
    
    function __construct() {
        
    }
    
    function getStatusid() {
        return $this->statusid;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function setStatusid($statusid) {
        $this->statusid = $statusid;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

}
