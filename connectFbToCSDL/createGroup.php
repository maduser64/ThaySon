<?php
session_start();
$parentGroupId=$_GET["parentGroupId"];
$groupId=$_POST["groupfacebook_id"];
$_SESSION['group_id'] = $groupId;
echo $groupId."  ".$_SESSION['group_id'];
header("Location: FbToCSDL_Group.php");

?>

