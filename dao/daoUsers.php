<?php

require_once 'db_connect.php';
require_once '/../models/users.php';

$userId = "UserId";
$userName = "UserName";
$password = "Password";
$fullName = "FullName";
$avatar = "Avatar";
$address1 = "Address1";
$address2 = "Address2";
$birthday = "Birthday";
$phoneNumber1 = "PhoneNumber1";
$phoneNumber2 = "PhoneNumber2";
$email = "Email";
$gender = "Gender";
$school = "School";
$class = "Class";
$createTime = "CreateTime";
$updateTime = "UpdateTime";
$facebookId = "FacebookId";

// validate for register
function validateUserAndPass($userNameTmp, $passTmp) {
    //echo '-------------------------------------------'.$passTmp;
        $r1 = '/[A-Z]{1,}/';  //Uppercase
        $r2 = '/[a-z]{1,}/';  //lowercase
     
         $r3 = "/^[a-z.@A-Z0-9]{3,}$/";   // whatever you mean by 'special char'
        $r4 = '/[0-9]{1,}/';  //numbers
        $uppercase = preg_match($r1, $passTmp);
        $lowercase = preg_match($r2, $passTmp);
        $number = preg_match($r4, $passTmp);
        $symbol = preg_match($r3, $passTmp);

        if (!$uppercase || !$lowercase || !$number  || !$symbol) {
            return 'Password must not include special character ,'
            . ' must include at least 1 uppercase letter,'
            . ' 1 lower letter, at least one number!';                    
        }
        if (strlen($passTmp) < 8) {
            return 'Password is too short(>8 characters)';
        }
        if (!preg_match_all($r3, $userNameTmp, $o))
            return 'Username must not include special character';
        if (strlen($userNameTmp) < 5) {
            return 'Username must include at least 5 character';
        }
        return 'true';  
}
function check_Pass($passTmp) {
//    $r3 = "/[!@#$%^&*()\-_=+{};:,<.>]/"; 
     $r3 = "/^[a-z.@A-Z0-9]{3,}$/"; 
    $symbol = preg_match($r3, $passTmp);
    if($symbol) return true;
    return false;
}
function checkUser($varUserName, $varPass) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * FROM users WHERE (UserName = '" . $varUserName . "' OR Email= '" . $varUserName . "') AND password = '" . $varPass . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row[$userId]);
            $users->setUserName($row[$userName]);
            $users->setPassword($row[$password]);
            $users->setFullName($row[$fullName]);
            $users->setAddress2($row[$address2]);
            $users->setAddress1($row[$address1]);
            $users->setBirthday($row[$birthday]);
            $users->setAvatar($row[$avatar]);
            $users->setPhoneNumber2($row[$phoneNumber2]);
            $users->setPhoneNumber1($row[$phoneNumber1]);
            $users->setEmail($row[$email]);
            $users->setGender($row[$gender]);
            $users->setSchool($row[$school]);
            $users->setClass($row[$class]);
            $users->setCreateTime($row[$createTime]);
            $users->setUpdateTime($row[$updateTime]);
            return $users;
        }
    }
    return null;
}

function getUserById($varUserName) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * ,DATE_FORMAT(Birthday, \"%d-%l-%Y\") AS DOB FROM users WHERE UserId = '" . $varUserName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row[$userId]);
            $users->setUserName($row[$userName]);
            $users->setPassword($row[$password]);
            $users->setFullName($row[$fullName]);
            $users->setAddress2($row[$address2]);
            $users->setAddress1($row[$address1]);
            $users->setBirthday($row['DOB']);
            $users->setAvatar($row[$avatar]);
            $users->setPhoneNumber2($row[$phoneNumber2]);
            $users->setPhoneNumber1($row[$phoneNumber1]);
            $users->setEmail($row[$email]);
            $users->setGender($row[$gender]);
            $users->setSchool($row[$school]);
            $users->setClass($row[$class]);
            $users->setCreateTime($row[$createTime]);
            $users->setUpdateTime($row[$updateTime]);
            return $users;
        }
    }
    return null;
}

