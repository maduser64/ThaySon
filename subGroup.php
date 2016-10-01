<?php
session_start();
require_once '/dao/daoUsers.php';
require_once '/models/users.php';
require_once '/models/inbox.php';
require_once '/dao/daoInbox.php';
require_once '/dao/daoGroups.php';
require_once '/models/groups.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
}

$userNameLogin = getUserById($_SESSION['user_id']);
$rule=FALSE;
$numInbox = getInboxIdUseStatus($_SESSION['user_id']);
if (checkRoleAdminUsingUserId($_SESSION['user_id'])||  checkRoleQLNhom($_SESSION['user_id'])) {
    $listGroup = getListGroupsbyUserId($_SESSION['user_id']);
    $rule=TRUE;
}
else if(checkRoleTV($_SESSION['user_id'])|| checkRoleQuanTri($_SESSION['user_id'])){
    $listGroup = getListGroupsbyUserId($_SESSION['user_id']);
    
}else {
    return;
}

//echo '---------------------'.  sizeof($listGroup);
?>
<html>
    <head>
        <?php include 'includeCss.php'; ?>
        <script>
            $(function () {
                $("#datetimepicker-from-date").datepicker();
            });
            $(function () {
                $("#datetimepicker-to-date").datepicker();
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
                        Groups Facebooks Manager
<!--                        <small>Optional description</small>-->
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="homePage.php"><i class="fa fa-home"></i> Home</a></li>
                        <li class="active">Groups Facebooks Information</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class= "col-md-12 text-center " style="padding-bottom: 20px;">
                        <?php if(checkRoleAdminUsingUserId($_SESSION['user_id'])==true||  checkRoleQuanTri($_SESSION['user_id'])==true){ ?>
                        <a class="btn bg-blue col-md-1 btn-sm" href="homePage.php"><i class="fa fa-backward"></i>  Back </a> 
                        <?php } ?>    
                        <?php if ($rule==TRUE) { ?>                          
                            <div class="col-md-7"></div>
                            <form action="connectFbToCSDL/createGroup.php" method="post" class="form-horizontal col-md-4">                                                  
                                <div class="col-md-8 center-block">
                                    <input class="form-control"  type="text" name="groupfacebook_id" placeholder="Facebook Group Id">
                                </div>
                                <button class="btn bg-blue col-md-4 btn-sm" name="btn-createGroup"><i class="fa fa-plus-circle"></i> Add Group </button>                    
                            </form>
                        <?php } ?>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box table-responsive ">
                                <div class="box-header">
                                    <h3 class="box-title">Groups Facebooks Manager</h3>
                                </div><!-- /.box-header -->
                                
                                    <div class="box-body ">
                                        <table id="example1" class="table table-bordered table-striped" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th class="text-center"> <small>No.</small></th>
                                                    <th class="text-center"><small>Group Name</small></th>
                                                    <th class="text-center"><small>Owner</small></th>
                                                    <th class="text-center"><small>Privacy</small></th>
                                                    <th class="text-center"><small>Group Member</small></th>
                                                    <th class="text-center"><small>Posts</small></th>                
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $size = sizeof($listGroup);
                                                $row = new Groups();
                                                $i = 0;
                                                foreach ($listGroup as $row) {
                                                    $i++;
                                                    echo '<tr>';
                                                    echo "<td class=\"text-center\" ><small>{$i}</smail></td>";
                                                    echo "<td class=\"text-left\"><small><a href=https://www.facebook.com/{$row->getFacebookGroupId()}>{$row->getName()}</a></small></td>";
                                                    $ow=$row->getOwner();
                                                    if($ow==NULL&&$ow==''){
                                                        echo "<td class=\"text-center\"><small><a href=https://www.facebook.com/groups/{$row->getFacebookGroupId()}/admins>More users</a></small></td>";
                                                    }else 
                                                        echo "<td class=\"text-center\"><small><a href=https://www.facebook.com/{$row->getOwner()}>{$row->getOwner()}</a></small></td>";
                                                    echo "<td class=\"text-center\"><small>{$row->getPrivacy()}</small></td>";
                                                    echo "<td class=\"text-center\"><small><a href = memberView.php?facebookGroupId={$row->getFacebookGroupId()}&groupId={$row->getGroupId()}>view</a></small></td>";
                                                    echo "<td class=\"text-center\"><small><a href = feedView.php?facebookGroupId={$row->getFacebookGroupId()}&groupId={$row->getGroupId()}&pageNum=1>view</a></small></td>";
                                                    echo '</tr>';
                                                }
                                                ?>

                                            </tbody>

                                        </table>
                                    </div><!-- /.box-body -->
                                
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->

            <!-- Main Footer -->
            <?php include 'includeFooter.php'; ?>
        </div>
    </body>
</html>
