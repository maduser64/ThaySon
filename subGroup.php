<?php
session_start();
require_once __DIR__ . '/host.php';
require_once $ROOT . '/dao/daoUsers.php';
require_once $ROOT . '/models/users.php';
require_once $ROOT . '/models/inbox.php';
require_once $ROOT . '/dao/daoInbox.php';
require_once $ROOT . '/dao/daoGroups.php';
require_once $ROOT . '/models/groups.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$res = getUserById($_SESSION['user_id']);
$rule=FALSE;
$listInbox = getInboxIdUseStatus($_SESSION['user_id']);
if (checkRoleAdminUsingUserId($_SESSION['user_id'])||  checkRoleQLNhom($_SESSION['user_id'])) {
    $listGroup = getListGroupsbyUserId($_SESSION['user_id']);
    $rule=TRUE;
}
else if(checkRoleTV($_SESSION['user_id'])|| checkRoleQuanTri($_SESSION['user_id'])){
    $listGroup = getListGroupsbyUserId($_SESSION['user_id']);
    
}else {
    return;
}

//echo '---------------------'.  sizeof($listGroup);
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
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
        <link rel="stylesheet"
              href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
        <link rel="stylesheet"
              href="https://cdn.datatables.net/1.10.10/css/dataTables.bootstrap.min.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
            $(function () {
                $("#datetimepicker-from-date").datepicker();
            });
            $(function () {
                $("#datetimepicker-to-date").datepicker();
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
                <a href="homePage.php" class="logo">
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
                        Groups Facebooks Manager
<!--                        <small>Optional description</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Groups Facebooks Information</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class= "col-md-12 text-center " style="padding-bottom: 20px;">
                        <?php if(checkRoleAdminUsingUserId($_SESSION['user_id'])==true||  checkRoleQuanTri($_SESSION['user_id'])==true){ ?>
                        <a class="btn bg-blue col-md-1 btn-sm" href="homePage.php"><i class="fa fa-backward"></i>  Back </a> 
                        <?php } ?>    
                        <?php if ($rule==TRUE) { ?>                          
                            <div class="col-md-7"></div>
                            <form action="connectFbToCSDL/createGroup.php" method="post" class="form-horizontal col-md-4">                                                  
                                <div class="col-md-8 center-block">
                                    <input class="form-control"  type="text" name="groupfacebook_id" placeholder="Facebook Group Id">
                                </div>
                                <button class="btn bg-blue col-md-4 btn-sm" name="btn-createGroup"><i class="fa fa-plus-circle"></i> Add Group </button>                    
                            </form>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box table-responsive ">
                                <div class="box-header">
                                    <h3 class="box-title">Groups Facebooks Manager</h3>
                                </div><!-- /.box-header -->
                                
                                    <div class="box-body ">
                                        <table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"> <small>No.</small></th>
                                                    <th class="text-center"><small>Group Name</small></th>
                                                    <th class="text-center"><small>Owner</small></th>
                                                    <th class="text-center"><small>Privacy</small></th>
                                                    <th class="text-center"><small>Group Member</small></th>
                                                    <th class="text-center"><small>Posts</small></th>                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listGroup);
                                                $row = new Groups();
                                                $i = 0;
                                                foreach ($listGroup as $row) {
                                                    $i++;
                                                    echo '<tr>';
                                                    echo "<td class=\"text-center\" ><small>{$i}</smail></td>";
                                                    echo "<td class=\"text-left\"><small><a href=https://www.facebook.com/{$row->getFacebookGroupId()}>{$row->getName()}</a></small></td>";
                                                    $ow=$row->getOwner();
                                                    if($ow==NULL&&$ow==''){
                                                        echo "<td class=\"text-center\"><small><a href=https://www.facebook.com/groups/{$row->getFacebookGroupId()}/admins>More users</a></small></td>";
                                                    }else 
                                                        echo "<td class=\"text-center\"><small><a href=https://www.facebook.com/{$row->getOwner()}>{$row->getOwner()}</a></small></td>";
                                                    echo "<td class=\"text-center\"><small>{$row->getPrivacy()}</small></td>";
                                                    echo "<td class=\"text-center\"><small><a href = memberView.php?facebookGroupId={$row->getFacebookGroupId()}&groupId={$row->getGroupId()}>view</a></small></td>";
                                                    echo "<td class=\"text-center\"><small><a href = feedView.php?facebookGroupId={$row->getFacebookGroupId()}&groupId={$row->getGroupId()}&pageNum=1>view</a></small></td>";
                                                    echo '</tr>';
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div><!-- /.box-body -->
                                
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
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
</html>
