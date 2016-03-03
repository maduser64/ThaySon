<?php

session_start();
$start= $_POST["from-date"];
$end=$_POST["to-date"];

$start=str_replace("/","-",$start);
$start2=  substr($start, 0,5);
$start2= substr($start, 6).'-'.$start2;

$end=str_replace("/","-",$end);
$end2=  substr($end, 0,5);
$end2= substr($end, 6).'-'.$end2;


$_SESSION['date_start'] = $start2;
$_SESSION['date_end'] = $end2;

//  da luu 2 session nay o file feed view
echo "".$_SESSION['group_id']." - ".$_SESSION['id_group_csdl']. " -|- ".$start2." -|- ".$end2;

header("Location: FbToCSDL_Feed.php");
?>

