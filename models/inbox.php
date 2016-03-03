<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Inbox {

    private $inboxId;
    private $fromUserId;
    private $toUserId;
    private $subject;
    private $content;
    private $status;
    private $sentDate;
    private $createTime;
    private $updateTime;

    function __construct() {
        
    }

    function getInboxId() {
        return $this->inboxId;
    }

    function getFromUserId() {
        return $this->fromUserId;
    }

    function getToUserId() {
        return $this->toUserId;
    }

    function getSubject() {
        return $this->subject;
    }

    function getContent() {
        return $this->content;
    }

    function getStatus() {
        return $this->status;
    }

    function getSentDate() {
        return $this->sentDate;
    }

    function getCreateTime() {
        return $this->createTime;
    }

    function getUpdateTime() {
        return $this->updateTime;
    }

    function setInboxId($inboxId) {
        $this->inboxId = $inboxId;
    }

    function setFromUserId($fromUserId) {
        $this->fromUserId = $fromUserId;
    }

    function setToUserId($toUserId) {
        $this->toUserId = $toUserId;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setContent($content) {
        $this->content = $content;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setSentDate($sentDate) {
        $this->sentDate = $sentDate;
    }

    function setCreateTime($createTime) {
        $this->createTime = $createTime;
    }

    function setUpdateTime($updateTime) {
        $this->updateTime = $updateTime;
    }

}

?>
