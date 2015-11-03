<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

require_once("c_transactions.php");
$inactive = 600;
if(!isset($_SESSION['timeout']) ) {
   header("Location: logout.php");
}
else{
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

    <title>Women Retention form</title>

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
        setTimeout(function() { window.location.href = "logout.php"; }, 6000000);
    </script>
    
</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            
            <ul class="nav navbar-top-links navbar-right"><?php echo $_SESSION["name"]; ?>  is logged in.
                
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
                            <div class="alert alert-success">
                                <a class="alert-link" href="dashboard.php"><?php include('version.php'); ?></a>
                            </div>
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
                    <h1 class="page-header">Women Retention form</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Enter form details 
                        </div>
                           <div class="col-lg-6">
                                    <?php
                                 $mode = $_REQUEST["mode"];
                                $retention_id = $_REQUEST["id"];
                                $action = $_REQUEST["action"];
                                $table = "retention";
                                $tbl_id = "retention_id";
                                $db = new db_transactions();
                         
                                if($mode == "retention")
                                    {
                                    $studyid= $_POST['studyid'];
                                    $hiv_visit = $_POST['hiv_visit'];
                                    $next_visit = $_POST['next_visit'];
                                    $btn = $_POST['btn'];
                                    $retention = array($studyid, $hiv_visit, $next_visit);

                                        if ($btn == "submit")
                                        {
                                             if($db->insertRentention($retention)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Retention recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Retention was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "update"){
                                            if($db->editRentention($retention, $retention_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women  Retention recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {echo "id = ".$retention_id;
                                                    echo '<label class="control-label" for="inputError">Women Retention was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                       
                                    }
                             
                                if ($action == "add" || $action == "edit") {
                                     $select_record = $db->selectRecord($table, $tbl_id, $retention_id);
                                    ?>
                                     
                                    <form role="form" action="retention.php?id=<?php echo $retention_id; ?>" method="post">
                                        <button type="button" onclick="window.location.href='women_retention.php'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>
                                        <input type="hidden" name="mode" value="retention" />
                                        <div class="form-group">
                                            <label>Participant Study ID</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["r_study_id"];} else if($_REQUEST["action"] == "add"){ echo trim($_REQUEST["study_id"]);} ?>" placeholder="Enter Study ID" name="studyid" required="TRUE" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Date of HIV care visit</label>
                                            <input required="TRUE" max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["hiv_visit"];}?>" placeholder="<?php if($action == "edit"){echo $select_record["hiv_visit"];}?>" name="hiv_visit" >
                                        </div>
                                        <div class="form-group">
                                            <label>Date of next appointment</label>
                                            <input required="TRUE" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["next_visit"];}?>" name="next_visit" >
                                        </div>
                                    
                                         <?php if($action == "add") { ?>
                                        <button type="submit" name="btn" value="submit" class="btn btn-success">Submit</button>
                                        <?php } else if($action == "edit") { ?>
                                        <button type="update" name="btn" value="update" class="btn btn-success">Update</button>
                                        <?php } ?>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                    <?php } else if($action == "delete") {
                                         if($db->deleteRentention($retention_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Retention deleted!</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Retention was not deleted.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                    } ?>
                                </div>
                               
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
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