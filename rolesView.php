<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/models/roles.php';
require_once '/dao/daoRoles.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
}
//if (checkRoleAdminUsingUserId($_SESSION['user_id']) == false)
//    return;

$userNameLogin = getUserById($_SESSION['user_id']);

$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
$current = $_GET['pageNumRole'] == null ? 1 : $_GET['pageNumRole'];
$start = ($current - 1) * 10;
$nameUser ='';

if (isset($_GET['nameUser']) && isset($_GET['searchUser'])) {
    $nameUser = $_GET['nameUser'];
    $listInbox = (array) getListUsersRoleWithName(0, 30, $nameUser);
    try {
        $_SESSION['isSearch'] = '0';
        $_SESSION['nameUser'] = $nameUser;
    } catch (Exception $ex) {
    }
} else {
    $listInbox = (array) getListUsersRole($start, 10);
    try {
        $_SESSION['pageNumRole'] = $current;
    } catch (Exception $ex) {
    }
}

$totalRecord = getListUsersCount();
$numPage = round($totalRecord / 10 + 0.5);
$listRole = getListRoles();

?>
<html>
    <head>
        <?php include 'includeCss.php'; ?>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $('#selectall').click(function (event) {  //on click 
                    if (this.checked) { // check select status
                        $('.cbox').each(function () { //loop through each checkbox
                            this.checked = true;  //select all checkboxes with class "checkbox1"               
                        });
                    } else {
                        $('.cbox').each(function () { //loop through each checkbox
                            this.checked = false; //deselect all checkboxes with class "checkbox1"                       
                        });
                    }
                });

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
                        Roles
                        <small>Select roles for user:</small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                        <li class="active">Roles</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">                              
                    <div class="row">
                        <form id="form_id" name="myform" action="processRoles.php" method="POST">
                            
                            <div class="col-md-12" style="padding-bottom: 10px;">
                                <span>
                                    <div class= "left" style="display:inline" >
                                        <a class="left text-center btn btn-sm btn-file bg-blue" href = "homePage.php"><fi class="fa fa-backward"></fi>  Back</a>
                                    </div>                                
                                    <div class= "center" style="display:inline;margin-left: 10px;" style="padding-left: 20px;">
                                        <button type="submit" name="deleteUser" class="text-center btn btn-sm btn-file bg-maroon" >Delete User</button>
                                    </div>
                                    <div class= "right" style="display:inline;margin-left: 10px;" style="padding-left: 20px;">
                                        <button type="submit" name="capQuyen1" class="text-center btn btn-sm btn-file btn-danger" >Save changes</button>
                                    </div>
                                </span>
                            </div>
                            
                            <div class="col-md-4" style="padding-bottom: 10px;">
                                <div class="input-group">
                                    <input type="text" name="nameUser"  class="form-control" placeholder="User Name" value="<?php echo $nameUser?>"/>
                                    <div class="input-group-btn">
                                        <button type="submit" name="searchUser" class="text-center btn btn-sm btn-file bg-blue"><i class="fa fa-search"></i> Search User</button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-md-12">
                                <div class="box">
                                    <div class="box-header">
                                        <h3 class="box-title">Roles</h3>
                                    </div><!-- /.box-header -->
                                    <div class="box-body">
                                        <table id="example1" class="table table-bordered table-striped text-sm" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"><input type="checkbox" id ="selectall"/></th>                                                 
                                                    <th class="text-center">Full name</th>
                                                    <th class="text-center">User name</th>
                                                    <th class="text-center">Roles</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listInbox);
                                                $row = new Users();
                                                $i = 0;
                                                foreach ($listInbox as $row) {
                                                    $i++;
                                                    echo '<tr>';
                                                    echo "<td class =\"text-center\"><input type=\"checkbox\" class =\"cbox\" name=\"checkbox_name[]\" value=\"{$row->getUserId()}\" /></td>";
                                                    // echo "<td><input type=\"checkbox\" name=\"checkbox_name[]\" value=\"{$row->getUserId()}\" /></td>";
                                                    // echo "<td>{$i}</td>";
                                                    echo "<td>" . $row->getFullName() . "</td>";
                                                    echo "<td>{$row->getUserName()}</td>";
                                                    echo "<td align=\"left\">";
                                                    for ($j = 0; $j < sizeof($listRole); $j++) {
                                                        $check = checkRole($row->getUserId(), $listRole[$j]->getRoleId());
                                                        if ($check) {
                                                            echo " &nbsp;<input type=\"checkbox\" name=\"{$row->getUserId()}[]\" value=\"{$listRole[$j]->getRoleId()}\""
                                                            . "checked = \"true\"/> &nbsp; &nbsp;"
                                                            . $listRole[$j]->getRoleName() . "<br>";
                                                        } else {
                                                            echo " &nbsp;<input type=\"checkbox\" name=\"{$row->getUserId()}[]\" value=\"{$listRole[$j]->getRoleId()}\""
                                                            . "/> &nbsp; &nbsp;"
                                                            . $listRole[$j]->getRoleName() . "<br>";
                                                        }
                                                    }
                                                    //echo "<td> <a class=\"left text-center btn btn-sm bg-blue\">Save</a></td>";
                                                    echo '</tr>';
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div><!-- /.col -->
                        </form>
                    </div><!-- /.row -->

                    <div class="row">
                        <div class="padding-2 col-md-12 text-center">
                            <ul class="pagination">
                                <?php
                                if ($numPage != null && $numPage > 1) {
                                    $iPage = $current;
                                    if ($iPage > 1) {
                                        $ncurrent = $current - 1;
                                        echo "<li><a href =rolesView.php?pageNumRole=$ncurrent>&laquo;</a></li>";
                                    }
                                    //$startPage, $endPage;
                                    $startPage = $iPage - 2;
                                    $endPage = $iPage + 2;
                                    if ($startPage < 1) {
                                        $endPage = $endPage - $startPage + 1;
                                        $startPage = 1;
                                    }
                                    if ($endPage > $numPage) {
                                        $endPage = $numPage;
                                    }
                                    for ($i = $startPage; $i <= $endPage; ++$i) {
                                        if ($iPage == $i)
                                            echo "<li class = \"active\"><a href=rolesView.php?pageNumRole=$i>$i</a></li>";
                                        else
                                            echo "<li><a href =rolesView.php?pageNumRole={$i}>$i</a></li>";
//                                            <li <% if (iPage == i){ %>  class = "active"  <%} %>><button  type="submit" value="<%=i %>" name="page"><%=i %></button></li>
                                    }
                                    if ($iPage < $numPage) {
                                        $ncurrent = $iPage + 1;
                                        echo "<li><a href =rolesView.php?pageNumRole={$ncurrent}>&raquo</a></li>";
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    </div>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php include 'includeFooter.php'; ?>

    </body>
</html>
