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

    <title>Identifiers and Demographics form</title>
  
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
                document.getElementById("haart_start_date").disabled = false;
            }else if (document.getElementById("optionsRadiosInline2").checked)
            {
                document.getElementById("haart_regimen").disabled = true;
                document.getElementById("haart_start_date").disabled = true;
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
             if (document.getElementById("hiv_status").value === "P" || document.getElementById("initial_hiv_status").value === "P")
            {
                document.getElementById("hiv_retest").disabled = true;
            }else
            {
                document.getElementById("hiv_retest").disabled = false;
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
                    <h1 class="page-header">Identifiers and Demographics form</h1>
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
                                $demographic_id = $_REQUEST['id'];
                                $action = $_REQUEST['action'];
                                $table = "demographics";
                                $tbl_id = "study_id";
                                $db = new db_transactions();
                                if($mode == "demographics")
                                    {
                                    $study_id = $_POST['study_id'];
                                    $abs_date= $_POST['abs_date'];
                                    $facility_id = $_POST['facility_id'];
                                    $anc_id = $_POST['anc_id'];
                                    $psc_id = $_POST['psc_id'];
                                    $visit_count = $_POST['visit_count'];
                                    $anc_visit_date = $_POST['anc_visit_date'];
                                    $birth_date= $_POST['birth_date'];
                                    $residence = $_POST['residence'];
                                    $parity = $_POST['parity'];
                                    $gravida = $_POST['gravida'];
                                    $gestational_period = $_POST['gestational_period'];
                                    $lmp_date = strtotime($_POST['lmp']); //make text field date database friendly
                                    $lmp = date('Y-m-d', $lmp_date);
                                    $edd_date = strtotime($_POST['edd']);
                                    $edd = date('Y-m-d', $edd_date);
                                    $marital_status = $_POST['marital_status'];
                                    $hiv_status = $_POST['hiv_status'];
                                    $initial_hiv_status = $_POST['initial_hiv_status'];
                                    $hiv_retest = $_POST['hiv_retest'];
                                    $woman_haart = $_POST['woman_haart'];
                                    $haart_regimen = $_POST['haart_regimen'];
                                    $haart_start_date = $_POST['haart_start_date'];
                                    $counselling = $_POST['counselling'];
                                    $hiv_status_partner = $_POST['hiv_status_partner'];
                                    $participant_outcome = $_POST['participant_outcome'];
                                    $outdate = $_POST['outdate'];
                                    $return_date = $_POST['return_date'];
                                    $btn = $_POST['btn'];
                                    
                                        $demographics = array($study_id, $abs_date, $facility_id, 
                                                            $anc_id, $psc_id, $visit_count, $anc_visit_date, $birth_date, 
                                                            $residence, $parity, $gravida, $gestational_period, $lmp,  $edd, $marital_status, $hiv_status, 
                                                            $initial_hiv_status, $hiv_retest, $woman_haart, $haart_regimen,$haart_start_date, $counselling, 
                                                            $hiv_status_partner,$participant_outcome,$outdate, $return_date);
                                        if ($btn == "submit")
                                        {
                                             if($db->insertDemographics($demographics)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Identifiers and Demographics recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Identifiers and Demographics was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "update"){
                                            if($db->editDemographics($demographics, $demographic_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess"> Women Identifiers and Demographics updated successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Identifiers and Demographics was not updated.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                       
                                    }
                          
                                if ($action == "add" || $action == "edit") {
                                        $select_record = $db->selectRecord($table, $tbl_id, $demographic_id);
                                    ?>
                            <div class="row">
                                
                                <form role="form" action="demographics_identifier.php?id=<?php echo $demographic_id;?>" method="post">
                                     <div class="col-lg-6">
                                         <button type="button" onclick="window.location.href='demographics.php'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>                                  
                                        <input type="hidden" name="mode" value="demographics" />
                                        <div class="form-group">
                                            <label>Participant Study ID</label>
                                            <input class="form-control" <?php if($action == "edit"){echo  "disabled";} ?> value="<?php if($action == "edit"){echo $select_record["study_id"];} ?>" 
                                                   placeholder="Enter participant study identification number" name="study_id" required="TRUE" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Date of Enrollment</label>
                                            <input max="<?php echo date("Y-m-d");?>" type="date"  class="form-control" value="<?php if($action == "edit"){echo ($select_record["abs_date"]);} ?>" name="abs_date" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Facility ID</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["facility_id"];} ?>" placeholder="Enter facility identification number" name="facility_id" required="TRUE" >
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Participant ANC  ID</label>
                                            <input  class="form-control" value="<?php if($action == "edit"){echo $select_record["anc_id"];} ?>" placeholder="Enter participant antenatal  identification number" name="anc_id" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Participant PSC ID</label>
                                            <input class="form-control"  value="<?php if($action == "edit"){echo $select_record["psc_id"];} ?>"placeholder="Enter participant patient support centre identification number" name="psc_id" required="TRUE" >
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
                                            <label>Date of Birth</label>
                                            <input required="TRUE" max="<?php date_format($date,"Y-m-d");;?>"  type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["birth_date"];} ?>" name="birth_date"  >
                                        </div>
  
                                         <div class="form-group">
                                            <label>Residence</label>
                                            <input required="TRUE" class="form-control" value="<?php if($action == "edit"){echo $select_record["residence"];} ?>" placeholder="Enter region or area where participant lives" name="residence"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Parity</label>
                                            <input required="TRUE" type="text"  class="form-control" value="<?php if($action == "edit"){echo $select_record["parity"];} ?>" placeholder="Enter the number of deliveries after 24 weeks/number of viable pregnancies" name="parity"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Gravida</label>
                                            <input required="TRUE" type="number" step="any" min="0" class="form-control" value="<?php if($action == "edit"){echo $select_record["gravida"];} ?>" placeholder="Enter the number of times a woman has been pregnant" name="gravida"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Gestational age in weeks</label>
                                            <input  required="TRUE" type="number" min="0" max="42" class="form-control" value="<?php if($action == "edit"){echo $select_record["gestational_period"];} ?>" placeholder="Enter the duration of pregnancy in weeks" name="gestational_period"  >
                                        </div>
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                    
                                        <div class="form-group">
                                            <label>Last Mestrual Period(LMP)</label>
                                            <input required="TRUE" id="lmp_date" max="<?php echo date("Y-m-d");?>" type="text" class="form-control" value="<?php if($action == "edit"){echo $select_record["lmp"];} ?>" name="lmp"  >
                                            
                                        </div>
                                        <div class="form-group">
                                            <label>EDD</label>
                                            <input required="TRUE" type="text" class="form-control" id="edd_date" value="<?php if($action == "edit"){echo $select_record["edd"];} ?>" name="edd"  >
                                        </div>
                                           <div class="form-group">
                                            <label>Marital status</label>
                                            <select required="TRUE" class="form-control" name="marital_status">
                                                <option value="" selected="">Select participant's relationship status</option>
                                                <option value="1" <?php if($select_record["marital_status"]=="1") { echo 'selected="selected"';} ?>>Married</option>
                                                <option value="2" <?php if($select_record["marital_status"]=="2") { echo 'selected="selected"';} ?>>Widowed</option>
                                                <option value="3" <?php if($select_record["marital_status"]=="3") { echo 'selected="selected"';} ?>>Single</option>
                                                <option value="4" <?php if($select_record["marital_status"]=="4") { echo 'selected="selected"';} ?>>Divorce</option>
                                                <option value="5" <?php if($select_record["marital_status"]=="5") { echo 'selected="selected"';} ?>>Separated</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>HIV status</label>
                                            <select required="TRUE" onchange="toggleHivStatus()" class="form-control" id="hiv_status" name="hiv_status">
                                                <option  value="" selected="">Select HIV status of the participant</option>
                                                <option value="P" <?php if($select_record["hiv_status"]=="P") { echo 'selected="selected"';} ?> >Positive</option>
                                                <option value="N" <?php if($select_record["hiv_status"]=="N") { echo 'selected="selected"';} ?> >Negative</option>
                                                <option value="KP" <?php if($select_record["hiv_status"]=="KP") { echo 'selected="selected"';} ?> >Known positive</option>
                                                <option value="U" <?php if($select_record["hiv_status"]=="U") { echo 'selected="selected"';} ?> >Unknown</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Initial HIV status</label>
                                            <select required="TRUE" onchange="toggleHivStatus()" class="form-control" id="initial_hiv_status" name="initial_hiv_status">
                                                <option value=""  selected="">Select participant's HIV status during the first ANC visit</option>
                                                 <option value="P" <?php if($select_record["initial_hiv_status"]=="P") { echo 'selected="selected"';} ?> >Positive</option>
                                                <option value="N" <?php if($select_record["initial_hiv_status"]=="N") { echo 'selected="selected"';} ?> >Negative</option>
                                                <option value="KP" <?php if($select_record["initial_hiv_status"]=="KP") { echo 'selected="selected"';} ?> >Known positive</option>
                                                <option value="U" <?php if($select_record["initial_hiv_status"]=="U") { echo 'selected="selected"';} ?> >Unknown</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label>Retest status</label>
                                            <select required="TRUE" class="form-control" name="hiv_retest" id="hiv_retest">
                                                <option value=""  selected="">Select women who  tested negative at first trimester and positive at third trimester</option>
                                                <option value="P" <?php if($select_record["hiv_retest"]=="P") { echo 'selected="selected"';} ?> >Positive</option>
                                                <option value="N" <?php if($select_record["hiv_retest"]=="N") { echo 'selected="selected"';} ?> >Negative</option>
                                                <option value="KP" <?php if($select_record["hiv_retest"]=="KP") { echo 'selected="selected"';} ?> >Known positive</option>
                                                <option value="U" <?php if($select_record["hiv_retest"]=="U") { echo 'selected="selected"';} ?> >Unknown</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Woman on HAART</label>
                                            <p class="help-block">Select whether participant is on triple ARV therapy</p>
                                            <label class="radio-inline">
                                                <input required="TRUE" onchange="toggleReg()" type="radio" name="woman_haart" id="optionsRadiosInline1" value="Y" <?php if($select_record["woman_haart"]=="Y") { echo 'checked="TRUE"';} ?> >Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onchange="toggleReg()" type="radio" name="woman_haart" id="optionsRadiosInline2" value="N" <?php if($select_record["woman_haart"]=="N") { echo 'checked="TRUE"';} ?> >No
                                            </label>                    
                                        </div>
                                        <div class="form-group">
                                            <label>HAART regimen</label>
                                            <select required="TRUE" <?php if($select_record["woman_haart"]=="N") { echo 'disabled="true"';} ?> id="haart_regimen" class="form-control" name="haart_regimen">
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
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>HAART regimen start date</label>
                                            <input max="<?php echo date("Y-m-d");?>" type="date" <?php if($select_record["woman_haart"]=="N") { echo 'disabled="true"';} ?> class="form-control" value="<?php if($action == "edit"){echo $select_record["haart_start_date"];} ?>" name="haart_start_date" id="haart_start_date" >
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
                                            <label>Participant Outcome</label>
                                            <select id="participant_outcome" class="form-control" name="participant_outcome">
                                                <option value=""  selected="">Select  the outcome of the study participant</option>
                                                <option value="TO" <?php if($select_record["participant_outcome"]=="TO") { echo 'selected="selected"';} ?> >Transfer out</option>
                                                <option value="MD" <?php if($select_record["participant_outcome"]=="MD") { echo 'selected="selected"';} ?> >Maternal death</option>
                                                <option value="LF" <?php if($select_record["participant_outcome"]=="LF") { echo 'selected="selected"';} ?> >Lost to follow</option>
                                                <option value="D" <?php if($select_record["participant_outcome"]=="D"){ { echo 'selected="selected"';}} ?> >Discontinuation</option>
                                                <option value="W" <?php if($select_record["participant_outcome"]=="W"){ { echo 'selected="selected"';}} ?> >Withdrawal</option>
                                                <option value="ID" <?php if($select_record["participant_outcome"]=="ID") { echo 'selected="selected"';} ?> >Infant death</option>
                                                <option value="SB" <?php if($select_record["participant_outcome"]=="SB") { echo 'selected="selected"';} ?> >Still Birth</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Outcome date</label>
                                            <input max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["outdate"];} ?>" name="outdate"  >
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
                                    </form>
                                
                                <!-- /.col-lg-6 (nested) -->
                               <?php } else if($action == "delete") {
                                         if($db->deleteDemographics($demographic_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Identifiers and Demographics deleted!</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Identifiers and Demographics  was not deleted.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
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
