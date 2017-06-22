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

    <title>Early Infant Diagnosis</title>

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
                    <h1 class="page-header">Infant Diagnosis form</h1>
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <?php
                            $mode = $_REQUEST['mode'];
                            $Diag_id = $_REQUEST['id'];
                            $action = $_REQUEST['action'];
                            $hei_id = $_REQUEST['hei_id'];
                            $table = "infant_diagnosis";
                            $tbl_id = "diagnosis_id";
                            $db = new db_transactions();
                            $immunization = getImmunizations();
                            
                                if($mode == "diagnosis")
                                    {
                                    $hei_id = $_POST['hei_id'];
                                    $visit_date= $_POST['visit_date'];
                                    $weight= $_POST['weight'];
                                    $height = $_POST['height'];
                                    $tb_contact = $_POST['tb_contact'];
                                    $tb_ass_outcome = $_POST['tb_ass_outcome'];
                                    $inf_milestones = $_POST['inf_milestones'];
                                    $feeding_6wks = $_POST['feeding_6wks'];
                                    $feeding_10wks = $_POST['feeding_10wks'];
                                    $feeding_14wks = $_POST['feeding_14wks'];
                                    $feeding_6mths = $_POST['feeding_6mths'];
                                    $feeding_9mths = $_POST['feeding_9mths'];
                                    $feeding_12mths = $_POST['feeding_12mths'];
                                    $feeding_15mths = $_POST['feeding_15mths'];
                                    $feeding_18mths = $_POST['feeding_18mths'];
                                    $next_appointment = $_POST['next_appointment'];
                                    $btn = $_POST['btn'];
                                    $diagnosis = array(
                                            $hei_id, $visit_date, $weight, $height, $tb_contact, 
                                            $tb_ass_outcome,  $inf_milestones, $immunization, $feeding_6wks, $feeding_10wks, $feeding_14wks, $feeding_6mths,
                                            $feeding_9mths, $feeding_12mths, $feeding_15mths, $feeding_18mths, $next_appointment
                                                 );
                                              if ($btn == "submit")
                                        {
                                             if($db->insertInfantDiagnosis($diagnosis)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "update"){
                                            if($db->editInfantDiagnosis($diagnosis, $Diag_id))
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                    }
                                else if($mode == "DNA_PCR"){
                                    $first_sample_collection = $_POST['first_sample_collection'];
                                    $first_results_collected = $_POST['first_results_collected'];
                                    $first_results = $_POST['first_results'];
                                                                      
                                    $diagnosis = array($first_sample_collection, $first_results_collected, $first_results, $_SESSION["username"]); 

                                    if ($db->updateInfantHivTests($diagnosis, $Diag_id, "first", $mode))
                                    {
                                        echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                        echo '<br \>';
                                        echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                    } else {
                                        echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                        echo '<br \>';
                                        echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                    }
                                }
                                else if($mode == "RPT_PCR"){
                                    $second_sample_collection = $_POST['second_sample_collection'];
                                    $second_results_collected = $_POST['second_results_collected'];
                                    $second_results = $_POST['second_results'];
                                    $diagnosis = array($second_sample_collection, $second_results_collected, $second_results, $_SESSION["username"]);
                                        if ($db->updateInfantHivTests($diagnosis, $Diag_id, "second", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                else if($mode == "2ND_PCR"){
                                    $nd_pcr_sample = $_POST['2nd_pcr_sample_collection'];
                                    $nd_pcr_collect = $_POST['2nd_pcr_results_collected'];
                                    $nd_pcr_results = $_POST['2nd_pcr_results'];
                                    $diagnosis = array($nd_pcr_sample, $nd_pcr_collect, $nd_pcr_results, $_SESSION["username"]);
                                        if ($db->updateInfantHivTests($diagnosis, $Diag_id, "2nd_pcr", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                else if($mode == "3RD_PCR"){
                                    $rd_pcr_sample = $_POST['3nd_pcr_sample_collection'];
                                    $rd_pcr_collect = $_POST['3nd_pcr_results_collected'];
                                    $rd_pcr_results = $_POST['3nd_pcr_results'];
                                    $diagnosis = array($rd_pcr_sample, $rd_pcr_collect, $rd_pcr_results, $_SESSION["username"]);
                                        if ($db->updateInfantHivTests($diagnosis, $Diag_id, "3nd_pcr", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                else if($mode == "ANT_BDY"){
                                    $third_sample_collection = $_POST['third_sample_collection'];
                                    $third_results_collected = $_POST['third_results_collected'];
                                    $third_results = $_POST['third_results'];
                                    $diagnosis = array($third_sample_collection, $third_results_collected, $third_results, $_SESSION["username"]);
                                    if ($db->updateInfantHivTests($diagnosis, $Diag_id, "third", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                else if($mode == "CON_PCR"){
                                    $forth_sample_collection = $_POST['forth_sample_collection'];
                                    $forth_results_collected = $_POST['forth_results_collected'];
                                    $forth_results = $_POST['forth_results'];
                                    $diagnosis = array($forth_sample_collection, $forth_results_collected, $forth_results, $_SESSION["username"]);
                                    if ($db->updateInfantHivTests($diagnosis, $Diag_id, "forth", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                else if($mode == "RPT_CON_PCR"){
                                    $fifth_sample_collection = $_POST['fifth_sample_collection'];
                                    $fifth_results_collected = $_POST['fifth_results_collected'];
                                    $fifth_results = $_POST['fifth_results'];
                                    $diagnosis = array($fifth_sample_collection, $fifth_results_collected, $fifth_results, $_SESSION["username"]);
                                    if ($db->updateInfantHivTests($diagnosis, $Diag_id, "fifth", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                else if($mode == "ANT_BDY_18"){
                                    $sixth_sample_collection = $_POST['sixth_sample_collection'];
                                    $sixth_results_collected = $_POST['sixth_results_collected'];
                                    $sixth_results = $_POST['sixth_results'];
                                    $diagnosis = array($sixth_sample_collection, $sixth_results_collected, $sixth_results, $_SESSION["username"]);
                                    if ($db->updateInfantHivTests($diagnosis, $Diag_id, "sixth", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                else if($mode == "EXIT"){
                                    $hei_outcome = $_POST['hei_outcome'];
                                    $exit_date = $_POST['exit_date'];
                                    
                                    $diagnosis = array($hei_outcome, $exit_date, $_SESSION["username"]);
                                    if ($db->updateInfantHivTests($diagnosis, $Diag_id, "feeding", $mode))
                                        {
                                            echo '<label class="control-label" for="inputSuccess">Early Infant Diagnosis updated successfully!</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                        else 
                                        {
                                            echo '<label class="control-label" for="inputError">Early Infant Diagnosis was not updated.</label>';
                                            echo '<br \>';
                                            echo 'Return to <a href="dashboard.php" >Dashboard</a>';
                                        }
                                }
                                
                                if ($action == "add" || $action == "edit") {
                                        $select_record = $db->selectRecord($table, $tbl_id, $Diag_id);
                                    ?>
                        <div class="panel-heading">
                            Enter forms details <button type="button" onclick="window.location.href='infant_diagnosis.php?id=<?php echo $Diag_id;?>'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>
                        </div>
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#diagnosis" data-toggle="tab">Diagnosis</a>
                                </li>
                                <li><a href="#dna_pcr" data-toggle="tab">1st DNA PCR</a>
                                </li>
                                <li><a href="#rpt_pcr" data-toggle="tab">Repeat PCR </a>
                                </li>
                                </li>
                                <li><a href="#2nd_pcr" data-toggle="tab">2nd PCR at 6 months</a>
                                </li>
                                <li><a href="#3nd_pcr" data-toggle="tab">3rd PCR at 12 months</a>
                                </li>
                                <li><a href="#ant_bdy" data-toggle="tab">1st Antibody test</a>
                                </li>
                                <li><a href="#con_pcr" data-toggle="tab">Confirmatory PCR</a>
                                </li>
                                <li><a href="#rpt_con_pcr" data-toggle="tab">Repeat Conf PCR</a>
                                </li>
                                <li><a href="#ant_bdy_18" data-toggle="tab">Final Antibody</a>
                                </li>
                                <li><a href="#exit" data-toggle="tab">Exit</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                   <div class="tab-pane fade in active" id="diagnosis">
                                 <h4>Diagnosis Form</h4>
                                    
                            <div class="row">
                                <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post">
                                     <div class="col-lg-6">
                                        <input type="hidden" name="mode" value="diagnosis" />
                                         <div class="form-group">
                                            <label>HEI ID</label>
                                            <input class="form-control" value="<?php if($_REQUEST["action"] == "edit"){echo $hei_id;} else if($_REQUEST["action"] == "add"){ echo trim($hei_id);}?>" 
                                                   placeholder="Enter identification number of the infant" name="hei_id"  required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Date of infant visit</label>
                                            <input max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["visit_date"];} ?>" name="visit_date" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Infant weight (KG)</label>
                                            <input required="TRUE" type="number" step="any" min="0" value="<?php if($action == "edit"){echo $select_record["weight"];} ?>" class="form-control" 
                                                   placeholder="Enter weight of infant during visit date" name="weight"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Infant height (CM)</label>
                                            <input required="TRUE" type="number" step="any" min="0" class="form-control" value="<?php if($action == "edit"){echo $select_record["height"];} ?>" 
                                                   placeholder="Enter height of infant during visit date" name="height"  >
                                        </div>
                                        <div class="form-group">
                                            <label>TB contact in household</label>
                                            <p class="help-block">Select history of TB contact in household</p>
                                            <label class="radio-inline">
                                                <input required="TRUE" type="radio" name="tb_contact" id="optionsRadiosInline1" value="Y" <?php if($action == "edit"){if($select_record["tb_contact"]=="Y") {echo 'checked="true"';}}?>>Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" type="radio" name="tb_contact" id="optionsRadiosInline2" value="N" <?php if($action == "edit"){if($select_record["tb_contact"]=="N") {echo 'checked="true"';}} ?>>No
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>TB assessment outcome</label>
                                            <select required="TRUE" class="form-control" name="tb_ass_outcome">
                                                <option value=""  selected="selected">Select TB status</option>
                                                <option value="No signs" <?php if($action == "edit"){if($select_record["tb_ass_outcome"]=="No signs") { echo 'selected="selected"';}} ?>>No signs or symptoms of TB</option>
                                                <option value="Suspect" <?php if($action == "edit"){if($select_record["tb_ass_outcome"]=="Suspect") { echo 'selected="selected"';}} ?>>TB referral or sputum sent</option>
                                                <option value="TB Rx" <?php if($action == "edit"){if($select_record["tb_ass_outcome"]=="TB Rx") { echo 'selected="selected"';}} ?>>TB Rx</option>
                                                <option value="Not Done" <?php if($action == "edit"){if($select_record["tb_ass_outcome"]=="Not Done") { echo 'selected="selected"';}} ?>>Not Done</option>
                                                <option value="Confirmed" <?php if($action == "edit"){if($select_record["tb_ass_outcome"]=="Confirmed") { echo 'selected="selected"';}} ?>>Confirmed sputum +</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Infant milestones</label>
                                            <select required="TRUE" class="form-control" name="inf_milestones">
                                                <option value="" selected="selected">Select developmental milestones by age</option>
                                                <option value="N" <?php if($action == "edit"){if($select_record["inf_milestones"]=="N") { echo 'selected="selected"';}} ?>>Normal</option>
                                <option value="D" <?php if($action == "edit"){if($select_record["inf_milestones"]=="D") { echo 'selected="selected"';}} ?>>Delayed</option>
                                                <option value="R" <?php if($action == "edit"){if($select_record["inf_milestones"]=="R") { echo 'selected="selected"';}} ?>>Regressed</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Immunization history</label>
                                            <p class="help-block">Select immunizations received by infant</p>
                                            <?php
                                            $arr = [];
                                            $count = 0;
                                            if ($action == "add")//get previous given immunization
                                            {
                                                $immunization_administered = $db->selectDefinedRecords("imm_history", $table, "i_hei_id", $_REQUEST['hei_id']);
                                                //print_r($immunization_administered);
                                                foreach ($immunization_administered as $imm_admin)
                                                {
                                                    $arr_tmp = explode(";", $imm_admin['imm_history']);
                                                    $arr = array_merge($arr, $arr_tmp);
                                                }
                                            } else
                                            {
                                                $arr = explode(";", $select_record["imm_history"]);
                                            }
                                            
                                            ?>
                                            
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="BCG"  name="bcg" <?php if(in_array("BCG", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("BCG", $arr)) {echo 'checked="true" ';} ?> >BCG
                                                </label>
                                           </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="OPV at birth" name="opv" <?php if(in_array("OPV at birth", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("OPV at birth", $arr)) {echo 'checked="true"';} ?>>OPV at birth
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="OPV1" name="opv_1" <?php if(in_array("OPV1", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("OPV1", $arr)) {echo 'checked="true"';} ?>>OPV1
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline" >
                                                    <input type="checkbox" value="Pentavalent 1" name="pent1" <?php if(in_array("Pentavalent 1", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("Pentavalent 1", $arr)) {echo 'checked="true"';} ?>>Pentavalent 1
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="PCV-10-1" name="pcv_1" <?php if(in_array("PCV-10-1", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("PCV-10-1", $arr)) {echo 'checked="true"';} ?>>PCV-10-1
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="Rotavirus 1" name="rota_1" <?php if(in_array("Rotavirus 1", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("Rotavirus 1", $arr)) {echo 'checked="true"';} ?>>Rotavirus 1
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline" >
                                                    <input type="checkbox" value="Penta 2" name="pent_2" <?php if(in_array("Penta 2", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("Penta 2", $arr)) {echo 'checked="true"';} ?>>Penta 2
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="PCV 10-2" name="pcv_2" <?php if(in_array("PCV 10-2", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("PCV 10-2", $arr)) {echo 'checked="true"';} ?>>PCV 10-2
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="Rotavirus 2" name="rota_2" <?php if(in_array("Rotavirus 2", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("Rotavirus 2", $arr)) {echo 'checked="true"';} ?>>Rotavirus 2
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline" >
                                                    <input type="checkbox" value="OPV 2" name="opv_2" <?php if(in_array("OPV 2", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("OPV 2", $arr)) {echo 'checked="true"';} ?>>OPV 2
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="OPV 3" name="opv_3" <?php if(in_array("OPV 3", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("OPV 3", $arr)) {echo 'checked="true"';} ?>>OPV 3
                                                 </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="Penta 3" name="pent3" <?php if(in_array("Penta 3", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("Penta 3", $arr)) {echo 'checked="true"';} ?>>Penta 3
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline" >
                                                    <input type="checkbox" value="PCV 10-3" name="pcv_3" <?php if(in_array("PCV 10-3", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("PCV 10-3", $arr)) {echo 'checked="true"';} ?>>PCV 10-3
                                                </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="IPV" name="ipv" <?php if(in_array("IPV", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("IPV", $arr)) {echo 'checked="true"';} ?>>IPV
                                                 </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="Measles at 6 months" name="mea_6" <?php if(in_array("Measles at 6 months", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("Measles at 6 months", $arr)) {echo 'checked="true"';} ?>>Measles at 6 months
                                                 </label>
                                                </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline" >
                                                    <input type="checkbox" value="Measles at 9 months" name="mea_9" <?php if(in_array("Measles at 9 months", $arr) && $action =="add") {echo 'checked="true" disabled="true"';} else if(in_array("Measles at 9 months", $arr)) {echo 'checked="true"';} ?>>Measles at 9 months
                                                </label>
                                            </div>
                                        </div>
                                        <!-- infant feeding methods based of an infant age -->
                                        <div class="form-group">
                                        <?php
                                            /*$dob = date();
                                            $today = date("Y-m-d");
                                            $infant_registration_record = $db->selectDefinedRecords("birth_date", "infant_registration", "hei_id", $_REQUEST['hei_id']);
                                            $dia_visit_date = $db->selectDefinedRecords("visit_date", "infant_diagnosis", "diagnosis_id", $Diag_id);                                            
                                            foreach ($infant_registration_record as $rec)
                                            {
                                                if($dia_visit_date[0]["visit_date"] != NULL && $action == "edit")
                                                { 
                                                    $diff = abs(strtotime($dia_visit_date[0]["visit_date"]) - strtotime($rec["birth_date"]));
                                                } else
                                                {
                                                    $diff = abs(strtotime($today) - strtotime($rec["birth_date"]));
                                                }
                                                                                               
                                            }*/
                                            //$diff = abs(strtotime($today) - strtotime($dob));
                                            //echo $diff;//." Visit Date: ".$dia_visit_date[0]["visit_date"];
                                            //$weeks = $diff/(60*60*24*7);
                                            //$months = $diff/(60*60*24*30);
                                            //echo "Diagnosis ID: ". $Diag_id;
                                            //echo "Weeks: ".$weeks;
                                            //echo "< br/>Months: ".$months;
                                                                                        
                                         //if (($diff >= 1 && $weeks < 10)/* || $action == "add"*/)   { ?>  
                                        <label>Infant feeding method at 6 weeks</label>
                                            <?php
                                            $feed_arr = ['EBF','ERF','MF', 'NBF', 'BF'];

                                            ?>
                                            <select class="form-control" name="feeding_6wks">
                                                <option value="" selected="selected" >Select infant feeding method at 6 weeks</option>
                                                <option value="EBF" <?php if($select_record["feeding_6wks"]=="EBF") { echo 'selected="selected"';} ?>>Exclusive Breastfed</option>
                                                <option value="ERF" <?php if($select_record["feeding_6wks"]=="ERF") { echo 'selected="selected"';} ?>>Exclusive Replacement Fed</option>
                                                <option value="MF" <?php if($select_record["feeding_6wks"]=="MF") { echo 'selected="selected"';} ?>>Mixed Fed</option>
                                            </select> 
                                        <?php //} 
                                        
                                        //if ($weeks >= 10 && $weeks < 14)   { 
                                        ?> 
                                        <label>Infant feeding method at 10 weeks</label>
                                            <select class="form-control" name="feeding_10wks">
                                                <option value="" selected="selected">Select infant feeding method at 10 weeks</option>
                                               <option value="EBF" <?php if($select_record["feeding_10wks"]=="EBF") { echo 'selected="selected"';} ?>>Exclusive Breastfed</option>
                                                <option value="ERF" <?php if($select_record["feeding_10wks"]=="ERF") { echo 'selected="selected"';} ?>>Exclusive Replacement Fed</option>
                                                <option value="MF" <?php if($select_record["feeding_10wks"]=="MF") { echo 'selected="selected"';} ?>>Mixed Fed</option>
                                            </select> 
                                        <?php //} 
                                        //if ($weeks >= 14 && $weeks < 16)   { 
                                        ?> 
                                        <label>Infant feeding method at 14 weeks</label>
                                            <select  class="form-control" name="feeding_14wks">
                                                <option value="" selected="selected">Select infant feeding method at 14 weeks</option>
                                                <option value="EBF" <?php if($select_record["feeding_14wks"]=="EBF") { echo 'selected="selected"';} ?>>Exclusive Breastfed</option>
                                                <option value="ERF" <?php if($select_record["feeding_14wks"]=="ERF") { echo 'selected="selected"';} ?>>Exclusive Replacement Fed</option>
                                                <option value="MF" <?php if($select_record["feeding_14wks"]=="MF") { echo 'selected="selected"';} ?>>Mixed Fed</option>
                                            </select> 
                                        <?php
                                        //// } 
                                       // if ($weeks >= 16 && $months < 6)   { 
                                        ?> 
                                          <label>Infant feeding method at 6 months</label>
                                            <select class="form-control" name="feeding_6mths">
                                                <option value="" selected="selected">Select infant feeding method at 6 months</option>
                                                <option value="EBF" <?php if($select_record["feeding_14wks"]=="EBF") { echo 'selected="selected"';} ?>>Exclusive Breastfed</option>
                                                <option value="ERF" <?php if($select_record["feeding_14wks"]=="ERF") { echo 'selected="selected"';} ?>>Exclusive Replacement Fed</option>
                                                <option value="MF" <?php if($select_record["feeding_14wks"]=="MF") { echo 'selected="selected"';} ?>>Mixed Fed</option>
                                            </select>        
                                          <?php //} 
                                        //if ($months > 6 && $months < 9)   { 
                                          ?> 
                                          <label>Infant feeding method at 9 months</label>
                                            <select class="form-control" name="feeding_9mths">
                                                <option value="" selected="selected">Select infant feeding method at 9 months</option>
                                                <option value="BF" <?php if($select_record["feeding_9mths"]=="BF") { echo 'selected="selected"';} ?> >Breastfed</option>
                                                <option value="NBF" <?php if($select_record["feeding_9mths"]=="NBF") { echo 'selected="selected"';} ?>>Not Breastfed</option>
                                            </select> 
                                        <?php 
                                        ////} 
                                       // if ($months >= 9 && $months < 12)   { 
                                        ?> 
                                        <label>Infant feeding method at 12 months</label>
                                            <select class="form-control" name="feeding_12mths">
                                                <option value="" selected="selected">Select infant feeding method at 12 months</option>
                                                <option value="BF" <?php if($select_record["feeding_12mths"]=="BF") { echo 'selected="selected"';} ?> >Breastfed</option>
                                                <option value="NBF" <?php if($select_record["feeding_12mths"]=="NBF") { echo 'selected="selected"';} ?>>Not Breastfed</option>
                                            </select>                                     
                                        <?php
                                        //// } 
                                        //if ($months >= 12 && $months < 15)   { 
                                        ?> 
                                        <label>Infant feeding method at 15 months</label>
                                            <select class="form-control" name="feeding_15mths">
                                                <option value="" selected="selected">Select infant feeding method at 15 months</option>
                                                <option value="BF" <?php if($select_record["feeding_15mths"]=="BF") { echo 'selected="selected"';} ?> >Breastfed</option>
                                                <option value="NBF" <?php if($select_record["feeding_15mths"]=="NBF") { echo 'selected="selected"';} ?>>Not Breastfed</option>
                                            </select>
                                        <?php
                                        //// } 
                                        //if ($months >= 15 && $months < 18)   { 
                                        ?> 
                                        <label>Infant feeding method at 18 months</label>
                                            <select class="form-control" name="feeding_18mths">
                                                <option value="" selected="selected">Select infant feeding method at 18 months</option>
                                                <option value="BF" <?php if($select_record["feeding_18mths"]=="BF") { echo 'selected="selected"';} ?> >Breastfed</option>
                                                <option value="NBF" <?php if($select_record["feeding_18mths"]=="NBF") echo 'selected="selected"'; ?>>Not Breastfed</option>
                                            </select> 
                                        <?php
                                           // } 
                                        ?>
                                        
                                    </div>
                                        
                                        <!-- infant feeding methods ends -->
                                         <div class="form-group">
                                            <label>Date of next appointment</label>
                                            <input required="TRUE" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["next_appointment"];} ?>" name="next_appointment"  >
                                        </div>
                                         <?php if($action == "add") { ?>
                                            <button type="submit" name="btn" value="submit" class="btn btn-success">Submit</button>
                                        <?php } else if($action == "edit") { ?>
                                        <button type="update" name="btn" value="update" class="btn btn-success">Update</button>
                                        <?php } ?>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </div>
                                <!-- /.col-lg-6 (nested) -->
                                <div class="col-lg-6">
                                        
                                       </div>
                                    </form>
                                
                                <!-- /.col-lg-6 (nested) -->
                               
                            </div>
                            <!-- /.row (nested) -->
                            </div>
                                
                                <!-- 1st DNA PCR -->
                                <div class="tab-pane fade" id="dna_pcr">
                                    <h4>1st DNA PCR </h4>
                                   <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="DNA_PCR">
                                    <input type="hidden" name="mode" value="DNA_PCR" />

                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["first_sample_collection"];} ?>" name="first_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["first_results_collected"];} ?>" name="first_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select results of Infant's 1st DNA PCR</p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="first_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["first_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="first_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["first_results"]=="NEG") {echo 'checked="true"';} ?>>Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="first_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["first_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                            
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                 <!-- Repeat PCR (for rejections) -->
                                <div class="tab-pane fade" id="rpt_pcr">
                                    <h4>Repeat confirmatory PCR for rejection/ +ve</h4>
                                    <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="RPT_PCR">
                                        <input type="hidden" name="mode" value="RPT_PCR" />
                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["second_sample_collection"];} ?>" name="second_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["second_results_collected"];} ?>" name="second_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select results of Infant's repeat PCR</p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="second_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["second_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="second_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["second_results"]=="NEG") {echo 'checked="true"';} ?>>Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="second_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["second_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                 <!-- 2nd PCR at 6 months -->
                                <div class="tab-pane fade" id="2nd_pcr">
                                    <h4>2nd PCR at 6 months</h4>
                                    <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="2ND_PCR">
                                        <input type="hidden" name="mode" value="2ND_PCR" />
                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["2nd_pcr_sample_collection"];} ?>" name="2nd_pcr_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["2nd_pcr_results_collected"];} ?>" name="2nd_pcr_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select results of 2nd PCR at 6 months</p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="2nd_pcr_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["2nd_pcr_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="2nd_pcr_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["2nd_pcr_results"]=="NEG") {echo 'checked="true"';} ?>>Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="2nd_pcr_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["2nd_pcr_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                 
                                 <!-- 3rd PCR at 12 months -->
                                <div class="tab-pane fade" id="3nd_pcr">
                                    <h4>3rd PCR at 12 months</h4>
                                    <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="3RD_PCR">
                                        <input type="hidden" name="mode" value="3RD_PCR" />
                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["3nd_pcr_sample_collection"];} ?>" name="3nd_pcr_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["3nd_pcr_results_collected"];} ?>" name="3nd_pcr_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select results of 3nd PCR at 12 months</p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="3nd_pcr_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["3nd_pcr_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="3nd_pcr_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["3nd_pcr_results"]=="NEG") {echo 'checked="true"';} ?>>Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="3nd_pcr_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["3nd_pcr_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                  <!-- 1st Antibody test at 9 months -->
                                <div class="tab-pane fade" id="ant_bdy">
                                    <h4>1st Antibody test at 9 months</h4>
                                    <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="ANT_BDY">
                                        <input type="hidden" name="mode" value="ANT_BDY" />
                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["third_sample_collection"];} ?>" name="third_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["third_results_collected"];} ?>" name="third_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select results of 1st Antibody test  </p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="third_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["third_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="third_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["third_results"]=="NEG") {echo 'checked="true"';} ?>> Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="third_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["first_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button> 
                                    </form>
                                </div>
                                   <!-- Confirmatory PCR if Antibody is positive -->
                                <div class="tab-pane fade" id="con_pcr">
                                    <h4>Confirmatory PCR if Antibody is positive</h4>
                                   <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="CON_PCR">
                                       <input type="hidden" name="mode" value="CON_PCR" />
                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["forth_sample_collection"];} ?>" name="forth_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["forth_sample_collection"];} ?>" name="forth_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select results of confirmatory PCR </p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="forth_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["forth_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="forth_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["forth_results"]=="NEG") {echo 'checked="true"';} ?>>Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="forth_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["first_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                    <!-- Repeat confirmatory PCR (For rejections) -->
                                <div class="tab-pane fade" id="rpt_con_pcr">
                                    <h4>Repeat PCR (For rejections/ +ve)</h4>
                                    <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="RPT_CON_PCR">
                                        <input type="hidden" name="mode" value="RPT_CON_PCR" />
                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["fifth_results_collected"];} ?>" name="fifth_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["fifth_results_collected"];} ?>" name="fifth_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select result of confirmatory PCR</p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="fifth_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["fifth_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="fifth_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["fifth_results"]=="NEG") {echo 'checked="true"';} ?>>Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="fifth_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["first_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                     <!-- Final antibody test at 18 months -->
                                <div class="tab-pane fade" id="ant_bdy_18">
                                    <h4>Final antibody test at 18 months</h4>
                                    <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="ANT_BDY_18">
                                        <input type="hidden" name="mode" value="ANT_BDY_18" />
                                    <div class="form-group">
                                        <label>Date of sample collection</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["sixth_sample_collection"];} ?>" name="sixth_sample_collection"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Date results collected</label>
                                        <input required="TRUE"  max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["sixth_results_collected"];} ?>" name="sixth_results_collected"  >
                                    </div>
                                    <div class="form-group">
                                        <label>Results</label>
                                        <p class="help-block">Select results of final antibody test</p>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="sixth_results" id="optionsRadiosInline1" value="POS" <?php if($select_record["sixth_results"]=="POS") {echo 'checked="true"';} ?>>Positive
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="sixth_results" id="optionsRadiosInline2" value="NEG" <?php if($select_record["sixth_results"]=="NEG") {echo 'checked="true"';} ?>>Negative
                                        </label>
                                        <label class="radio-inline">
                                            <input required="TRUE"  type="radio" name="sixth_results" id="optionsRadiosInline3" value="REJ" <?php if($select_record["first_results"]=="REJ") {echo 'checked="true"';} ?>>Rejected
                                        </label>
                                        
                                    </div>
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                      <!-- Date at exit -->
                                <div class="tab-pane fade" id="exit">
                                    <h4>HEI outcome at exit</h4>
                                    <form role="form" action="diagnosis.php?id=<?php echo $Diag_id;?>" method="post" id="EXIT">
                                        <input type="hidden" name="mode" value="EXIT" />
                                        <div class="form-group">
                                            <label>Date at exit</label>
                                            <input required="TRUE" max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["exit_date"];} ?>" name="exit_date"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Final HEI outcome at exit</label>
                                            <select required="TRUE" class="form-control" name="hei_outcome">
                                                <option value="" selected="selected">Select HEI outcome at exit</option>
                                                <option value="1" <?php if($select_record["hei_outcome"]=="1") { echo 'selected="selected"';} ?>>Discharged  at 18 months </option>
                                                <option value="2" <?php if($select_record["hei_outcome"]=="2") { echo 'selected="selected"';} ?>>Referred to CCC </option>
                                                <option value="3" <?php if($select_record["hei_outcome"]=="3") { echo 'selected="selected"';} ?>>Transfer out</option>
                                                <option value="4" <?php if($select_record["hei_outcome"]=="4") { echo 'selected="selected"';} ?>>Lost to follow up</option>
                                                <option value="5" <?php if($select_record["hei_outcome"]=="5") { echo 'selected="selected"';} ?>>Dead</option>
                                            </select>
                                        </div>
                                       
                                        <button type="update" class="btn btn-success">Update</button>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                            <?php } else if($action == "delete") {
                                         if($db->deleteInfantDiagnosis($Diag_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Infant Diagnosis deleted!</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Infant Diagnosis was not deleted.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                    }?>
                        <!-- /.panel-body -->
                    </div><!-- chedk here -->
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
<?php
function getImmunizations()
{
    $immunization = "";
    if (isset($_POST["bcg"]).";")
    {  $immunization .= trim($_POST["bcg"]).";";  }
    if (isset($_POST["opv"]))
    {  $immunization .= trim($_POST["opv"]).";";  }
    if (isset($_POST["opv_1"]))
    {  $immunization .= trim($_POST["opv_1"]).";";  }
    if (isset($_POST["pent1"]))
    {  $immunization .= trim($_POST["pent1"]).";";  }
    if (isset($_POST["pcv_1"]))
    {  $immunization .= trim($_POST["pcv_1"]).";";  }
    if (isset($_POST["rota_1"]))
    {  $immunization .= trim($_POST["rota_1"]).";";  }
    if (isset($_POST["pent_2"]))
    {  $immunization .= trim($_POST["pent_2"]).";";  }
    if (isset($_POST["pcv_2"]))
    {  $immunization .= trim($_POST["pcv_2"]).";";  }
    if (isset($_POST["rota_2"]))
    {  $immunization .= trim($_POST["rota_2"]).";";  }
    if (isset($_POST["opv_2"]))
    {  $immunization .= trim($_POST["opv_2"]).";";  }
    if (isset($_POST["opv_3"]))
    {  $immunization .= trim($_POST["opv_3"]).";";  }
    if (isset($_POST["pent3"]))
    {  $immunization .= trim($_POST["pent3"]).";";  }
    if (isset($_POST["pcv_3"]))
    {  $immunization .= trim($_POST["pcv_3"]).";";  }
    if (isset($_POST["ipv"]))
    {  $immunization .= trim($_POST["ipv"]).";";  }
     if (isset($_POST["mea_6"]))
    {  $immunization .= trim($_POST["mea_6"]).";";  }
    if (isset($_POST["mea_9"]))
    {  $immunization .= trim($_POST["mea_9"]).";";  }
   $immunization = trim($immunization, ";");
   return $immunization;
 }
