<!DOCTYPE html>

<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoComments.php';
require_once '/models/comments.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$res = getUserById($_SESSION['user_id']);
//$listInbox = getInboxIdUseStatus('1');
if ($_GET['feedId'] != null) {
    $current = $_GET['pageNumComment'] == null ? 1 : $_GET['pageNumComment'];
} else {
    return;
}

try {
    $_SESSION['id_feed_csdl'] = $_GET['feedId'];
} catch (Exception $ex) {
    
}
try {
    $_SESSION['feed_id'] = $_GET['facebookFeedId'];
} catch (Exception $ex) {
    
}
try {
    $_SESSION['pageNumComment'] = $current;
} catch (Exception $ex) {
    
}

$start = ($current - 1) * 10;
$listComments = (array) getCommentIdUseFeedId($_GET['feedId'], $start, 10);

$listInbox = getInboxIdUseStatus($_SESSION['user_id']);
$totalRecord = getTotalRecord1($_GET['feedId']);
$numPage = round($totalRecord / 10);
//$userRow=mysql_fetch_row($res);
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Welcome - <?php echo $res->getUserName(); ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <?php include 'includeCss.php'; ?>
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
                                            Hi'  <?php echo $res->getFullName(); ?>&nbsp;&nbsp; 
                                            <small>Member since  <?php echo $res->getCreateTime(); ?></small>
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
                                <a href="#" data-toggle="control-sidebar"></a>
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
                        Comments In Feed
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home </a></li>
                        <li><a href="#"><i class="fa fa-comment"></i> Comment Page </a></li>
                        <li class="active">Comment</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                    <!-- Your Page Content Here -->
                    <div class= "col-md-12" style="padding-bottom: 20px; padding-left: 10px;">
                        <?php
                        $backLink = "feedView.php?facebookGroupId=" . $_SESSION['group_id'] . "&groupId=" . $_SESSION['id_group_csdl'] . "&pageNum=" . $_SESSION['pageNum'];
                        ?>
                        <a class="left control-button text-center btn btn-sm bg-blue" href = "<?php echo $backLink; ?>"><i class="fa fa-backward"></i> Back</a>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box table-responsive">
                                <div class="box-header">
                                    <h3 class="box-title">Comments in Feed</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body ">
                                    <table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Writer</th>
                                                <th class="text-center">Content</th>
                                                <th class="text-center">Time create</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            //echo '---'.round($numPage);
                                            $size = sizeof($listComments);
                                            $row = new Comments();
                                            $i = $start+1;
                                            foreach ($listComments as $row) {
                                                echo '<tr>';
                                                echo "<td class=\"text-center\" >{$i}</td>";
                                                echo "<td class=\"text-center\" ><a href=https://www.facebook.com/{$row->getFacebookUserIdComment()}>{$row->getFacebookUserIdComment()}</a></td>";
                                                echo "<td class=\"text-left\"><a href=https://www.facebook.com/{$row->getFacebookIdComment()}>{$row->getMessage()}</a></td>";
                                                echo "<td class=\"text-center\">{$row->getCreateCommentTime()}</td>";
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
                        <div class="padding-6 col-md-12 text-center">
                            <ul class="pagination">
                                <div class="row">
                                    <div class="padding-2 col-md-12 text-center">
                                        <ul class="pagination">
                                            <?php
                                            if ($numPage != null && $numPage != 1) {
                                                $iPage = $current;
                                                if ($iPage > 1) {
                                                    $ncurrent = $current - 1;
                                                    echo "<li><a href =commentList.php?facebookFeedId={$_GET['facebookFeedId']}&feedId={$_GET['feedId']}&pageNumComment=$ncurrent>&laquo;</a></li>";
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
                                                        echo "<li class = \"active\"><a href=commentList.php?facebookFeedId={$_GET['facebookFeedId']}&feedId={$_GET['feedId']}&pageNumComment=$i>$i</a></li>";
                                                    else
                                                        echo "<li><a href =commentList.php?facebookFeedId={$_GET['facebookFeedId']}&feedId={$_GET['feedId']}&pageNumComment={$i}>$i</a></li>";
//                                            <li <% if (iPage == i){ %>  class = "active"  <%} %>><button  type="submit" value="<%=i %>" name="page"><%=i %></button></li>
                                                }
                                                if ($iPage < $numPage) {
                                                    $ncurrent = $iPage + 1;
                                                    echo "<li><a href =commentList.php?facebookFeedId={$_GET['facebookFeedId']}&feedId={$_GET['feedId']}&pageNumComment={$ncurrent}>&raquo</a></li>";
                                                }
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </div>

                            </ul></div>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php include 'includeFooter.php'; ?>
        </div>

    </body>
</html>
