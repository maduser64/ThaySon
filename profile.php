<!DOCTYPE html>
<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/dao/daoRoles.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoGroups.php';
require_once '/models/groups.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
if (isset($_GET['update'])) {
    ?>
    <script>alert('Done!');</script>
    <?php
}
$userNameLogin = new Users();
$userNameLogin = getUserById($_SESSION['user_id']);
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);

//$listGroup = (array) getListGroupsWithIdUser($_SESSION['user_id']);
//echo '---'.$listInbox;
if (isset($_POST['save'])) {
    $email = mysql_real_escape_string($_POST['email']);
    $fullname = mysql_real_escape_string($_POST['fullname']);
    $address = mysql_real_escape_string($_POST['address']);
    $phone = mysql_real_escape_string($_POST['phonenumber']);
    $gender = mysql_real_escape_string($_POST['gender']);
    $tdate = mysql_real_escape_string($_POST['date']);
    $phone2 = mysql_real_escape_string($_POST['phonenumber2']);
    $address2 = mysql_real_escape_string($_POST['address2']);
    $class = mysql_real_escape_string($_POST['class']);
    $school = mysql_real_escape_string($_POST['school']);
    // echo ''.$email.$fullname.$address.$phone.$phone2;
    $userNameLogin->setEmail($email);
    $userNameLogin->setPhoneNumber1($phone);
    $userNameLogin->setAddress1($address);
    $userNameLogin->setGender($gender);
    $userNameLogin->setBirthday(date('Y-m-d', strtotime($tdate)));
    $userNameLogin->setAddress2($address2);
    $userNameLogin->setClass($class);
    $userNameLogin->setSchool($school);
    $userNameLogin->setPhoneNumber2($phone2);
    $userNameLogin->setFullName($fullname);

    $insert = updateUsers($userNameLogin);

    if ($insert == true) {
        header("Location: profile.php?update=ok");
    } else {
        ?>
        <script>alert('error while registering you...');</script>
        <?php
    }
}
if(isset($_POST['change'])){
    
    $new = $_POST['newpassword'];
    $repeat = $_POST['repeatnewpassword'];
//    $new = mysql_real_escape_string($_POST['newpassword']);
//    $repeat = mysql_real_escape_string($_POST['repeatnewpassword']);
   // echo '$new: '.$new.'  '.$repeat;
    
    if(strcmp($new,$repeat)==0){
        //if(!preg_match("[0-9a-zA-Z]",$new)){
       
        $valid = validateUserAndPass("tuongvv", $repeat);
        if (strcmp($valid, 'true') == 0) {
            $userNameLogin->setPassword($repeat);
            if(updateUsersPass($userNameLogin)==true){
                echo '<script>alert(\'Successful!\');</script>';
            }else {
                echo '<script>alert(\'Error!\');</script>';
            }
        }else {
            echo '<script>alert(\'New password not good!\');</script>';
        }
    }else {
        echo '<script>alert(\'Password not match!\');</script>';
    }
}

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>User Profile</title>
        <link rel="shortcut icon" href="css/icon.ico" />
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <script src="bootstrap/js/bootstrap.js" type="text/javascript"></script>
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="plugins/jQueryUI/jquery-ui.js" type="text/javascript"></script>
        <script src="plugins/jQueryUI/jquery-ui.min.js" type="text/javascript"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="plugins/datepicker/bootstrap-datepicker.js"></script>
        <link rel="stylesheet" href="plugins/datepicker/datepicker3.css">

        <script>
            $(function () {
                $("#datepicker").datepicker();
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
                        User Profile
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">User profile</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-3">

                                <!-- Profile Image -->
                                <div class="box box-primary">
                                    <div class="box-body box-profile">
                                        <img class="profile-user-img img-responsive img-circle" src="dist/img/user4-128x128.jpg" alt="User profile picture">
                                        <h3 class="profile-username text-center"> <?php echo '' . $userNameLogin->getFullName(); ?></h3>
                                        <p class="text-muted text-center"> Member since <?php echo '' . $userNameLogin->getCreateTime(); ?></p>

                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                            <div class=" col-sm-6 "> 

                                <div class="box box-primary box-header with-border" >
                                    <!--                                    <h2 class=" center">Update Personal info</h2>-->
                                    <!--/.box-header-->  
                                    <form class="form-horizontal" role="formpass" method="post">
                                        <div class="box-header center">
                                            <h1 class="box-title center">Change password</h1>
                                            <div style="height: 10px;"></div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">New password:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="" type="password" name="newpassword">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Repeat new password:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="" type="password" name="repeatnewpassword">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-md-5 control-label"></label>
                                            <div class="col-md-6">

                                                <button class="btn btn-primary" type="submit" name="change"><i class="fa fa-save"></i> Change</button>
<!--                                                <input class="btn btn-primary"  value="Save" type="submit" name="save">-->
                                                <span style="padding-right: 10px;"></span>
                                                <input class="btn btn-default"  type="reset" value="Cancel"/>
                                            </div>
                                        </div> 
                                    </form>
                                    <form class="form-horizontal" role="form" method="post">
                                        <div class="box-header center">
                                            <h1 class="box-title center">Personal Information</h1>
                                            <div style="height: 10px;"></div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Full name:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $userNameLogin->getFullName() ?>" type="text" name="fullname">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Phone Number:</label>
                                            <div class="col-lg-8">
                                                <input name="phonenumber" class="form-control" value="<?php echo $userNameLogin->getPhoneNumber1() ?>" type="text">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Date of birth:</label>
                                            <div class="col-lg-8">
                                                <div class='input-group date' id='datepicker' data-provide="datepicker" data-date-format="dd-mm-yyyy">
                                                    <input type='text' class="form-control" name = "date" value="<?php echo $userNameLogin->getBirthday() ?>"/>
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Current Address:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $userNameLogin->getAddress1() ?>" type="text" name="address">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Email:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $userNameLogin->getEmail() ?>" type="text" name="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Gender</label>
                                            <div class="col-lg-8">
                                                <div class="ui-select">
                                                    <select id="user_time_zone" class="form-control" name="gender">
                                                        <?php
                                                        if ($userNameLogin->getGender() == 1) {
                                                            echo '<option value="1" name="gen" selected>Male</option>';
                                                            echo '<option value="2" name="gen">Female</option>';
                                                        } else {
                                                            echo '<option value="1" name="gen" >Male</option>';
                                                            echo '<option value="2" name="gen" selected>Female</option>';
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <br><br>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Home Number:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $userNameLogin->getPhoneNumber2() ?>" type="text" name="phonenumber2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Home town:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $userNameLogin->getAddress2() ?>" type="text" name="address2">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">Class:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $userNameLogin->getClass() ?>" type="text" name="class">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-lg-3 control-label">School:</label>
                                            <div class="col-lg-8">
                                                <input class="form-control" value="<?php echo $userNameLogin->getSchool() ?>" type="text" name="school">
                                            </div>
                                        </div>

                                        <?php
                                        if (checkRole($userNameLogin->getUserId(), 5)) {
                                            ?>
                                            <div class="form-group">
                                                <label class="col-md-5 control-label"></label>
                                                <div class="col-md-6">

                                                    <button class="btn btn-primary" type="submit" name="save"><i class="fa fa-save"></i> Save</button>
    <!--                                                <input class="btn btn-primary"  value="Save" type="submit" name="save">-->
                                                    <span style="padding-right: 10px;"></span>
                                                    <input class="btn btn-default"  type="reset" value="Cancel"/>
                                                </div
                                            </div> 
                                        <?php } ?>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-3 sidebar" ></div>
                        </div><!-- /.row -->
                    </div>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
            <?php include 'includeFooter.php'; ?>
        </div><!-- ./wrapper -->

        <!-- jQuery 2.1.4 -->
        <script src="plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="bootstrap/js/bootstrap.min.js"></script>
        <!-- FastClick -->
        <script src="plugins/fastclick/fastclick.min.js"></script>
        <!-- AdminLTE App -->
        <script src="dist/js/app.min.js"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="dist/js/demo.js"></script>
    </body>
</html>
