<?php
require_once 'db_connect.php';
require_once '/models/user_role.php';

$userRoleId = "UserRoleId";
$roleId = "RoleId";
$userId = "UserId";

function getUserRoleIdUseUserRoleId($varName) {
    global $userRoleId,$userRoleId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_role WHERE ".$userRoleId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$userRoleId];
            break;
        }
    }
    return $varName;
}

function getUserRoleIdUseRoleId($varName) {
    global $userRoleId,$roleId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_role WHERE ".$roleId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$userRoleId];
            break;
        }
    }
    return $varName;
}

function getUserRoleIdUseUserId($varName) {
    global $userRoleId,$userId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_role WHERE ".$userId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$userRoleId];
            break;
        }
    }
    return $varName;
}

function getListUser_Role() {
 global    $userRoleId, $roleId, $userId; 
$listUser_Role = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_role") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $user_role = new User_Role();
            $user_role->setUserRoleId($row[$userRoleId]);
            $user_role->setRoleId($row[$roleId]);
            $user_role->setUserId($row[$userId]);

            array_push($listUser_Role, $user_role);
        }
    }
    return $listUser_Role;
}

function updateUser_Role(User_Role $user_role) {
  global   $userRoleId, $roleId, $userId; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE user_role SET  "
            .$roleId." = '". $user_role->getRoleId()."', "
            .$userId." = '". $user_role->getUserId()
            ."' WHERE ".$userRoleId." = '".$user_role->getUserRoleId()."'");
    if ($result) {
        return true;
    }
    return false;
}

function createUser_Role(User_Role $user_role) {
    global   $userRoleId, $roleId, $userId; 
    $db = new DB_CONNECT();
//    $result2 = mysql_query("SELECT *FROM user_role WHERE ".$roleId." = '".$user_role->getRoleId()."' AND ".$userId." = '".$user_role->getUserId()."'") or die(mysql_error());
//    if (mysql_num_rows($result2) > 0) {
//        return false;
//    }
    $result = mysql_query("INSERT INTO user_role("
            .$roleId.","
            .$userId
            .") VALUES( '"
            .$user_role->getRoleId()."','"
            .$user_role->getUserId()."')");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteUser_RoleUseUserRoleId($id) {
    global $userRoleId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_role WHERE ".$userRoleId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteUser_RoleUseRoleId($id) {
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_role WHERE roleId = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   
function deleteUser_Role($role,$user) {
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_role WHERE roleId = '".$role."' AND userId = ".$user);
    if ($result) {
        return true;
    }
    return false;
}
function deleteUser_RoleUseUserId($id) {
    global $userId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM user_role WHERE ".$userId." = '".$id."'");
    $db->close();
    if ($result) {
        return true;
    }
    return false;
}   

?>