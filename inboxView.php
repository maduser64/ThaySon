<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoGroups.php';
require_once '/models/groups.php';
require_once '/dao/daoUsers.php';
require_once '/dao/daoRoles.php';
require_once '/models/users.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$userNameLogin = getUserById($_SESSION['user_id']);
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
$current = $_GET['pageNumInbox'] == null ? 1 : $_GET['pageNumInbox'];
$start = ($current - 1) * 10+1;
$listInbox = (array) getListInbox2($_SESSION['user_id'], ($start-1), 10);
$totalRecord = getListInboxSize($_SESSION['user_id']);
$numPage = round($totalRecord / 10 + 0.5);
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
        <?php include 'includeCss.php'; ?>
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
            <?php include 'includeTab.php';?>
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
                    <div class="row">
                        <form id="form_id" name="myform" action="approvedInbox.php" method="POST">
<!--                            <div class="row">-->
                                <div class= "col-md-12" style="padding-bottom: 10px;">
                                    <div class= "left" style="display:inline">
                                        <a class="left text-center btn btn-sm btn-file bg-blue" href = "homePage.php"><i class="fa fa-backward"></i> Back</a>
                                    </div>
                                    <div class= "center" style="margin-left: 10px; display:inline">
                                        <a class="left text-center btn btn-sm btn-file bg-blue" href = "sentMailPage.php"><i class="fa fa-envelope-o"></i> New</a>
                                    </div>
                                    <div class= "center" style="margin-left: 10px;display:inline">
                                        <button type="button"class="text-center btn btn-sm btn-file bg-blue" name="approve"><i class="fa fa-upload"></i> Approve</button>
                                    </div>
                                    <div class= "right" style="margin-left: 10px;display:inline">
                                        <button  type="button" name="deleteGroup" class="text-center btn btn-sm btn-file bg-red-active"><i class="fa fa-trash"></i> Delete</button>
                                    </div>
                                </div>
                            <!--</div>-->
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
                                if ($numPage != null && $numPage > 1) {
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
