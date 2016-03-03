<?php
require_once __DIR__ .'/host.php';
require_once $ROOT .'/dao/db_connect.php';
require_once $ROOT .'/models/groupuser.php';
require_once $ROOT .'/dao/daoUser_GroupUser.php';

$groupUserId = "GroupUserId";
$name = "Name";
$description = "Description";
$userId = "UserId";
$createTime = "CreateTime";
$updateTime = "UpdateTime";

function getGroupUserIdUseGroupUserId($varName) {
    global $groupUserId,$groupUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser WHERE ".$groupUserId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$groupUserId];
            break;
        }
    }
    return $varName;
}

function getGroupUserIdUseName($varName) {
    global $groupUserId,$name;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser WHERE ".$name." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$groupUserId];
            break;
        }
    }
    return $varName;
}

function getGroupUserIdUseDescription($varName) {
    global $groupUserId,$description;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser WHERE ".$description." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$groupUserId];
            break;
        }
    }
    return $varName;
}

function getGroupUserIdUseUserId($varName) {
    global $groupUserId,$userId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser WHERE ".$userId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$groupUserId];
            break;
        }
    }
    return $varName;
}

function getGroupUserIdUseCreateTime($varName) {
    global $groupUserId,$createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser WHERE ".$createTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$groupUserId];
            break;
        }
    }
    return $varName;
}

function getGroupUserIdUseUpdateTime($varName) {
    global $groupUserId,$updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser WHERE ".$updateTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$groupUserId];
            break;
        }
    }
    return $varName;
}

function getListGroupUser() {
 global    $groupUserId, $name, $description, $userId, $createTime, $updateTime; 
$listGroupUser = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $groupuser = new GroupUser();
            $groupuser->setGroupUserId($row[$groupUserId]);
            $groupuser->setName($row[$name]);
            $groupuser->setDescription($row[$description]);
            $groupuser->setUserId($row[$userId]);
            $groupuser->setCreateTime($row[$createTime]);
            $groupuser->setUpdateTime($row[$updateTime]);

            array_push($listGroupUser, $groupuser);
        }
    }
    return $listGroupUser;
}
function getListGroupUserUsingUserId($varname) {
 global    $groupUserId, $name, $description, $userId, $createTime, $updateTime; 
$listGroupUser = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groupuser WHERE ".$userId." = ".$varname) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $groupuser = new GroupUser();
            $groupuser->setGroupUserId($row[$groupUserId]);
            $groupuser->setName($row[$name]);
            $groupuser->setDescription($row[$description]);
            $groupuser->setUserId($row[$userId]);
            $groupuser->setCreateTime($row[$createTime]);
            $groupuser->setUpdateTime($row[$updateTime]);

            array_push($listGroupUser, $groupuser);
        }
    }
    return $listGroupUser;
}
function updateGroupUser(GroupUser $groupuser) {
  global   $groupUserId, $name, $description, $userId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE groupuser SET  "
            .$name." = '". $groupuser->getName()."', "
            .$description." = '". $groupuser->getDescription()."', "
            .$userId." = '". $groupuser->getUserId()
            ."' WHERE ".$groupUserId." = '".$groupuser->getGroupUserId()."'");
    if ($result) {
        return true;
    }
    return false;
}

function createGroupUser(GroupUser $groupuser) {
    global   $groupUserId, $name, $description, $userId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $result = mysql_query("INSERT INTO groupuser("
            .$name.","
            .$description.","
            .$userId
            .") VALUES( '"
            .$groupuser->getName()."','"
            .$groupuser->getDescription()."','"
            .$groupuser->getUserId()."')");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteGroupUserUseGroupUserId($id) {
    global $groupUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groupuser WHERE ".$groupUserId." = '".$id."'");
    if ($result) {
        ///  xoa nhieu hon o user_groupuser
        if(deleteUser_GroupUserUseGroupUserId($id)) 
            return true;
    }
    return false;
}   

function deleteGroupUserUseName($id) {
    global $name;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groupuser WHERE ".$name." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteGroupUserUseDescription($id) {
    global $description;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groupuser WHERE ".$description." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteGroupUserUseUserId($id) {
    global $userId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groupuser WHERE ".$userId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteGroupUserUseCreateTime($id) {
    global $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groupuser WHERE ".$createTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteGroupUserUseUpdateTime($id) {
    global $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groupuser WHERE ".$updateTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

?>