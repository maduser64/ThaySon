<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
if (isset($_SESSION['user']) != "") {
    header("Location: home.php");
}

if (isset($_POST['btn-signup'])) {
    $uname = mysql_real_escape_string($_POST['uname']);
    $email = mysql_real_escape_string($_POST['email']);
    $upass = (mysql_real_escape_string($_POST['pass']));
    $fullname = mysql_real_escape_string($_POST['fullname']);
    $address = mysql_real_escape_string($_POST['address']);
    $phone = (mysql_real_escape_string($_POST['phone']));
    $gender = mysql_real_escape_string($_POST['gender']);  // Storing Selected Value In Variable
    $tdate = mysql_real_escape_string($_POST['date']);
    $date = str_replace('/', '-', $tdate);
    $user = new Users();

    $user->setUserName($uname);
    $user->setEmail($email);
    $user->setPhoneNumber($phone);
    $user->setAddress($address);
    $user->setGender($gender);
    $user->setBirthday(date('Y-m-d', strtotime($date)));
    $user->setPassword($upass);
    $user->setFullName($fullname);
    $insert = createUsers($user);
    echo " : " . $insert;
    
    if ($insert != null) {
        $_SESSION['user'] = $user->getUserName();
        header("Location: homePage.php");
    } else {
        ?>
        <script>alert('error while registering you...');</script>
        <?php
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Register</title>
        <link rel="shortcut icon" href="css/icon.ico" />
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
        <center>
            <div id="login-form">
                <form method="post">
                    <table align="center" width="60%" border="0">
                        <tr>
                            <td><input type="text" name="uname" placeholder="User Name" required /></td>
                            <td><input type="password" name="pass" placeholder="Your Password" required /></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="fullname" placeholder="Full Name" required /></td>
                            <td><input type="text" name="address" placeholder="Your Address" required /></td>
                        </tr>
                        <tr>
                            <td><input type="text" name="phone" placeholder="Your Phone" required /></td>
                            <td><input type="email" name="email" placeholder="Your Email" required /></td>
                        </tr>
                        <tr>
                            <td> <input type="text" name="date" id="datepicker" placeholder="Your BirthDay" required></td>
                            <td><select class="select" name="gender">
                                    <option name="gen" value="1">Nam</option>
                                    <option name="gen" value="2">Nữ</option>
                                </select>
                            </td> 
                        </tr>
                        <tr>
                            <td><button align = "center" type="submit" name="btn-signup">Sign Me Up</button></td>
                        </tr>
                        <tr>
                            <td><a href="index.php">Sign In Here</a></td>
                        </tr>
                    </table>
                </form>
            </div>
        </center>
    </body>
</html>
