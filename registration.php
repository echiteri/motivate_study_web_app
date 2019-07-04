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

    <title>Early Infant Registration</title>

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
     <script>
        function enableToggle(){
            if (document.getElementById("arv_pro").value == "5")
            {
                document.getElementById("other").disabled = false;
            }else
            {
                document.getElementById("other").disabled = true;
            }
        }
    </script>
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

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Infant Registration form</h1>
                    <div class="panel panel-default">
                        
                        <!-- /.panel-heading -->
                        <?php
                            $mode = $_REQUEST['mode'];
                            $reg_id = $_REQUEST['reg_id'];
                            $id = $_REQUEST['id'];
                            $action = $_REQUEST['action'];
                            $table = "infant_registration";
                            $tbl_id = "id";
                            $db = new db_transactions();
                                if($mode == "registration")
                                    {
                                    $hei_id = $_POST['hei_id'];
                                    $d_study_id = $_POST['d_study_id'];
                                    $birth_date = $_POST['birth_date'];
                                    $birth_weight = $_POST['birth_weight'];
                                    $sex = $_POST['sex'];
                                    $delivery_place = $_POST['delivery_place'];
                                    $arv_prophylaxis = $_POST['arv_prophylaxis'];
                                    $arv_pro_other= $_POST['arv_pro_other'];
                                    $enrol_date = $_POST['enrol_date'];
                                    $enrol_age = $_POST['enrol_age'];
                                    $participant_outcome = $_POST['participant_outcome'];
                                    $outdate = $_POST['outdate'];
                                    $btn = $_POST['btn'];
                                    $registration = array(
                                             $hei_id, $d_study_id, $birth_date, $birth_weight, $sex, 
                                            $delivery_place, $arv_prophylaxis,  $arv_pro_other,
                                            $enrol_date, $enrol_age,$participant_outcome,$outdate);
                                              if ($btn == "submit")
                                        {
                                             if($db->insertInfantRegistration($registration)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Early Infant Registration recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Early Infant Registration was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "update"){
                                            if($db->editInfantRegistration($registration, $reg_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess"> Early Infant Registration updated successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError"> Early Infant Registration was not updated.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                    } 
                                    ?>
                            <?php   
                                if ($action == "add" || $action == "edit") {
                                        $select_record = $db->selectRecord($table, $tbl_id, $id);
                                    ?>
                        <div class="panel-heading">
                            Enter forms details <button type="button" onclick="window.location.href='infant_registration.php?id=<?php echo $reg_id;?>'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>
                        </div>
                        <div class="panel-body">
                            <!-- Nav tabs -->
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#registration" data-toggle="tab">Registration</a>
                                </li>
                            </ul>

                            <!-- Tab panes -->
                            <div class="tab-content">
                   <div class="tab-pane fade in active" id="registration">
                                 <h4>Infant Registration Form</h4>
                                    
                            <div class="row">
                                <form role="form" action="registration.php?id=<?php echo $reg_id;?>" method="post">
                                     <div class="col-lg-6">
                                        <input type="hidden" name="mode" value="registration" />
                                        <input type="hidden" name="reg_id" value="<?php echo $_REQUEST['id'];?>" />
                                        <div class="form-group">
                                            <label>Mother Study ID</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["d_study_id"];} else if($_REQUEST["action"] == "add"){ echo trim($_REQUEST["study_id"]);}?>"
                                                   placeholder="Enter participant study identification number" name="d_study_id" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>HEI ID</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["hei_id"];} ?>" 
                                                   placeholder="Enter identification number of the infant" name="hei_id" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Infant birth date</label>
                                            <input required="TRUE" max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["birth_date"];} ?>" name="birth_date"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Infant birth weight (KG)</label>
                                            <input required="TRUE" type="number" step="0.01" min="0" class="form-control" value="<?php if($action == "edit"){echo $select_record["birth_weight"];} ?>" 
                                                   placeholder="Enter weight of infant at birth" name="birth_weight"  autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Sex of infant</label>
                                            <p class="help-block">Select sexual/gender identity of infant</p>
                                            <label class="radio-inline">
                                                <input required="TRUE" type="radio" name="sex" id="optionsRadiosInline1" value="M" <?php if($select_record["sex"]=="M") { echo 'checked="TRUE"';} ?> >Male
                                            </label>
                                            <label class="radio-inline">
                                                <input required="TRUE" type="radio" name="sex" id="optionsRadiosInline2" value="F" <?php if($select_record["sex"]=="F") { echo 'checked="TRUE"';} ?>>Female
                                            </label>
                                             <label class="radio-inline">
                                                <input required="TRUE" type="radio" name="sex" id="optionsRadiosInline3" value="None">None
                                            </label> 
                                        </div>
                                        <div class="form-group">
                                            <label>Place of delivery</label>
                                            <select required="TRUE" class="form-control" name="delivery_place">
                                                <option value="" selected="">Select birth place of infant</option>
                                                <option value="HOS" <?php if($select_record["delivery_place"]=="HOS") { echo 'selected="selected"';} ?> >Hospital Delivery</option>
                                                <option value="HOME" <?php if($select_record["delivery_place"]=="HOME") { echo 'selected="selected"';} ?>>Home Delivery</option>
                                                <option value="OTHER" <?php if($select_record["delivery_place"]=="OTHER") { echo 'selected="selected"';} ?>>Other</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label>ARV Prophylaxis</label>
                                            <select required="TRUE" id="arv_pro" onclick="enableToggle();" class="form-control" name="arv_prophylaxis">
                                                <option value="" selected="">Select ARV regimen for PMTCT</option>
                                                <option value="1" <?php if($select_record["arv_prophylaxis"]=="1") { echo 'selected="selected"';} ?> >sdNVP only</option>
                                                <option value="2" <?php if($select_record["arv_prophylaxis"]=="2") { echo 'selected="selected"';} ?>>NVP for 7 days</option>
                                                <option value="3" <?php if($select_record["arv_prophylaxis"]=="3") { echo 'selected="selected"';} ?>>NVP for 6 weeks</option>
                                                <option value="6" <?php if($select_record["arv_prophylaxis"]=="6") { echo 'selected="selected"';} ?>>AZT for 6 weeks + NVP for 12 weeks</option>
                                                <option value="7" <?php if($select_record["arv_prophylaxis"]=="7") { echo 'selected="selected"';} ?>>NVP for 12 weeks</option>
                                                <option value="4" <?php if($select_record["arv_prophylaxis"]=="4") { echo 'selected="selected"';} ?>>None</option>
                                                <option value="5" <?php if($select_record["arv_prophylaxis"]=="5") { echo 'selected="selected"';} ?>>Other(specify)</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Specify Other</label>
                                            <input required="TRUE" id="other" disabled="disabled" class="form-control" value="<?php if($action == "edit"){echo $select_record["arv_pro_other"];} ?>" 
                                                   placeholder="Enter other ARV Prophylaxis" name="arv_pro_other"  >
                                        </div>
                                         <div class="form-group">
                                            <label>Date of enrollment in HEI follow-up</label>
                                            <input required="TRUE" max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["enrol_date"];} ?>" name="enrol_date"  >
                                        </div>
                                        <div class="form-group">
                                            <label>Age at enrollment(weeks)</label>
                                            <input required="TRUE"type="number" min="0" class="form-control" value="<?php if($action == "edit"){echo $select_record["enrol_age"];} ?>" 
                                                   placeholder="Enter age of the infant at enrollment" name="enrol_age"  >
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
                                        
                                         <?php if($action == "add") { ?>
                                            <button type="submit" name="btn" value="submit" class="btn btn-success">Submit</button>
                                        <?php } else if($action == "edit") { ?>
                                        <button type="update" name="btn" value="update" class="btn btn-success">Update</button>
                                        <?php } ?>
                                        <button type="reset" class="btn btn-warning">Clear</button>
                                       </div>
                                    </form>
                                
                                <!-- /.col-lg-6 (nested) -->
                               
                            </div>
                            <!-- /.row (nested) -->
                            </div>
                            </div>
                        </div>
                            <?php } else if($action == "delete") {
                                            if($db->deleteRecords($table, $tbl_id, $id)>0)
                                        // if($db->deleteInfantRegistration($reg_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Infant Registration deleted!</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Infant Registration was not deleted.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
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