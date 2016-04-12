<?php
session_start();
require_once __DIR__ . '/host.php';
require_once $ROOT . '/dao/daoUsers.php';
require_once $ROOT . '/models/users.php';
require_once $ROOT . '/models/inbox.php';
require_once $ROOT . '/dao/daoInbox.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$res = getUserById($_SESSION['user_id']);
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
// Get infor to send -
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
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <!--  - mail -->
        <link rel="stylesheet" href="mailBox/css/token-input.css">
        <!--        <link rel="stylesheet" href="mailBox/css/send_email.css">-->
        <link rel="stylesheet" href="mailBox/css/token-input-facebook.css">
        <script src="mailBox/js/jquery-1.9.1.js"></script>
        <script src="mailBox/js/jquery.tokeninput.js"></script>
        <script src="mailBox/js/send_email.js"></script>
        <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js" ></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"/>
        <!--  - alert -->
        <link rel="stylesheet" href="bootstrap/css/sweetalert.css"/>
        <script src="bootstrap/js/sweetalert.min.js"/>
        <script src="bootstrap/js/sweetalert2.min.js"/>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/sweetalert2.css"/>
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
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css"/>
    </head>
    <?php
    if (isset($_POST['send-action'])) {
        $fromUserId = $_SESSION['user_id'];
        $toAddress = mysql_real_escape_string($_POST['ToAddress']);
        $toGroup = mysql_real_escape_string($_POST['ToGroupAddress']);
        $subject = mysql_real_escape_string($_POST['Subject']);
        $content = $_POST['ContentMessage'];
        $toGroup = trim($toGroup);
        if (isset($toGroup) === true && $toGroup === '') {
            $result = insertWithMultiInbox($fromUserId, $toAddress, $subject, $content);
        }
        if (isset($toAddress) === true && $toAddress === '') {
            $result = insertWithMultiInbox2($fromUserId, $toGroup, $subject, $content);
        }
        //$result = insertWithMultiInbox($fromUserId, $toAddress, $subject, $content);
        //$result2 = insertWithMultiInbox2($fromUserId, $toGroup, $subject, $content);
        // echo '--------------------' . $toGroup;
        if (strcmp($result, 'true') == 0) {
            // echo 'Strings match.';
            echo '<script> alert("Your message has been sent!"); </script>';
        } else {
            echo '<script> alert("Can not send! Try again "); </script>';
            //  echo 'Strings do not match.';
        }
    } else if (isset($_POST['send-action-ex'])) {
        $fromUserId = $_SESSION['user_id'];
        $toAddress = mysql_real_escape_string($_GET['UserId']);
        //$toGroup = mysql_real_escape_string($_POST['ToGroupAddress']);
        $subject = mysql_real_escape_string($_POST['Subject']);
        $content = $_POST['ContentMessage'];
        $result = insertWithMultiInbox($fromUserId, $toAddress, $subject, $content);
        //$result2 = insertWithMultiInbox2($fromUserId, $toGroup, $subject, $content);
        // echo '--------------------' . $toGroup;
        if (strcmp($result, 'true') == 0) {
            // echo 'Strings match.';
            echo '<script> alert("Your message has been sent!"); </script>';
        } else {
            echo '<script> alert(' . '"' . $result . '"' . '); </script>';
        }
    }
    ?>
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
                    <!-- Sidebar Menu -->

                </section>
                <!-- /.sidebar -->
            </aside>
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Mailbox
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Mailbox</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <form method="post" class="row">
                        <div class="col-md-2">
                            <a href="inboxView.php?pageNumInbox=1" class="btn btn-primary btn-block margin-bottom"><i class="fa fa-backward"></i> Back to Inbox</a>             
                        </div><!-- /.col -->
                        <div class="col-md-9">
                            <div class="box box-primary table-responsive">
                                <div class="box-header with-border">
                                    <h3 class="box-title"> Compose New Message</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body" style="align-content: center">
                                    <?php
                                    if (isset($_GET['UserId'])) {
                                        $keyy = ($_GET['UserName']);
                                        ?>
                                        <div class="form-group">
    <!--                                        <input id="to_manuals" class="form-control" placeholder="To:">-->       
                                            <div><span>To users: </span></div>
                                            <input readonly="true" type="text" name="ToAddress1"  class="form-control" required value="<?php echo $keyy ?>"/>
                                        </div>
                                    <?php } else { ?>
                                        <div class="form-group">
    <!--                                        <input id="to_manuals" class="form-control" placeholder="To:">-->       
                                            <div class="email_subject_label"><span>To users: </span></div>
                                            <input type="text" name="ToAddress" id="to_manuals" class="form-control" placeholder="To users:" />
                                        </div>   
                                        <div class="form-group">
    <!--                                        <input id="to_manuals" class="form-control" placeholder="To:">-->       
                                            <div class="email_subject_label"><span>To groups: </span></div>
                                            <input type="text" name="ToGroupAddress" id="cc_manuals" class="form-control" placeholder="To groups:" />
                                        </div> 
                                    <?php } ?>
                                    <div class="form-group">
                                        <div class="email_subject_label"><span>Subject: </span></div>
                                        <input name="Subject" class="form-control" placeholder="Subject:" required>
                                    </div>

                                    <div class="form-group">
                                        <textarea name ="ContentMessage" class="form-control" style="height: 300px" required>
                                            <?php
                                            if (isset($_GET['reportLink']))
                                                echo $_GET['reportLink'];
                                            ?>
                                        </textarea>
                                    </div>                                 

                                </div><!-- /.box-body -->
                                <div class="box-footer">
                                    <div class="pull-right">
                                        <?php if (isset($_GET['UserId'])) { ?>
                                            <button type="submit" class="btn btn-primary" name = "send-action-ex"><i class="fa fa-envelope-o"></i> Send</button>  
                                        <?php } else { ?>
                                            <button type="submit" class="btn bg-green" name = "send-action"><i class="fa fa-envelope-o"></i> Send</button>                                      
                                        <?php } ?>
                                    </div>
<!--                                    <button class="btn btn-default"><i class="fa fa-times"></i> Discard</button>-->
                                </div><!-- /.box-footer -->
                            </div><!-- /. box -->
                        </div><!-- /.col -->
                        <!-- /.row -->
                    </form>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <footer class="main-footer">
                <div class="pull-right hidden-xs">
                    <b>Version</b> 2.3.0
                </div>
                <strong>Copyright &copy; 2014-2015 <a href="http://almsaeedstudio.com">Almsaeed Studio</a>.</strong> All rights reserved.
            </footer>
        </div>

    </body>
    <!-- iCheck -->
    <script src="plugins/iCheck/icheck.min.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <!-- Page Script -->
    <script>
            $(function () {
                //Add text editor
                $("#compose-textarea").wysihtml5();
            });
    </script>
</html>
