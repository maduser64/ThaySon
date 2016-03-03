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
class Feeds {

    private $feedId;
    private $facebookIdFeed;
    private $facebookUserIdFeed;
    private $message;
    private $createFeedTime;
    private $updateFeedTime;
    private $groupId;
    private $statusId;
    private $createTime;
    private $updateTime;

    function __construct() {
        
    }

    function getFeedId() {
        return $this->feedId;
    }

    function getFacebookIdFeed() {
        return $this->facebookIdFeed;
    }

    function getFacebookUserIdFeed() {
        return $this->facebookUserIdFeed;
    }

    function getMessage() {
        return $this->message;
    }

    function getCreateFeedTime() {
        return $this->createFeedTime;
    }

    function getUpdateFeedTime() {
        return $this->updateFeedTime;
    }

    function getGroupId() {
        return $this->groupId;
    }

    function getStatusId() {
        return $this->statusId;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function getUpdateTime() {
        return $this->updateTime;
    }

    function setFeedId($feedId) {
        $this->feedId = $feedId;
    }

    function setFacebookIdFeed($facebookIdFeed) {
        $this->facebookIdFeed = $facebookIdFeed;
    }

    function setFacebookUserIdFeed($facebookUserIdFeed) {
        $this->facebookUserIdFeed = $facebookUserIdFeed;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setCreateFeedTime($createFeedTime) {
        $this->createFeedTime = $createFeedTime;
    }

    function setUpdateFeedTime($updateFeedTime) {
        $this->updateFeedTime = $updateFeedTime;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    function setStatusId($statusId) {
        $this->statusId = $statusId;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;
    }

}
