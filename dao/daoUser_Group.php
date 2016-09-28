<?php
require_once 'db_connect.php';
require_once '/models/user_group.php';

$userGroupId = "UserGroupId";
$userId = "UserId";
$groupId = "GroupId";

function getUserGroupIdUseUserGroupId($varName) {
    global $userGroupId,$userGroupId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_group WHERE ".$userGroupId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$userGroupId];
            break;
        }
    }
    return $varName;
}

function getUserGroupIdUseUserId($varName) {
    global $userGroupId,$userId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_group WHERE ".$userId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$userGroupId];
            break;
        }
    }
    return $varName;
}

function getUserGroupIdUseGroupId($varName) {
    global $userGroupId,$groupId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_group WHERE ".$groupId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$userGroupId];
            break;
        }
    }
    return $varName;
}
function checkUser_Group(User_group $user_group) {
 global    $userGroupId, $userId, $groupId; 
$listUser_Group = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_group WHERE $userId=".$user_group->getUserId()." AND $groupId=".$user_group->getGroupId()) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return true;
    }
    return false;
}
function getListUser_Group($groupID) {
 global    $userGroupId, $userId, $groupId; 
$listUser_Group = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_group WHERE userId = ".$groupID) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $user_group = new User_Group();
            $user_group->setUserGroupId($row[$userGroupId]);
            $user_group->setUserId($row[$userId]);
            $user_group->setGroupId($row[$groupId]);

            array_push($listUser_Group, $user_group);
        }
    }
    return $listUser_Group;
}

function updateUser_Group(User_Group $user_group) {
  global   $userGroupId, $userId, $groupId; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE user_group SET  "
            .$userId." = '". $user_group->getUserId()."', "
            .$groupId." = '". $user_group->getGroupId()
            ."' WHERE ".$userGroupId." = '".$user_group->getUserGroupId()."'");
    if ($result) {
        return true;
    }
    return false;
}

function createUser_Group(User_Group $user_group) {
    global   $userGroupId, $userId, $groupId; 
    $db = new DB_CONNECT();
    if(checkUser_Group($user_group)) return false;
    $result = mysql_query("INSERT INTO user_group("
            .$userId.","
            .$groupId
            .") VALUES( '"
            .$user_group->getUserId()."','"
            .$user_group->getGroupId()."')");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteUser_GroupUseUserGroupId($id) {
    global $userGroupId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_group WHERE ".$userGroupId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteUser_GroupUseUserId($id) {
    global $userId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_group WHERE ".$userId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteUser_GroupUseGroupId($id) {
    global $groupId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_group WHERE ".$groupId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

?>