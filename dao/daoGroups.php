<?php

require_once 'db_connect.php';
require_once '/../models/groups.php';
require_once 'daoGroups.php';
$groupId = "GroupId";
$facebookGroupId = "FacebookGroupId";
$name = "Name";
$privacy = "Privacy";
$description = "Description";
$icon = "Icon";
$email = "Email";
$owner = "Owner";
$createGroupTime = "CreateGroupTime";
$createTime = "CreateTime";

function getGroupIdUseGroupId($varName) {
    global $groupId, $groupId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $groupId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseFacebookGroupId($varName) {
    global $groupId, $facebookGroupId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $facebookGroupId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseName($varName) {
    global $groupId, $name;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $name . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUsePrivacy($varName) {
    global $groupId, $privacy;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $privacy . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseDescription($varName) {
    global $groupId, $description;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $description . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseIcon($varName) {
    global $groupId, $icon;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $icon . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseEmail($varName) {
    global $groupId, $email;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $email . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseOwner($varName) {
    global $groupId, $owner;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $owner . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseCreateGroupTime($varName) {
    global $groupId, $createGroupTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $createGroupTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getGroupIdUseCreateTime($varName) {
    global $groupId, $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups WHERE " . $createTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$groupId];
            break;
        }
    }
    return $varName;
}

function getListGroups($tmpuserid) {
   //lobal $groupId, $facebookGroupId, $name, $privacy, $description, $icon, $email, $owner, $createGroupTime, $createTime;
    $listGroups = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * FROM groupuser a JOIN user_groupuser b on a.GroupUserId = b.GroupUserId and b.UserId = ".$tmpuserid) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $groups = new GroupUser();
            $groups->setGroupUserId($row['GroupUserId']);
            $groups->setName($row['Name']);
            $groups->setUserId($row['UseId']);
            $groups->setDescription($row['Description']);
            array_push($listGroups, $groups);
        }
    }
    return $listGroups;
}

function getListGroupsForAd($varIdUser, $parentId) {
    global $groupId, $facebookGroupId, $name, $privacy, $description, $icon, $email, $owner, $createGroupTime, $createTime;
    $parentId = trim($parentId);
    if (isset($parentId) === true && $parentId === '') {
        $parentId = 0;
    }
    $listGroups = array();
    $db = new DB_CONNECT();
//    $result = mysql_query("SELECT *FROM groups,user_group WHERE user_group.GroupId=groups.GroupId AND groups.ParentGroupId = " . $parentId
//            . " AND user_group.UserId=" . $varIdUser) or die(mysql_error());
    $result = mysql_query("SELECT *FROM groups WHERE ParentGroupId = " . $parentId) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $groups = new Groups();
            $groups->setGroupId($row[$groupId]);
            $groups->setFacebookGroupId($row[$facebookGroupId]);
            $groups->setName($row[$name]);
            $groups->setPrivacy($row[$privacy]);
            $groups->setDescription($row[$description]);
            $groups->setIcon($row[$icon]);
            $groups->setEmail($row[$email]);
            $groups->setOwner($row[$owner]);
            $groups->setCreateGroupTime($row[$createGroupTime]);
            $groups->setCreateTime($row[$createTime]);

            array_push($listGroups, $groups);
        }
    }
    return $listGroups;
}

function getListGroupsForQL($varIdUser, $parentId) {
    global $groupId, $facebookGroupId, $name, $privacy, $description, $icon, $email, $owner, $createGroupTime, $createTime;
    //echo '--------------'.$parentId;
    $parentId = trim($parentId);
    if (isset($parentId) === true && $parentId === '') {
        $parentId = 0;
    }
    //  echo '--------------'.$parentId;
    $listGroups = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM groups,user_group WHERE user_group.GroupId=groups.GroupId AND groups.ParentGroupId = " . $parentId
            . " AND user_group.UserId=" . $varIdUser) or die(mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $groups = new Groups();
            $groups->setGroupId($row[$groupId]);
            $groups->setFacebookGroupId($row[$facebookGroupId]);
            $groups->setName($row[$name]);
            $groups->setPrivacy($row[$privacy]);
            $groups->setDescription($row[$description]);
            $groups->setIcon($row[$icon]);
            $groups->setEmail($row[$email]);
            $groups->setOwner($row[$owner]);
            $groups->setCreateGroupTime($row[$createGroupTime]);
            $groups->setCreateTime($row[$createTime]);

            array_push($listGroups, $groups);
        }
    }
    return $listGroups;
}

function getListGroupsbyUserId($varIdUser) {
//    $parentId = trim($parentId);
//    if (isset($parentId) === true && $parentId === '') {
//        $parentId = 0;
//    }
    $listGroups = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * FROM groups,user_group WHERE user_group.GroupId=groups.GroupId AND user_group.UserId = " . $varIdUser) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $groups = new Groups();
            $groups->setGroupId($row['GroupId']);
            $groups->setFacebookGroupId($row['FacebookGroupId']);
            $groups->setName($row['Name']);
            $groups->setPrivacy($row['Privacy']);
            $groups->setDescription($row['Description']);
            //$groups->setIcon($row[$icon]);
            $groups->setEmail($row['Email']);
            $groups->setOwner($row['Owner']);
            // $groups->setCreateGroupTime($row[$createGroupTime]);
            //$groups->setCreateTime($row[$createTime]);

            array_push($listGroups, $groups);
        }
    }
    return $listGroups;
}

