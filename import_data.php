<?php
 
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

$bucket = CloudStorageTools::getDefaultGoogleStorageBucketName();
$root_path = 'gs://motivatestudy/';
 
$public_urls = [];
foreach($_FILES['userfile']['name'] as $idx => $name) {
    $ext = strtolower(end(explode('.', $_FILES['userfile']['name'])));
  if ($_FILES['userfile']['type'][$idx] === 'text/csv') {
  
      echo "IT IS CSV";
    //$im = imagecreatefromjpeg($_FILES['userfile']['tmp_name'][$idx]);
    //imagefilter($im, IMG_FILTER_GRAYSCALE);
    //$grayscale = $root_path .  'gray/' . $name;
    //imagejpeg($im, $grayscale);
 
    $original = $root_path.'csv/'.$name;
    move_uploaded_file($_FILES['userfile']['tmp_name'][$idx], $original);
    echo nl2br($original.'idx '.$idx);
    
    /* === */
           if($csvfile = fopen("gs://motivatestudy/csv/variables.csv", 'r') !== FALSE)
           { 
           echo nl2br("FILE READ SUCCSSFULY");
           echo nl2br($_FILES['userfile']['tmp_name']);
           if ($_REQUEST['form'] == "demographics") { $sqlinsert = $sql_demographics;}
           if ($_REQUEST['form'] == "infant_registration") { $sqlinsert = $sql_infant_registration;}
           if ($_REQUEST['form'] == "adherence") { $sqlinsert = $sql_adherence;}
           if ($_REQUEST['form'] == "variables") { $sqlinsert = $sql_variables;}
           if ($_REQUEST['form'] == "retention") { $sqlinsert = $sql_retention;}
           if ($_REQUEST['form'] == "infant_diagnosis") { $sqlinsert = $sql_infant_diagnosis;}
           $result = $db->importFromCSV($csvfile, $sqlinsert);
           //echo nl2br($result);
           if ($result > 0)
           {
               echo nl2br("\n".$result." Total records for ".$_REQUEST['form']." imported successfully");
           }

           fclose($fp);
           }
           else
           {
               echo nl2br("UNABLE TO READ CSV FILE");
           }
           /* === */
 
    /*$public_urls[] = [
        'name' => $name,
        'original' => CloudStorageTools::getImageServingUrl($original),
        'original_thumb' => CloudStorageTools::getImageServingUrl($original, ['size' => 75]),
        'grayscale' => CloudStorageTools::getImageServingUrl($grayscale),
        'grayscale_thumb' => CloudStorageTools::getImageServingUrl($grayscale, ['size' => 75]),
    ];*/
  } 
}
//$options = [ 'gs_bucket_name' => 'motivatestudy-967.appspot.com' ];
//$upload_url = CloudStorageTools::createUploadUrl('/import_data.php', $options);
 
?>
<html>
<body>
<?php
    //echo $bucket;
    echo $root_path;
     if (isset($_REQUEST['action']))
         {      
                /* === */
           $csvfile = fopen($original, 'r');
           echo nl2br("\n".$_REQUEST['action']);
           echo nl2br("\n".$_REQUEST['form']);


           if ($_REQUEST['form'] == "demographics") { $sqlinsert = $sql_demographics;}
           if ($_REQUEST['form'] == "infant_registration") { $sqlinsert = $sql_infant_registration;}
           if ($_REQUEST['form'] == "adherence") { $sqlinsert = $sql_adherence;}
           if ($_REQUEST['form'] == "variables") { $sqlinsert = $sql_variables;}
           if ($_REQUEST['form'] == "retention") { $sqlinsert = $sql_retention;}
           if ($_REQUEST['form'] == "infant_diagnosis") { $sqlinsert = $sql_infant_diagnosis;}
           $result = $db->importFromCSV($csvfile, $sqlinsert);
           echo nl2br($result);
           if ($result > 0)
           {
               echo nl2br("\n".$result." Total records for ".$_REQUEST['form']." imported successfully");
           }

           fclose($fp);
           /* === */
         
     }
     
    
//var_dump($_FILES);
/*foreach($public_urls as $urls) {
  echo '<a href="' . $urls['original'] .'"><IMG src="' . $urls['original_thumb'] .'"></a> ';
  echo '<a href="' . $urls['grayscale'] .'"><IMG src="' . $urls['grayscale_thumb'] .'"></a>';
  echo '<p>';
}*/
?>
<p>
<a href="/">Upload More</a>
</body>
</html>