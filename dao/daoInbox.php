<?php

require_once 'db_connect.php';
require_once '/../models/inbox.php';

$inboxId = "InboxId";
$fromUserId = "FromUserId";
$toUserId = "ToUserId";
$subject = "Subject";
$content = "Content";
$status = "Status";
$sentdate = "Sentdate";
$createTime = "CreateTime";
$updateTime = "UpdateTime";

//
//class test {

function getInboxIdUseInboxId($varName) {
    global $inboxId, $inboxId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $inboxId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$inboxId];
            break;
        }
    }
    return $varName;
}

function getInboxIdUseFromUserId($varName) {
    global $inboxId, $fromUserId;
    $listInbox = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $fromUserId . " = '" . $varName . "' AND createTime between" . "") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $inbox = new Inbox();
            $inbox->setInboxId($row[$inboxId]);
            $inbox->setFromUserId($row[$fromUserId]);
            $inbox->setToUserId($row[$toUserId]);
            $inbox->setSubject($row[$subject]);
            $inbox->setContent($row[$content]);
            $inbox->setStatus($row[$status]);
            $inbox->setSentdate($row[$sentdate]);
            $inbox->setCreateTime($row[$createTime]);
            $inbox->setUpdateTime($row[$updateTime]);

            array_push($listInbox, $inbox);
        }
    }
    return $listInbox;
//    $db = new DB_CONNECT();
//    $result = mysql_query("SELECT *FROM inbox WHERE ".$fromUserId." = '".$varName."'") or die(mysql_error());
//    if (mysql_num_rows($result) > 0) {
//        while ($row = mysql_fetch_array($result)) {
//            $varName=$row[$inboxId];
//            break;
//        }
//    }
//    return $varName;
}

function getInboxIdUseToUserId($varName) {
    global $inboxId, $toUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $toUserId . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$inboxId];
            break;
        }
    }
    return $varName;
}

function getInboxIdUseSubject($varName) {
    global $inboxId, $subject;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $subject . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$inboxId];
            break;
        }
    }
    return $varName;
}

function getInboxIdUseContent($varName) {
    global $inboxId, $content;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $content . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$inboxId];
            break;
        }
    }
    return $varName;
}

function getInboxIdUseStatus($varName) {
    global $inboxId, $status;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT 1 FROM inbox "
            . " WHERE  status = 1 and toUserId = " . $varName)
            or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return mysql_num_rows($result);
    }
    return 0;
}

function getInboxIdUseSentdate($varName) {
    global $inboxId, $sentdate;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $sentdate . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$inboxId];
            break;
        }
    }
    return $varName;
}

function getInboxIdUseCreateTime($varName) {
    global $inboxId, $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $createTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$inboxId];
            break;
        }
    }
    return $varName;
}

function getInboxIdUseUpdateTime($varName) {
    global $inboxId, $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox WHERE " . $updateTime . " = '" . $varName . "'") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $varName = $row[$inboxId];
            break;
        }
    }
    return $varName;
}

function getListInbox() {
    global $inboxId, $fromUserId, $toUserId, $subject, $content, $status, $sentdate, $createTime, $updateTime;
    $listInbox = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT *FROM inbox") or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $inbox = new Inbox();
            $inbox->setInboxId($row[$inboxId]);
            $inbox->setFromUserId($row[$fromUserId]);
            $inbox->setToUserId($row[$toUserId]);
            $inbox->setSubject($row[$subject]);
            $inbox->setContent($row[$content]);
            $inbox->setStatus($row[$status]);
            $inbox->setSentdate($row[$sentdate]);
            $inbox->setCreateTime($row[$createTime]);
            $inbox->setUpdateTime($row[$updateTime]);

            array_push($listInbox, $inbox);
        }
    }
    return $listInbox;
}

function updateStatusInbox($varName) {
    global $inboxId, $fromUserId, $toUserId, $subject, $content, $status, $sentdate, $createTime, $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE inbox SET  "
            . $status . " = '3' WHERE " . $inboxId . " = '" . $varName . "'");
    if ($result) {
        return true;
    }
    return false;
}

