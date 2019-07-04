<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
anc_id AS ID,
anc_study_id AS StudyID, 
abs_date AS AbsDate,
visit_count AS ANC_Visit_count,
anc_visit_date AS ANC_Date,
gestational_period AS Gestation_wks,
haart_regimen AS HAART_Regimen,
counselling AS Couple_counseling, 
hiv_status_partner AS Partner_HIV_status,
return_date AS Next_Visit_Date
FROM anc_followup
WHERE voided = 0";
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