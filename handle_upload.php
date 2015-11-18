<?php
//require_once 'google/appengine/api/cloud_storage/CloudStorageTools.php';
use google\appengine\api\cloud_storage\CloudStorageTools;



require_once("c_transactions.php");
$db = new db_transactions();
// SQL statements
$sql_demographics = "INSERT INTO demographics (study_id, abs_date, facility_id, anc_id, psc_id, visit_count, "
                        . "anc_visit_date, birth_date, residence, parity, gravida, gestational_period, lmp, edd,"
                        . " marital_status, hiv_status, initial_hiv_status, hiv_retest, woman_haart, haart_regimen, "
                        . "counselling, hiv_status_partner, return_date, user_initial) ";
$sql_infant_registration = "INSERT INTO infant_registration(hei_id, d_study_id, birth_date, birth_weight, "
        . "sex, delivery_place, arv_prophylaxis, arv_pro_other, enrol_date, enrol_age, user_initial) ";
$sql_adherence = "INSERT INTO adherence(a_study_id, visit_date, haart_start_date, haart_regimen, art_effect, "
        . "self_art_adherence, self_ctx_adherence, cd4_taken, cd4_count, cd4_date, vl_taken, viral_load, "
        . "viral_date, who_stage, user_initial, next_visit_date) ";
$sql_variables = "INSERT INTO variables(v_study_id, visit_date, weight, height, hb_taken, hemoglobin, "
        . "hemoglobin_date, tb_status, preg_status, edd, fp_status, fp_method, disclosure, patner_tested, "
        . "user_initial, next_visit_date) ";
$sql_retention = "INSERT INTO retention (r_study_id, hiv_visit, next_visit, user_initial) ";

$sql_infant_diagnosis = "INSERT INTO infant_diagnosis(i_hei_id, visit_date, weight, height, "
        . "tb_contact, tb_ass_outcome, inf_milestones, imm_history, next_appointment, first_sample_collection, first_results_collected,"
        . "first_results, second_sample_collection, second_results_collected, second_results, third_sample_collection, "
        . " third_results_collected, third_results, forth_sample_collection, forth_results_collected, forth_results,"
        . "fifth_sample_collection, fifth_results_collected, fifth_results, sixth_sample_collection, sixth_results_collected,"
        . "sixth_results, hei_outcome, exit_date, feeding_6wks, feeding_10wks, "
        . "feeding_14wks, feeding_9mths, feeding_12mths, feeding_15mths, feeding_18mths, "
        . "user_initial) ";
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
            <!-- /.navbar-header -->
            <ul class="nav navbar-top-links navbar-right"><?php echo $_SESSION["name"]." is logged in."; ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li class="divider"></li>
                        <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            <div id="page-wrapper">
               <div class="row">
                <div class="col-lg-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="text-danger">Data imported from CSV file</h3>
                        </div>
                        <div class="panel-body">
                            
                        
            <?php
            $root_path = 'gs://motivatestudy/';
 
            $public_urls = [];
            foreach($_FILES['userfile']['name'] as $idx => $name) {
              if ($_FILES['userfile']['type'][$idx] === 'text/csv') {
                $original = $root_path . 'import_csv/' . $name;
                move_uploaded_file($_FILES['userfile']['tmp_name'][$idx], $original);
              } 
            }
               //var_dump($_FILES);
            echo $bucket;
            echo $root_path;
            print_r($public_urls);
            if (isset($_REQUEST['action']))
            {
                //define('CSV_PATH','/var/www/html/gae/csv/'); // specify CSV file path
                //define('CLOUD_SV_PATH','gs://motivatestudy/'); // specify CSV file path
                //$filename = $_REQUEST['form'].".csv";
                //$csv_file = CLOUD_SV_PATH . $filename; // Name of your CSV file
                $csvfile = fopen($original, 'r');
                
                
                if ($_REQUEST['form'] == "demographics") { $sqlinsert = $sql_demographics;}
                if ($_REQUEST['form'] == "infant_registration") { $sqlinsert = $sql_infant_registration;}
                if ($_REQUEST['form'] == "adherence") { $sqlinsert = $sql_adherence;}
                if ($_REQUEST['form'] == "variables") { $sqlinsert = $sql_variables;}
                if ($_REQUEST['form'] == "retention") { $sqlinsert = $sql_retention;}
                if ($_REQUEST['form'] == "infant_diagnosis") { $sqlinsert = $sql_infant_diagnosis;}
                $result = $db->importFromCSV($csvfile, $sqlinsert);
                if ($result > 0)
                {
                    echo nl2br("\n".$result." Total records for ".$_REQUEST['form']." imported successfully");
                }
              
                fclose($fp);
                /*if (!unlink($csv_file))
                  {
                    echo nl2br("\nError Removing $name. The file may not exist on the server");
                  }
                else
                  {
                    echo nl2br("\nThe file $name has been removed from the server");
                  }*/
            }
            ?>
                
                            <br />
                            <button type="button" onclick="window.location.href='dashboard.php'" class="btn btn-outline btn-primary btn-xs"><< Back to dashboard</button>
                        </div>
                    </div>
                </div>
              </div>
            </div>
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