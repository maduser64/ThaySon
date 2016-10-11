<?php

session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoGroups.php';
require_once '/models/groups.php';
require_once '/dao/daoUsers.php';
require_once '/dao/daoRoles.php';
require_once '/models/users.php';

if (isset($_POST['deleteMail'])) {
    echo '-------------------------------------------------------------------------------------deleteUser';
    $posted = array_unique($_POST['checkbox_name']);
    foreach ($posted as $value) {
        deleteInboxUseInboxId($value);
    }
    $sendLink = "Location: inboxView.php?pageNumInbox=" . $_SESSION['pageNumInbox'];
    exit(header($sendLink));
}
if (isset($_POST['approveMail'])) {
    $posted = array_unique($_POST['checkbox_name']);
    foreach ($posted as $value) {
        updateStatusInbox($value);
    }
    $sendLink = "Location: inboxView.php?pageNumInbox=" . $_SESSION['pageNumInbox'];
    exit(header($sendLink));
}
?>

