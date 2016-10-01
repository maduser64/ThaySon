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
$userNameLogin = getUserById($_SESSION['user_id']);

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
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
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
                            <div class="col-md-4 col-sm-8 center">
                                <button type="submit" class=" col-md-6 btn bg-blue" value="Update feeds"/>
                                <i class="fa fa-refresh"></i> Refresh Feeds</buton> 
                            </div>
                        </form>
                    </div>

                    <div class="row">
                        <form id="form_id" name="myform" action="processReport.php" method="POST">
                            <div class= "col-md-12" style="padding-bottom: 10px;">
                                <div class= "left" style="display:inline" >
                                    <a class="left text-center btn btn-sm btn-file bg-blue" href = "subGroup.php"><i class="fa fa-backward"></i> Back</a>
                                </div>
                                <div class= "center" style="display:inline;margin-left: 10px;" >
                                    <button type="submit" class="btn-sm btn bg-blue" name="approve"><i class="fa fa-compass"></i> Approve</button>
                                    <!--<input type="submit" name="approve" class="control-button text-center btn btn-sm bg-blue" value="Approve"/>-->
                                </div>
                                <div class= "right" style="display:inline;margin-left: 10px;" >
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