function checkUserName($varName) {
    //global    $userId, $userName, $password, $fullName, $address, $birthday, $phoneNumber, $email, $gender, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * FROM users WHERE UserName = '" . $varName . "' ") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            return true;
        }
    }
    return false;
}
function checkEmail($varName) {
    //global    $userId, $userName, $password, $fullName, $address, $birthday, $phoneNumber, $email, $gender, $createTime, $updateTime; 
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * FROM users WHERE Email = '" . $varName . "' ") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            return true;
        }
    }
    return false;
}

function getFullNameById($varName) {
    global $userId, $userName, $fullName;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT " . $fullName . " FROM users WHERE " . $userId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$fullName];
            return $varName;
            // break;
        }
    }
    return 'null';
}

function getUserIdUseUserName($varName) {
    global $userId, $userName;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $userName . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getNameUserUseUserId($varName) {
    global $userId, $userName, $fullName;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $userId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            return $row[$fullName];
            break;
        }
    }
    return $varName;
}

function getUserIdUsePassword($varName) {
    global $userId, $password;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $password . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUseFullName($varName) {
    global $userId, $fullName;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $fullName . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUseAddress($varName) {
    global $userId, $address;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $address . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUseBirthday($varName) {
    global $userId, $birthday;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $birthday . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUsePhoneNumber($varName) {
    global $userId, $phoneNumber;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $phoneNumber . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUseEmail($varName) {
    global $userId, $email;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $email . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUseGender($varName) {
    global $userId, $gender;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $gender . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUseCreateTime($varName) {
    global $userId, $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $createTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getUserIdUseUpdateTime($varName) {
    global $userId, $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE " . $updateTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$userId];
            break;
        }
    }
    return $varName;
}

function getListUsers() {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row[$userId]);
            $users->setUserName($row[$userName]);
            $users->setPassword($row[$password]);
            $users->setFullName($row[$fullName]);
            $users->setAddress2($row[$address2]);
            $users->setAddress1($row[$address1]);
            $users->setBirthday($row[$birthday]);
            $users->setAvatar($row[$avatar]);
            $users->setPhoneNumber2($row[$phoneNumber2]);
            $users->setPhoneNumber1($row[$phoneNumber1]);
            $users->setEmail($row[$email]);
            $users->setGender($row[$gender]);
            $users->setSchool($row[$school]);
            $users->setClass($row[$class]);
            $users->setCreateTime($row[$createTime]);
            $users->setUpdateTime($row[$updateTime]);

            array_push($listUsers, $users);
        }
    }
    return $listUsers;
}

function getListUsersRole($start, $count) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users  order by " . $fullName . " LIMIT " . $start . "," . $count . "") or die(mysql_error());
    $rule = "<pre><font color=\"#ff0000\">";
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row[$userId]);
            $users->setUserName($row[$userName]);
            $users->setPassword($row[$password]);
            $users->setFullName($row[$fullName]);
            $users->setAddress2($row[$address2]);
            $users->setAddress1($row[$address1]);
            $users->setBirthday($row[$birthday]);
            $users->setAvatar($row[$avatar]);
            $users->setPhoneNumber2($row[$phoneNumber2]);
            $users->setPhoneNumber1($row[$phoneNumber1]);
            $users->setEmail($row[$email]);
            $users->setGender($row[$gender]);
            $users->setSchool($row[$school]);
            $users->setClass($row[$class]);
            $users->setCreateTime($row[$createTime]);
            $users->setUpdateTime($row[$updateTime]);
            array_push($listUsers, $users);
        }
        return $listUsers;
    }
    return $listUsers;
}
function getListUsersRoleWithName($start, $count, $nameUser) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users WHERE $userName like '%$nameUser%' order by " . $fullName . " LIMIT " . $start . "," . $count . "") or die(mysql_error());
    $rule = "<pre><font color=\"#ff0000\">";
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row[$userId]);
            $users->setUserName($row[$userName]);
            $users->setPassword($row[$password]);
            $users->setFullName($row[$fullName]);
            $users->setAddress2($row[$address2]);
            $users->setAddress1($row[$address1]);
            $users->setBirthday($row[$birthday]);
            $users->setAvatar($row[$avatar]);
            $users->setPhoneNumber2($row[$phoneNumber2]);
            $users->setPhoneNumber1($row[$phoneNumber1]);
            $users->setEmail($row[$email]);
            $users->setGender($row[$gender]);
            $users->setSchool($row[$school]);
            $users->setClass($row[$class]);
            $users->setCreateTime($row[$createTime]);
            $users->setUpdateTime($row[$updateTime]);
            array_push($listUsers, $users);
        }
        return $listUsers;
    }
    return $listUsers;
}
function getListUsersCount() {
    //global  $userId, $userName, $password, $fullName, $address1, $address2, $birthday,$phoneNumber1,$phoneNumber2, $email, $gender, $createTime, $updateTime,$school, $class, $avatar;
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return mysql_num_rows($result);
    }
    return 0;
}

