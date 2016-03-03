<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comments
 *
 * @author TriTueViet
 */
class Comments {

    private $commentId;
    private $facebookIdComment;
    private $facebookUserIdComment;
    private $message;
    private $createCommentTime;
    private $statusId;
    private $createTime;
    private $updateTime;
    private $feedId;

    function __construct() {
        
    }

    function getCommentId() {
        return $this->commentId;
    }

    function getFacebookIdComment() {
        return $this->facebookIdComment;
    }

    function getFacebookUserIdComment() {
        return $this->facebookUserIdComment;
    }

    function getMessage() {
        return $this->message;
    }

    function getCreateCommentTime() {
        return $this->createCommentTime;
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

    function getFeedId() {
        return $this->feedId;
    }

    function setCommentId($commentId) {
        $this->commentId = $commentId;
    }

    function setFacebookIdComment($facebookIdComment) {
        $this->facebookIdComment = $facebookIdComment;
    }

    function setFacebookUserIdComment($facebookUserIdComment) {
        $this->facebookUserIdComment = $facebookUserIdComment;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setCreateCommentTime($createCommentTime) {
        $this->createCommentTime = $createCommentTime;
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

    function setFeedId($feedId) {
        $this->feedId = $feedId;
    }

}
