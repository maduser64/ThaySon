
<aside class="main-sidebar ">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" >

        <!-- Sidebar user panel (optional) -->
        <!--                <div class="user-panel">
                            <div class="pull-left image">
                                <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                            </div>
                            <div class="pull-left info">
                                <p> <?php // echo $res->getFullName();    ?>&nbsp;&nbsp; </p>
                                 Status 
                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>-->
        <?php $adminRole = checkRoleAdminUsingUserId($_SESSION['user_id']);
        if ($adminRole) {
            ?>
            <!-- search form (Optional) -->
            <form action="javascript:check()" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" id="key" class="form-control" placeholder="Search by FacebookID..." value="">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
                </div>
            </form>
            <script>
                function check() {
                    // alert( 'Insert FB Id to Search');
                    if (!$('#key').val())
                        alert('Insert FB Id to Search');
                    else {
                        var keey = $('#key').val();
                        window.location.href = 'memberSearch.php?FacebookProfileId='.concat(keey);
                    }
                }
            </script>>
            <!-- /.search form -->
        <?php } ?>
        <!-- Sidebar Menu -->
        <ul class="sidebar-menu">
            <li class="header">MENU</li>
            <!-- Optionally, you can add icons to the links -->
            <!--<li class="active"><a href="#"><i class="fa fa-link"></i> <span>Link</span></a></li>-->
            <?php if ($adminRole) { ?>
                <li><a href="rolesView.php?pageNumRole=1"><i class="fa fa-link"></i> <span>Permission user manager</span></a></li>
            <?php } if (checkRoleQLNhom($_SESSION['user_id']) || checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                <li><a href="subGroup.php"><i class="fa fa-link"></i> <span>Group facebook manager</span></a></li>
            <?php } ?>
            <!--            <li class="treeview">
                            <a href="#"><i class="fa fa-link"></i> <span>Multilevel</span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="#">Link in level 2</a></li>
                                <li><a href="#">Link in level 2</a></li>
                            </ul>
                        </li>-->
        </ul><!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
