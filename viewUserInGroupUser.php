<!DOCTYPE html>

<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoGroupUser.php';
require_once '/models/groupuser.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
$key = !isset($_GET['key']) ? "" : $_GET['key'];
$userNameLogin = getUserById($_SESSION['user_id']);

$groupId = $_GET['GroupUserId'];
if (checkRoleAdminUsingUserId($_SESSION['user_id']) || checkRoleQuanTri($_SESSION['user_id'])) {
    if (isset($key)) {
//       echo "-------------------------------kuw---------".$key;
        $listUser = (array) getListUserbyKey($groupId, $key);
    } else
        $listUser = (array) getListUserInGroupUserUsingGroupUserId($groupId);
    //  for($i=0;$i< sizeof($listUser);$i++)
    //    echo ''.((Users)$listUser[i])->getUserId();
} else {
    header("Location: homePage.php");
}

$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
if (isset($_POST['addUser'])) {
    $groupId = $_GET['GroupUserId'];
    $toAddress = mysql_real_escape_string($_POST['userList']);
    echo '----------------------------------------------------------------' . $toAddress;
    addUser($toAddress, $groupId);
    $backLink = "Location: viewUserInGroupUser.php?GroupUserId=" . $groupId;
    exit(header($backLink));
}
if (isset($_POST['searchUser'])) {
    $groupId = $_GET['GroupUserId'];
    $key = mysql_real_escape_string($_POST['usename']);
    echo '----------------------------------------------------------------' . $key;
    //addUser($toAddress, $groupId);
    $backLink = "Location: viewUserInGroupUser.php?GroupUserId=" . $groupId . "&key=" . $key;
    exit(header($backLink));
}
if (isset($_POST['deleteUser'])) {
    echo '----------------------------------------------------------------';
    $groupId = $_GET['GroupUserId'];
    //   echo $groupId;
    $posted = array_unique($_POST['checkbox_name']);
    //echo sizeof($posted);
    if ($posted != null) {
        foreach ($posted as $value) {
            $userSelect = explode(',', $value);
            //echo $value . '--' . $userSelect[0] . '-----' . $userSelect[1];
            $res = deleteUser_Group($userSelect[0], $groupId);
        }
    }
    $backLink = "Location: viewUserInGroupUser.php?GroupUserId=" . $groupId;
    exit(header($backLink));
}
if (isset($_POST['sentMail'])) {
    echo '----------------------------------------------------------------';
    $groupId = $_GET['GroupUserId'];
    //   echo $groupId;
    $posted = array_unique($_POST['checkbox_name']);
    //echo sizeof($posted);
    $listId = '';
    $listName = '';
    if ($posted != null) {
        foreach ($posted as $value) {
            $userSelect = explode(',', $value);
            $listName = $listName . $userSelect[1] . ' ; ';
            $listId = $listId . $userSelect[0] . ',';
//            echo $value . '--' . $userSelect[0] . '-----' . $userSelect[1];
//          //  $res = deleteUser_Group($value, $groupId);
        }
        echo $value . '--' . $listName . '-----' . $listId;
    }
    $backLink = "Location: sentMailPage.php?UserId=" . $listId . '&UserName=' . $listName;
    exit(header($backLink));
//    if ($res == 'Error') {
//        echo '' . "<script> alert(\"Lỗi\");</script>";
//    } else
//        echo '' . "<script> alert(\"TC\");</script>";
//    //echo '---------------------------------------------------'.$res;
}
?>
<html>
    <head>
        <?php include 'includeCss.php'; ?>
        
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <!--  - mail -->
        <link rel="stylesheet" href="mailBox/css/token-input.css">
        <!--        <link rel="stylesheet" href="mailBox/css/send_email.css">-->
        <link rel="stylesheet" href="mailBox/css/token-input-facebook.css">
        <script src="mailBox/js/jquery-1.9.1.js"></script>
        <script src="mailBox/js/jquery.tokeninput.js"></script>
        <script src="mailBox/js/send_email.js"></script>
        <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js" ></script>
        <!--  - alert -->
        <link rel="stylesheet" href="bootstrap/css/sweetalert.css"/>
        <script src="bootstrap/js/sweetalert.min.js"/>
        <!-- <script src="bootstrap/js/sweetalert2.min.js"/>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/sweetalert2.css"/>-->
        <script src="mailBox/js/jquery-1.9.1.js"></script>
        <script >
            function showAlertFalse() {
                //console.log("fAIL");
                sweetAlert('Oops...', 'Something went wrong!', 'error');
            }
            function showSweetAlert1(message) {
                // console.log("OK");

                swal(message, "", "success");
            }
            jQuery(document).ready(function($) {
                $('#selectall').click(function(event) {  //on click 
                    if (this.checked) { // check select status
                        $('.cbox').each(function() { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                    } else {
                        $('.cbox').each(function() { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                        });
                    }
                });

            });
        </script>
    </head>

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includeTab.php';?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Members User Manager
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Member user Information</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <form method="post" id="myForm" > 
                        <div class="row">
                            <div class="col-md-12" style="padding-bottom: 10px;">
                                <div class= "left" style="display:inline" >
                                    <a href="homePage.php" class="left text-center btn btn-sm btn-file bg-blue"><i class="fa fa-backward"></i> Back</a>             
                                </div>
                                <div class= "center" style="margin-left: 10px; display:inline">
                                    <a class="left text-center btn btn-sm btn-file bg-blue" href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');"><i class="fa fa-plus-circle"></i> Add</a>
                                </div>
                                <div class= "center" style="margin-left: 10px;display:inline">
                                    <button class="text-center btn btn-sm btn-file bg-blue" type="submit" name="sentMail"> <i class="fa fa-envelope-o"></i> Send mail</button>
                                </div>
                                <div class= "right" style="margin-left: 10px;display:inline">
                                    <button class="text-center btn btn-sm btn-file bg-red-active" type="submit" name="deleteUser"> <i class="fa fa-trash"></i> Delete</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box table-responsive ">
                                    <div class="box-header">
                                        <div class="row">
                                            <div class="col-md-12" style="padding-bottom: 10px;">
                                                <h3 class="box-title left text-center" style="display:inline">Users</h3>
                                                <div class="col-sm-3 col-md-3 pull-right" id="search_user1" style="display:inline">
                                                    <div class="input-group">
                                                        <input type="text" name="usename"  class="form-control" placeholder="Search user..." value="<?php echo $key ?>"/>
                                                        <div class="input-group-btn">
                                                            <button  name="searchUser" id="search-btn" class=" btn bg-blue" onclick="check();" ><i class="glyphicon glyphicon-search"></i></button>
                                                        </div>
                                                    </div>                                
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.box-header -->
                                    <div class="box-body ">
                                        <input type="hidden" name="param" />
                                        
                                        <table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><input type="checkbox" id ="selectall"/></th>
                                                    <th class="text-center"><small>Full Name</small></th>
                                                    <th class="text-center"><small>User name</small></th>
                                                    <th class="text-center"><small>Current Address</small></th>
                                                    <th class="text-center"><small>Home town</small></th>
                                                    <th class="text-center"><small>Phone Number</small></th>
                                                    <th class="text-center"><small>Home Number</small></th>
                                                    <th class="text-center"><small>Email</small></th>
                                                    <th class="text-center"><small>Birthday</small></th>
                                                    <th class="text-center"><small>Gender</small></th>
                                                    <th class="text-center"><small>School</small></th>
                                                    <th class="text-center"><small>Class</small></th>
                                                    <th class="text-center"><small>Send mail</small></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listUser);
                                                $row = new Users();
                                                $i = 0;
                                                foreach ($listUser as $row) {
                                                    echo '<tr>';
                                                    echo "<td class =\"text-center\"><input type=\"checkbox\" class =\"cbox\" name=\"checkbox_name[]\" value=\"{$row->getUserId()},{$row->getUserName()}({$row->getEmail()})\" /></td>";
                                                    $i++;

                                                    echo "<td class=\"text-center\" ><small>{$row->getFullName()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getUserName()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getAddress1()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getAddress2()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getPhoneNumber1()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getPhoneNumber2()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getEmail()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getBirthday()}</smail></td>";
                                                    if ($row->getGender() == 1)
                                                        echo "<td class=\"text-center\" ><small>Nam</smail></td>";
                                                    else
                                                        echo "<td class=\"text-center\" ><small>Nữ</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getSchool()}</smail></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getClass()}</smail></td>";
                                                    echo "<td class=\"text-center\"><small><a href = sentMailPage.php?UserId={$row->getUserId()}&UserName={$row->getUserName()}({$row->getEmail()})>send</a></small></td>";
                                                    echo '</tr>';
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->

                        <!-- /.content -->
                        <!--</div> /.content-wrapper 
            
                        <!-- Main Footer -->
                        <div id="popupBoxOnePosition">
                            <div class="popupBoxWrapper">
                                <div class="popupBoxContent">
                                    <div class="form-group has-feedback">                        
                                        <input type="text" class="form-control" placeholder="Choose User" name ="userList" id ="search_user">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>   
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6"></div>
                                            <button  class="btn btn-sm col-md-3 btn-success" name="addUser" >Add users</button>
                                            <div class="col-sm-1"></div>
                                            <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');" class="bg-blue btn btn-sm col-md-2 right"><fi class="fa fa-close"></fi>Close</a>    
                                        </div><!-- /.col -->
                                    </div>


                                </div>
                            </div>
                        </div>                       
                    </form>

                </section>
            </div>
            <?php include 'includeFooter.php'; ?>
        </div>  <!-- /.content -->
    </body>
    <script type="text/javascript">
        function toggle_visibility(id) {
            console.log('Click');
            var e = document.getElementById(id);
            var e1 = document.getElementById("search_user1");

            console.log(e1);
            if (e.style.display == 'block') {
                e.style.display = 'none';
                e1.style.display = 'block';
            }
            else {
                e.style.display = 'block';
                e1.style.display = 'none';
            }
        }

    </script>
    <style type="text/css">
        #popupBoxOnePosition{
            top: 0; left: 0; position: fixed; width: 100%; height: 120%;
            background-color: rgba(0,0,0,0.7); display: none;
        }
        .popupBoxWrapper{
            width: 500px; margin: 50px auto; text-align: center;
        }
        .popupBoxContent{
            background-color: #FFF; padding: 15px;
            border-radius: 10px;
            margin-top: 100px;
        }
    </style>
</html>