function getListUserInGroupUserUsingGroupUserId($varIdGroup) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users,user_groupuser WHERE users.UserId=user_groupuser.UserId AND user_groupuser.GroupUserId= " . $varIdGroup) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row[$userId]);
            $users->setUserName($row[$userName]);
            $users->setPassword($row[$password]);
            $users->setFullName($row[$fullName]);
            $users->setAddress2($row[$address2]);
            $users->setAddress1($row[$address1]);
            $users->setBirthday($row[$birthday]);
            $users->setAvatar($row[$avatar]);
            $users->setPhoneNumber2($row[$phoneNumber2]);
            $users->setPhoneNumber1($row[$phoneNumber1]);
            $users->setEmail($row[$email]);
            $users->setGender($row[$gender]);
            $users->setSchool($row[$school]);
            $users->setClass($row[$class]);
            $users->setCreateTime($row[$createTime]);
            $users->setUpdateTime($row[$updateTime]);
            array_push($listUsers, $users);
        }
    }
    $db->close();
    return $listUsers;
}

function getListUserbyKey($groId, $key) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users,user_groupuser "
            . " WHERE users.UserId=user_groupuser.UserId "
            . " AND user_groupuser.GroupUserId= " . $groId
            . " AND (users.UserName like N'%" . $key . "%' OR users.FullName like N'%" . $key . "%')") or die(mysql_error());
//    echo "SELECT *FROM users,user_groupuser "
//            . " WHERE users.UserId=user_groupuser.UserId "
//            . " AND user_groupuser.GroupUserId= ".$groId 
//            . " AND (users.UserName like N'%".$key."%' OR users.FullName like N'%".$key."%')";
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row[$userId]);
            $users->setUserName($row[$userName]);
            $users->setPassword($row[$password]);
            $users->setFullName($row[$fullName]);
            $users->setAddress2($row[$address2]);
            $users->setAddress1($row[$address1]);
            $users->setBirthday($row[$birthday]);
            $users->setAvatar($row[$avatar]);
            $users->setPhoneNumber2($row[$phoneNumber2]);
            $users->setPhoneNumber1($row[$phoneNumber1]);
            $users->setEmail($row[$email]);
            $users->setGender($row[$gender]);
            $users->setSchool($row[$school]);
            $users->setClass($row[$class]);
            //$users->setCreateTime($row[$createTime]);
            //$users->setUpdateTime($row[$updateTime]);      
            array_push($listUsers, $users);
        }
    }
    $db->close();
    return $listUsers;
}

function getFullRoleNameUsingUserId($varName) {
    //global    $userId, $userName, $password, $fullName, $address, $birthday, $phoneNumber, $email, $gender, $createTime, $updateTime; 
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM users,roles,user_role where users.UserId=user_role.UserId AND user_role.RoleId=roles.RoleId AND users.UserId=" . $varName) or die(mysql_error());
    $rule = "<pre><font color=\"#ff0000\">";
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $rule = $rule . "<br>" . $row["RoleName"];
        }
        return $rule . "</font>";
    }
    return "<pre><font color=\"#ff0000\">Chưa có bất kì quyền nào!</font>";
}

function checkRoleAdminUsingUserId($varName) {
// global    $userId, $userName, $password, $fullName, $address, $birthday, $phoneNumber, $email, $gender, $createTime, $updateTime; 
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * from user_role where roleId = 1 AND UserId = " . $varName) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function checkRoleTV($varName) {
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * from user_role where roleId = 4 AND UserId = " . $varName) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function checkRoleQuanTri($varName) {
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * from user_role where roleId = 2 AND UserId = " . $varName) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function checkRoleQLNhom($varName) {
    $listUsers = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT * from user_role where roleId = 3 AND UserId = " . $varName) or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return true;
    }
    return false;
}

