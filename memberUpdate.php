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
require_once '/readExcel.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$userNameLogin = getUserById($_SESSION['user_id']);
if (isset($_GET['groupId'])) {
    $listMembers = (array) getListMembersUsingGroupId($_GET['groupId']);
} else {
    header("Location: homePage.php");
    return;
}
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);


//----------------------------------------------------------------------------------------
    function getData($data) {
        $dom = new DOMDocument;
        $dom->loadHTML($data);
        $divs = $dom->getElementsByTagName('code');
        foreach ($divs as $div) {
            return $div->nodeValue;
        }
    }

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
        return getData($result);
    }

    if (isset($_POST["update"])) {
        echo '<script> showPleaseWait(); </script>';
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

            $row->setRealName(trim($_POST['irealname'][$i]));
            $row->setAddress1(trim($iaddress1[$i]));
            $row->setAddress2(trim($iaddress2[$i]));
            $row->setBirthday(trim($ibirthday[$i]));
            $row->setPhoneNumber1(trim($iphone1[$i]));
            $row->setPhoneNumber2(trim($iphone2[$i]));
            $row->setEmail(trim($iemail[$i]));
            $row->setGender(trim($igender[$i]));
            $row->setClass(trim($iclass[$i]));
            $row->setSchool(trim($ischool[$i]));
            $row->setFacebookLink(trim($ifacebooklink[$i]));
            $row->setFacebookProfileId(trim(getFacebookIdProfile($ifacebooklink[$i])));
            $result = updateMembers($row);

            if ($result == false) {
                echo '<script> showAlertFalse(); </script>';
                break;
            }
            $i++;
        }
        echo '<script> hidePleaseWait(); </script>';
        echo '<script> showAlertTrue(); </script>';
    }
?>

<html>
    <head>
        <?php include 'includeCss.php'; ?>
        <!-- DataTables -->
        <script src="plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="plugins/bootstrap-waitingfor.js"></script>
        <script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

        <link rel="stylesheet" href="bootstrap/css/sweetalert.css"/>
        <script src="bootstrap/js/sweetalert.min.js"/>
        <!-- <script src="bootstrap/js/sweetalert2.min.js"/>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/sweetalert2.css"/>-->
        <script src="mailBox/js/jquery-1.9.1.js"></script>
        
        <script>
            function showPleaseWait() {
                var modalLoading = '<div class="modal" id="pleaseWaitDialog" data-backdrop="static" data-keyboard="false role="dialog">\
        <div class="modal-dialog">\
            <div class="modal-content">\
                <div class="modal-header">\
                    <h4 class="modal-title">Please wait...</h4>\
                </div>\
                <div class="modal-body">\
                    <div class="progress">\
                      <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar"\
                      aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width:100%; height: 40px">\
                      </div>\
                    </div>\
                </div>\
            </div>\
        </div>\
    </div>';
                $(document.body).append(modalLoading);
                $("#pleaseWaitDialog").modal("show");
            }

            /**
             * Hides "Please wait" overlay. See function showPleaseWait().
             */
            function hidePleaseWait() {
                $("#pleaseWaitDialog").modal("hide");
            }

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
            function showAlertTrue() {
                //console.log("fAIL");
                sweetAlert('Succesful...', 'update successful!', 'error');
            }
            function showSweetAlert1(message) {
                // console.log("OK");

                swal(message, "", "success");
            }
        </script>
    
    <?php


    ?>
