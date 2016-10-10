<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoGroups.php';
require_once '/dao/daoGroupUser.php';
require_once '/models/groupuser.php';
require_once '/dao/daoRoles.php';
require_once '/models/groups.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
$userNameLogin = getUserById($_SESSION['user_id']);
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);

$roleAdmin = checkRoleAdminUsingUserId($_SESSION['user_id']);
$roleQuanTri = checkRoleQuanTri($_SESSION['user_id']);
$nameSearchGroup ='';
if ($roleAdmin || $roleQuanTri) {
    if (isset($_POST['GroupUserName']) && isset($_POST['searchGroup'])) {
        $nameSearchGroup = $_POST['GroupUserName'];
        $listGroup = (array) getListGroupUserUsingUserIdAndName($_SESSION['user_id'], $nameSearchGroup);
    } else {
        $listGroup = (array) getListGroupUserUsingUserId($_SESSION['user_id']);
    }
} else if (checkRoleQLNhom($_SESSION['user_id']) || checkRoleTV($_SESSION['user_id'])) {
    header("Location: subGroup.php");
} else {
    header("Location: waiter.php");
}

//echo '---'.$listInbox;
//btn-create
if (isset($_POST['create'])) {
    //echo'----------------------------------------------';
    $userid = $_SESSION['user_id'];
    $groupName = $_POST['gname'];
    $gdes = $_POST['gdes'];
    $groupuser = new GroupUser();
    $groupuser->setName($groupName);
    $groupuser->setDescription($gdes);
    $groupuser->setUserId($userid);
    createGroupUser($groupuser);
    $backLink = "Location: homePage.php";
    exit(header($backLink));
}
if (isset($_POST['deleteGroup'])) {
    $posted = array_unique($_POST['checkbox_name']);
    foreach ($posted as $value) {
        echo $value . '</br>';
        $res = deleteGroupUserUseGroupUserId($value);
    }
    if ($res == 'Error') {
        echo '' . "<script> alert(\"Lỗi\");</script>";
    } else
        echo '' . "<script> alert(\"TC\");</script>";
    //echo '---------------------------------------------------'.$res;
    $backLink = "Location: homePage.php";
    exit(header($backLink));
}
?>
<html>
    <head>
        
        <?php include 'includeCss.php'; ?>
        
        <script>
            jQuery(document).ready(function ($) {
                $('#selectall').click(function (event) {  //on click 
                    if (this.checked) { // check select status
                        $('.cbox').each(function () { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                    } else {
                        $('.cbox').each(function () { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                        });
                    }
                });

            });
        </script>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <?php include 'includeTab.php'; ?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Groups Users Manager
<!--                        <small>Optional description</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Group Users Information</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <form method="post" id="myForm" > 
                        <?php
                        if ($roleAdmin || $roleQuanTri) {
                            ?>
                        <div class="row">
                            <div class="col-md-12" style="padding-bottom: 10px;">
                                <div class= "left" style="display:inline" >
                                    <a class="left text-center btn btn-sm btn-file bg-blue" href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');"><i class="fa fa-plus-circle"></i> Add Group</a>
                                </div>                                
                                <div class= "center" style="display:inline;margin-left: 10px;" style="padding-left: 20px;">
                                    <button class="text-center btn btn-sm btn-file bg-red" type="submit" name="deleteGroup"><i class="fa fa-trash"></i> Delete Group</button>
                                </div>
                            </div>
                        </div>    
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-4" style="padding-bottom: 10px;">
                                <div class="input-group">
                                    <input type="text" name="GroupUserName"  class="form-control" placeholder="Group Name" value="<?php echo $nameSearchGroup?>"/>
                                    <div class="input-group-btn">
                                        <button type="submit" name="searchGroup" class="text-center btn btn-sm btn-file bg-blue"><i class="fa fa-search"></i> Search Group User</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box table-responsive ">
                                    <div class="box-header">
                                        <h3 class="box-title">Groups</h3>
                                    </div><!-- /.box-header -->
                                    <div class="panel-body">
                                        <input type="hidden" name="param" />

                                        <table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><input type="checkbox" id ="selectall"/></th>
                                                    <!--<th class="text-center"> <small>No.</small></th>-->
                                                    <th class="text-center"><small>Group Name</small></th>
                                                    <th class="text-center"><small>Description</small></th>
                                                    <!--<th class="text-center"><small>Privacy</small></th>-->
                                                    <th class="text-center"><small>Add/Edit member</small></th>
        <!--                                                    <th class="text-center"><small></small></th>-->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listGroup);
                                                $row = new GroupUser();
                                                $i = 0;
                                                foreach ($listGroup as $row) {
                                                    echo '<tr>';
                                                    echo "<td class =\"text-center\"><input type=\"checkbox\" class =\"cbox\" name=\"checkbox_name[]\" value=\"{$row->getGroupUserId()}\" /></td>";
                                                    $i++;

//                                                    echo "<td class=\"text-center\" ><small>{$i}</smail></td>";
                                                    echo "<td class=\"text-left\"><small>{$row->getName()}</small></td>";
                                                    echo "<td class=\"text-center\" ><small>{$row->getDescription()}</smail></td>";
                                                    echo "<td class=\"text-center\"><small><a href = viewUserInGroupUser.php?GroupUserId={$row->getGroupUserId()}>view</a></small></td>";
                                                    echo '</tr>';
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                        <div id="popupBoxOnePosition">
                            <div class="popupBoxWrapper">
                                <div class="popupBoxContent">

                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Group Name" name ="gname">
                                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                                    </div>   
                                    <div class="form-group has-feedback">
                                        <input type="text" class="form-control" placeholder="Mô tả" name ="gdes">

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="col-md-6"></div>
                                            <button type="submit" class="btn btn-sm col-md-3 btn-success" name="create" onclick="toggle_visibility('popupBoxOnePosition');">Create</button>
                                            <div class="col-sm-1"></div>
                                            <a href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');" class="bg-blue btn btn-sm col-md-2 right"><fi class="fa fa-close"></fi>Close</a>    
                                        </div><!-- /.col -->
                                    </div>


                                </div>
                            </div>
                        </div></form>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php include 'includeFooter.php'; ?>
        </div>
    </body>
    <script type="text/javascript">
        function toggle_visibility(id) {
            //console.log('Click');
            var e = document.getElementById(id);
            var e1 = document.getElementById("search_form");
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
            width: 400px; margin: 50px auto; text-align: center;
        }
        .popupBoxContent{
            background-color: #FFF; padding: 15px;
            border-radius: 10px;
            margin-top: 100px;
        }
    </style>

</html>
