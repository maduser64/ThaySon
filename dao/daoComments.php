<?php

require_once __DIR__ . '/host.php';
require_once $ROOT . '/dao/db_connect.php';
require_once $ROOT . '/models/comments.php';

$commentId = "CommentId";
$facebookIdComment = "FacebookIdComment";
$facebookUserIdComment = "FacebookUserIdComment";
$message = "Message";
$createCommentTime = "CreateCommentTime";
$statusId = "StatusId";
$feedId = "FeedId";
$createTime = "CreateTime";
$updateTime = "UpdateTime";

function getCommentIdUseCommentId($varName) {
    global $commentId, $commentId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $commentId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            break;
        }
    }
    return $varName;
}

function getCommentIdUseFacebookIdComment($varName) {
    global $commentId, $facebookIdComment;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $facebookIdComment . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            return $varName;
        }
    }
    return null;
}

function getCommentIdUseFacebookUserIdComment($varName) {
    global $commentId, $facebookUserIdComment;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $facebookUserIdComment . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            break;
        }
    }
    return $varName;
}

function getCommentIdUseMessage($varName) {
    global $commentId, $message;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $message . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            break;
        }
    }
    return $varName;
}

function getCommentIdUseCreateCommentTime($varName) {
    global $commentId, $createCommentTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $createCommentTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            break;
        }
    }
    return $varName;
}

function getCommentIdUseStatusId($varName) {
    global $commentId, $statusId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $statusId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            break;
        }
    }
    return $varName;
}

function getCommentIdUseFeedId($varName, $start, $count) {
     global $commentId, $facebookIdComment, $facebookUserIdComment, $message, $createCommentTime, $statusId, $feedId, $createTime, $updateTime;
    $db = new DB_CONNECT();
    $listComments =  array();
    $result = mysql_query("SELECT `CommentId`,`FacebookUserIdComment`, `FacebookIdComment`, `Message`, `CreateCommentTime`, b.Name 
                            FROM comments AS a INNER JOIN status as b on a.statusId = b.StatusId AND feedId = ".$varName 
                            ." ORDER BY a.CreateCommentTime LIMIT ".$start.",".$count. "") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $comments = new Comments();
            $comments->setCommentId($row[$commentId]);
            $comments->setFacebookUserIdComment($row[$facebookUserIdComment]);
            $comments->setFacebookIdComment($row[$facebookIdComment]);
            $comments->setMessage($row[$message]);
            $comments->setCreateCommentTime($row[$createCommentTime]);
            $comments->setStatusId($row['Name']);
//            $comments->setFeedId($row[$feedId]);
//            $comments->setCreateTime($row[$createTime]);
//            $comments->setUpdateTime($row[$updateTime]);

            array_push($listComments, $comments);
        }
    }
    return $listComments;
}

function getCommentIdUseCreateTime($varName) {
    global $commentId, $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $createTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            break;
        }
    }
    return $varName;
}

function getCommentIdUseUpdateTime($varName) {
    global $commentId, $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments WHERE " . $updateTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$commentId];
            break;
        }
    }
    return $varName;
}

function getListComments() {
    global $commentId, $facebookIdComment, $facebookUserIdComment, $message, $createCommentTime, $statusId, $feedId, $createTime, $updateTime;
    $listComments = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM comments") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $comments = new Comments();
            $comments->setCommentId($row[$commentId]);
            $comments->setFacebookIdComment($row[$facebookIdComment]);
            $comments->setFacebookUserIdComment($row[$facebookUserIdComment]);
            $comments->setMessage($row[$message]);
            $comments->setCreateCommentTime($row[$createCommentTime]);
            $comments->setStatusId($row[$statusId]);
            $comments->setFeedId($row[$feedId]);
            $comments->setCreateTime($row[$createTime]);
            $comments->setUpdateTime($row[$updateTime]);

            array_push($listComments, $comments);
        }
    }
    return $listComments;
}

function updateComments(Comments $comments) {
    global $commentId, $facebookIdComment, $facebookUserIdComment, $message, $createCommentTime, $statusId, $feedId, $createTime, $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE comments SET  "
            . $facebookIdComment . " = '" . $comments->getFacebookIdComment() . "', "
            . $facebookUserIdComment . " = '" . $comments->getFacebookUserIdComment() . "', "
            . $message . " = '" . $comments->getMessage() . "', "
            . $createCommentTime . " = '" . $comments->getCreateCommentTime() . "', "
            . $statusId . " = '" . $comments->getStatusId() . "', "
            . $feedId . " = '" . $comments->getFeedId()
            . "' WHERE " . $commentId . " = '" . $comments->getCommentId() . "'");
    if ($result) {
        return true;
    }
    return false;
}

function createComments(Comments $comments) {
    global $commentId, $facebookIdComment, $facebookUserIdComment, $message, $createCommentTime, $statusId, $feedId, $createTime, $updateTime;
    $db = new DB_CONNECT();
    $re = getCommentIdUseFacebookIdComment($comments->getFacebookIdComment());
    if ($re != null)
        return false;

    $result = mysql_query("INSERT INTO comments("
            . $facebookIdComment . ","
            . $facebookUserIdComment . ","
            . $message . ","
            . $createCommentTime . ","
            . $statusId . ","
            . $feedId
            . ") VALUES( '"
            . $comments->getFacebookIdComment() . "','"
            . $comments->getFacebookUserIdComment() . "','"
            . $comments->getMessage() . "','"
            . $comments->getCreateCommentTime() . "','"
            . $comments->getStatusId() . "','"
            . $comments->getFeedId() . "')");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseCommentId($id) {
    global $commentId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $commentId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseFacebookIdComment($id) {
    global $facebookIdComment;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $facebookIdComment . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseFacebookUserIdComment($id) {
    global $facebookUserIdComment;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $facebookUserIdComment . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseMessage($id) {
    global $message;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $message . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseCreateCommentTime($id) {
    global $createCommentTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $createCommentTime . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseStatusId($id) {
    global $statusId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $statusId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseFeedId($id) {
    global $feedId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $feedId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseCreateTime($id) {
    global $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $createTime . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteCommentsUseUpdateTime($id) {
    global $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM comments WHERE " . $updateTime . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function getTotalRecord1($feedId) {
    $db = new DB_CONNECT();
    $result = mysql_query("select feedid FROM comments where feedId  = " . $feedId);
    if ($result != null)
        return mysql_num_rows($result);
    return 0;
}

?>