function updateUsers(Users $users) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;

    $db = new DB_CONNECT();

    $phoneNumber1 = "PhoneNumber1";
    $address2 = "Address2";
    $phoneNumber2 = "PhoneNumber2";
    $email = "Email";
    $gender = "Gender";
    $school = "School";
    $class = "Class";

    $result = mysql_query("UPDATE users SET  "
            . $fullName . " = '" . $users->getFullName() . "', "
            . $address1 . " = '" . $users->getAddress1() . "', "
            . $birthday . " = '" . $users->getBirthday() . "', "
            . $phoneNumber1 . " = '" . $users->getPhoneNumber1() . "', "
            . $email . " = '" . $users->getEmail() . "', "
            . $gender . " = '" . $users->getGender() . "', "
            . $phoneNumber2 . " = '" . $users->getPhoneNumber2() . "', "
            . $address2 . " = '" . $users->getAddress2() . "', "
            . $class . " = '" . $users->getClass() . "', "
            . $school . " = '" . $users->getSchool()
            . "' WHERE " . $userId . " = '" . $users->getUserId() . "'") or die(mysql_error());
    if ($result) {
        return true;
    }
    return false;
}

function updateUsersPass(Users $users) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;

    $db = new DB_CONNECT();

    $result = mysql_query("UPDATE users SET  "
            . $password . " = '" . $users->getPassword()
            . "' WHERE " . $userId . " = '" . $users->getUserId() . "'") or die(mysql_error());
    if ($result) {
        return true;
    }
    return false;
}

function createUsers(Users $users) {
    global $userId, $userName, $password, $fullName, $address1, $address2, $birthday, $phoneNumber1, $phoneNumber2, $email, $gender, $createTime, $updateTime, $school, $class, $avatar;

    if (checkUserName($users->getUserName()) == true||checkEmail($users->getEmail()) == true)
        return "Username or email are existent!";
//$sql = 'TEST create';
//System.out.print($sql);
    $db = new DB_CONNECT();
    $sql = "INSERT INTO users($userName,$password ,$fullName ,$address1 , $address2, $birthday, $phoneNumber1, $phoneNumber2, Email, $gender, $school, $class, $createTime) VALUES( '"
            . $users->getUserName() . "','"
            . $users->getPassword() . "','"
            . $users->getFullName() . "','"
            . $users->getAddress1() . "','"
            . $users->getAddress2() . "','"
            . $users->getBirthday() . "','"
            . $users->getPhoneNumber1() . "','"
            . $users->getPhoneNumber2() . "','"
            . $users->getEmail() . "','"
            . $users->getGender() . "','"
            . $users->getSchool() . "','"
            . $users->getClass() . "',NOW());";
//    echo '' . $sql;
    $result = mysql_query($sql);
    if ($result) {
        return 'true';
    }
    return 'Error occured!';
}

function deleteUsersUseUserId($id) {
    global $userId;
    $db = new DB_CONNECT();
    mysql_query("DELETE FROM user_group WHERE " . $userId . " = '" . $id . "'");
    mysql_query("DELETE FROM user_role WHERE " . $userId . " = '" . $id . "'");
    $result = mysql_query("DELETE FROM users WHERE " . $userId . " = '" . $id . "'");
    $db->close();
    if ($result) {
        return true;
    }
    return false;
}

