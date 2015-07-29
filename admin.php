<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("c_transactions.php");
$inactive = 600;

if(isset($_SESSION['timeout']) ) {
  $session_life = time() - $_SESSION['timeout'];
  if($session_life > $inactive) { 
    header("Location: logout.php"); 
  }
}

$_SESSION['timeout'] = time();
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>User administration form</title>

    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
<script type="text/javascript">
    //setTimeout(function() { window.location.href = "logout.php"; }, 60 * 10);
</script>
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php"><?php include('version.php'); ?></a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <!--<li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                        </li>
                        <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                        </li>-->
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="dashboard.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                        </li>
                        <li>
                            <!--<a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Menus<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">-->
                     <?php foreach ($_SESSION["access"] as $key => $access) { ?>
                        <li>
                            <?php echo '<a href="#"><i class="fa fa-arrow-circle-right"></i>'. $access["top_menu_name"].'<span class="fa arrow"></span></a>'; ?>
                            <?php
                            echo '<ul class="nav nav-second-level">';
                            foreach ($access as $k => $val) {
                                if ($k != "top_menu_name") {
                                    echo '<li><a href="' . ($val["page_name"]) . '">' . $val["menu_name"] . '</a></li>';
                                    ?>
                                    <?php
                                }
                            }
                            echo '</ul>';
                            ?>
                        </li>
                    <?php
                }
                ?>
                            
                        </li>
                        
                      
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">User administration form</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
            <div class="row">
                <div class="col-lg-8">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            Enter form details 
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-8">
                               <?php
                                $mode = $_REQUEST['mode'];
                                $user_id = $_REQUEST['id'];
                                $action = $_REQUEST['action'];
                                $table = "system_users";
                                $table_role = "role";
                                $tbl_id = "u_userid";
                                $db = new db_transactions();
                                if($mode == "user")
                                    {
                                    $usn = $_POST['u_username'];
                                    $pwd = $_POST['u_password'];
                                    $role_code = $_POST['u_rolecode'];
                                    $name = $_POST['u_name'];
                                    $btn = $_POST['btn'];
                                    
                                        $user = array($usn, $pwd, $role_code, $name);
                                                                                    
                                        if ($btn == "u_submit")
                                        {
                                             if($db->insertUser($user)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">New user created successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">New user was not created.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "u_update"){
                                            if($db->editUser($user, $user_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">User details updated successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo "id = ".$user_id;
                                                    echo '<label class="control-label" for="inputError">User details was not updated.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                       
                                    }
                                else if($action != "add" && $action != "edit" && $action != "delete") { ?>
                                    
                                    <div class="table-responsive">
                                        <a href="admin.php?action=add"  class="fa fa-pencil"> Add new</a>
                                        <table class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Full Name</th>
                                                    <th>Username</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $select_all = $db->selectAll($table);
                                                    foreach ($select_all as $key => $rec)
                                                    {
                                                        echo "<tr><td>".$rec["u_userid"]."</td>";
                                                        echo "<td>".$rec["u_name"]."</td>";
                                                        echo "<td>".$rec["u_username"]."</td>";
                                                        echo "<td>".$rec["u_rolecode"]."</td>";
                                                        echo "<td> <a href='admin.php?action=edit&id=".$rec["u_userid"]."' class='fa fa-edit' alt='Edit current record'></a> |  "
                                                        . "<a href='admin.php?action=delete&id=".$rec["u_userid"]."' class='fa fa-times' alt='Delete current record'></a></td></tr>";
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                <?php   }
                                if ($action == "add" || $action == "edit") {
                                     $select_record = $db->selectRecord($table, $tbl_id, $user_id);
                                    ?>
                                     
                                    <form role="form" action="admin.php?id=<?php echo $user_id; ?>" method="post">
                                        <button type="button" onclick="window.location.href='admin.php'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>
                                        <input type="hidden" name="mode" value="user" />
                                        <div class="form-group">
                                            <label>User Full Names</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["u_name"];} ?>" placeholder="Enter User full name" name="u_name" required="TRUE" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Username</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["u_username"];} ?>" placeholder="Enter user login name" name="u_username" required="TRUE" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Password</label>
                                            <input type="password" class="form-control" value="<?php if($action == "edit"){echo $select_record["u_password"];} ?>" placeholder="Enter User password" name="u_password" required="TRUE" autofocus>
                                        </div>
                                       <div class="form-group">
                                            <label>Role type</label>
                                            <select class="form-control" name="u_rolecode">
                                             <?php    $select_all = $db->selectAll($table_role);
                                                    foreach ($select_all as $key => $rec)
                                                    {?>
                                                        <option value="<?php echo $rec["role_rolecode"] ?>" <?php if(isset($rec["role_rolecode"])) {echo 'selected="selected"';} ?> ><?php echo $rec["role_rolename"].'-'.$rec["role_rolecode"] ?></option>
                                              <?php  } ?>
                                            </select>
                                        </div>
                                       
                                    
                                         <?php if($action == "add") { ?>
                                        <button type="submit" name="btn" value="u_submit" class="btn btn-success">Submit</button>
                                        <?php } else if($action == "edit") { ?>
                                        <button type="update" name="btn" value="u_update" class="btn btn-success">Update</button>
                                        <?php } ?>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                    <?php } else if($action == "delete") {
                                         if($db->deleteRentention($retention_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">User has been disabled !</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">User has not beeen disabled.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                    } ?>
                                </div>
                               
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body --><div class="panel-footer">
                        </div>
                    </div>
                    <!-- /.panel -->
                    
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            
           
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
