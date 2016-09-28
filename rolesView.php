<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/models/roles.php';
require_once '/dao/daoRoles.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
//if (checkRoleAdminUsingUserId($_SESSION['user_id']) == false)
//    return;

$res = getFullNameById($_SESSION['user_id']);
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
$current = $_GET['pageNumRole'] == null ? 1 : $_GET['pageNumRole'];
$start = ($current - 1) * 10 + 1;
$listInbox = (array) getListUsersRole(($start - 1), 10);
$totalRecord = getListUsersCount();
$numPage = round($totalRecord / 10);
$listRole = getListRoles();
try {
    $_SESSION['pageNumRole'] = $current;
} catch (Exception $ex) {
    
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome - <?php echo $res; ?></title>
         <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="bootstrap/css/bootstrap-datetimepicker.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/skin-blue.min.css">
        <link rel="stylesheet"
              href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet"
              href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
        <script type="text/javascript">
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

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="homePage.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg "><i class="fa fa-home"></i><b> Home Page</b></span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
<!--                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>-->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li class="dropdown messages-menu">
                                <!-- Menu toggle button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-envelope-o"></i>
                                    <span class="label label-success"><?php echo '' . ($numInbox == null ? 0 : $numInbox); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header">You have <?php echo '' . ($numInbox == null ? 0 : $numInbox); ?> messages</li>

                                    <li class="footer"><a href="inboxView.php?pageNumInbox=1">See All Messages</a></li>
                                </ul>
                            </li><!-- /.messages-menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs"> <?php echo $res; ?>&nbsp;&nbsp; </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            Hi' <?php echo $res; ?>&nbsp;&nbsp; 
                                            <small>Member since Nov. 2012</small>
                                        </p>
                                    </li>

                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="#" class="btn btn-default btn-flat">Profile</a>
                                        </div>
                                        <div class="pull-right">               
                                            <a href="logout.php?logout" class="btn btn-default btn-flat">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <?php include 'includeTab.php';?>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->


                <section class="content-header">
                    <h1>
                        Roles
                        <small>Select roles for user:</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Roles</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">                              
                    <div class="row">
                        <form id="form_id" name="myform" action="processRoles.php" method="POST">
                            <div class="col-md-12"  style="padding-bottom: 10px;">
                                <div class= "col-md-2" style="padding-left: 10px;">
                                    <a class="left text-center btn btn-sm bg-blue" href = "homePage.php"><fi class="fa fa-backward"></fi>  Back</a>
                                </div>                                
                                <div class= "col-md-2 text-left ">
                                    <button type="submit" name="deleteUser" class="text-center btn btn-sm btn-file bg-maroon" >Delete User</button>
                                </div>
                                <div class= "col-md-8 right ">
                                    <button type="submit" name="capQuyen1" class="text-center btn btn-sm btn-danger" >Save changes</button>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Roles</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-striped text-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><input type="checkbox" id ="selectall"/></th>                                                 
                                                    <th class="text-center">Full name</th>
                                                    <th class="text-center">User name</th>
                                                    <th class="text-center">Roles</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listInbox);
                                                $row = new Users();
                                                $i = 0;
                                                foreach ($listInbox as $row) {
                                                    $i++;
                                                    echo '<tr>';
                                                    echo "<td class =\"text-center\"><input type=\"checkbox\" class =\"cbox\" name=\"checkbox_name[]\" value=\"{$row->getUserId()}\" /></td>";
                                                    // echo "<td><input type=\"checkbox\" name=\"checkbox_name[]\" value=\"{$row->getUserId()}\" /></td>";
                                                    // echo "<td>{$i}</td>";
                                                    echo "<td>" . $row->getFullName() . "</td>";
                                                    echo "<td>{$row->getUserName()}</td>";
                                                    echo "<td align=\"left\">";
                                                    for ($j = 0; $j < sizeof($listRole); $j++) {
                                                        $check = checkRole($row->getUserId(), $listRole[$j]->getRoleId());
                                                        if ($check) {
                                                            echo " &nbsp;<input type=\"checkbox\" name=\"{$row->getUserId()}[]\" value=\"{$listRole[$j]->getRoleId()}\""
                                                            . "checked = \"true\"/> &nbsp; &nbsp;"
                                                            . $listRole[$j]->getRoleName() . "<br>";
                                                        } else {
                                                            echo " &nbsp;<input type=\"checkbox\" name=\"{$row->getUserId()}[]\" value=\"{$listRole[$j]->getRoleId()}\""
                                                            . "/> &nbsp; &nbsp;"
                                                            . $listRole[$j]->getRoleName() . "<br>";
                                                        }
                                                    }
                                                    //echo "<td> <a class=\"left text-center btn btn-sm bg-blue\">Save</a></td>";
                                                    echo '</tr>';
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </form>
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="padding-2 col-md-12 text-center">
                            <ul class="pagination">
                                <?php
                                if ($numPage != null && $numPage != 1) {
                                    $iPage = $current;
                                    if ($iPage > 1) {
                                        $ncurrent = $current - 1;
                                        echo "<li><a href =rolesView.php?pageNumRole=$ncurrent>&laquo;</a></li>";
                                    }
                                    //$startPage, $endPage;
                                    $startPage = $iPage - 2;
                                    $endPage = $iPage + 2;
                                    if ($startPage < 1) {
                                        $endPage = $endPage - $startPage + 1;
                                        $startPage = 1;
                                    }
                                    if ($endPage > $numPage) {
                                        $endPage = $numPage;
                                    }
                                    for ($i = $startPage; $i <= $endPage; ++$i) {
                                        if ($iPage == $i)
                                            echo "<li class = \"active\"><a href=rolesView.php?pageNumRole=$i>$i</a></li>";
                                        else
                                            echo "<li><a href =rolesView.php?pageNumRole={$i}>$i</a></li>";
//                                            <li <% if (iPage == i){ %>  class = "active"  <%} %>><button  type="submit" value="<%=i %>" name="page"><%=i %></button></li>
                                    }
                                    if ($iPage < $numPage) {
                                        $ncurrent = $iPage + 1;
                                        echo "<li><a href =rolesView.php?pageNumRole={$ncurrent}>&raquo</a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
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

    </body>
</html>
