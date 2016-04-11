<?php
session_start();
require_once __DIR__ . '/host.php';
require_once $ROOT . '/dao/daoUsers.php';
require_once $ROOT . '/models/users.php';
require_once $ROOT . '/models/inbox.php';
require_once $ROOT . '/dao/daoInbox.php';
require_once $ROOT . '/dao/daoGroups.php';
require_once $ROOT . '/models/groups.php';
require_once $ROOT . '/dao/daoUsers.php';
require_once $ROOT . '/dao/daoRoles.php';
require_once $ROOT . '/models/users.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$res = getUserById($_SESSION['user_id']);
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
$current = $_GET['pageNumInbox'] == null ? 1 : $_GET['pageNumInbox'];
$start = ($current - 1) * 10 + 1;
$listInbox = (array) getListInbox2($_SESSION['user_id'], ($start), 10);
$totalRecord = getListInboxSize($_SESSION['user_id']);
$numPage = round($totalRecord / 10);
try {
    $_SESSION['pageNumInbox'] = $current;
} catch (Exception $ex) {
    
}
if (isset($_POST['deleteGroup'])) {
    $posted = array_unique($_POST['checkbox_name']);
    foreach ($posted as $value) {
        echo $value . '</br>';
        $res = deleteGroupsUseGroupId($value);
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
        <script>
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

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="homePage.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><i class="fa fa-home"></i><b> Admin</b></span>
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
                                    <span class="hidden-xs"> <?php echo $res->getFullName(); ?>&nbsp;&nbsp; </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                        <p>
                                            Hi' <?php echo $res->getFullName(); ?>&nbsp;&nbsp; 
                                            <small>Member since <?php echo $res->getCreateTime(); ?></small>
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
                            <!-- Control Sidebar Toggle Button -->
                            <li>
                                <div class="col-sm-2"></div>
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
                        Mailbox
                        <small><?php echo $totalRecord ?> new messages</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Inbox</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class= "col-md-12 text-center " style="padding-bottom: 20px; padding-left: 10px; margin-left: 37px;">
                    </div>
                    <div class="row">
                        <form id="form_id" name="myform" action="approvedInbox.php" method="POST">
                            <div class= "col-md-12" style="padding-top: 10px;padding-bottom: 10px;">
                                <div class= "col-md-3" >
                                    <a class="btn-sm btn bg-blue" href = "homePage.php"><i class="fa fa-backward"></i> Back</a>
                                </div>
                                <?php if (checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                                    <div class= "col-md-3 " >
                                        <button type="button"class=" btn-sm btn bg-blue" name="approve"><i class="fa fa-upload"></i> Approve</button>
                                    </div>
                                <?php } ?>                              
                                <?php if (checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                                    <div class= "col-md-3" >
                                        <button  type="button" name="deleteGroup" class="btn btn-sm bg-red-active"><i class="fa fa-trash"></i> Delete Message</button>
                                    </div>
                                <?php } ?>

                                <div class= "col-md-3 col-sm-3 pull-right">
                                    <a class="btn btn-sm bg-blue " href = "sentMailPage.php"><i class="fa fa-envelope-o"></i> Compose New Message</a>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box table-responsive">
                                    <div class="box-header">
                                        <h3 class="box-title">Inbox</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <!--                                        <a href="#" onClick="select_all('checkbox_name', '1');">Check All</a> | <a href="#" onClick="select_all('checkbox_name', '0');">Uncheck All</a>-->
                                        <table id="example1" class="table table-bordered table-striped text-center text-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>                    
                                                    <th><input type="checkbox" id="selectall"/></th>
                                                    <th>From</th>
                                                    <th>Subject</th>
                                                    <th>Content</th>
                                                    <th>Sent Date</th>  
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listInbox);
                                                $row = new Inbox();
                                                $i = 0;
                                                foreach ($listInbox as $row) {
                                                    $i++;
                                                    echo '<tr>';
                                                    echo "<td><input type=\"checkbox\" class =\"cbox\" name=\"checkbox_name[]\" value=\"{$row->getInboxId()}\" /></td>";
//                                                    echo "<td>{$i}</td>";
                                                    echo "<td>" . getNameUserUseUserId($row->getFromUserId()) . "</td>";
                                                    echo "<td>{$row->getSubject()}</td>";
                                                    echo "<td>{$row->getContent()}</td>";
                                                    echo "<td>{$row->getSentDate()}</td>";
                                                    if ($row->getStatus() == 1)
                                                        echo "<td><font color=\"#ff0000\">Unapproved</font></td>";
                                                    else
                                                        echo "<td>Approved</td>";

                                                    echo '</tr>';
//      
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
                                        echo "<li><a href =feedView.php?facebookGroupId={$_GET['facebookGroupId']}&groupId={$_GET['groupId']}&pageNum=$ncurrent>&laquo;</a></li>";
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
                                            echo "<li class = \"active\"><a href=feedView.php?facebookGroupId={$_GET['facebookGroupId']}&groupId={$_GET['groupId']}&pageNum=$i>$i</a></li>";
                                        else
                                            echo "<li><a href =feedView.php?facebookGroupId={$_GET['facebookGroupId']}&groupId={$_GET['groupId']}&pageNum={$i}>$i</a></li>";
//                                            <li <% if (iPage == i){ %>  class = "active"  <%} %>><button  type="submit" value="<%=i %>" name="page"><%=i %></button></li>
                                    }
                                    if ($iPage < $numPage) {
                                        $ncurrent = $iPage + 1;
                                        echo "<li><a href =feedView.php?facebookGroupId={$_GET['facebookGroupId']}&groupId={$_GET['groupId']}&pageNum={$ncurrent}>&raquo</a></li>";
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