function updateInbox(Inbox $inbox) {
    global $inboxId, $fromUserId, $toUserId, $subject, $content, $status, $sentdate, $createTime, $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("UPDATE inbox SET  "
            . $fromUserId . " = '" . $inbox->getFromUserId() . "', "
            . $toUserId . " = '" . $inbox->getToUserId() . "', "
            . $subject . " = '" . $inbox->getSubject() . "', "
            . $content . " = '" . $inbox->getContent() . "', "
            . $status . " = '" . $inbox->getStatus() . "', "
            . $sentdate . " = '" . $inbox->getSentdate()
            . "' WHERE " . $inboxId . " = '" . $inbox->getInboxId() . "'");
    if ($result) {
        return true;
    }
    return false;
}

function createInbox(Inbox $inbox) {
    global $inboxId, $fromUserId, $toUserId, $subject, $content, $status, $sentdate, $createTime, $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("INSERT INTO inbox("
            . $fromUserId . ","
            . $toUserId . ","
            . $subject . ","
            . $content . ","
            . $status . ","
            . $sentdate . ","
            . $createTime
            . ") VALUES( '"
            . $inbox->getFromUserId() . "','"
            . $inbox->getToUserId() . "','"
            . $inbox->getSubject() . "','"
            . $inbox->getContent() . "','"
            . $inbox->getStatus() . "','"
            . $inbox->getSentdate() . "', NOW())");
    if ($result) {
        return true;
    }
    return false;
}

function insertWithMultiInbox($fromUser, $toUser, $subject, $content123) {
   // echo nl2br('' . $content123 . "\n".$toUser."\n".$subject."\n".$fromUser."\n");
    $fromUser = trim($fromUser);
    if (isset($fromUser) === true && $fromUser === '') {
        return 'Can not send message!';
    }
    $content123 = trim($content123);
    if (isset($content123) === true && $content123 === '') {
        return 'Please fill out Content!';
    }
    $toUser = trim($toUser);
    if (isset($toUser) === true && $toUser === '') {
       return 'Please choose users or groups!';
    }
    $myArray = explode(',', $toUser);
    //print_r($myArray);
    $amount = sizeof($myArray) - 1;
    if($myArray[$amount]==='')
        $amount = sizeof($myArray) - 2;
    $now = new DateTime();
    // echo $now->format('Y-m-d H:i:s');    // MySQL datetime format
    // echo nl2br(''.$content."\n");
    $sqlString = "INSERT INTO inbox (FromUserId,ToUserId,Subject,Content,Status,Sentdate,createTime) VALUES ";
    $item = '';
    for ($i = 0; $i < $amount; $i++) {
        $item = $item . ' (' . $fromUser . ',' . $myArray[$i] . ",'" . $subject . "','" . $content123 . "',1,'" . $now->format('Y-m-d H:i:s') . "','" . $now->format('Y-m-d H:i:s') . "'),";
    }
    $item = $item . ' (' . $fromUser . ',' . $myArray[$amount] . ",'" . $subject . "','" . $content123 . "',1,'" . $now->format('Y-m-d H:i:s') . "','" . $now->format('Y-m-d H:i:s') . "');";
    $sqlString = $sqlString . $item;
    $db = new DB_CONNECT();
    //echo $sqlString;
    $result = mysql_query($sqlString);
    if ($result)
        return 'true';
    return 'false';
}

