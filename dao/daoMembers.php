<?php
require_once 'db_connect.php';
require_once '/models/members.php';
require_once '/models/membersSearchUserGroup.php';

$memberId = "MemberId";
$facebookIdMember = "FacebookIdMember";
$name = "Name";
$administrator = "Administrator";
$groupId = "GroupId";
$realName = "RealName";
$address1 = "Address1";
$address2 = "Address2";
$birthday = "Birthday";
$phoneNumber1 = "PhoneNumber1";
$phoneNumber2 = "PhoneNumber2";
$email = "Email";
$gender = "Gender";
$class = "Class";
$school = "School";
$facebookLink = "FacebookLink";
$facebookProfileId = "FacebookProfileId";
$createTime = "CreateTime";
$updateTime = "UpdateTime";

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
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            return $varName;
        }
    }
    return NULL;
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

function getMemberIdUseRealName($varName) {
    global $memberId,$realName;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$realName." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseAddress1($varName) {
    global $memberId,$address1;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$address1." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseAddress2($varName) {
    global $memberId,$address2;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$address2." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseBirthday($varName) {
    global $memberId,$birthday;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$birthday." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUsePhoneNumber1($varName) {
    global $memberId,$phoneNumber1;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$phoneNumber1." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUsePhoneNumber2($varName) {
    global $memberId,$phoneNumber2;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$phoneNumber2." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseEmail($varName) {
    global $memberId,$email;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$email." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseGender($varName) {
    global $memberId,$gender;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$gender." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseClass($varName) {
    global $memberId,$class;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$class." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseSchool($varName) {
    global $memberId,$school;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$school." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseFacebookLink($varName) {
    global $memberId,$facebookLink;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$facebookLink." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseFacebookProfileId($varName) {
    global $memberId,$facebookProfileId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$facebookProfileId." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseCreateTime($varName) {
    global $memberId,$createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$createTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}

function getMemberIdUseUpdateTime($varName) {
    global $memberId,$updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$updateTime." = '".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName=$row[$memberId];
            break;
        }
    }
    return $varName;
}
function searchMembersByFacebookProfileIdInAllGroup($varName) {
 global    $memberId, $facebookIdMember, $name, $administrator, $groupId, $realName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $class, $school,$facebookLink, $facebookProfileId, $createTime, $updateTime; 
$listMembers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT members.MemberId, members.Address1,members.Administrator,members.Name,members.GroupId, members.Birthday, members.PhoneNumber1,members.Email, members.Gender,members.PhoneNumber2, members.Address2, members.Class, members.School, members.FacebookIdMember, members.RealName,members.FacebookLink, members.FacebookProfileId, "
            ." members.CreateTime,members.UpdateTime, users.UserName,users.FullName,users.PhoneNumber1,users.UserId, groups.FacebookGroupId "
            ." FROM users,user_group,groups,members "  
            ." WHERE users.UserId=user_group.UserId AND user_group.GroupId=members.GroupId AND groups.GroupId =user_group.GroupId AND members.FacebookProfileId like N'%".$varName."%'") or die(mysql_error());

    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $members = new MembersSearchUserGroup();
            $members->setMemberId($row[$memberId]);
            $members->setFacebookIdMember($row[$facebookIdMember]);
            $members->setName($row[$name]);
            $members->setAdministrator($row[$administrator]);
            $members->setGroupId($row[$groupId]);
            $members->setRealName($row[$realName]);
            $members->setAddress1($row[$address1]);
            $members->setAddress2($row[$address2]);
            $members->setBirthday($row[$birthday]);
            $members->setPhoneNumber1($row[$phoneNumber1]);
            $members->setPhoneNumber2($row[$phoneNumber2]);
            $members->setEmail($row[$email]);
            $members->setGender($row[$gender]);
            $members->setClass($row[$class]);
            $members->setSchool($row[$school]);
            $members->setFacebookLink($row[$facebookLink]);
            $members->setFacebookProfileId($row[$facebookProfileId]);
            $members->setCreateTime($row[$createTime]);
            $members->setUpdateTime($row[$updateTime]);
            
            $members->setUsernameManager($row['UserName']);
            $members->setPhoneNumberManager($row['PhoneNumber1']);
            $members->setIdUserManager($row['UserId']);
            $members->setIdGroupFacebook($row['FacebookGroupId']);
            $members->setFullnameManager($row['FullName']);

            array_push($listMembers, $members);
        }
    }
    return $listMembers;
}
function getListMembersUsingGroupId($varName) {
 global    $memberId, $facebookIdMember, $name, $administrator, $groupId, $realName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $class, $school,$facebookLink, $facebookProfileId, $createTime, $updateTime; 
$listMembers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM members WHERE ".$groupId."='".$varName."'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $members = new Members();
            $members->setMemberId($row[$memberId]);
            $members->setFacebookIdMember($row[$facebookIdMember]);
            $members->setName($row[$name]);
            $members->setAdministrator($row[$administrator]);
            $members->setGroupId($row[$groupId]);
            $members->setRealName($row[$realName]);
            $members->setAddress1($row[$address1]);
            $members->setAddress2($row[$address2]);
            $members->setBirthday($row[$birthday]);
            $members->setPhoneNumber1($row[$phoneNumber1]);
            $members->setPhoneNumber2($row[$phoneNumber2]);
            $members->setEmail($row[$email]);
            $members->setGender($row[$gender]);
            $members->setClass($row[$class]);
            $members->setSchool($row[$school]);
            $members->setFacebookLink($row[$facebookLink]);
            $members->setFacebookProfileId($row[$facebookProfileId]);
            $members->setCreateTime($row[$createTime]);
            $members->setUpdateTime($row[$updateTime]);

            array_push($listMembers, $members);
        }
    }
    return $listMembers;
}

