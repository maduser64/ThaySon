<?php
session_start();
require_once __DIR__ . '/host.php';
require_once $ROOT . '/dao/daoUsers.php';
require_once $ROOT . '/models/users.php';
require_once $ROOT . '/models/inbox.php';
require_once $ROOT . '/dao/daoInbox.php';
require_once $ROOT . '/dao/daoGroups.php';
require_once $ROOT . '/dao/daoGroupUser.php';
require_once $ROOT . '/models/groupuser.php';
require_once $ROOT . '/dao/daoRoles.php';
require_once $ROOT . '/models/groups.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}
$res = getUserById($_SESSION['user_id']);
$listInbox = getInboxIdUseStatus($_SESSION['user_id']);

if (checkRoleAdminUsingUserId($_SESSION['user_id']) || checkRoleQuanTri($_SESSION['user_id'])) {
    $listGroup = (array) getListGroupUserUsingUserId($_SESSION['user_id']);
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
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome - <?php echo $res->getUserName(); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap/css/sweetalert.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet"
              href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet"
              href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
            //$('#search-btn').click(function(event){
            function check() {
                // alert( 'Insert FB Id to Search');
                if (!$('#key').val())
                    alert('Insert FB Id to Search');
                else {
                    var keey = $('#key').val();
                    window.location.href = 'memberView.php?key='.concat(keey);
                }
                // $('search-btn').val();
            }
            // });

            //    
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
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="#" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg "><i class="fa fa-home"></i><b> Admin Page</b></span>
                </a>
                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success"><?php echo '' . ($listInbox == null ? 0 : $listInbox); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <?php echo '' . ($listInbox == null ? 0 : $listInbox); ?> messages</li>                                   
                                    <li class="footer"><a href="inboxView.php?pageNumInbox=1">See All Messages</a></li>
                                </ul>
                            </li><!-- /.messages-menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs"> <?php echo $res->getFullName(); ?>&nbsp;&nbsp; </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            Hi' <?php echo $res->getFullName(); ?>&nbsp;&nbsp; 
                                            <small>Member since <?php echo $res->getCreateTime(); ?>&nbsp;&nbsp; </small>
                                        </p>
                                    </li>

                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="profile.php" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">               
                                            <a href="logout.php?logout" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>

                                </ul>
                            </li>
                            <li>
                                <a href="#" data-toggle="control-sidebar"></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p> <?php echo $res->getFullName(); ?>&nbsp;&nbsp; </p>
                            <!-- Status -->
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                </section>
                <!-- /.sidebar -->
            </aside>
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
                        if (checkRoleAdminUsingUserId($_SESSION['user_id'])) {
                            ?>
                            <div class= "col-md-3 text-center " style="padding-bottom: 20px;">                      
                                <div class="form-group">                                 
                                    <!--<button class="btn bg-blue col-md-4 btn-sm" name="btn-createGroup"><i class="fa fa-plus-circle"></i> Add Group </button>-->
                                    <a class="btn bg-blue col-md-6 btn-sm" href="javascript:void(0)" onclick="toggle_visibility('popupBoxOnePosition');"><i class="fa fa-plus-circle"></i> Add Group</a>
                                </div>                     
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box table-responsive ">
                                    <div class="box-header">
                                        <h3 class="box-title">Groups</h3>
                                    </div><!-- /.box-header -->
                                    <div class="panel-body">
                                        <input type="hidden" name="param" />
                                        <div class="btn-group col-md-12" style="padding-bottom: 10px;">

                                            <div class= "btn col-md-1 text-left ">
                                                <button class="btn bg-blue btn-sm btn-danger" type="submit" name="deleteGroup">Delete</button>
                                            </div>
                                            <?php if (checkRoleQLNhom($_SESSION['user_id'])||checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                                                <div class= "btn col-md-1 text-left ">
                                                    <a class="btn bg-blue btn-sm " href="subGroup.php"> Manager group facebook</a>
                                                </div>
                                                <div class= "col-md-1"></div>
                                            <?php } ?>
                                            <?php if (checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                                                <div class= "btn col-md-1 text-left ">
                                                    <a class="btn bg-blue btn-sm " href="rolesView.php?pageNumRole=1"> Permission</a>
                                                </div>
                                                <div class= "btn col-md-2"></div>
                                                <div class="btn col-md-4">
                                                    <!-- search form -->

                                                    <div class="btn-group  col-md-12">
                                                        <input type="text" id="key" name="q" class="form col-md-8" placeholder="Search by FacebookID..." value=""/>
                                                        <span class="input-group-btn">
                                                            <a type="submit" name="" id="search-btn" class="form btn bg-blue col-md-4"
                                                               onclick="check()" ><i class="fa fa-search"></i></a>
                                                        </span>                                  
                                                    </div> <!-- input -->

                                                </div> 
                                            <?php } ?>
                                        </div>
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
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                    Anything you want
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
            </footer>
        </div>
    </body>
    <script type="text/javascript">
        function toggle_visibility(id) {
            console.log('Click');
            var e = document.getElementById(id);
            if (e.style.display == 'block')
                e.style.display = 'none';
            else
                e.style.display = 'block';
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
