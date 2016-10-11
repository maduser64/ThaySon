<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Login</title>
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
    </head>
    <?php
    require_once __DIR__ . '/host.php';
    require_once '/dao/daoUsers.php';
    require_once '/models/users.php';
    session_start();

//if(isset($_SESSION['user_id'])!="")
//{
//	header("Location: homePage.php");
//}
    if (isset($_POST['btn-login'])) {
		$user=$_POST['UserName'];
		$upass=$_POST['Password'];
		//echo $user.' '.$upass;
        $user = @mysql_real_escape_string($user);
        $user = htmlentities($user);
        $upass = @mysql_real_escape_string($upass);
        $upass = htmlentities($upass);
        
        //$res=mysql_query("SELECT * FROM users WHERE email='$email'");
        //$row=mysql_fetch_array($res);
		
        $valid = check_Pass($upass);
        $valid2 = check_Pass($user);
	//	echo $user.'-->'.$upass.' $valid: ';
        if ($valid&&$valid2) {
            $userLogin = new Users();
            $userLogin = checkUser($user,$upass);
            if ($userLogin != null) {
                $_SESSION['user_id'] = $userLogin->getUserId();
                header("Location: homePage.php");                             
            } else {
                 echo '<script> alert("UserName/Password invalid")</script>;';
            }
        } else {
            echo '<script> alert("UserName/Password invalid! only number and character! min 3 character and number!")</script>;';
        }
    }
    ?>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <!--        <a href="#"><b>Admin</b>LTE</a>-->
            </div><!-- /.login-logo -->
            <div class="login-box-body">
                <p class="login-box-msg">Sign in</p>
                <form  method="post">
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" name="UserName" placeholder="User name or email" required />
           <!--            <input type="email" class="form-control" placeholder="Email">-->
                        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" name="Password" placeholder="Password" required />
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat"  name="btn-login">Sign In</button>
                        </div><!-- /.col -->
                    </div>
                </form>
                <a href="register2.php" style="padding-top: 8px" class="text-center">Register a new membership</a>

            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->

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
