
<aside class="main-sidebar " style="background-color:#2D5566;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" >

        <!-- Sidebar user panel (optional) -->
<!--                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p> <?php // echo $res->getFullName(); ?>&nbsp;&nbsp; </p>
                         Status 
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>-->
        <div class="container-fluid">
            <?php if (checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                <div class="user-panel">
                    <!--<div class="col-md-6 pull-right col-sm-6 " id = "search_form">-->
                    <!-- search form -->
                    <div class="input-group" >
                        <input type="text" id="key"  class="form-control" name="q" placeholder="Search by FacebookID..." value=""/>
                        <div class="input-group-btn">
                            <a type="submit" name="" id="search-btn" class="form-control btn bg-blue" onclick="check()" ><i class="fa fa-search"></i></a>
                        </div>  
                    </div>
					<br>
                    <!-- input -->

                    <!--</div>--> 
                </div>
                <div class="user-panel">
                    <div class= "row-md-4 text-left ">
                        <a class="btn bg-green btn-sm " href="rolesView.php?pageNumRole=1"> Permission user manager</a>
                    </div>
                </div>

            <?php } ?>
            <div class="user-panel">
                <?php if (checkRoleQLNhom($_SESSION['user_id']) || checkRoleAdminUsingUserId($_SESSION['user_id'])) { ?>
                    <div class= "row-md-4 text-left ">
                        <a class="btn bg-green btn-sm " href="subGroup.php"> Group facebook manager</a>
                    </div>
                <?php } ?>
            </div>
        </div>
        
    </section>
    <!-- /.sidebar -->
</aside>
