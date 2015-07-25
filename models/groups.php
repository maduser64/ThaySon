<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groups
 *
 * @author NgoCo
 */
class Groups {
    private $groupid;
    private $facebookgroupid;
    private $name;
    private $privacy;
    private $description;
    private $icon;
    private $email;
    private $owner;
    private $creategrouptime;
    private $createtime;
    
    private $userid;

    function __construct() {
        
    }
    function getGroupid() {
        return $this->groupid;
    }

    function getName() {
        return $this->name;
    }

    function getPrivacy() {
        return $this->privacy;
    }

    function getDescription() {
        return $this->description;
    }

    function getIcon() {
        return $this->icon;
    }

    function getEmail() {
        return $this->email;
    }

    function getOwner() {
        return $this->owner;
    }

    function getUserid() {
        return $this->userid;
    }

    function getCreategrouptime() {
        return $this->creategrouptime;
    }

    function getCreatetime() {
        return $this->createtime;
    }

    function setGroupid($groupid) {
        $this->groupid = $groupid;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setPrivacy($privacy) {
        $this->privacy = $privacy;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setIcon($icon) {
        $this->icon = $icon;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setOwner($owner) {
        $this->owner = $owner;
    }

    function setUserid($userid) {
        $this->userid = $userid;
    }

    function setCreategrouptime($creategrouptime) {
        $this->creategrouptime = $creategrouptime;
    }

    function setCreatetime($createtime) {
        $this->createtime = $createtime;
    }
    function getFacebookgroupid() {
        return $this->facebookgroupid;
    }

    function setFacebookgroupid($facebookgroupid) {
        $this->facebookgroupid = $facebookgroupid;
    }




}
