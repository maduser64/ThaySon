<?php
require_once 'db_connect.php';
require_once '/models/user_groupuser.php';

$userGroupUserId = "UserGroupUserId";
$userId = "UserId";
$groupUserId = "GroupUserId";

function getUserGroupUserIdUseUserGroupUserId($varName) {
    global $userGroupUserId, $userGroupUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_groupuser WHERE " . $userGroupUserId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userGroupUserId];
            break;
        }
    }
    return $varName;
}

function getUserGroupUserIdUseUserId($varName) {
    global $userGroupUserId, $userId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_groupuser WHERE " . $userId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userGroupUserId];
            break;
        }
    }
    return $varName;
}

function getUserGroupUserIdUseGroupUserId($varName) {
    global $userGroupUserId, $groupUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_groupuser WHERE " . $groupUserId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userGroupUserId];
            break;
        }
    }
    return $varName;
}

function getListUser_GroupUser() {
    global $userGroupUserId, $userId, $groupUserId;
    $listUser_GroupUser = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_groupuser") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $user_groupuser = new User_GroupUser();
            $user_groupuser->setUserGroupUserId($row[$userGroupUserId]);
            $user_groupuser->setUserId($row[$userId]);
            $user_groupuser->setGroupUserId($row[$groupUserId]);

            array_push($listUser_GroupUser, $user_groupuser);
        }
    }
    return $listUser_GroupUser;
}

function getListUser_GroupUserUsingUserGroupUserId($varName) {
    global $userGroupUserId, $userId, $groupUserId;
    $listUser_GroupUser = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_groupuser WHERE " . $userGroupUserId . " = " . $varName) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $user_groupuser = new User_GroupUser();
            $user_groupuser->setUserGroupUserId($row[$userGroupUserId]);
            $user_groupuser->setUserId($row[$userId]);
            $user_groupuser->setGroupUserId($row[$groupUserId]);

            array_push($listUser_GroupUser, $user_groupuser);
        }
    }
    $db->close();
    return $listUser_GroupUser;
}

function updateUser_GroupUser(User_GroupUser $user_groupuser) {
    global $userGroupUserId, $userId, $groupUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE user_groupuser SET  "
            . $userId . " = '" . $user_groupuser->getUserId() . "', "
            . $groupUserId . " = '" . $user_groupuser->getGroupUserId()
            . "' WHERE " . $userGroupUserId . " = '" . $user_groupuser->getUserGroupUserId() . "'");
    if ($result) {
        return true;
    }
    return false;
}

function createUser_GroupUser(User_GroupUser $user_groupuser) {
    global $userGroupUserId, $userId, $groupUserId;
    $db = new DB_CONNECT();
//    echo '----------'."SELECT 1 FROM user_groupuser"
//            . " WHERE " . $userId . " = " . $user_groupuser->getUserId()
//            . " AND " . $groupUserId . " = " . $user_groupuser->getGroupUserId();
    $check = mysql_query("SELECT 1 FROM user_groupuser"
            . " WHERE " . $userId . " = " . $user_groupuser->getUserId()
            . " AND " . $groupUserId . " = " . $user_groupuser->getGroupUserId() );
   // echo '----------'.$check;
     if (mysql_num_rows($check) == 0) { 
//        echo '----------'."5555";
        $result = mysql_query("INSERT INTO user_groupuser("
                . $userId . ","
                . $groupUserId
                . ") VALUES( '"
                . $user_groupuser->getUserId() . "','"
                . $user_groupuser->getGroupUserId() . "')");
        if ($result) {
            return true;
        }
    }
     $db->close();
    return false;
}

function deleteUser_GroupUserUseUserGroupUserId($id) {
    global $userGroupUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_groupuser WHERE " . $userGroupUserId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}
function deleteUser_GroupUserUseUserId($id) {
    global $userId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_groupuser WHERE " . $userId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}
function deleteUser_Group($user,$groupId) {
   // echo '---------------------------------------------------'.$user.'----'.$groupId;
    global $groupUserId,$userId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_groupuser WHERE " . $userId . " = '" . $user . "' AND ".$groupUserId ."=".$groupId);
    if ($result) {
        return true;
    }
    return false;
}
function addUser($stringUser,$grId){
    // echo '---------------------------------------------------'.$stringUser.'----'.$grId; 
    $sUser = trim($stringUser);
    if (isset($sUser) === true && $sUser === '') {
        return 'false';
    }
    $myArray = explode(',', $sUser);
    //$us = new User_GroupUser();
    for ($i = 0; $i < sizeof($myArray); $i++) {
       $us = new User_GroupUser();
     //  echo '---------------------------------------------------'.$myArray[$i].'----'.$grId; 
       $us->setUserId($myArray[$i]); 
       $us->setGroupUserId($grId);
        createUser_GroupUser($us);
    }
}
?>