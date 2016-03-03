<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Status
 *
 * @author TriTueViet
 */
class Status {
    private $statusId;
    private $name;
    private $description;
    
    function __construct() {
        
    }
    function getStatusId() {
        return $this->statusId;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function setStatusId($statusId) {
        $this->statusId = $statusId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }


}