function updateGroups(Groups $groups) {
    global $groupId, $facebookGroupId, $name, $privacy, $description, $icon, $email, $owner, $createGroupTime, $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE groups SET  "
            . $facebookGroupId . " = '" . $groups->getFacebookGroupId() . "', "
            . $name . " = '" . $groups->getName() . "', "
            . $privacy . " = '" . $groups->getPrivacy() . "', "
            . $description . " = '" . $groups->getDescription() . "', "
            . $icon . " = '" . $groups->getIcon() . "', "
            . $email . " = '" . $groups->getEmail() . "', "
            . $owner . " = '" . $groups->getOwner() . "', "
            . $createGroupTime . " = '" . $groups->getCreateGroupTime()
            . "' WHERE " . $groupId . " = '" . $groups->getGroupId() . "'");
    if ($result) {
        return true;
    }
    return false;
}

function createGroups(Groups $groups) {
    global $groupId, $facebookGroupId, $name, $privacy, $description, $icon, $email, $owner, $createGroupTime, $createTime;
    $db = new DB_CONNECT();
    $resultCheck = mysql_query("SELECT * FROM groups WHERE " . $facebookGroupId . "=" . $groups->getFacebookGroupId());

    if (mysql_num_rows($resultCheck) > 0) {
        while ($rows = mysql_fetch_array($resultCheck)) {
            updateGroups($groups);
            return $rows[$groupId];
        }
        return false;
    }
    $result = mysql_query("INSERT INTO groups("
            . $facebookGroupId . ","
            . $name . ","
            . $privacy . ","
            . $description . ","
            . $icon . ","
            . $email . ","
            . $owner . ","
            . $createGroupTime . ","
            . $createTime
            . ") VALUES( '"
            . $groups->getFacebookGroupId() . "','"
            . $groups->getName() . "','"
            . $groups->getPrivacy() . "','"
            . $groups->getDescription() . "','"
            . $groups->getIcon() . "','"
            . $groups->getEmail() . "','"
            . $groups->getOwner() . "','"
            . $groups->getCreateGroupTime() . "', NOW())");
    if ($result) {
        return getGroupIdUseFacebookGroupId($groups->getFacebookGroupId());
    }
    return false;
}

function deleteGroupsUseGroupId($id) {
    global $groupId;
    $db = new DB_CONNECT();
    $check = mysql_query("SELECT 1 FROM `groups` WHERE `ParentGroupId` = " . $id);

    if (mysql_num_rows($check) > 0) {
        return "Error!";
    }
    mysql_query("DELETE FROM user_group WHERE " . $groupId . " = '" . $id . "'");
    $result = mysql_query("DELETE FROM groups WHERE " . $groupId . " = '" . $id . "'");
    $db->close();
    if ($result) {
        return "Done!";
    }
    return "Error";
}

function deleteGroupsUseFacebookGroupId($id) {
    global $facebookGroupId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $facebookGroupId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUseName($id) {
    global $name;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $name . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUsePrivacy($id) {
    global $privacy;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $privacy . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUseDescription($id) {
    global $description;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $description . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUseIcon($id) {
    global $icon;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $icon . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUseEmail($id) {
    global $email;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $email . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUseOwner($id) {
    global $owner;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $owner . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUseCreateGroupTime($id) {
    global $createGroupTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $createGroupTime . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteGroupsUseCreateTime($id) {
    global $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM groups WHERE " . $createTime . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function createParentGroups($groupName, $des, $userId) {
    //echo '-------------------------------------------------'.$des.'-----------------'.$groupName.'------------'. $userId;
    $db = new DB_CONNECT();
    $result = mysql_query("INSERT INTO Groups(Name, Description) VALUES ('" . $groupName . "','" . $des . "');");
    // $sql = "INSERT INTO Groups(Name, Description) VALUES ('".$groupName+"','".$des+"')";
    $result = mysql_query("SELECT groupId FROM Groups ORDER BY groupId DESC LIMIT 1;");
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $index = '' . $row[$groupId];
        }
    }
    $result = mysql_query("INSERT INTO user_group(groupId, userId) VALUES (" . $index . "," . $userId . ")");
    //echo ''.$index.'--'.$result;
    $db->close();
}

?>