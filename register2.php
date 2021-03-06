<!DOCTYPE html>
<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';

if (isset($_SESSION['user']) != "") {
    header("Location: login.php");
}

if (isset($_POST['btn-signup'])) {
    $uname = $_POST['uname'];
    $email = $_POST['email'];
    $upass = $_POST['upass'];
    $urpass = $_POST['urpass'];
    
    $uname = @mysql_real_escape_string($uname);
    $uname = htmlentities($uname);
    $email = @mysql_real_escape_string($email);
    $email = htmlentities($email);
    $upass = @mysql_real_escape_string($upass);
    $upass = htmlentities($upass);
    $urpass = @mysql_real_escape_string($urpass);
    $urpass = htmlentities($urpass);
    if (strcmp($upass, $urpass) == 0) {
        $valid = validateUserAndPass($uname, $upass);
        if (strcmp($valid, 'true') == 0) {
            $user = new Users();
            $user->setUserName($uname);
            $user->setEmail($email);
            $user->setPassword($upass);
//    $user->setFullName($fullname);
            $insert = createUsers($user);
            //   echo " : " . $insert;
            if (!strcmp($insert, 'true')) {
                $now = new DateTime();
                $fromUser = getUserIdUseUserName($uname);
                $inbox = new Inbox();
                $inbox->setContent("Hi,\n Tôi mới đăng kí thành viên mới! Xin bạn hãy kiểm duyệt và cấp quyền cho tôi: ".$uname);
                $inbox->setFromUserId((int)$fromUser);
                $inbox->setToUserId((int)'1');
                $inbox->setSentDate($now->format('Y-m-d H:i:s'));
                $inbox->setSubject("[Register NEW MEMBER]");
                $inbox->setStatus((int)'1');

                echo createInbox($inbox);
                //header("Location: login.php");
            } else {
                ?>
                <script>alert('error while registering you...');</script>
                <?php
            }
        } else {
            echo '<script> alert(' . '"' . $valid . '"' . ')</script>;';
        }
    } else {
        echo '<script> alert("Password doesnot match")</script>;';
    }
}
?>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Register</title>
        <link rel="shortcut icon" href="css/icon.ico" />
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
        <script>
            $(function() {
                $("#datepicker").datepicker();
            });
        </script>

    </head>
    <body class="hold-transition register-page">
        <div class="register-box">
            <div class="register-logo">
                <!--<a href="homePage.php"><b>Admin</b>LTE</a>-->
            </div>

            <div class="register-box-body">
                <p class="login-box-msg">Register a new membership</p>
                <form  method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="User Name" name ="uname" required="">
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                   
                    <div class="form-group has-feedback">
                        <input type="email" class="form-control" placeholder="Email" name ="email" required="">
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Password" name="upass" required="">
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Retype password" name="urpass" required="">
                        <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8">
                            <!--                            <div class="checkbox icheck">
                                                            <label>
                                                                <input type="checkbox"> I agree to the <a href="#">terms</a>
                                                            </label>
                                                        </div>-->
                        </div><!-- /.col -->
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat" name="btn-signup">Register</button>
                        </div><!-- /.col -->
                    </div>
                </form>

                <!--                <div class="social-auth-links text-center">
                                    <p>- OR -</p>
                                    <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using Facebook</a>
                                    <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using Google+</a>
                                </div>-->

                <a href="login.php" class="text-center">I already have a membership</a>
            </div><!-- /.form-box -->
        </div><!-- /.register-box -->

        <!-- jQuery 2.1.4 -->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- iCheck -->
        <script src="plugins/iCheck/icheck.min.js"></script>
        <script>
            $(function() {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
            });
        </script>
    </body>
</html>