function insertWithMultiInbox2($fromUser, $toUser, $subject, $content123) {
    //echo nl2br('' . $content123 . "\n".$toUser."\n".$subject."\n".$fromUser."\n");
    $fromUser = trim($fromUser);
    if (isset($fromUser) === true && $fromUser === '') {
         return 'Error!!';
    }
    $content123 = trim($content123);
    if (isset($content123) === true && $content123 === '') {
         return 'Please fill out content!';
    }
    $toUser = trim($toUser);
    if (isset($toUser) === true && $toUser === '') {
         return 'Please choose users or groups!';
    }
//    $content123 = trim($content123);
//    if (isset($content123) === true && $content123 === '') {
//        return 'false';
//    }
    $myArray = explode(',', $toUser);
    $amount = sizeof($myArray);
    
    $now = new DateTime();
    for ($i = 0; $i < $amount; $i++) {
        $listUser = getGroupAdUser2($myArray[$i]);
        $amount1 = sizeof($listUser) - 1;
        $item = '';
        $db = new DB_CONNECT();
        if(sizeof($listUser) > 0){
            $sqlString = "INSERT INTO inbox (FromUserId,ToUserId,Subject,Content,Status,Sentdate) VALUES ";
            for ($j = 0; $j < $amount1; $j++) {
                $item = $item . ' (' . $fromUser . ',' . $listUser[$j]->getUserId() . ",'" . $subject . "','" . $content123 . "',1,'" . $now->format('Y-m-d H:i:s') . "'),";
            }
            $item = $item . ' (' . $fromUser . ',' . $listUser[$amount1]->getUserId() . ",'" . $subject . "','" . $content123 . "',1,'" . $now->format('Y-m-d H:i:s') . "');";
            $sqlString = $sqlString . $item;
           
            $result = mysql_query($sqlString);
            //echo $sqlString;
        }
        // if(sizeof($myArray))
    }
    $db->close();
  
    if ($result)
        return 'true';
    return 'false';
}

function deleteInboxUseInboxId($id) {
    global $inboxId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $inboxId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseFromUserId($id) {
    global $fromUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $fromUserId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseToUserId($id) {
    global $toUserId;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $toUserId . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseSubject($id) {
    global $subject;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $subject . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseContent($id) {
    global $content;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $content . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseStatus($id) {
    global $status;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $status . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseSentdate($id) {
    global $sentdate;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $sentdate . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseCreateTime($id) {
    global $createTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $createTime . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function deleteInboxUseUpdateTime($id) {
    global $updateTime;
    $db = new DB_CONNECT();
    $result = mysql_query("DELETE FROM inbox WHERE " . $updateTime . " = '" . $id . "'");
    if ($result) {
        return true;
    }
    return false;
}

function __construct() {
    echo $this->insertWithMultiInbox(1, "9,4,8", "222", "222");
}

function getListInboxSize($userId) {
    global $inboxId, $fromUserId, $toUserId, $subject, $content, $status, $sentdate, $createTime, $updateTime;
    $listInbox = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT 1 FROM inbox a,users b, status c "
            . "WHERE a.ToUserId = b.userId and a.status = c.StatusId and a. toUserId = " . $userId . " order by a.sentdate desc")
            or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        return mysql_num_rows($result);
    }
    return 0;
}

function getListInbox2($userId, $start, $row) {
    global $inboxId, $fromUserId, $toUserId, $subject, $content, $status, $sentdate, $createTime, $updateTime;
    $listInbox = array();
    $db = new DB_CONNECT();
    $result = mysql_query("SELECT b.`FullName`,a.`InboxId`, a.`Subject`, a.`Content`,  a.`Sentdate`, a.`Status` FROM inbox a,users b "
            . "WHERE a.ToUserId = b.UserId and a.ToUserId = " . $userId . " order by a.sentdate desc limit " . $start . "," . $row)
            or die(mysql_error());
    if (mysql_num_rows($result) > 0) {
        while ($row = mysql_fetch_array($result)) {
            $inbox = new Inbox();
//            $inbox->setInboxId($row[$inboxId]);
            $inbox->setFromUserId($row['FullName']);
            $inbox->setInboxId($row[$inboxId]);
            $inbox->setSubject($row[$subject]);
            $inbox->setContent($row[$content]);
            $inbox->setStatus($row[$status]);
            $inbox->setSentdate($row[$sentdate]);
//            $inbox->setCreateTime($row[$createTime]);
//            $inbox->setUpdateTime($row[$updateTime]);

            array_push($listInbox, $inbox);
        }
    }
    return $listInbox;
}

//}
//
//$tee = new test();
?>