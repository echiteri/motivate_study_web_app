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

    <title>Other woman's variables form</title>

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
        function toggleFpStatus(){
            if (document.getElementById("status").value !== "NO FP")
            {
                document.getElementById("c").disabled = false;
                document.getElementById("ecp").disabled = false;
                document.getElementById("oc").disabled = false;
                document.getElementById("inj").disabled = false;
                document.getElementById("imp").disabled = false;
                document.getElementById("iud").disabled = false;
                document.getElementById("lam").disabled = false;
                document.getElementById("d").disabled = false;
                document.getElementById("fa").disabled = false;
                document.getElementById("tl").disabled = false;
                document.getElementById("v").disabled = false;
                document.getElementById("undtl").disabled = false;
                document.getElementById("no").disabled = false;
                alert("it has been set to false");

            }else
            {
                document.getElementById("c").disabled = true;
                document.getElementById("ecp").disabled = true;
                document.getElementById("oc").disabled = true;
                document.getElementById("inj").disabled = true;
                document.getElementById("imp").disabled = true;
                document.getElementById("iud").disabled = true;
                document.getElementById("lam").disabled = true;
                document.getElementById("d").disabled = true;
                document.getElementById("fa").disabled = true;
                document.getElementById("tl").disabled = true;
                document.getElementById("v").disabled = true;
                document.getElementById("undtl").disabled = true;
                document.getElementById("no").disabled = true;            
                alert("it has been set to true");
            }
        }
        
        function togglePregStatus(){
             if (document.getElementById("preg_status").value === "AB" || document.getElementById("preg_status").value === "MC")
                {
                    document.getElementById("edd_date").disabled = false;
                } 
            else
                {
                    document.getElementById("edd_date").disabled = true;

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
                    <h1 class="page-header">Other woman's variables form</h1>
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
                                $variables_id = $_REQUEST['id'];
                                $action = $_REQUEST['action'];
                                $table = "variables";
                                $tbl_id = "variables_id";
                                $db = new db_transactions();
                                $fp_method = getFpMethods();
                                if($mode == "variables")
                                    {
                                    $v_study_id = $_POST['v_study_id'];
                                    $weight= $_POST['weight'];
                                    $height = $_POST['height'];
                                    $hemoglobin = $_POST['hemoglobin'];
                                    $hemoglobin_date= $_POST['hemoglobin_date'];
                                    $tb_status = $_POST['tb_status'];
                                    $preg_status = $_POST['preg_status'];
                                    $edd = $_POST['edd'];
                                    $fp_status = $_POST['fp_status'];
                                    //$fp_method = $_POST['fp_method'];
                                    $disclosure = $_POST['disclosure'];
                                    $patner_tested = $_POST['patner_tested'];
                                    $btn = $_POST['btn'];
                                    
                                    
                                        $variables = array(
                                            $v_study_id, $weight, $height, $hemoglobin, $hemoglobin_date,
                                            $tb_status, $preg_status, $edd, $fp_status, $fp_method, 
                                            $disclosure, $patner_tested
                                            );
                                        if ($btn == "submit")
                                        {
                                             if($db->insertVariables($variables)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Variables recorded successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Variables was not recorded.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        } else if ($btn == "update"){
                                            if($db->editVariables($variables, $variables_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Variables updated successfully</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Variables was not updated.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
                                                }
                                        }
                                       
                                    }
                                if ($action == "add" || $action == "edit") {
                                        $select_record = $db->selectRecord($table, $tbl_id, $variables_id);
                                    ?>
                            <div class="row">
                                    
                                    <form role="form" action="variables.php?id=<?php echo $variables_id;?>" method="post">
                                     <div class="col-lg-6">
                                         <button type="button" onclick="window.location.href='women_variables.php'" class="btn btn-outline btn-primary btn-xs">Back</button><br><br>
                                        <input type="hidden" name="mode" value="variables" />
                                        <div class="form-group">
                                            <label>Participant Study ID</label>
                                            <input class="form-control" value="<?php if($action == "edit"){echo $select_record["v_study_id"];} ?>" placeholder="Enter participant study identification number" name="v_study_id" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Weight (Kgs)</label>
                                            <input type="number" step="any" min="0" class="form-control" value="<?php if($action == "edit"){echo $select_record["weight"];} ?>" placeholder="Enter measurement of how heavy the participant is" name="weight" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Height(cms)</label>
                                            <input type="number" step="any" min="0" class="form-control" value="<?php if($action == "edit"){echo $select_record["height"];} ?>" placeholder="Enter measurement of how tall the participant is" name="height" required="TRUE" autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label>Hemoglobin</label>
                                            <input type="number" step="any" min="0" class="form-control" value="<?php if($action == "edit"){echo $select_record["hemoglobin"];} ?>" placeholder="Enter measurement of level of hemoglobin in the participant's blood" name="hemoglobin" required="TRUE" >
                                        </div>
                                        <div class="form-group">
                                            <label>Hemoglobin date</label>
                                            <input max="<?php echo date("Y-m-d");?>" type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["hemoglobin_date"];} ?>" name="hemoglobin_date" required="TRUE" >
                                        </div>
                                         <div class="form-group">
                                            <label>TB Status</label>
                                            <select class="form-control" name="tb_status">
                                                <option value="" selected="">Select participants status of a TB infection </option>
                                                <option value="No Signs" <?php if($select_record["tb_status"]=="No Signs") { echo 'selected="selected"';} ?>>No signs or symptoms of TB</option>
                                                <option value="Suspect" <?php if($select_record["tb_status"]=="Suspect") { echo 'selected="selected"';} ?>>TB referral or sputum sent</option>
                                                <option value="ND" <?php if($select_record["tb_status"]=="ND") { echo 'selected="selected"';} ?>>Not assessed for TB</option>
                                                <option value="TB Rx" <?php if($select_record["tb_status"]=="TB Rx") { echo 'selected="selected"';} ?>>currently on TB treatment</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Pregnancy status</label>
                                            <select onchange="togglePregStatus()"  id="preg_status" class="form-control" id="preg" name="preg_status">
                                                <option value="" selected="">Select Pregnancy status of the client</option>
                                                <option value="P" <?php if($select_record["preg_status"]=="P") { echo 'selected="selected"';} ?>>ANC Number</option>
                                                <option value="PD" <?php if($select_record["preg_status"]=="PD") { echo 'selected="selected"';} ?>>EDD</option>
                                                <option value="AB" <?php if($select_record["preg_status"]=="AB") { echo 'selected="selected"';} ?>>Abortion</option>
                                                <option value="MC" <?php if($select_record["preg_status"]=="MC") { echo 'selected="selected"';} ?>>Miscarriage</option>
                                            </select>
                                        </div>
                                         <div class="form-group">
                                            <label>EDD</label>
                                            <input type="date" class="form-control" value="<?php if($action == "edit"){echo $select_record["edd"];} ?>" id="edd_date"  name="edd" >
                                        </div>
                                         <div class="form-group">
                                            <label>FP status</label>
                                            <select id="status" onchange="toggleFpStatus()" class="form-control" name="fp_status">
                                                <option value="" selected="">Select whether the participant is using  Family planning methods</option>
                                                <option value="FP" <?php if($select_record["fp_status"]=="FP") { echo 'selected="selected"';} ?>>Currently on FP</option>
                                                <option value="NO FP" <?php if($select_record["fp_status"]=="NO FP") { echo 'selected="selected"';} ?>>Not on Family planning</option>
                                                <option value="WFP" <?php if($select_record["fp_status"]=="WFP") { echo 'selected="selected"';} ?>>Wants FP</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Family Planning Methods</label>
                                            <?php
                                            $arr = split(";", $select_record["fp_method"]);
                                            ?>
                                          <div class="checkbox">                        
                                            <label class="checkbox-inline">                                                
                                                <input type="checkbox" value="C" name="c" id="c" <?php if(in_array("C", $arr)) { echo 'checked="true"';} ?> >Condoms
                                            </label>
                                          </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                <input type="checkbox" value="ECP" name="ecp" id="ecp" <?php if(in_array("ECP", $arr)) { echo 'checked="true"';} ?> >Emergency contraceptives
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="OC" name="oc" id="oc" <?php if(in_array("OC", $arr)) { echo 'checked="true"';} ?> >Oral contraceptives
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="INJ" name="inj" id="inj" <?php if(in_array("INJ", $arr)) { echo 'checked="true"';} ?> >Injectable
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="IMP" name="imp" id="imp" <?php if(in_array("IMP", $arr)) { echo 'checked="true"';} ?> >Implant
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="IUD" name="iud" id="iud" <?php if(in_array("IUD", $arr)) { echo 'checked="true"';} ?> >Intrauterine device
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="LAM" name="lam" id="lam"<?php if(in_array("LAM", $arr)) { echo 'checked="true"';} ?> >Lactational Amenorrhea method
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="D" name="d" id="d" <?php if(in_array("D", $arr)) { echo 'checked="true"';} ?> >Diagphram
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="FA" name="fa" id="fa" <?php if(in_array("FA", $arr)) { echo 'checked="true"';} ?> >Fertility awareness
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="TL" name="tl" id="tl" <?php if(in_array("TL", $arr)) { echo 'checked="true"';} ?> >Tubal ligation
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="V" name="v" id="v" <?php if(in_array("V", $arr)) { echo 'checked="true"';} ?> >Vasectomy
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="UNDTL" name="undtl" id="undtl" <?php if(in_array("UNDTL", $arr)) { echo 'checked="true"';} ?> >undecided
                                                </label>
                                            </div>
                                            <div class="checkbox">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" value="NO" name="no" id="no" <?php if(in_array("NO", $arr)) { echo 'checked="true"';} ?> >None
                                                </label>
                                            </div>
                                        </div>
                                        
                                         <div class="form-group">
                                            <label>Disclosure</label>
                                            <p class="help-block">Select whether the participant has disclosed HIV status  or not</p>
                                            <label class="radio-inline">
                                                <input type="radio" name="disclosure" id="optionsRadiosInline1" value="Y" <?php if($select_record["disclosure"]=="Y") {echo 'checked="true"';} ?>>Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="disclosure" id="optionsRadiosInline2" value="N" <?php if($select_record["disclosure"]=="N") {echo 'checked="true"';} ?>>No
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label>Partner tested</label>
                                            <p class="help-block">Select whether the participant's partner was tested for HIV</p>
                                            <label class="radio-inline">
                                                <input type="radio" name="patner_tested"  value="Y" <?php if($select_record["patner_tested"]=="Y") {echo 'checked="true"';} ?> >Yes
                                            </label>
                                            <label class="radio-inline">
                                                <input type="radio" name="patner_tested"  value="N" <?php if($select_record["patner_tested"]=="N") {echo 'checked="true"';} ?>>No
                                            </label>
                                            
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
                                         if($db->deleteVariables($variables_id)>0)
                                                {
                                                    echo '<label class="control-label" for="inputSuccess">Women Variables deleted!</label> <br \> Return to <a href="dashboard.php" >Dashboard</a>';
                                                } else {
                                                    echo '<label class="control-label" for="inputError">Women Variables was not deleted.</label><br \>Return to <a href="dashboard.php" >Dashboard</a>';
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

function getFpMethods()
{
    $method = "";
    if (isset($_POST["c"]).";")
    {  $method .= trim($_POST["c"]).";";  }
    if (isset($_POST["ecp"]))
    {  $method .= trim($_POST["ecp"]).";";  }
    if (isset($_POST["oc"]))
    {  $method .= trim($_POST["oc"]).";";  }
    if (isset($_POST["inj"]))
    {  $method .= trim($_POST["inj"]).";";  }
    if (isset($_POST["imp"]))
    {  $method .= trim($_POST["imp"]).";";  }
    if (isset($_POST["iud"]))
    {  $method .= trim($_POST["iud"]).";";  }
    if (isset($_POST["lam"]))
    {  $method .= trim($_POST["lam"]).";";  }
    if (isset($_POST["d"]))
    {  $method .= trim($_POST["d"]).";";  }
    if (isset($_POST["fa"]))
    {  $method .= trim($_POST["fa"]).";";  }
    if (isset($_POST["tl"]))
    {  $method .= trim($_POST["tl"]).";";  }
    if (isset($_POST["v"]))
    {  $method .= trim($_POST["v"]).";";  }
    if (isset($_POST["undtl"]))
    {  $method .= trim($_POST["undtl"]).";";  }
    if (isset($_POST["no"]))
    {  $method .= trim($_POST["no"]).";";  }
   $method = trim($method, ";");
   return $method;
}

?>