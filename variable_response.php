<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
variables_id AS VariableID, 
v_study_id AS StudyID,
tb_status AS TB_Status, 
preg_status AS Preg_Status,
edd AS EDC,
fp_status AS FP_status, 
disclosure AS HIV_Disclosure,
next_visit_date AS Next_visit_date
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