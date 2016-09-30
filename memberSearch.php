<!DOCTYPE html>

<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoComments.php';
require_once '/models/comments.php';
require_once '/dao/daoMembers.php';
require_once '/models/members.php';
require_once '/models/membersSearchUserGroup.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$res = getUserById($_SESSION['user_id']);
if (isset($_GET['FacebookProfileId'])) {
    $listMembers = (array) searchMembersByFacebookProfileIdInAllGroup($_GET['FacebookProfileId']);
}else {
    header("Location: homePage.php");
    return;
}
$listInbox = getInboxIdUseStatus($_SESSION['user_id']);

?>

<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome - <?php echo $res->getUserName(); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include 'includeCss.php'; ?>
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script>
            $(function () {
                $("#datetimepicker-from-date").datepicker();
            });
            $(function () {
                $("#datetimepicker-to-date").datepicker();
            });
            $(document).ready(function () {
                $('#example').DataTable();
            });
        </script>

        <script src="dist/js/app.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
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
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
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
                        Members Manager
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Member Information</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <form id="form_id"  method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class= "col-md-12" style="padding-bottom: 20px;">
                                <a class="col-md-1 btn btn-sm bg-blue" href = "homePage.php"><i class="fa fa-backward "></i> Back</a>
                            </div> <!-- col -->
                            <div class="col-md-12">
                                <div class="box table-responsive">
                                    <div class="box-header">
                                        <h3 class="box-title">Members in Group</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body ">
                                        <table name= "data" id="example1" class="table table-bordered text-sm table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" >No.</th>
                                                    <th class="text-center" >Member Name</th>
                                                    <th class="text-center" >Administrator</th>
                                                    <th class="text-center" >Real name</th>
                                                    <th class="text-center" >Current Address</th>
                                                    <th class="text-center" >Home Address</th>
                                                    <th class="text-center" >Date of birth</th>
                                                    <th class="text-center" >Phone</th>
                                                    <th class="text-center" >Home phone</th>
                                                    <th class="text-center" >Email</th>
                                                    <th class="text-center" >Gender</th>
                                                    <th class="text-center" >Class</th>
                                                    <th class="text-center" >School</th>
                                                    <th class="text-center" >Facebook link</th>
                                                    
                                                    <th class="text-center" >User name manager</th>
                                                    <th class="text-center" >Full name manager</th>
                                                    <th class="text-center" >Phone number manager</th>
                                                    <th class="text-center" >Facebook group of member</th>
                                                    
                                                    <th class="text-center" >Create time</th>
                                                    <th class="text-center" >Update time</th>
                                                    
                                                    
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listMembers);
                                                $row = new MembersSearchUserGroup();
                                                $i = 1;
                                                foreach ($listMembers as $row) {
                                                    echo '<tr>';
                                                    echo "<td class=\"text-center\">{$i}</td>";
                                                    echo "<td class=\"text-left\"><a href=https://www.facebook.com/{$row->getFacebookIdMember()}>{$row->getName()}</a></td>";
                                                    if ($row->getAdministrator() == 1)
                                                        echo "<td class=\"text-center\">true</td>";
                                                    else
                                                        echo "<td class=\"text-center\">false</td>";
                                                    echo "<td class=\"text-center\">{$row->getRealName()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getAddress1()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getAddress2()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getBirthday()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getPhoneNumber1()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getPhoneNumber2()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getEmail()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getGender()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getClass()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getSchool()}</td>";
                                                    echo "<td class=\"text-center\"><a href={$row->getFacebookLink()}>{$row->getFacebookLink()}</a></td>";
                                                    
                                                    echo "<td class=\"text-center\">{$row->getUsernameManager()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getFullnameManager()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getPhoneNumberManager()}</td>";
                                                    echo "<td class=\"text-center\"><a href=https://www.facebook.com/{$row->getIdGroupFacebook()}>{$row->getIdGroupFacebook()}</td>";
                                                    
                                                    echo "<td class=\"text-center\">{$row->getCreateTime()}</td>";
                                                    echo "<td class=\"text-center\">{$row->getUpdateTime()}</td>";
                                                    
                                                    echo '</tr>';
                                                    $i++;
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->  
                            </div><!-- /.col -->   

                        </div><!-- /.row -->

                        <div class="row">
                            <div class="padding-6 col-md-12 text-center ">
                            </div>                           
                        </div>

                        <div class="row">
                            <div class="col-md-12 text-center">
                                

                            </div>                           
                        </div>
                    </form>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper 

            <!-- Main Footer -->
            <?php include 'includeFooter.php'; ?>
            <script type="text/javascript">

                var _gaq = _gaq || [];
                _gaq.push(['_setAccount', 'UA-38304687-1']);
                _gaq.push(['_trackPageview']);

                (function () {
                    var ga = document.createElement('script');
                    ga.type = 'text/javascript';
                    ga.async = true;
                    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(ga, s);
                })();

            </script>
        </div>
    </body>
</html>
