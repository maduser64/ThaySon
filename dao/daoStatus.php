<?php
require_once 'db_connect.php';
require_once '/models/status.php';

$statusId = "StatusId";
$name = "Name";
$description = "Description";

function getStatusIdUseStatusId($varName) {
    global $statusId,$statusId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM status WHERE ".$statusId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$statusId];
            break;
        }
    }
    return $varName;
}

function getStatusIdUseName($varName) {
    global $statusId,$name;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM status WHERE ".$name." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$statusId];
            break;
        }
    }
    return $varName;
}

function getStatusIdUseDescription($varName) {
    global $statusId,$description;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM status WHERE ".$description." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$statusId];
            break;
        }
    }
    return $varName;
}

function getListStatus() {
 global    $statusId, $name, $description; 
$listStatus = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM status") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $status = new Status();
            $status->setStatusId($row[$statusId]);
            $status->setName($row[$name]);
            $status->setDescription($row[$description]);

            array_push($listStatus, $status);
        }
    }
    return $listStatus;
}

function updateStatus(Status $status) {
  global   $statusId, $name, $description; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE status SET  "
            .$name." = '". $status->getName()."', "
            .$description." = '". $status->getDescription()
            ."' WHERE ".$statusId." = '".$status->getStatusId()."'");
    if ($result) {
        return true;
    }
    return false;
}

function createStatus(Status $status) {
    global   $statusId, $name, $description; 
    $db = new DB_CONNECT();
    $result = mysql_query("INSERT INTO status("
            .$name.","
            .$description
            .") VALUES( '"
            .$status->getName()."','"
            .$status->getDescription()."')");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteStatusUseStatusId($id) {
    global $statusId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM status WHERE ".$statusId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteStatusUseName($id) {
    global $name;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM status WHERE ".$name." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteStatusUseDescription($id) {
    global $description;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM status WHERE ".$description." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

?>