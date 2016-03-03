<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feeds
 *
 * @author TriTueViet
 */
class GroupUser {

    private $groupUserId;
    private $name;
    private $description;
    private $userId;
    private $createTime;
    private $updateTime;
    
    function __construct() {
        
    }
    
    function getGroupUserId() {
        return $this->groupUserId;
    }

    function getName() {
        return $this->name;
    }

    function getDescription() {
        return $this->description;
    }

    function getUserId() {
        return $this->userId;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function getUpdateTime() {
        return $this->updateTime;
    }

    function setGroupUserId($groupUserId) {
        $this->groupUserId = $groupUserId;
    }

    function setName($name) {
        $this->name = $name;
    }

    function setDescription($description) {
        $this->description = $description;
    }

    function setUserId($userId) {
        $this->userId = $userId;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;
    }


}
