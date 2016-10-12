<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
$userNameLogin = getUserById($_SESSION['user_id']);
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
// Get infor to send -
?>
<html>
    <head>
        <?php include 'includeCss.php'; ?>
        <link rel="stylesheet" href="plugins/iCheck/flat/blue.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        
        <!--  - mail -->
        <link rel="stylesheet" href="mailBox/css/token-input.css">
        <!--        <link rel="stylesheet" href="mailBox/css/send_email.css">-->
        <link rel="stylesheet" href="mailBox/css/token-input-facebook.css">
        <script src="mailBox/js/jquery.tokeninput.js"></script>
        <script src="mailBox/js/send_email.js"></script>
        <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js" ></script>
        <!--  - alert -->
        <link rel="stylesheet" href="bootstrap/css/sweetalert.css"/>
        <script src="bootstrap/js/sweetalert.min.js"/>
        <script src="bootstrap/js/sweetalert2.min.js"/>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/sweetalert2.css"/>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <!-- Bootstrap WYSIHTML5 -->
        <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    
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
    if (isset($_POST['send-action'])) {
        $fromUserId = $_SESSION['user_id'];
        $toAddress = html_entity_decode(mysql_real_escape_string($_POST['ToAddress']));
        $toGroup = html_entity_decode(mysql_real_escape_string($_POST['ToGroupAddress']));
        $subject = html_entity_decode(mysql_real_escape_string($_POST['Subject']));
        $content = html_entity_decode($_POST['ContentMessage']);
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
            <?php include 'includeTab.php';?>
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
                    <form method="post">
                        <div class="row">
                            <div class="col-md-2" style="padding-bottom: 10px;">
                                <div class= "left" style="display:inline" >
                                    <a href="inboxView.php?pageNumInbox=1" class="left text-center btn btn-sm btn-file bg-blue"><i class="fa fa-backward"></i> Back</a>
                                </div> 
                            </div><!-- /.col -->
                        </div>
                        <div class="row">
                            <div class="col-md-12">
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
                        </div><!-- /.row -->
                    </form>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include 'includeFooter.php'; ?>
        </div>

    </body>
    <!-- Page Script -->
    <script>
            $(function () {
                //Add text editor
                $("#compose-textarea").wysihtml5();
            });
    </script>
</html>
