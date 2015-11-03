<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
study_id AS StudyID, 
abs_date AS AbsDate,
facility_id AS Fac_ID,
anc_id AS ANC_Number,
anc_visit_date AS ANC_Date,
birth_date AS DOB,
parity AS Parity, 
gravida AS Gravida,
lmp AS LMP, 
edd AS EDD,
marital_status AS Marital_Status,
hiv_status AS HIV_status,
haart_regimen AS HAART_Regimen,
counselling AS Couple_counseling, 
hiv_status_partner AS Partner_HIV_status,
return_date AS Next_Visit_Date
FROM demographics";
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