<?php

session_start();
require_once '/dao/daoFeeds.php';
require_once '/models/feeds.php';

if (isset($_POST['report']) && !isset($_POST['approve'])) {
    echo $_POST['report'] . '</br>';
    $posted = array_unique($_POST['checkbox_name']);
    $reportString ='</br></br> Các bài viết vi phạm điều lệ: </br><pre>';
    foreach ($posted as $value) {
        echo $value . '</br>';
        $errLink=getFacebookFeedIdUseFeedId($value);
        $reportString= $reportString.'</br><a href="http://facebook.com/'.$errLink.'">http://facebook.com/'.$errLink.'</a>';
    }
    $reportString= $reportString.'';
    $sendLink = "Location: sentMailPage.php?reportLink=".$reportString;
    exit(header($sendLink));
    
} else if (isset($_POST['approve'])) {
    echo $_POST['approve'] . '</br>';
    $posted = array_unique($_POST['checkbox_name']);
    foreach ($posted as $value) {
        echo $value . '</br>';
        updateStatusFeed($value);
    }
    $backLink = "Location: feedView.php?facebookGroupId=" . $_SESSION['group_id'] . "&groupId=" . $_SESSION['id_group_csdl'] . "&pageNum=" . $_SESSION['pageNum'];
    exit(header($backLink));
    
}
?>

