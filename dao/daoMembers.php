<?php
require_once __DIR__ .'/host.php';
require_once $ROOT .'/dao/db_connect.php';
require_once $ROOT .'/models/members.php';

$memberId = "MemberId";
$facebookIdMember = "FacebookIdMember";
$name = "Name";
$realname = "RealName";
$administrator = "Administrator";
$groupId = "GroupId";
$memberId = "MemberId";
$facebookProfileId = "FacebookProfileMember";
$class = "Class";
$school = "School";
$phoneNumber1 = "PhoneNumber1";
$phoneNumber2="PhoneNumber2";
$address1= "Address1";
$address2= "Address2";

function getMemberIdUseMemberId($varName) {
    global $memberId,$memberId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$memberId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseFacebookIdMember($varName) {
    global $memberId,$facebookIdMember;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$facebookIdMember." = '".$varName."'") or die(mysql_error());
    $varName=null;
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
 
    return $varName;
}
function getMemberIdUseFacebookIdMemberAndGroupId($varName,$varGroupId) {
    global $memberId,$facebookIdMember,$groupId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$facebookIdMember." = '".$varName."' and ".$groupId." = '".$varGroupId."'") or die(mysql_error());
    $varName=null;
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
 
    return $varName;
}
function getMemberIdUseName($varName) {
    global $memberId,$name;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$name." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseAdministrator($varName) {
    global $memberId,$administrator;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$administrator." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseGroupId($varName) {
    global $memberId,$groupId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$groupId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getListMembers($varIdGroup) {
 global    $memberId, $facebookIdMember, $name, $administrator, $groupId; 
$listMembers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE $groupId=".$varIdGroup ) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $members = new Members();
            $members->setMemberId($row[$memberId]);
            $members->setFacebookIdMember($row[$facebookIdMember]);
            $members->setName($row[$name]);
            $members->setAdministrator($row[$administrator]);
            $members->setGroupId($row[$groupId]);
            $members->setAddress1($row['Address1']);
            $members->setAddress2($row['Address2']);
            $members->setClass($row['Class']);
            $members->setSchool($row['School']);
            $members->setEmail($row['Email']);
            $members->setPhoneNumber1($row['PhoneNumber1']);
            $members->setPhoneNumber2($row['PhoneNumber2']);
            $members->setFullname($row['Realname']);
            $members->setFacebookProfileId($row['FacebookProfileId']);
            array_push($listMembers, $members);
        }
    }
    return $listMembers;
}

