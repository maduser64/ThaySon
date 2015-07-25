<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Feeds
 *
 * @author NgoCo
 */
class Feeds {

    private $feedid;
    private $facebookidfeed;
    private $facebookuseridfeed;
    private $message;
    private $createfeedtime;
    private $updatefeedtime;
    private $createtime;
    private $updatetime;
    private $groupid;
    private $statusid;

    function __construct() {
        
    }

    function getFeedid() {
        return $this->feedid;
    }

    function getFacebookidfeed() {
        return $this->facebookidfeed;
    }

    function getFacebookuseridfeed() {
        return $this->facebookuseridfeed;
    }

    function getMessage() {
        return $this->message;
    }

    function getCreatefeedtime() {
        return $this->createfeedtime;
    }

    function getUpdatefeedtime() {
        return $this->updatefeedtime;
    }

    function getCreatetime() {
        return $this->createtime;
    }

    function getUpdatetime() {
        return $this->updatetime;
    }

    function getGroupid() {
        return $this->groupid;
    }

    function getStatusid() {
        return $this->statusid;
    }

    function setFeedid($feedid) {
        $this->feedid = $feedid;
    }

    function setFacebookidfeed($facebookidfeed) {
        $this->facebookidfeed = $facebookidfeed;
    }

    function setFacebookuseridfeed($facebookuseridfeed) {
        $this->facebookuseridfeed = $facebookuseridfeed;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setCreatefeedtime($createfeedtime) {
        $this->createfeedtime = $createfeedtime;
    }

    function setUpdatefeedtime($updatefeedtime) {
        $this->updatefeedtime = $updatefeedtime;
    }

    function setCreatetime($createtime) {
        $this->createtime = $createtime;
    }

    function setUpdatetime($updatetime) {
        $this->updatetime = $updatetime;
    }

    function setGroupid($groupid) {
        $this->groupid = $groupid;
    }

    function setStatusid($statusid) {
        $this->statusid = $statusid;
    }

}
