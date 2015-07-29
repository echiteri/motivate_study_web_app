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
//demographic variables
$demographic_study_id = $_REQUEST["id"];
$demographics_table = "demographics";
$demographics_table_id = "study_id";
//women variable variables
$women_variables_study_id = $_REQUEST["id"];
$women_variables_table = "variables";
$women_variables_table_id = "v_study_id";
//women retention variables
$women_retention_study_id = $_REQUEST["id"];
$women_retention_table = "retention";
$women_retention_table_id = "r_study_id";
//women adherence variables
$women_adherence_study_id = $_REQUEST["id"];
$women_adherence_table = "adherence";
$women_adherence_table_id = "a_study_id";

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
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="dashboard.php"><?php include('version.php'); ?></a>
            </div>
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
                    <h1 class="page-header">Study ID: <?php echo $demographic_study_id; ?></h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="text-danger"><strong>Demographic and identifier summary</strong></h3>
                            <?php $select_record = $db->selectRecord($demographics_table, $demographics_table_id, $demographic_study_id);?>
                        </div>
                        <div class="panel-body">
                            <h3>Date of birth: <small><?php echo $select_record["birth_date"]; ?></small></h3>
                            <h3>Facility ID: <small><?php echo $select_record["facility_id"]; ?></small></h3>
                            <h3>Anc ID: <small><?php echo $select_record["anc_id"]; ?></small></h3>
                            <h3>PSC ID: <small><?php echo $select_record["psc_id"]; ?></small></h3>
                            <h3>Abstraction date: <small><?php echo $select_record["abs_date"]; ?></small></h3>
                            <h3>Expected Delivery Date: <small><?php echo $select_record["edd"]; ?></small></h3>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                
                <div class="col-lg-5">
                   <!-- women variable panel begins -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-danger">Women Variables <span class="pull-right"> <a href="variables.php?action=add"  class="fa fa-pencil"> Add new</a></span></h4>
                            <?php 
                            $number = 1;
                            $select_variables = "variables_id, weight, height, edd";
                            $select_record = $db->selectDefinedRecords($select_variables, $women_variables_table, $women_variables_table_id, $women_variables_study_id);
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
                                    echo " Visit Date: <strong>".$rec["variables_id"]."</strong> "
                                            . "Weight: <strong>".$rec["weight"]."</strong> "
                                            . "Height: <strong>".$rec["height"]."</strong> "
                                            . "EDD: <strong>".$rec["edd"]."</strong> ";
                                    echo "<span class='pull-right'>";
                                    echo "<a href='variables.php?action=edit&id=".$rec["variables_id"]."' class='fa fa-edit' alt='Edit current record'></a> |  "
                                                        . "<a href='variables.php?action=delete&id=".$rec["variables_id"]."' class='fa fa-times-circle' alt='Delete current record'></a>";
                                    echo "</span>";
                                    echo '</p>';
                                    
                                    $number++;
                                }
                            }
                        ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- women variable panel ends -->
                    
                    <!-- women adherence panel begins -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h4 class="text-danger">Women Adherence<span class="pull-right"> <a href="adherence.php?action=add"  class="fa fa-pencil"> Add new</a></span></h4>
                            <?php 
                            $number = 1;
                            $select_variables = "adherence_id, haart_regimen, cd4_count, viral_load";
                            $select_record = $db->selectDefinedRecords($select_variables, $women_adherence_table, $women_adherence_table_id, $women_adherence_study_id);
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
                                echo '<p class="text-success"';
                                echo $number;
                                echo " <strong> Visit Date: ".$rec["adherence_id"]."</strong> "
                                        . "Haart Regimen: <strong>".$rec["haart_regimen"]."</strong> "
                                        . "CD4 count: <strong>".$rec["cd4_count"]."</strong> "
                                        . "Viral Load: <strong>".$rec["viral_load"]."</strong> .";
                                echo "<span class='pull-right'>";
                                echo "<a href='adherence.php?action=edit&id=".$rec["adherence_id"]."' class='fa fa-edit' alt='Edit current record'></a> |  "
                                                        . "<a href='adherence.php?action=delete&id=".$rec["adherence_id"]."' class='fa fa-times-circle' alt='Delete current record'></a>";
                                echo "</span>";
                                echo '</p>';
                                $number++;
                                }
                            }
                        ?>
                       </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- women adherence panel ends -->
                    
                    <!-- women retention panel begins -->
                    <div class="panel panel-default">
                        <div class="panel-heading"> <span style="text-align: left"></span>
                            <h4 class="text-danger">Women Retention <span class="pull-right"> <a href="retention.php?action=add"  class="fa fa-pencil"> Add new</a></span></h4>
                            <?php 
                            $number = 1;
                            $select_variables = "retention_id, hiv_visit, next_visit";
                            $select_record = $db->selectDefinedRecords($select_variables, $women_retention_table, $women_retention_table_id, $women_retention_study_id);
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
                                        echo " Visit Date: <strong>".$rec["hiv_visit"]."</strong>  "
                                                . "Next Visit: <strong>".$rec["next_visit"]."</strong>  ";
                                        echo "<span class='pull-right'>";
                                        echo "<a href='retention.php?action=edit&id=".$rec["retention_id"]."' class='fa fa-edit' alt='Edit current record'></a> |  "
                                                        . "<a href='retention.php?action=delete&id=".$rec["retention_id"]."' class='fa fa-times-circle' alt='Delete current record'></a>";
                                        echo "</span>";
                                        echo '</p>';
                                        $number++;
                                    }
                            }
                             ?>
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- women retention panel ends -->
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