function deleteUsersUseUserName($id) {
    global $userName;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM users WHERE " . $userName . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteUsersUsePassword($id) {
    global $password;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM users WHERE " . $password . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteUsersUseFullName($id) {
    global $fullName;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM users WHERE " . $fullName . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

//function deleteUsersUseAddress($id) {
//    global $address;
//    $db = new DB_CONNECT();
//    $result = mysql_query("DELETE FROM users WHERE ".$address." = '".$id."'");
//    if ($result) {
//        return true;
//    }
//    return false;
//}   
//function deleteUsersUseBirthday($id) {
//    global $birthday;
//    $db = new DB_CONNECT();
//    $result = mysql_query("DELETE FROM users WHERE ".$birthday." = '".$id."'");
//    if ($result) {
//        return true;
//    }
//    return false;
//}   
//function deleteUsersUsePhoneNumber($id) {
//    global $phoneNumber;
//    $db = new DB_CONNECT();
//    $result = mysql_query("DELETE FROM users WHERE ".$phoneNumber." = '".$id."'");
//    if ($result) {
//        return true;
//    }
//    return false;
//}   
//function deleteUsersUseEmail($id) {
//    global $email;
//    $db = new DB_CONNECT();
//    $result = mysql_query("DELETE FROM users WHERE ".$email." = '".$id."'");
//    if ($result) {
//        return true;
//    }
//    return false;
//}   
//function deleteUsersUseGender($id) {
//    global $gender;
//    $db = new DB_CONNECT();
//    $result = mysql_query("DELETE FROM users WHERE ".$gender." = '".$id."'");
//    if ($result) {
//        return true;
//    }
//    return false;
//}   
//
//function deleteUsersUseCreateTime($id) {
//    global $createTime;
//    $db = new DB_CONNECT();
//    $result = mysql_query("DELETE FROM users WHERE ".$createTime." = '".$id."'");
//    if ($result) {
//        return true;
//    }
//    return false;
//}   
//function deleteUsersUseUpdateTime($id) {
//    global $updateTime;
//    $db = new DB_CONNECT();
//    $result = mysql_query("DELETE FROM users WHERE ".$updateTime." = '".$id."'");
//    if ($result) {
//        return true;
//    }
//    return false;
//}   
//function updateUser(Users $user){
//    $sql = "update users set FullName = '".$user->getFullName()
//            ."', Address1 = '".$user->getAddress1()
//            ."', Address2 = '".$user->getAddress2()
//            ."', Birthday = '".$user->getBirthday()
//            ."', PhoneNumber1= '".$user->getPhoneNumber1()
//            ."', PhoneNumber2= '".$user->getPhoneNumber2()
//            ."', Gender= '".$user->getGender()
//            ."', Email= '".$user->getEmail()
//            ."', School= '".$user->getSchool()
//            ."', Class= '".$user->getClass()
//            ."'  where UserId = ".$user->getUserId();
//    $db = new DB_CONNECT();
//    $result = mysql_query($sql);
//    echo ''.$sql;
//    if ($result) {
//        return true;
//    }
//    return false; 
//}
function getGroupAdUser($user, $group) {
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT a.`UserId` ,a.`FullName`,a.`PhoneNumber`,a.`Email`, c.Name from users a, user_group b, groups c, user_role d "
            . "WHERE b.UserId = a.UserId AND b.GroupId = c.GroupId AND b.UserId = d.UserId AND c.ParentGroupId =" . $group . " AND d.RoleId = 1 and a.userId = " . $user)
            or die(mysql_error());
    $listUser = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row['UserId']);
            // $users->setUserName($row[$userName]);
            //  $users->setPassword($row[$password]);
            $users->setFullName($row['FullName']);
            $users->setAddress($row['Name']);
//            $users->setBirthday($row['Email']);
            $users->setPhoneNumber($row['PhoneNumber']);
//            $users->setEmail($row['Email']);
//            $users->setCreateTime($row[$createTime]);
//            $users->setGender($row[$gender]);  
            array_push($listUser, $users);
        }
        return $listUser;
    }
    return null;
}

function getGroupAdUser2($group) {
   
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT a.UserId from users a, user_groupuser b "
            . "WHERE b.UserId = a.UserId AND b.GroupUserId = ".$group)
            or die(mysql_error());
    $userL = array();
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $users = new Users();
            $users->setUserId($row['UserId']);
  //           echo '-------------------------------------------------------'.$row['UserId'];
            // $users->setUserName($row[$userName]);
            //  $users->setPassword($row[$password]);
//            $users->setFullName($row['FullName']);
//           $users->setAddress($row['Name']);
//            $users->setBirthday($row['Email']);
//           $users->setPhoneNumber($row['PhoneNumber']);
//            $users->setEmail($row['Email']);
//            $users->setCreateTime($row[$createTime]);
//            $users->setGender($row[$gender]);            
            array_push($userL, $users);
        }
        return $userL;
    }
    return null;
}

?>