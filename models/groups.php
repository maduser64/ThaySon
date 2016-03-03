<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Groups
 *
 * @author TriTueViet
 */
class Groups {

    private $groupId;
    private $facebookGroupId;
    private $name;
    private $privacy;
    private $description;
    private $icon;
    private $email;
    private $owner;
    private $createGroupTime;
    private $createTime;

    function __construct() {
        
    }

    function getGroupId() {
        return $this->groupId;
    }

    function getFacebookGroupId() {
        return $this->facebookGroupId;
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

    function getCreateGroupTime() {
        return $this->createGroupTime;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    function setFacebookGroupId($facebookGroupId) {
        $this->facebookGroupId = $facebookGroupId;
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

    function setCreateGroupTime($createGroupTime) {
        $this->createGroupTime = $createGroupTime;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

}
