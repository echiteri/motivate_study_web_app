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

    <title>Adherence of women form</title>

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
   function toggleCd4(){
             if (document.getElementById("optionsRadiosInline1").checked)
            {
                document.getElementById("cd4_count_id").disabled = false;
                document.getElementById("cd4_date_id").disabled = false;
            }else if (document.getElementById("optionsRadiosInline2").checked)
            {
                document.getElementById("cd4_count_id").disabled = true;
                document.getElementById("cd4_date_id").disabled = true;
            }else if (document.getElementById("optionsRadiosInline6").checked)
            {
                document.getElementById("cd4_count_id").disabled = true;
                document.getElementById("cd4_date_id").disabled = true;
            }else if (document.getElementById("optionsRadiosInline9").checked)
            {
                document.getElementById("cd4_count_id").disabled = true;
                document.getElementById("cd4_date_id").disabled = true;
            }                         
        }
   function toggleHaartChange(){
            
        if (document.getElementById("optionsRadiosInline7").checked)
            {
                document.getElementById("haart_regimen").disabled = false;
                document.getElementById("haart_change_date").disabled = false;
            }else if (document.getElementById("optionsRadiosInline8").checked)
            {
                document.getElementById("haart_regimen").disabled = true;
                document.getElementById("haart_change_date").disabled = true;
            }                      
        }
   function toggleVl(){
             if (document.getElementById("optionsRadiosInline3").checked)
            {
                document.getElementById("viral_load_id").disabled = false;
                document.getElementById("viral_date_id").disabled = false;
            }else if (document.getElementById("optionsRadiosInline4").checked)
            {
                document.getElementById("viral_load_id").disabled = true;
                document.getElementById("viral_date_id").disabled = true;
            }else if (document.getElementById("optionsRadiosInline5").checked)
            {
                document.getElementById("viral_load_id").disabled = true;
                document.getElementById("viral_date_id").disabled = true;
            }else if (document.getElementById("optionsRadiosInline10").checked)
            {
                document.getElementById("viral_load_id").disabled = true;
                document.getElementById("viral_date_id").disabled = true;
            }             
        }
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

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Adherence of women form</h1>
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
                                $adherence_id = $_REQUEST['id'];
                                $action = $_REQUEST['action'];
                                $table = "adherence";
                                $tbl_id = "adherence_id";
                                $db = new db_transactions();
                                $art_effect = getArtSideEffect();
                                //echo $art_effect;
                                
                                if($mode == "adherence")
                                    {
                                    $a_study_id = $_POST['a_study_id'];
                                    $visit = $_POST['visit_date'];
                                    $haart_change = $_POST['haart_change'];
                                    $haart_change_date= $_POST['haart_change_date'];
                                    $haart_regimen = $_POST['haart_regimen'];
                                    //$art_effect = $_POST['art_effect'];
                                    $self_art_adherence = $_POST['self_art_adherence'];
                                    $self_ctx_adherence = $_POST['self_ctx_adherence'];
                                    $cd4_taken = $_POST['cd4_taken'];
                                    if ($cd4_taken == "NA" || $cd4_taken == "N" || $cd4_taken == "NV")
                                    { $cd4_count = 'NULL'; }
                                    else { $cd4_count = $_POST['cd4_count']; }
                                    $cd4_date = $_POST['cd4_date'];
                                    $vl_taken = $_POST['vl_taken'];
                                    if($vl_taken == "NA" || $vl_taken == "N" || $vl_taken == "NV")
                                    { $viral_load = 'NULL';}
                                    else {$viral_load = $_POST['viral_load'];}
                                    $viral_date = $_POST['viral_date'];
                                    $who_stage = $_POST['who_stage'];
                                    $btn = $_POST['btn'];
                                    $next_visit = $_POST['next_visit_date'];
                                    $adherence = array(
                                            $a_study_id,$visit, $haart_change, $haart_change_date, $haart_regimen , $art_effect,
                                            $self_art_adherence, $self_ctx_adherence,$cd4_taken, $cd4_count, $cd4_date, $vl_taken,
                                            $viral_load, $viral_date, $who_stage, $next_visit
                                            );
                                        
                                        if ($btn == "submit")
                                        {
                                             if($db->insertAdherence($adherence)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Adherence recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Adherence was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "update"){
                                            if($db->editAdherence($adherence, $adherence_id)>0)
                                                    
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Adherence updated successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Adherence was not updated.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                       
                                    }
                               
                                if ($action == "add" || $action == "edit") {
                                     $select_record = $db->selectRecord($table, $tbl_id, $adherence_id);
                                     ?>
                            <div class="row">
                                    <form role="form" action="adherence.php?id=<?php echo $adherence_id;?>" method="post">
                                     <div class="col-lg-6">
                                         <button type="button" onclick="window.location.href='women_adherence.php'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>
                                        <input type="hidden" name="mode" value="adherence" />
                                        <div class="form-group">
                                            <label>Participant Study ID</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["a_study_id"];} else if($_REQUEST["action"] == "add"){ echo trim($_REQUEST["study_id"]);} ?>" placeholder="Enter participant study identification number" name="a_study_id" required="TRUE" >
                                        </div>
                                         <div class="form-group">
                                            <label>Visit date</label>
                                            <input required="TRUE" max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["visit_date"];} ?>" name="visit_date">
                                        </div>
                                        <div class="form-group">
                                            <label>Has HAART regimen changed?</label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleHaartChange()" type="radio" name="haart_change" id="optionsRadiosInline7" value="Y" <?php if($select_record["haart_change"]=="Y") { echo 'checked="true"';} ?> >Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleHaartChange()" type="radio" name="haart_change" id="optionsRadiosInline8" value="N" <?php if($select_record["haart_change"]=="N") { echo 'checked="true"';} ?> >No
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Date of changing HAART</label>
                                            <input required="TRUE" <?php if($select_record["haart_change"]=="N") { echo 'disabled="true"';} ?> max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["haart_start_date"];} ?>"  name="haart_change_date" id="haart_change_date">
                                        </div>
                                         <div class="form-group">
                                            <label>HAART regimen</label>
                                            <select required="TRUE" <?php if($select_record["haart_change"]=="N") { echo 'disabled="true"';} ?> class="form-control" name="haart_regimen" id="haart_regimen">
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
                                            <label>Side effects of ART</label>
                                            <?php
                                            $arr = split(";", $select_record["art_effect"]);
                                            ?>
                                          <div class="checkbox">                                                                                           
                                            <label class="checkbox-inline">                                                
                                                <input type="checkbox" value="N" name="n" <?php if(in_array("N", $arr)) { echo 'checked="true"';} ?> >Nausea
                                            </label>
                                          </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="H" name="h" <?php if(in_array("H", $arr)) { echo 'checked="true"';} ?> >Headache
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="A" name="a" <?php if(in_array("A", $arr)) { echo 'checked="true"';} ?> >Anaemia
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="F" name="f" <?php if(in_array("F", $arr)) { echo 'checked="true"';} ?> >Fatigue
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="FAT" name="fat" <?php if(in_array("FAT", $arr)) { echo 'checked="true"';} ?> >FAT Changes
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="BN" name="bn" <?php if(in_array("BN", $arr)) { echo 'checked="true"';} ?> >Burning
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="CNS" name="cns"<?php if(in_array("CNS", $arr)) { echo 'checked="true"';} ?> >Dizzy/Nightmares/Anxiety
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="R" name="r" <?php if(in_array("R", $arr)) { echo 'checked="true"';} ?> >Rash
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="D" name="d" <?php if(in_array("D", $arr)) { echo 'checked="true"';} ?> >Diarrhoea
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="J" name="j" <?php if(in_array("J", $arr)) { echo 'checked="true"';} ?> >Jaundice
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="AB" name="ab" <?php if(in_array("AB", $arr)) { echo 'checked="true"';} ?> >Abdominal pain
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="NO" name="no" <?php if(in_array("NO", $arr)) { echo 'checked="true"';} ?> >None
                                            </label>
                                           </div>
                                        </div>
                                            <div class="form-group">
                                            <label>Self reported ART adherence.</label>
                                            <select required="TRUE" class="form-control" name="self_art_adherence">
                                                
                                                <option value="" selected="">Select participant's self report of taking ART exactly as prescribed</option>
                                                <option value="G" <?php if($select_record["self_art_adherence"]=="G") { echo 'selected="selected"';} ?> >Good (>95%)</option>
                                                <option value="F" <?php if($select_record["self_art_adherence"]=="F") { echo 'selected="selected"';} ?> >Fair (85% - 94%)</option>
                                                <option value="P" <?php if($select_record["self_art_adherence"]=="P") { echo 'selected="selected"';} ?> >Poor (<85%)</option> 
                                                <option value="NI" <?php if($select_record["self_art_adherence"]=="NI") { echo 'selected="selected"';} ?> >Newly Initiated</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Self reported CTX adherence</label>
                                            <select required="TRUE" class="form-control" name="self_ctx_adherence">
                                                <option value="" selected="">Select participant's self report of taking septrin(CTX) exactly as prescribed</option>
                                                <option value="G" <?php if($select_record["self_ctx_adherence"]=="G") { echo 'selected="selected"';} ?> >Good (>95%)</option>
                                                <option value="F" <?php if($select_record["self_ctx_adherence"]=="F") { echo 'selected="selected"';} ?> >Fair (85% - 94%)</option>
                                                <option value="P" <?php if($select_record["self_ctx_adherence"]=="P") { echo 'selected="selected"';} ?> >Poor (<85%)</option> 
                                                <option value="NI" <?php if($select_record["self_ctx_adherence"]=="NI") { echo 'selected="selected"';} ?> >Newly Initiated</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>CD 4 taken</label>
                                            <p class="help-block">Select whether CD 4 was taken or not</p>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleCd4()" type="radio" name="cd4_taken" id="optionsRadiosInline1" value="Y" <?php if($select_record["cd4_taken"]=="Y") { echo 'checked="true"';} ?> >Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleCd4()" type="radio" name="cd4_taken" id="optionsRadiosInline2" value="N" <?php if($select_record["cd4_taken"]=="N") { echo 'checked="true"';} ?> >No
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleCd4()" type="radio" name="cd4_taken" id="optionsRadiosInline6" value="NA" <?php if($select_record["cd4_taken"]=="NA") { echo 'checked="true"';} ?> >NA
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleCd4()" type="radio" name="cd4_taken" id="optionsRadiosInline9" value="NV" <?php if($select_record["cd4_taken"]=="NV") { echo 'checked="true"';} ?> >Not Available
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>CD4 count</label>
                                            <input required="TRUE" <?php if($select_record["cd4_taken"]=="NA" || $select_record["cd4_taken"]=="N" || $select_record["cd4_taken"]=="NV") { echo 'disabled="true"';} ?> id="cd4_count_id" type="number" step="any" min="0" class="form-control" placeholder="Enter the number of CD4 T lymphocytes (CD4 cells) in a sample of blood" value="<?php if($action == "edit"){echo $select_record["cd4_count"];} ?>" name="cd4_count" >
                                        </div>
                                        <div class="form-group">
                                            <label>CD4 Date</label>
                                            <input required="TRUE" <?php if($select_record["cd4_taken"]=="NA" || $select_record["cd4_taken"]=="N" || $select_record["cd4_taken"]=="NV") { echo 'disabled="true"';} ?> id="cd4_date_id" max="<?php echo date("Y-m-d");?>" type="date"class="form-control"  value="<?php if($action == "edit"){echo $select_record["cd4_date"];} ?>"  name="cd4_date">
                                        </div>
                                        <div class="form-group">
                                            <label>Viral Load taken</label>
                                            <p class="help-block">Select whether viral load was taken or not</p>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleVl()" type="radio" name="vl_taken" id="optionsRadiosInline3" value="Y" <?php if($select_record["vl_taken"]=="Y") { echo 'checked="true"';} ?> >Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleVl()" type="radio" name="vl_taken" id="optionsRadiosInline4" value="N" <?php if($select_record["vl_taken"]=="N") { echo 'checked="true"';} ?> >No
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleVl()" type="radio" name="vl_taken" id="optionsRadiosInline5" value="NA" <?php if($select_record["vl_taken"]=="NA") { echo 'checked="true"';} ?> >NA
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" onclick="toggleVl()" type="radio" name="vl_taken" id="optionsRadiosInline10" value="NV" <?php if($select_record["vl_taken"]=="NV") { echo 'checked="true"';} ?> >Not Available
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Viral load </label>
                                            <input required="TRUE" <?php if($select_record["vl_taken"]=="NA" || $select_record["vl_taken"]=="N" || $select_record["vl_taken"]=="NV") { echo 'disabled="true"';} ?> type="text" id="viral_load_id" class="form-control" placeholder="Enter amount of HIV in a sample of blood reported as the number of HIV RNA copies per milliliter of blood"  value="<?php if($action == "edit"){echo $select_record["viral_load"];} ?>" name="viral_load">
                                        </div>
                                        <div class="form-group">
                                            <label>Viral load date</label>
                                            <input required="TRUE" <?php if($select_record["vl_taken"]=="NA" || $select_record["vl_taken"]=="N" || $select_record["vl_taken"]=="NV") { echo 'disabled="true"';} ?> id="viral_date_id" max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["viral_date"];} ?>" name="viral_date" >
                                        </div>
                                           <div class="form-group">
                                            <label>WHO Stage</label>
                                            <select required="TRUE" class="form-control" name="who_stage">
                                                <option value="" selected="">Select The clinical staging and case definition of HIV</option>
                                                <option value="WHO stage I" <?php if($select_record["who_stage"]=="WHO stage I") { echo 'selected="selected"';} ?> >WHO stage I</option>
                                                <option value="WHO stage II" <?php if($select_record["who_stage"]=="WHO stage II") { echo 'selected="selected"';} ?>>WHO stage II</option>
                                                <option value="WHO stage III"<?php if($select_record["who_stage"]=="WHO stage III") { echo 'selected="selected"';} ?>>WHO stage III</option>
                                                <option value="WHO stage IV"<?php if($select_record["who_stage"]=="WHO stage IV") { echo 'selected="selected"';} ?>>WHO stage IV</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Next Visit date</label>
                                            <input required="TRUE" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["next_visit_date"];} ?>" name="next_visit_date" >
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
                                
                                <!-- /.col-lg-6 (nested) -->
                               <?php } else if($action == "delete") {
                                         if($db->deleteAdherence($adherence_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Adherence deleted!</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Adherence was not deleted.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
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
function getArtSideEffect()
{    
    $art_effects = "";
    if (isset($_POST["h"]).";")
    {  $art_effects .= trim($_POST["n"]).";";  }
    if (isset($_POST["n"]).";")
    {  $art_effects .= trim($_POST["h"]).";";  }
    if (isset($_POST["a"]))
    {  $art_effects .= trim($_POST["a"]).";";  }
    if (isset($_POST["f"]))
    {  $art_effects .= trim($_POST["f"]).";";  }
    if (isset($_POST["fat"]))
    {  $art_effects .= trim($_POST["fat"]).";";  }
    if (isset($_POST["bn"]))
    {  $art_effects .= trim($_POST["bn"]).";";  }
    if (isset($_POST["cns"]))
    {  $art_effects .= trim($_POST["cns"]).";";  }
    if (isset($_POST["r"]))
    {  $art_effects .= trim($_POST["r"]).";";  }
    if (isset($_POST["d"]))
    {  $art_effects .= trim($_POST["d"]).";";  }
    if (isset($_POST["j"]))
    {  $art_effects .= trim($_POST["j"]).";";  }
    if (isset($_POST["ab"]))
    {  $art_effects .= trim($_POST["ab"]).";";  }
    if (isset($_POST["no"]))
    {  $art_effects .= trim($_POST["no"]).";";  }
   $art_effects = trim($art_effects, ";");
   return $art_effects;
 }