function updateMembers(Members $members) {
  global    $memberId, $facebookIdMember, $name, $administrator, $groupId, $realName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $class, $school,$facebookLink, $facebookProfileId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE members SET  "
            .$facebookIdMember." = '". $members->getFacebookIdMember()."', "
            .$name." = '". $members->getName()."', "
            .$administrator." = '". $members->getAdministrator()."', "
            .$groupId." = '". $members->getGroupId()."', "
            .$realName." = '". $members->getRealName()."', "
            .$address1." = '". $members->getAddress1()."', "
            .$address2." = '". $members->getAddress2()."', "
            .$birthday." = '". $members->getBirthday()."', "
            .$phoneNumber1." = '". $members->getPhoneNumber1()."', "
            .$phoneNumber2." = '". $members->getPhoneNumber2()."', "
            .$email." = '". $members->getEmail()."', "
            .$gender." = '". $members->getGender()."', "
            .$class." = '". $members->getClass()."', "
            .$school." = '". $members->getSchool()."', "
            .$facebookLink." = '". $members->getFacebookLink()."', "
            .$facebookProfileId." = '". $members->getFacebookProfileId()
            ."' WHERE ".$memberId." = '".$members->getMemberId()."'") or die(mysql_error());
    if ($result) {
        return true;
    }
    return false;
}

function createMembers(Members $members) {
    global   $memberId, $facebookIdMember, $name, $administrator, $groupId, $realName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $class, $school, $facebookLink, $facebookProfileId, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $id=getMemberIdUseFacebookIdMember($members->getFacebookIdMember());
    if($id!=NULL){
        $members->setMemberId($id);
        updateMembers($members);
        return;
    }
    $result = mysql_query("INSERT INTO members("
            .$facebookIdMember.","
            .$name.","
            .$administrator.","
            .$groupId.","
            .$realName.","
            .$address1.","
            .$address2.","
            .$birthday.","
            .$phoneNumber1.","
            .$phoneNumber2.","
            .$email.","
            .$gender.","
            .$class.","
            .$school.","
            .$facebookLink.","
            .$facebookProfileId
            .") VALUES( '"
            .$members->getFacebookIdMember()."','"
            .$members->getName()."','"
            .$members->getAdministrator()."','"
            .$members->getGroupId()."','"
            .$members->getRealName()."','"
            .$members->getAddress1()."','"
            .$members->getAddress2()."','"
            .$members->getBirthday()."','"
            .$members->getPhoneNumber1()."','"
            .$members->getPhoneNumber2()."','"
            .$members->getEmail()."','"
            .$members->getGender()."','"
            .$members->getClass()."','"
            .$members->getSchool()."','"
            .$members->getFacebookLink()."','"
            .$members->getFacebookProfileId()."')") or die(mysql_error());
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

function deleteMembersUseRealName($id) {
    global $realName;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$realName." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseAddress1($id) {
    global $address1;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$address1." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseAddress2($id) {
    global $address2;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$address2." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseBirthday($id) {
    global $birthday;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$birthday." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUsePhoneNumber1($id) {
    global $phoneNumber1;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$phoneNumber1." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUsePhoneNumber2($id) {
    global $phoneNumber2;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$phoneNumber2." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseEmail($id) {
    global $email;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$email." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseGender($id) {
    global $gender;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$gender." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseClass($id) {
    global $class;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$class." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseSchool($id) {
    global $school;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$school." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseFacebookLink($id) {
    global $facebookLink;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$facebookLink." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseFacebookProfileId($id) {
    global $facebookProfileId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$facebookProfileId." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseCreateTime($id) {
    global $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$createTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

function deleteMembersUseUpdateTime($id) {
    global $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM members WHERE ".$updateTime." = '".$id."'");
    if ($result) {
        return true;
    }
    return false;
}   

?>