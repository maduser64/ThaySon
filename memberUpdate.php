<!DOCTYPE html>

<?php
session_start();
require_once __DIR__ . '/host.php';
require_once $ROOT . '/dao/daoUsers.php';
require_once $ROOT . '/models/users.php';
require_once $ROOT . '/models/inbox.php';
require_once $ROOT . '/dao/daoInbox.php';
require_once $ROOT . '/dao/daoComments.php';
require_once $ROOT . '/models/comments.php';
require_once $ROOT . '/dao/daoMembers.php';
require_once $ROOT . '/models/members.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$res = getUserById($_SESSION['user_id']);
if (isset($_GET['groupId'])) {
    $listMembers = (array) getListMembersUsingGroupId($_GET['groupId']);
} else {
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
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
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
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/bootstrap-waitingfor.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
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
    <?php

    function getFacebookIdProfile($profile_url) {
        $url = 'http://findmyfbid.com';
        $data = array('url' => $profile_url);

// use key 'http' even if you send the request to https://...
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($data),
            ),
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);

        function getData($data) {
            $dom = new DOMDocument;
            $dom->loadHTML($data);
            $divs = $dom->getElementsByTagName('code');

            foreach ($divs as $div) {
                return $div->nodeValue;
            }
        }
        return getData($result);
    }

    if (isset($_POST["update"])) {
        ?>
    <script>
        $('#myModal').on('shown.bs.modal', function () {
 
    var progress = setInterval(function() {
    var $bar = $('.bar');

    if ($bar.width()==500) {
      
        // complete
      
        clearInterval(progress);
        $('.progress').removeClass('active');
        $('#myModal').modal('hide');
        $bar.width(0);
        
    } else {
      
        // perform processing logic here
      
        $bar.width($bar.width()+50);
    }
    
    $bar.text($bar.width()/5 + "%");
	}, 800);
  
  
})
    </script>
        <?php
        $ifullname = $_POST['irealname'];
        $iaddress1 = $_POST['iaddress1'];
        $iaddress2 = $_POST['iaddress2'];
        $ibirthday = $_POST['ibirthday'];
        $iphone1 = $_POST['iphone1'];
        $iphone2 = $_POST['iphone2'];
        $iemail = $_POST['iemail'];
        $igender = $_POST['igender'];
        $iclass = $_POST['iclass'];
        $ischool = $_POST['ischool'];
        $ifacebooklink = $_POST['ifacebooklink'];

        $size = sizeof($listMembers);
        $row = new Members();
        $i = 0;
        foreach ($listMembers as $row) {

            $row->setRealName($_POST['irealname'][$i]);
            $row->setAddress1($iaddress1[$i]);
            $row->setAddress2($iaddress2[$i]);
            $row->setBirthday($ibirthday[$i]);
            $row->setPhoneNumber1($iphone1[$i]);
            $row->setPhoneNumber2($iphone2[$i]);
            $row->setEmail($iemail[$i]);
            $row->setGender($igender[$i]);
            $row->setClass($iclass[$i]);
            $row->setSchool($ischool[$i]);
            $row->setFacebookLink($ifacebooklink[$i]);
            $row->setFacebookProfileId(getFacebookIdProfile($ifacebooklink[$i]));
            $result = updateMembers($row);
            
            if ($result == false) {
                echo '<script> showAlertFalse(); </script>';
                break;
            }
            $i++;
        }
          ?>
    <script>
        myApp.hidePleaseWait();
    </script>
        <?php
    }
    ?>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel"><i class="fa fa-clock-o"></i> Please Wait</h4>
      </div>
      <div class="modal-body center-block">
        <p>Process....</p>
        <div class="progress">
          <div class="progress-bar bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
            
          </div>
        </div>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">
            <!-- Main Header -->
            <header class="main-header">
                <!-- Logo -->
                <a href="homePage.php" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>A</b>LT</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><i class="fa fa-home"></i> <b>Admin</b></span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->                  
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
                                <a class="col-md-1 btn btn-sm bg-blue" href = "subGroup.php"><i class="fa fa-backward "></i> Back</a>
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
    echo "<td class=\"text-center\"><input name = \"irealname[]\" type = \"text\" value = \"{$row->getRealName()}\"/></td>";
    echo'' . " <td class=\"text-left\" ><input name = \"iaddress1[]\" type = \"text\" value =\" {$row->getAddress1()}\"/></th>";
    echo'' . " <td class=\"text-left\" ><input name = \"iaddress2[]\" type = \"text\" value =\" {$row->getAddress2()} \"/></th>";
    echo "<td class=\"text-center\"><input name = \"ibirthday[]\" type = \"text\" value =\" {$row->getBirthday()} \"/></td>";
    echo'' . " <td class=\"text-left\" ><input name = \"iphone1[]\" type = \"text\" value =\" {$row->getPhoneNumber1()} \"/></th>";
    echo'' . " <td class=\"text-left\" ><input name = \"iphone2[]\" type = \"text\" value = \"{$row->getPhoneNumber2()}\"/></td>";
    echo'' . " <td class=\"text-left\" ><input name = \"iemail[]\" type = \"text\" value =\" {$row->getEmail()} \"/></th>";
    echo'' . " <td class=\"text-left\" ><input name = \"igender[]\" type = \"text\" value =\" {$row->getGender()} \"/></th>";
    echo'' . " <td class=\"text-left\" ><input name = \"iclass[]\" type = \"text\" value =\" {$row->getClass()}\"/></th>";
    echo'' . " <td class=\"text-left\" ><input name = \"ischool[]\" type = \"text\" value =\" {$row->getSchool()} \"/></th>";
    $link=trim($row->getFacebookLink());
    echo'' . " <td class=\"text-left\" ><input name = \"ifacebooklink[]\" type = \"text\" value =\"{$link}\"/></th>";

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
<button  class="col-md-1 center btn btn-primary" type="submit" name = "update"><i href="#myModal" class="fa fa-envelope-o fa-save" style="margin-right: 5px;"> </i>Save</button>";


                            </div>                           
                        </div>
                    </form>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper 

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="pull-right hidden-xs">
                    Anything you want
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2015 <a href="#">Company</a>.</strong> All rights reserved.
            </footer>
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