// get member in specific  group by key
function getListMembersByKey($varIdGroup,$key) {
 global    $memberId, $facebookIdMember, $name, $administrator, $groupId; 
$listMembers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE $groupId=".$varIdGroup." and FacebookIdMember like N'%".$key."%'" ) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $members = new Members();
            $members->setMemberId($row[$memberId]);
            $members->setFacebookIdMember($row[$facebookIdMember]);
            $members->setName($row[$name]);
            $members->setAdministrator($row[$administrator]);
            $members->setGroupId($row[$groupId]);
            $members->setAddress1($row['Address1']);
            $members->setAddress2($row['Address2']);
            $members->setSchool($row['Class']);
            $members->setClass($row['School']);
            $members->setEmail($row['Email']);
            $members->setPhoneNumber1($row['PhoneNumber1']);
            $members->setPhoneNumber2($row['PhoneNumber2']);
            $members->setFullname($row['Realname']);
            $members->setFacebookProfileId($row['FacebookProfileId']);
            array_push($listMembers, $members);
        }
    }
    $db->close();
    return $listMembers;
}
//// get member in all  groups by key 
function getListMembersByKeyInAllGroup($user,$key) {
 global    $memberId, $facebookIdMember, $name, $administrator, $groupId; 
$listMembers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members m,user_group ug WHERE ug.userId=".$user
            . " and m.groupId = ug.groupId and m.FacebookIdMember like N'%".$key."%'" ) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $members = new Members();
            $members->setMemberId($row[$memberId]);
            $members->setFacebookIdMember($row[$facebookIdMember]);
            $members->setName($row[$name]);
            $members->setFullname($row[$realname]);
            $members->setAdministrator($row[$administrator]);
            $members->setGroupId($row[$groupId]);
            $members->setAddress1($row['Address1']);
            $members->setAddress2($row['Address2']);
            $members->setSchool($row['Class']);
            $members->setClass($row['School']);
            $members->setEmail($row['Email']);
            $members->setPhoneNumber1($row['PhoneNumber1']);
            $members->setPhoneNumber2($row['PhoneNumber2']);
            $members->setFullname($row['Realname']);
            $members->setFacebookProfileId($row['FacebookProfileId']);
            array_push($listMembers, $members);
        }
    }
    return $listMembers;
}
//
function updateMembers(Members $members) {
  global   $memberId, $facebookIdMember, $name, $administrator, $groupId,$address1
          ,$address2,$phoneNumber1,$phoneNumber2,$school,$class; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE members SET  "
            .$facebookIdMember." = '". $members->getFacebookIdMember()."', "
            .$name." = '". $members->getName()."', "
            .$administrator." = '". $members->getAdministrator()."', "
            .$groupId." = '". $members->getGroupId()."', "
            .$address1." = '". $members->getAddress1()."', "
            .$address2." = '". $members->getAddress2()."', "
            .$phoneNumber1." = '". $members->getPhoneNumber1()."', "
            .$phoneNumber2." = '". $members->getPhoneNumber2()."', "
            .$class." = '". $members->getClass()."', "
            .$school." = '". $members->getSchool()."', "
            .$facebookProfileId." = '". $members->getFacebookProfileId()
            ."' WHERE ".$memberId." = '".$members->getMemberId()."'");
    if ($result) {
        return true;
    }
    return false;
}

function createMembers(Members $members) {
    global   $memberId, $facebookIdMember, $name, $administrator, $groupId; 
    $db = new DB_CONNECT();
    
    $exitMember=getMemberIdUseFacebookIdMemberAndGroupId($members->getFacebookIdMember(),$members->getGroupId());
    if($exitMember!=null)   return false;
    
    $result = mysql_query("INSERT INTO members("
            .$facebookIdMember.","
            .$name.","
            .$administrator.","
            .$groupId
            .$address1.","
            .$address2.","
            .$phoneNumber1.","
            .$phoneNumber2.","
            .$class.","
            .$school.","
            .$facebookProfileId
            .") VALUES( '"
            .$members->getFacebookIdMember()."','"
            .$members->getName()."','"
            .$members->getAdministrator()."','"
            .$members->getGroupId()."','"
            .$members->getAddress1()."','"
            .$members->getAddress2()."','"
            .$members->getPhoneNumber1()."','"
            .$members->getPhoneNumber2()."','"
            .$members->getClass()."','"
            .$members->getSchool().","
            .$members->getFacebookProfileId()
            ."')");
    
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseMemberId($id) {
    global $memberId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$memberId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseFacebookIdMember($id) {
    global $facebookIdMember;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$facebookIdMember." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseName($id) {
    global $name;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$name." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseAdministrator($id) {
    global $administrator;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$administrator." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseGroupId($id) {
    global $groupId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$groupId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   
function updateInfor($id, $iclass, $ifullname, $iphone1, $iphone2, $iaddress1, $iaddress2, $iemail, $ischool){
     $db = new DB_CONNECT();
     $sql = "update Members set Class = '".$iclass."',Realname='".$ifullname."'"
             . ",PhoneNumber1='".$iphone1."',Address1='".$iaddress1."',Email ='".$iemail."'"
             . ",PhoneNumber2='".$iphone2."',Address2='".$iaddress2."',School ='".$ischool
             . "' where MemberId = ".$id.";";
     //echo ''.$sql;
     $result = mysql_query($sql);
     if($result) return 'true';
     return 'false';
}
?>