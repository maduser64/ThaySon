<?php

require_once __DIR__ .'/host.php';
require_once $ROOT .'/dao/db_connect.php';
require_once $ROOT .'/models/members.php';

$memberid = "memberid";
$name = "name";
$facebookIdMember = "facebookidmember";
$administrator = "administrator";
$groupid = "groupid";

function getListMembers() {
    global $memberid, $name, $facebookIdMember, $administrator, $groupid;
    $$listMembers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $member = new Members();
            $member->setMemberid($row[$memberid]);
            $member->setName($row[$name]);
            $member->setFacebookidmember($row[$facebookIdMember]);
            $member->setAdministrator($row[$administrator]);
            $member->setGroupid($row[$groupid]);
            
            array_push($listMembers, $member);
        }
    }
    return $listMembers;
}

function updateMember(Members $member) {
    global $memberid, $name, $facebookIdMember, $administrator, $groupid;
    
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE members SET  "
            .$facebookIdMember." = ". $member->getMemberid().", "
            .$name." = ".$member->getName().", "
            .$administrator." = ".$member->getAdministrator().", "
            .$groupid." = ".$member->getGroupid()
            ." WHERE ".$memberid." = ".$member->getMemberid());
    if (!empty($result)) {
        return true;
    }
    return false;
}

function createMember(Members $member) {
    global $memberid, $name, $facebookIdMember, $administrator, $groupid;
    $db = new DB_CONNECT();
    $result = mysql_query("INSERT INTO members(".$memberid.",".$facebookIdMember.","
            .$name.",".$administrator.",".$groupid.") VALUES(".$member->getMemberid().",".$member->getFacebookidmember()
            .",".$member->getName().",".$member->getAdministrator().",".$member->getGroupid().")");
    if (!empty($result)) {
        return true;
    }
    return false;
}   

function deleteMember($id) {
    global $memberid;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$memberid."=".$id);
    if (!empty($result)) {
        return true;
    }
    return false;
}   
?>
