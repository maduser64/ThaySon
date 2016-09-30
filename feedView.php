<!DOCTYPE html>

<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoFeeds.php';
require_once '/models/feeds.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$res = getUserById($_SESSION['user_id']);

if ($_GET['groupId'] != null) {
    $currentGroup = $_GET['groupId'];
    $current = $_GET['pageNum'] == null ? 1 : $_GET['pageNum'];
} else {
    header("Location: homePage.php");
    return;
}
try {
    $_SESSION['id_group_csdl'] = $_GET['groupId'];
} catch (Exception $ex) {
    
}
try {
    $_SESSION['group_id'] = $_GET['facebookGroupId'];
} catch (Exception $ex) {
    
}
try {
    $_SESSION['pageNum'] = $current;
} catch (Exception $ex) {
    
}
$start = ($current - 1) * 10;
$listFeeds = (array) getFeedIdUseGroupId($_GET['groupId'], $start, 10);
$listInbox = getInboxIdUseStatus($_SESSION['user_id']);
$totalRecord = getTotalRecord($_SESSION['user_id']);
$numPage = round($totalRecord / 10);
function getCurentWeekDates(){
   $date = new DateTime();
   $date->modify('+2 day');
   return $date->format('m-d-Y');
}
function getLastWeekDates(){
   $date = new DateTime('7 days ago');
   return $date->format('m-d-Y');
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome - <?php echo $res->getUserName(); ?></title>
        <link rel="shortcut icon" href="css/icon.ico" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include 'includeCss.php'; ?>
        <script src="plugins/jQueryUI/jquery-ui.js" type="text/javascript"></script>
        <script src="plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">      
        <script>
            $(function () {
                $("#datetimepicker-from-date").datepicker();
            });
            $(function () {
                $("#datetimepicker-to-date").datepicker();
            });
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
                        Posts In Group
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Post Detail</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Your Page Content Here -->

                    <div class= "col-md-12" style="padding-bottom: 20px;">
                        <form action="connectFbToCSDL/createFeed.php" method="POST" class="form-horizontal">
                            <div class="col-md-4 left">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">From Date </label>
                                    <div class="col-md-8">
                                        <div class='input-group date' id='datetimepicker-from-date' data-provide="datepicker" data-date-format="mm-dd-yyyy">
                                            <input type='text' class="form-control" name = "from-date" placeholder="Input start date" value="<?php echo getLastWeekDates();?>"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                            <div class="col-md-4 left">
                                <div class="form-group">
                                    <label class="col-md-4 control-label">To Date </label>
                                    <div class="col-md-8">
                                        <div class='input-group date' id='datetimepicker-to-date' data-provide="datepicker" data-date-format="mm-dd-yyyy">
                                            <input type='text' class="form-control" name = "to-date" placeholder="Input end date" value="<?php echo getCurentWeekDates(); ?>"/>
                                            <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4 left">
                                <button type="submit" class=" col-md-6  btn bg-blue" value="Update feeds"/>
                                <i class="fa fa-refresh"></i> Refresh Feeds</buton> 
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <form id="form_id" name="myform" action="processReport.php" method="POST">
                            <div class= "col-md-6" style="padding-top: 10px;padding-bottom: 10px;">
                                <div class= "col-md-2" style="padding-bottom: 20px; padding-left: 10px;">
                                    <a class="btn-sm btn bg-blue" href = "subGroup.php"><i class="fa fa-backward"></i> Back</a>
                                </div>
                                    <div class= "col-md-2 text-left ">
                                        <button type="submit" class="btn-sm btn bg-blue" name="approve"><i class="fa fa-compass"></i> Approve</button>
                                        <!--<input type="submit" name="approve" class="control-button text-center btn btn-sm bg-blue" value="Approve"/>-->
                                    </div>
                                
                                <div class= "col-md-2 text-left " >
                                    <button type="submit"class="left btn-sm btn bg-blue" name="report"><i class="fa fa-upload"></i> Report</button>
<!--                                    <input type="submit" name="report" class="control-button  btn  bg-blue" value="Report"/>-->
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box mailbox-messages table-responsive">
                                    <div class="box-header">
                                        <h3 class="box-title">Feeds in Group</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body table-bordered">
                                        <!--                                        <a href="#" onClick="select_all('checkbox_name', '1');">Check All</a> | <a href="#" onClick="select_all('checkbox_name', '0');">Uncheck All</a>-->
                                        <table id="example1" class="table table-bordered table-sm " cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><input type="checkbox" id ="selectall"/></th>
                                                    <th class="text-center">Writer Feed</th>
                                                    <th class="text-center"> Content</th>
                                                    <th class="text-center">Time create</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center"> View comments</th> 

                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                //echo '---'.round($numPage);
                                                $size = sizeof($listFeeds);
                                                $row = new Feeds();
                                                $i = $start+1;
                                                foreach ($listFeeds as $row) {
                                                    echo '<tr>';
                                                    echo "<td class =\"text-center\"><input type=\"checkbox\" class =\"cbox\" name=\"checkbox_name[]\" value=\"{$row->getFeedId()}\" /></td>";
//                                                    echo "<td>{$i}</td>";
                                                    echo "<td class =\"text-center\"><a href=https://www.facebook.com/{$row->getFacebookUserIdFeed()}>{$row->getFacebookUserIdFeed()}</a></td>";
//                                                echo "<td>{$row->getFacebookUserIdFeed()}</td>";
                                                    echo "<td class =\"text-left\"><a href=https://www.facebook.com/{$row->getFacebookIdFeed()}>{$row->getMessage()}</a></td>";
                                                    echo "<td class =\"text-center\">{$row->getCreateFeedTime()}</td>";
                                                    if ($row->getStatusId() == 1)
                                                        echo "<td class =\"text-center\"><font color=\"#ff0000\">Unapproved</font></td>";
                                                    else
                                                        echo "<td class =\"text-center\">Approved</td>";
                                                    echo "<td class =\"text-center\"><a href = commentList.php?facebookFeedId={$row->getFacebookIdFeed()}&feedId={$row->getFeedId()}&pageNumComment=1>View</a></td>";
                                                    echo '</tr>';
                                                    $i++;
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
            <?php include 'includeFooter.php'; ?>
    </body>
</html>
