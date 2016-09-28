<?php
require_once 'db_connect.php';
require_once '/models/roles.php';

$roleId = "RoleId";
$roleName = "RoleName";
$description = "Description";

function getRoleIdUseRoleId($varName) {
    global $roleId,$roleId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM roles WHERE ".$roleId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$roleId];
            break;
        }
    }
    return $varName;
}

function getRoleIdUseRoleName($varName) {
    global $roleId,$roleName;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM roles WHERE ".$roleName." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$roleId];
            break;
        }
    }
    return $varName;
}

function getRoleIdUseDescription($varName) {
    global $roleId,$description;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM roles WHERE ".$description." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$roleId];
            break;
        }
    }
    return $varName;
}
function checkRole($user, $role) {
$listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM user_role where UserId= ".$user." AND RoleId= ".$role) or die(mysql_error());
    //echo''."SELECT *FROM user_role where UserId= ".$user." AND RoleId= ".$role;
    if (mysql_num_rows($result) > 0) {
        return true;
//        while ($row = mysql_fetch_array($result)) {
//            if($row["RoleId"]==2) return true;
//        }  
    }
    return false;
}
function getListRoles() {
 global    $roleId, $roleName, $description; 
$listRoles = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM roles order by roleId") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $roles = new Roles();
            $roles->setRoleId($row[$roleId]);
            $roles->setRoleName($row[$roleName]);
            $roles->setDescription($row[$description]);

            array_push($listRoles, $roles);
        }
    }
    return $listRoles;
}

function updateRoles(Roles $roles) {
  global   $roleId, $roleName, $description; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE roles SET  "
            .$roleName." = '". $roles->getRoleName()."', "
            .$description." = '". $roles->getDescription()
            ."' WHERE ".$roleId." = '".$roles->getRoleId()."'");
    if ($result) {
        return true;
    }
    return false;
}

function createRoles(Roles $roles) {
    global   $roleId, $roleName, $description; 
    $db = new DB_CONNECT();
    $result = mysql_query("INSERT INTO roles("
            .$roleName.","
            .$description
            .") VALUES( '"
            .$roles->getRoleName()."','"
            .$roles->getDescription()."')");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteRolesUseRoleId($id) {
    global $roleId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM roles WHERE ".$roleId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteRolesUseRoleName($id) {
    global $roleName;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM roles WHERE ".$roleName." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteRolesUseDescription($id) {
    global $description;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM roles WHERE ".$description." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

?>