<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Comments
 *
 * @author NgoCo
 */
class Comments {

    private $commentid;
    private $facebookidcomment;
    private $facebooommenttime;
    private $createkuseridcomment;
    private $message;
    private $createctime;
    private $updatetime;
    private $statusid;

    function __construct() {
        
    }

    function getCommentid() {
        return $this->commentid;
    }

    function getFacebookidcomment() {
        return $this->facebookidcomment;
    }

    function getFacebooommenttime() {
        return $this->facebooommenttime;
    }

    function getCreatekuseridcomment() {
        return $this->createkuseridcomment;
    }

    function getMessage() {
        return $this->message;
    }

    function getCreatectime() {
        return $this->createctime;
    }

    function getUpdatetime() {
        return $this->updatetime;
    }

    function getStatusid() {
        return $this->statusid;
    }

    function setCommentid($commentid) {
        $this->commentid = $commentid;
    }

    function setFacebookidcomment($facebookidcomment) {
        $this->facebookidcomment = $facebookidcomment;
    }

    function setFacebooommenttime($facebooommenttime) {
        $this->facebooommenttime = $facebooommenttime;
    }

    function setCreatekuseridcomment($createkuseridcomment) {
        $this->createkuseridcomment = $createkuseridcomment;
    }

    function setMessage($message) {
        $this->message = $message;
    }

    function setCreatectime($createctime) {
        $this->createctime = $createctime;
    }

    function setUpdatetime($updatetime) {
        $this->updatetime = $updatetime;
    }

    function setStatusid($statusid) {
        $this->statusid = $statusid;
    }

}
