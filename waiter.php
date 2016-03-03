<?php
session_start();
require_once __DIR__ . '/host.php';
unset($_SESSION['user_id']);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login & Registration System</title>
        <link rel="stylesheet" href="style.css" type="text/css" />
        <link rel="stylesheet" type="text/css"
              href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css"/>
        <script src="//code.jquery.com/jquery-1.10.2.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script>
        $(function () {
            $("#datepicker").datepicker({});
        });
        </script>
    </head>
    <body>
   Bạn mới đăng kí cần chờ cấp quyền!  hoặc liên hệ admin: sđt...  email...
    </body>
</html>
