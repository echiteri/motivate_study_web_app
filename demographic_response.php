<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
study_id AS StudyID, 
abs_date AS AbsDate,
facility_id AS Fac_ID,
anc_id AS ANC_ID, 
psc_id AS PSC_ID,
visit_count AS Visits,
anc_visit_date AS ANC_Date, 
birth_date AS DOB,
residence AS Place,
parity AS Parity, 
gravida AS Gravida,
gestational_period AS Gest_Period,
lmp AS LMP, 
edd AS EDD,
marital_status AS Married,
hiv_status AS HIV_status, 
initial_hiv_status AS Init_HIV,
hiv_retest AS Retest,
woman_haart AS Haart,
haart_regimen AS Regimen,
counselling AS Couns, 
hiv_status_partner AS Partner,
return_date AS NextVisit
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