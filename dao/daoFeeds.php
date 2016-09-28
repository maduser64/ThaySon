<?php
require_once 'db_connect.php';
require_once '/../models/feeds.php';

$feedId = "FeedId";
$facebookIdFeed = "FacebookIdFeed";
$facebookUserIdFeed = "FacebookUserIdFeed";
$message = "Message";
$createFeedTime = "CreateFeedTime";
$updateFeedTime = "UpdateFeedTime";
$statusId = "StatusId";
$groupId = "GroupId";
$createTime = "CreateTime";
$updateTime = "UpdateTime";

function getFeedIdUseFeedId($varName) {
    global $feedId,$feedId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$feedId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}
function getFacebookFeedIdUseFeedId($varName) {
    global $feedId,$facebookIdFeed;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$feedId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$facebookIdFeed];
            break;
        }
    }
    return $varName;
}
function getFeedIdUseFacebookIdFeed($varName) {
    global $feedId,$facebookIdFeed;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$facebookIdFeed." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            return $varName;
        }
    }
    return null;
}

function getFeedIdUseFacebookUserIdFeed($varName) {
    global $feedId,$facebookUserIdFeed;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$facebookUserIdFeed." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}

function getFeedIdUseMessage($varName) {
    global $feedId,$message;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$message." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}

function getFeedIdUseCreateFeedTime($varName) {
    global $feedId,$createFeedTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$createFeedTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}

function getFeedIdUseUpdateFeedTime($varName) {
    global $feedId,$updateFeedTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$updateFeedTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}

function getFeedIdUseStatusId($varName) {
    global $feedId,$statusId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$statusId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}

function getFeedIdUseGroupId($varName,$start,$count) {
    global $feedId,$groupId,
    $feedId, $facebookIdFeed, $facebookUserIdFeed, $message, $createFeedTime, $updateFeedTime, $statusId, $groupId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $listFeeds = array();
    $result = mysql_query("SELECT *FROM feeds WHERE groupId = ".$varName." order by ".$createFeedTime ." desc LIMIT ".$start.",".$count."") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $feeds = new Feeds();
            $feeds->setFeedId($row[$feedId]);
            $feeds->setFacebookIdFeed($row[$facebookIdFeed]);
            $feeds->setFacebookUserIdFeed($row[$facebookUserIdFeed]);
            $feeds->setMessage($row[$message]);
            $feeds->setCreateFeedTime($row[$createFeedTime]);
            $feeds->setUpdateFeedTime($row[$updateFeedTime]);
            $feeds->setStatusId($row[$statusId]);
            $feeds->setGroupId($row[$groupId]);
            $feeds->setCreateTime($row[$createTime]);
            $feeds->setUpdateTime($row[$updateTime]);

            array_push($listFeeds, $feeds);
        }
    }
    return $listFeeds;
}

function getFeedIdUseCreateTime($varName) {
    global $feedId,$createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$createTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}

function getFeedIdUseUpdateTime($varName) {
    global $feedId,$updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds WHERE ".$updateTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$feedId];
            break;
        }
    }
    return $varName;
}

function getListFeeds() {
 global    $feedId, $facebookIdFeed, $facebookUserIdFeed, $message, $createFeedTime, $updateFeedTime, $statusId, $groupId, $createTime, $updateTime; 
$listFeeds = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM feeds") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $feeds = new Feeds();
            $feeds->setFeedId($row[$feedId]);
            $feeds->setFacebookIdFeed($row[$facebookIdFeed]);
            $feeds->setFacebookUserIdFeed($row[$facebookUserIdFeed]);
            $feeds->setMessage($row[$message]);
            $feeds->setCreateFeedTime($row[$createFeedTime]);
            $feeds->setUpdateFeedTime($row[$updateFeedTime]);
            $feeds->setStatusId($row[$statusId]);
            $feeds->setGroupId($row[$groupId]);
            $feeds->setCreateTime($row[$createTime]);
            $feeds->setUpdateTime($row[$updateTime]);

            array_push($listFeeds, $feeds);
        }
    }
    return $listFeeds;
}
function updateStatusFeed($varName) {
  global   $feedId, $facebookIdFeed, $facebookUserIdFeed, $message, $createFeedTime, $updateFeedTime, $statusId, $groupId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE feeds SET  "
            .$statusId." = '3' WHERE ".$feedId." = '".$varName."'");
    if ($result) {
        return true;
    }
    return false;
}
function updateFeeds(Feeds $feeds) {
  global   $feedId, $facebookIdFeed, $facebookUserIdFeed, $message, $createFeedTime, $updateFeedTime, $statusId, $groupId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE feeds SET  "
            .$facebookIdFeed." = '". $feeds->getFacebookIdFeed()."', "
            .$facebookUserIdFeed." = '". $feeds->getFacebookUserIdFeed()."', "
            .$message." = '". $feeds->getMessage()."', "
            .$createFeedTime." = '". $feeds->getCreateFeedTime()."', "
            .$updateFeedTime." = '". $feeds->getUpdateFeedTime()."', "
            .$statusId." = '". $feeds->getStatusId()."', "
            .$groupId." = '". $feeds->getGroupId()
            ."' WHERE ".$feedId." = '".$feeds->getFeedId()."'");
    if ($result) {
        return true;
    }
    return false;
}

function createFeeds(Feeds $feeds) {
    global   $feedId, $facebookIdFeed, $facebookUserIdFeed, $message, $createFeedTime, $updateFeedTime, $statusId, $groupId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $re=getFeedIdUseFacebookIdFeed($feeds->getFacebookIdFeed());
    if($re!=null) return $re;
    $result = mysql_query("INSERT INTO feeds("
            .$facebookIdFeed.","
            .$facebookUserIdFeed.","
            .$message.","
            .$createFeedTime.","
            .$updateFeedTime.","
            .$statusId.","
            .$groupId
            .") VALUES( '"
            .$feeds->getFacebookIdFeed()."','"
            .$feeds->getFacebookUserIdFeed()."','"
            .$feeds->getMessage()."','"
            .$feeds->getCreateFeedTime()."','"
            .$feeds->getUpdateFeedTime()."','"
            .$feeds->getStatusId()."','"
            .$feeds->getGroupId()."')");
    if ($result) {
        return getFeedIdUseFacebookIdFeed($feeds->getFacebookIdFeed());
    }
    return false;
}   

function deleteFeedsUseFeedId($id) {
    global $feedId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$feedId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseFacebookIdFeed($id) {
    global $facebookIdFeed;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$facebookIdFeed." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseFacebookUserIdFeed($id) {
    global $facebookUserIdFeed;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$facebookUserIdFeed." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseMessage($id) {
    global $message;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$message." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseCreateFeedTime($id) {
    global $createFeedTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$createFeedTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseUpdateFeedTime($id) {
    global $updateFeedTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$updateFeedTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseStatusId($id) {
    global $statusId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$statusId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseGroupId($id) {
    global $groupId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$groupId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseCreateTime($id) {
    global $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$createTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteFeedsUseUpdateTime($id) {
    global $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM feeds WHERE ".$updateTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   
function getTotalRecord($group) {
    $db = new DB_CONNECT();
    $result = mysql_query("select feedid FROM feeds where groupId = "+$group);
    if ($result!=null) 
        return mysql_num_rows($result);
    return 0;
}  
?>