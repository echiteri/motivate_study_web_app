<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
variables_id AS VariableID, 
v_study_id AS StudyID,
weight AS Weight,
height AS Height, 
hemoglobin AS Hemoglobin,
hemoglobin_date AS Hemoglobin_Date,
tb_status AS TB_Status, 
preg_status AS Preg_Status,
edd AS EDD,
fp_status AS FP_status, 
fp_method AS FP_Method,
disclosure AS HIV_Disclosure,
patner_tested AS Partner_Tested
FROM variables";
$data = $db->getAssoArray($sql);
$results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"=>$data);
/*while($row = $result->fetch_array(MYSQLI_ASSOC)){
  $results["data"][] = $row ;
}*/
echo json_encode($results);
?>