</head>

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
                    <form  method="post" enctype="multipart/form-data">
                        <div class= "col-md-22" style="padding-bottom: 20px;">
                            <span><h5 class="box-title">Select excel file to upload, download sample file <a href="files/SampleFileInput.xlsx">here</a>:</h5></span>
                                <table>
                                    <tr>
                                        <td><input type="file" name="fileToUpload" id="fileToUpload"></td>
                                        <td><input type="submit" value="Upload excel file" name="submitExcel"></td>
                                    </tr>
                                </table>
                            
                        </div>
                    </form>
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
                                                if (isset($_POST["submitExcel"])) {
                                                    $target_dir = "uploads/";
                                                    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
                                                    $target_file2 = $target_dir . $_SESSION['user_id'] . '.xlsx';

                                                    $uploadOk = 1;
                                                    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
                                                    //if (file_exists($target_file)) {
                                                    //    echo "Sorry, file already exists.";
                                                    //}
                                                    //if ($_FILES["fileToUpload"]["size"] > 500000) {
                                                    //    echo "Sorry, your file is too large.";
                                                    //    $uploadOk = 0;
                                                    //}
                                                    if ($imageFileType != "xlsx") {
                                                        echo "Sorry, only xlsx files are allowed.";
                                                        $uploadOk = 0;
                                                    }
                                                    if ($uploadOk == 0) {
                                                        echo "Sorry, your file was not uploaded.";
                                                    } else {
                                                        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file2)) {
                                                            // echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";
                                                            $count = sizeof($listMembers);
                                                            $sheetData = (array) getListMemberFromExel($count, $target_file2);

                                                            //var_dump($sheetData);
//                                                            echo '<br> chay bai 2 :  - -- - - ';
//                                                            echo 'count: ' . $count . '<br>';
                                                            //$j = 0;
                                                            //for ($i = 2; $i <= $count + 1; $i++) {

                                                            $row = new Members();
                                                            $i = 2;
                                                            foreach ($listMembers as $row) {
//                                                                for ($j = 'A'; $j <= 'M'; $j++) {
//                                                                    echo $sheetData[$i][$j] . ' ';
//                                                                }
//                                                                echo '<br>';
                                                                $j = $i - 1;
                                                                echo '<tr>';
                                                                echo "<td class=\"text-center\">{$j}</td>";
                                                                echo "<td class=\"text-left\"><a href=https://www.facebook.com/{$row->getFacebookIdMember()}>{$row->getName()}</a></td>";
                                                                if ($row->getAdministrator() == 1)
                                                                    echo "<td class=\"text-center\">true</td>";
                                                                else
                                                                    echo "<td class=\"text-center\">false</td>";
                                                                echo "<td class=\"text-center\"><input name = \"irealname[]\" type = \"text\" value = \"{$sheetData[$i]['C']}\"/></td>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"iaddress1[]\" type = \"text\" value =\"{$sheetData[$i]['D']}\"/></th>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"iaddress2[]\" type = \"text\" value =\"{$sheetData[$i]['E']}\"/></th>";
                                                                echo "<td class=\"text-center\"><input name = \"ibirthday[]\" type = \"text\" value =\"{$sheetData[$i]['F']}\"/></td>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"iphone1[]\" type = \"text\" value =\"{$sheetData[$i]['G']}\"/></th>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"iphone2[]\" type = \"text\" value = \"{$sheetData[$i]['H']}\"/></td>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"iemail[]\" type = \"text\" value =\"{$sheetData[$i]['I']}\"/></th>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"igender[]\" type = \"text\" value =\"{$sheetData[$i]['J']}\"/></th>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"iclass[]\" type = \"text\" value =\"{$sheetData[$i]['K']}\"/></th>";
                                                                echo'' . " <td class=\"text-left\" ><input name = \"ischool[]\" type = \"text\" value =\"{$sheetData[$i]['L']}\"/></th>";
                                                                $link = trim($sheetData[$i]['M']);
                                                                echo'' . " <td class=\"text-left\" ><input name = \"ifacebooklink[]\" type = \"text\" value =\"{$link}\"/></th>";

                                                                echo '</tr>';
                                                                $i++;
                                                            }
                                                        } else {
                                                            echo "Sorry, there was an error uploading your file.";
                                                        }
                                                    }
                                                } else {
//------------------------------------------------------------------------------------------------------------
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
                                                        echo'' . " <td class=\"text-left\" ><input name = \"iaddress1[]\" type = \"text\" value =\"{$row->getAddress1()}\"/></th>";
                                                        echo'' . " <td class=\"text-left\" ><input name = \"iaddress2[]\" type = \"text\" value =\"{$row->getAddress2()}\"/></th>";
                                                        echo "<td class=\"text-center\"><input name = \"ibirthday[]\" type = \"text\" value =\"{$row->getBirthday()}\"/></td>";
                                                        echo'' . " <td class=\"text-left\" ><input name = \"iphone1[]\" type = \"text\" value =\"{$row->getPhoneNumber1()}\"/></th>";
                                                        echo'' . " <td class=\"text-left\" ><input name = \"iphone2[]\" type = \"text\" value = \"{$row->getPhoneNumber2()}\"/></td>";
                                                        echo'' . " <td class=\"text-left\" ><input name = \"iemail[]\" type = \"text\" value =\"{$row->getEmail()}\"/></th>";
                                                        echo'' . " <td class=\"text-left\" ><input name = \"igender[]\" type = \"text\" value =\"{$row->getGender()}\"/></th>";
                                                        echo'' . " <td class=\"text-left\" ><input name = \"iclass[]\" type = \"text\" value =\"{$row->getClass()}\"/></th>";
                                                        echo'' . " <td class=\"text-left\" ><input name = \"ischool[]\" type = \"text\" value =\"{$row->getSchool()}\"/></th>";
                                                        $link = trim($row->getFacebookLink());
                                                        echo'' . " <td class=\"text-left\" ><input name = \"ifacebooklink[]\" type = \"text\" value =\"{$link}\"/></th>";

                                                        echo '</tr>';
                                                        $i++;
                                                    }
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
                                echo"<button class=\"col-md-1 center btn btn-primary\" type=\"submit\" name = \"update\"><i class=\"fa fa-envelope-o fa-save\" style=\"margin-right: 5px;\"></i> Save</button>";
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
