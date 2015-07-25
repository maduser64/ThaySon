<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
    require_once __DIR__ . '/models/members.php';
    require_once __DIR__ . '/dao/daoMembers.php';
?>
//tài sao k có j
//hay ah nha
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $member = new Members();
        $member->setMemberid("123");
        $member->setName("0234");
        $member->setFacebookidmember("133");
        $member->setAdministrator("211");
        $member->setGroupid("1");
        echo "kq: " . $member->getName();
        if (createMember($member))
            echo " create thanh cong";
        else if (updateMember($member))
            echo " update thanh cong";
        else
            deleteMember($member->getMemberid());
        ?>
    </body>
</html>
