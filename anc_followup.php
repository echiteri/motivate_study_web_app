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
else
{
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

    <title>ANC Followup form</title>
  
  <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
  <script>
      
  $(function() {
    $("#lmp_date").datepicker({
    maxDate: 0,
    onSelect: function(dateText, inst) {
       var actualDate = new Date(dateText);
       var newDate = new Date(actualDate.getFullYear()+1, actualDate.getMonth()-3, actualDate.getDate()+7);
        $('#edd_date').datepicker('option', 'minDate', newDate );
    }
});
  });
  
  $(function() {
   $("#edd_date").datepicker();
  });

        function toggleReg(){
             if (document.getElementById("optionsRadiosInline1").checked)
            {
                document.getElementById("haart_regimen").disabled = false;
            }else if (document.getElementById("optionsRadiosInline2").checked)
            {
                document.getElementById("haart_regimen").disabled = true;
            }
            
        }
        
        function toggleHiv(){
             if (document.getElementById("optionsRadiosInline3").checked)
            {
                document.getElementById("hiv_status_partner").disabled = false;
            }else if (document.getElementById("optionsRadiosInline4").checked)
            {
                document.getElementById("hiv_status_partner").disabled = true;
            }
        }
            
        function toggleHivStatus(){
             if (document.getElementById("initial_hiv_status").value === "P")
            {
                document.getElementById("hiv_retest").disabled = true;
            }else
            {
                document.getElementById("hiv_retest").disabled = false;
            }
        }
        
        function toggleHaartChange(){
             if (document.getElementById("optionsRadiosInline5").checked)
            {
                document.getElementById("haart_regimen").disabled = false;
                document.getElementById("haart_change_date").disabled = false;
            }else if (document.getElementById("optionsRadiosInline6").checked)
            {
                document.getElementById("haart_regimen").disabled = true;
                document.getElementById("haart_change_date").disabled = true;
            }                      
        }
      
    </script>
    <!-- Bootstrap Core CSS -->
    <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="bower_components/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
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
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw">Logout</i></a>
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
                    <h1 class="page-header">ANC Followup form</h1>
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
                        <div class="panel-body">
                            
                                    <?php
                                $mode = $_REQUEST['mode'];
                                $anc_id = $_REQUEST['id'];
                                $action = $_REQUEST['action'];
                                $table = "anc_followup";
                                $tbl_id = "anc_id";
                                $db = new db_transactions();
                                if($mode == "anc_followup")
                                    {
                                    $anc_study_id = $_POST['anc_study_id'];
                                    $abs_date= $_POST['abs_date'];
                                    $visit_count = $_POST['visit_count'];
                                    $anc_visit_date = $_POST['anc_visit_date'];
                                    $gestational_period = $_POST['gestational_period'];
                                    $haart_change = $_POST['haart_change'];
                                    $haart_regimen = $_POST['haart_regimen'];
                                    $haart_change_date = $_POST['haart_change_date'];
                                    $counselling = $_POST['counselling'];
                                    $hiv_status_partner = $_POST['hiv_status_partner'];
                                    $return_date = $_POST['return_date'];
                                    $btn = $_POST['btn'];
                                    
                                       $anc_followup = array($anc_study_id, $abs_date, $visit_count, $anc_visit_date, 
                                                            $gestational_period,$haart_change, $haart_regimen, $haart_change_date, $counselling, 
                                                            $hiv_status_partner, $return_date);
                                       
                                        if ($btn == "submit")
                                        {
                                             if($db->insertAncFollowup($anc_followup)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women ANC Followup recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women ANC Followup was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "update"){
                                            if($db->editAncFollowup($anc_followup, $anc_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess"> Women ANC Followup  updated successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women ANC Followup was not updated.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                       
                                    }
                          
                                if ($action == "add" || $action == "edit") {
                                        $select_record = $db->selectRecord($table, $tbl_id, $anc_id);
                                    ?>
                            <div class="row">
                                
                                <form role="form" action="anc_followup.php?id=<?php echo $anc_id;?>" method="post">
                                     <div class="col-lg-6">
                                         <button type="button" onclick="window.location.href='women_anc.php'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>                                  
                                        <input type="hidden" name="mode" value="anc_followup" />
                                        <div class="form-group">
                                            <label>Participant Study ID</label>
                                            <input class="form-control"  value="<?php if($action == "edit"){echo $select_record["anc_study_id"];} else if($_REQUEST["action"] == "add"){ echo trim($_REQUEST["study_id"]);} ?>" 
                                                   placeholder="Enter participant study identification number" name="anc_study_id" required="TRUE" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Abstraction</label>
                                            <input max="<?php echo date("Y-m-d");?>" type="date"  class="form-control" value="<?php if($action == "edit"){echo ($select_record["abs_date"]);} ?>" name="abs_date" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Number of participant's ANC visit</label>
                                            <input required="TRUE" type="number" min="0" value="<?php if($action == "edit"){echo $select_record["visit_count"];} ?>" class="form-control" placeholder="Enter number of participant's visit to facility for ANC services" name="visit_count"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Date of ANC visit</label>
                                            <input required="TRUE" max="<?php echo date("Y-m-d");?>" type="date"  class="form-control" value="<?php if($action == "edit"){echo $select_record["anc_visit_date"];} ?>" name="anc_visit_date"  >
                                        </div>
                                       <div class="form-group">
                                            <label>Gestational age in weeks</label>
                                            <input  required="TRUE" type="number" min="0" max="42" class="form-control" value="<?php if($action == "edit"){echo $select_record["gestational_period"];} ?>" placeholder="Enter the duration of pregnancy in weeks" name="gestational_period"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Has HAART regimen changed?</label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onchange="toggleHaartChange()" type="radio" name="haart_change" id="optionsRadiosInline5" value="Y" <?php if($select_record["haart_change"]=="Y") { echo 'checked="true"';} ?> >Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onchange="toggleHaartChange()" type="radio" name="haart_change" id="optionsRadiosInline6" value="N" <?php if($select_record["haart_change"]=="N") { echo 'checked="true"';} ?> >No
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Date of changing HAART</label>
                                            <input required="TRUE" <?php if($select_record["haart_change"]=="N") { echo 'disabled="true"';} ?> max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["haart_change_date"];} ?>" id="haart_change_date"  name="haart_change_date" >
                                        </div>
                                        <div class="form-group">
                                            <label>HAART regimen</label>
                                            <select required="TRUE" <?php if($select_record["haart_change"]=="N") { echo 'disabled="true"';} ?> id="haart_regimen" class="form-control" name="haart_regimen">
                                                <option value=""  selected="">Select the type of triple ARV therapy</option>
                                               <option value="" selected="selected">Select the regimen/code  of triple ARV therapy </option>
                                                <option value="AF1A" <?php if($select_record["haart_regimen"]=="AF1A") { echo 'selected="selected"';} ?> >AZT + 3TC + NVP = AF1A</option>
                                                <option value="AF1B" <?php if($select_record["haart_regimen"]=="AF1B") { echo 'selected="selected"';} ?> >AZT + 3TC + EFV = AF1B</option>
                                                <option value="AF2A" <?php if($select_record["haart_regimen"]=="AF2A") { echo 'selected="selected"';} ?> >TDF + 3TC + NVP = AF2A</option>
                                                <option value="AF2B" <?php if($select_record["haart_regimen"]=="AF2B") { echo 'selected="selected"';} ?> >TDF + 3TC + EFV = AF2B</option>
                                                <option value="AF2C" <?php if($select_record["haart_regimen"]=="AF2C") { echo 'selected="selected"';} ?> >TDF + 3TC + ATV/r = AF2C</option>
                                                <option value="AS1A" <?php if($select_record["haart_regimen"]=="AS1A") { echo 'selected="selected"';} ?> >AZT + 3TC + LPV/r = AS1A</option>
                                                <option value="AS1C" <?php if($select_record["haart_regimen"]=="AS1C") { echo 'selected="selected"';} ?> >AZT + 3TC + ABC = AS1C</option>
                                                <option value="AS2A" <?php if($select_record["haart_regimen"]=="AS2A") { echo 'selected="selected"';} ?> >TDF + 3TC + LPV/r = AS2A</option>
                                                <option value="AS2B" <?php if($select_record["haart_regimen"]=="AS2B") { echo 'selected="selected"';} ?> >TDF + 3TC + ABC = AS2B</option>
                                                <option value="AS2D" <?php if($select_record["haart_regimen"]=="AS2D") { echo 'selected="selected"';} ?> >TDF + ABC + LPV/r = AS2D</option>
                                                <option value="AS2E" <?php if($select_record["haart_regimen"]=="AS2E") { echo 'selected="selected"';} ?> >TDF + AZT + LPV/r = AS2E</option>
                                                <option value="AS1B" <?php if($select_record["haart_regimen"]=="AS1B") { echo 'selected="selected"';} ?> >AZT + 3TC + ATV/r = AS1B</option>
                                                <option value="AS2C" <?php if($select_record["haart_regimen"]=="AS2C") { echo 'selected="selected"';} ?> >TDF + 3TC + ATV/r = AS2C</option>
                                                <option value="AS5B" <?php if($select_record["haart_regimen"]=="AS5B") { echo 'selected="selected"';} ?> >ABC + 3TC + ATV/r = AS5B</option>
                                                <option value="AF5X" <?php if($select_record["haart_regimen"]=="AF5X") { echo 'selected="selected"';} ?> >DTG + 3TC + TDF = AF5X</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label>Couple counselling</label>
                                            <p class="help-block">Select Whether participant and her partner were counselled as a couple</p>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleHiv()" type="radio" name="counselling" id="optionsRadiosInline3" value="Y" <?php if($select_record["counselling"]=="Y") { echo 'checked="TRUE"';} ?> >Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleHiv()" type="radio" name="counselling" id="optionsRadiosInline4" value="N" <?php if($select_record["counselling"]=="N") {{ echo 'checked="TRUE"';}} ?> >No
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Partner HIV result</label>
                                            <select required="TRUE" <?php if($select_record["counselling"]=="N") { echo 'disabled="true"';} ?> id="hiv_status_partner" class="form-control" name="hiv_status_partner">
                                                <option value=""  selected="">Select  HIV test results of the participant's partner</option>
                                                <option value="P" <?php if($select_record["hiv_status_partner"]=="P") { echo 'selected="selected"';} ?> >Positive</option>
                                                <option value="N" <?php if($select_record["hiv_status_partner"]=="N") { echo 'selected="selected"';} ?> >Negative</option>
                                                <option value="KP" <?php if($select_record["hiv_status_partner"]=="KP") { echo 'selected="selected"';} ?> >Known positive</option>
                                                <option value="U" <?php if($select_record["hiv_status_partner"]=="U"){ { echo 'selected="selected"';}} ?> >Unknown</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label>Date of return visit</label>
                                            <input required="TRUE" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["return_date"];} ?>" name="return_date"  >
                                        </div>
                                        <?php if($action == "add") { ?>
                                    <button type="submit" name="btn" value="submit" class="btn btn-success">Submit</button>
                                        <?php } else if($action == "edit") { ?>
                                        <button type="update" name="btn" value="update" class="btn btn-success">Update</button>
                                        <?php } ?>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                
                                    </form>
                               <?php } else if($action == "delete") {
                                         if($db->deleteAncFollowup($anc_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women ANC Followup deleted!</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women ANC Followup  was not deleted.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                    }?>
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

 <!-- Bootstrap Core JavaScript -->
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="bower_components/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>

</body>

</html>
