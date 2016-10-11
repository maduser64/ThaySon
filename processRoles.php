<?php

session_start();
require_once '/dao/daoUser_Role.php';
require_once '/models/user_role.php';
require_once '/dao/daoUsers.php';
require_once '/dao/daoRoles.php';
//
//if (isset($_POST['thanhVien']) && !isset($_POST['quanTri']) && !isset($_POST['quanLyNhom']) && !isset($_POST['capQuyen']) && !isset($_POST['xoaQuyen'])) {
//    echo $_POST['thanhVien'] . '</br>';
//    $posted = array_unique($_POST['checkbox_name']);
//
//    foreach ($posted as $value) {
//        echo $value . '</br>';
//        $userRole = new User_role();
//        $userRole->setRoleId(4);
//        $userRole->setUserId($value);
//        createUser_Role($userRole);
//    }
//    $sendLink = "Location: rolesView.php?pageNumRole=" . $_SESSION['pageNumRole'];
//    exit(header($sendLink));
//} else if (!isset($_POST['thanhVien']) && isset($_POST['quanTri']) && !isset($_POST['quanLyNhom']) && !isset($_POST['capQuyen']) && !isset($_POST['xoaQuyen'])) {
//    echo $_POST['quanTri'] . '</br>';
//    $posted = array_unique($_POST['checkbox_name']);
//
//    foreach ($posted as $value) {
//        echo $value . '</br>';
//        $userRole = new User_role();
//        $userRole->setRoleId(3);
//        $userRole->setUserId($value);
//        createUser_Role($userRole);
//    }
//    $sendLink = "Location: rolesView.php?pageNumRole=" . $_SESSION['pageNumRole'];
//    exit(header($sendLink));
//} else if (!isset($_POST['thanhVien']) && !isset($_POST['quanTri']) && isset($_POST['quanLyNhom']) && !isset($_POST['capQuyen']) && !isset($_POST['xoaQuyen'])) {
//    echo $_POST['quanLyNhom'] . '</br>';
//    $posted = array_unique($_POST['checkbox_name']);
//
//    foreach ($posted as $value) {
//        echo $value . '</br>';
//        $userRole = new User_role();
//        $userRole->setRoleId(2);
//        $userRole->setUserId($value);
//        createUser_Role($userRole);
//    }
//    $sendLink = "Location: rolesView.php?pageNumRole=" . $_SESSION['pageNumRole'];
//    exit(header($sendLink));
//} else if (!isset($_POST['thanhVien']) && !isset($_POST['quanTri']) && !isset($_POST['quanLyNhom']) && isset($_POST['capQuyen']) && !isset($_POST['xoaQuyen'])) {
//    echo $_POST['capQuyen'] . '</br>';
//    $posted = array_unique($_POST['checkbox_name']);
//
//    foreach ($posted as $value) {
//        echo $value . '</br>';
//        $userRole = new User_role();
//        $userRole->setRoleId(1);
//        $userRole->setUserId($value);
//        createUser_Role($userRole);
//    }
//    $sendLink = "Location: rolesView.php?pageNumRole=" . $_SESSION['pageNumRole'];
//    exit(header($sendLink));
//} else if (!isset($_POST['thanhVien']) && !isset($_POST['quanTri']) && !isset($_POST['quanLyNhom']) && !isset($_POST['capQuyen']) && isset($_POST['xoaQuyen'])) {
//    echo $_POST['xoaQuyen'] . '</br>';
//    $posted = array_unique($_POST['checkbox_name']);
//
//    foreach ($posted as $value) {
//        echo $value . '</br>';
//        deleteUser_RoleUseUserId($value);
//    }
//    $sendLink = "Location: rolesView.php?pageNumRole=" . $_SESSION['pageNumRole'];
//    exit(header($sendLink));
//}
if (isset($_POST['nameUser']) && isset($_POST['searchUser']) && !isset($_POST['capQuyen1'])) {
    $sendLink = "Location: rolesView.php?nameUser=".$_POST['nameUser']."&searchUser=1&pageNumRole=1";
    exit(header($sendLink));
}

if (isset($_POST['deleteUser'])) {
    echo '-------------------------------------------------------------------------------------deleteUser';
    $posted = array_unique($_POST['checkbox_name']);
    foreach ($posted as $value) {
        deleteUsersUseUserId($value);
    }
    $sendLink = "Location: rolesView.php?pageNumRole=" . $_SESSION['pageNumRole'];
    exit(header($sendLink));
}
if (isset($_POST['capQuyen1'])) {
    //echo '-------------------------------------------------------------------------------------capQuyen1';
    // $users = getListUsers();
    if (strcasecmp($_SESSION['isSearch'], '0') == 0) {
        $listUser = (array) getListUsersRoleWithName(0, 30, $_SESSION['nameUser']);    
    } else {
        $current = $_SESSION['pageNumRole'];
        $start = ($current - 1) * 10 + 1;
        $listUser = (array) getListUsersRole(($start - 1), 10);    
    }
    //echo  '---'.sizeof($listUser).'---';
    $role = getListRoles();
    for ($i = 0; $i < sizeof($listUser); $i++) {
        // $posted = $_POST[$listUser[$i]->getUserId()];
        if (!empty($_POST[$listUser[$i]->getUserId()])) {
            //echo '-------------------not empty\n';
            $posted = array_unique($_POST[$listUser[$i]->getUserId()]);
            echo $listUser[$i]->getUserId().'-------------------sizeof($posted): '.sizeof($posted).'--';
            for ($j = 0; $j < sizeof($role); $j++) {  
                //echo '-------------------sizeof($role): '.sizeof($role);
                $flag = false;
                foreach ($posted as $value) {
                    if ($role[$j]->getRoleId() == $value) {
                        $flag = true;
                       
                        if (!checkRole($listUser[$i]->getUserId(), $value)) {
                             echo '-------add';
                           // echo '-----------------------------------------------------check>>>>>>';
                            $userRole = new User_role();
                            $userRole->setRoleId($value);
                            $userRole->setUserId($listUser[$i]->getUserId());
                            createUser_Role($userRole);
                        }
                        break;
                    }
                }
                //echo '---------------------$flag----'.$flag;
                if (!$flag) {
                     echo '-------delete';
                     deleteUser_Role($role[$j]->getRoleId(),$listUser[$i]->getUserId());
                }
            }
        }else{
             //echo '---------------------empty----';
            deleteUser_RoleUseUserId($listUser[$i]->getUserId());
        }      
    }
      $sendLink = "Location: rolesView.php?pageNumRole=" . $_SESSION['pageNumRole'];
      exit(header($sendLink));
}
?>

