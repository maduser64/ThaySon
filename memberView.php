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

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$userNameLogin = getUserById($_SESSION['user_id']);
if (isset($_GET['groupId'])) {
    $listMembers = (array) getListMembersUsingGroupId($_GET['groupId']);
}else {
    header("Location: homePage.php");
    return;
}
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);

?>

<html>
    <head>
        <?php include 'includeCss.php'; ?>
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        
        <!--  - alert -->
        <link rel="stylesheet" href="bootstrap/css/sweetalert.css"/>
        <script src="bootstrap/js/sweetalert.min.js"/>
        <!-- <script src="bootstrap/js/sweetalert2.min.js"/>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/sweetalert2.css"/>-->
        <script src="mailBox/js/jquery-1.9.1.js"></script>
        
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
    <?php
//    if (isset($_POST["update"])) {
//
//        $iclass = $_POST['iclass'];
//        $ifullname = $_POST['irealname'];
//        $iaddress1 = $_POST['iaddress1'];
//        $iaddress2 = $_POST['iaddress2'];
//        $iphone1 = $_POST['iphone1'];
//        $iphone2 = $_POST['iphone2'];
//        $iemail = $_POST['iemail'];
//        $ischool = $_POST['ischool'];
//        $size = sizeof($listMembers);
//        $result = 'false';
//        for ($i = 0; $i < $size; $i++) {
////            echo $listMembers[$i]->getMemberId() . '---' . $iclass[$i] . '---' . $ifullname[$i] . '--' . $iphone[$i] . '--' . $iaddress[$i] . '--' . $iemail[$i];
//            $result = updateInfor($listMembers[$i]->getMemberId(), 
//              $iclass[$i], $ifullname[$i], $iphone1[$i], $iphone2[$i], 
//              $iaddress1[$i], $iaddress2[$i], $iemail[$i], $ischool[$i]);
//        }
////        echo '' . "---------------------------------------" + $result;
//        if (strcmp($result, 'true') == 0) {
//            $update = 0;
//        } else {
//
//            echo '<script> showAlertFalse(); </script>';
//            //  echo 'Strings do not match.';
//        }
//    }
   
    ?>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
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
                            <div class= "col-md-12" style="padding-bottom: 10px;">
                                <a class="left text-center btn btn-sm btn-file bg-blue" href = "subGroup.php"><i class="fa fa-backward "></i> Back</a>
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
                                                    <th class="text-center" >Create time</th>
                                                    <th class="text-center" >Update time</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listMembers);
                                                $row = new Members();
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
                                                    echo "<td class=\"text-center\">{$row->getFacebookLink()}</td>";
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
                                <?php
                                echo "<a class=\"btn  bg-blue\" href=memberUpdate.php?groupId={$_GET['groupId']}><i class=\"fa fa-pencil-square-o style=\"margin-right: 5px; \"></i> Update / View Detail</a>";
                                ?>

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
