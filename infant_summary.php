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
//infant registration variables
$infant_registation_id = $_REQUEST["id"];
$infant_registration_table = "infant_registration";
$infant_registration_table_id = "id";
//infant diagnosis variables
$infant_diagnosis_table = "infant_diagnosis";
$infant_diagnosis_table_id = "i_hei_id";


$db = new db_transactions();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Summary of participant's visit</title>
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

            <ul class="nav navbar-top-links navbar-right"><?php echo $_SESSION["name"]." is logged in."; ?>
               
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
        <?php $inf_reg_rec = $db->selectRecord($infant_registration_table, $infant_registration_table_id, $infant_registation_id);?>
        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">HEI ID: <?php echo $inf_reg_rec["hei_id"]; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="text-danger">Infant identifier summary </h3>
                            
                        </div>
                        <div class="panel-body">
                            <h3>Date of birth: <small><?php echo $inf_reg_rec["birth_date"]; ?></small></h3>
                            <h3>Mother Study ID: <small><?php echo $inf_reg_rec["d_study_id"]; ?></small></h3>
                            <h3>Birth Weight: <small><?php echo $inf_reg_rec["birth_weight"]; ?> Kg</small></h3>
                            <h3>Sex: <small><?php echo $inf_reg_rec["sex"]; ?></small></h3>
                            <h3>Delivery Place: <small><?php echo $inf_reg_rec["delivery_place"]; ?></small></h3>
                            <h3>Abstraction Date: <small><?php echo  date("Y-m-d", strtotime($inf_reg_rec["created_date"])); ?></small></h3>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                
                <div class="col-lg-7">
                   <!-- infant diagnosis panel begins -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-danger">Infant diagnosis <span class="pull-right"> <a href="diagnosis.php?action=add&id=<?php echo $infant_registation_id ; ?>&hei_id=<?php echo $inf_reg_rec["hei_id"] ; ?>" class="fa fa-pencil"> Add new</a></span></h4>
                            <?php 
                            $number = 1;
                            $select_variables = "diagnosis_id, visit_date, weight, height, next_appointment, created_date";
                            $select_record = $db->selectDefinedRecords($select_variables, $infant_diagnosis_table, $infant_diagnosis_table_id, $inf_reg_rec["hei_id"]);
                            ?>
                        </div>
                        <div class="panel-body">
                        
                        <?php
                            if (count($select_record) < 1)
                            {
                                echo "<p class='text-warning'>No visits for the participant</p>";
                            }
                            else
                            {
                             foreach ($select_record as $key => $rec)
                                {
                                    echo '<p class="text-success">';
                                    echo $number;
                                    echo " Visit Date: <strong>".$rec["visit_date"]."</strong> "
                                            . "Weight: <strong>".$rec["weight"]."</strong> "
                                            . "Height: <strong>".$rec["height"]."</strong> "
                                            . "Next Appointment: <strong>".$rec["next_appointment"]."</strong> "
                                            . "Abstraction Date: <strong>".$rec["created_date"]."</strong> .";
                                    echo "<span class='pull-right'>";
                                    echo "<a href='diagnosis.php?action=edit&id=".$rec["diagnosis_id"]."&hei_id=".$inf_reg_rec["hei_id"]."' class='fa fa-edit' alt='Edit current record'></a> |  "
                                                        . "<a href='diagnosis.php?action=delete&id=".$rec["diagnosis_id"]."' class='fa fa-times-circle' alt='Delete current record'></a>";
                                    echo "</span>";
                                    echo '</p>';
                                    
                                    $number++;
                                }
                            }
                        ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- infant diagnosis panel ends -->
               
                </div>
                <!-- /.col-lg-6 -->
                
            </div>
                       
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