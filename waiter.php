<?php
//chao
session_start();
unset($_SESSION['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login & Registration System</title>
        <link rel="shortcut icon" href="css/icon.ico" />
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
        $(function () {
            $("#datepicker").datepicker({});
        });
        </script>
    </head>
    
    
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-box-body">
                <br>
                    <h4><a class="login-box-msg text-center"><font color="black"> Bạn mới đăng kí cần chờ cấp quyền!</font></a></h4>
                <br>
                    <h4 class="login-box-msg text-center"><font color="black"> Hoặc nhấn vào <a href="http://facebook.com/tritueviet01" >đây</a> để liên hệ admin!</font></h4>
            </div>
        </div>
   
    </body>
</html>
