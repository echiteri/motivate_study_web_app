<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
r.d_study_id AS Study_ID,
i.diagnosis_id AS DiagID, 
i.i_hei_id AS HEI_ID,
i.feeding_6wks AS Feeding_method_6_Weeks,
i.feeding_10wks AS Feeding_method_10_Weeks,
i.feeding_14wks AS Feeding_method_14_Weeeks,
i.feeding_9mths AS Feeding_method_9_Months,
i.feeding_12mths AS Feeding_method_12_Months,
i.feeding_15mths AS Feeding_method_15_Months,
i.feeding_18mths AS Feeding_method_18_Months,
i.first_results AS 1st_DNA_PCR,
i.forth_results  AS Confirmatory_PCR,
i.third_results  AS 1st_Antibody_Test,
i.fifth_results  AS Repeat_Confirmatory_PCR,
i.sixth_results  AS Final_Antibody_Test,
i.hei_outcome AS HEI_Outcome,
i.next_appointment AS Next_Visit_Date
FROM infant_registration AS r 
JOIN infant_diagnosis AS i 
ON i.i_hei_id = r.hei_id";
$data = $db->getAssoArray($sql);
$results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"=>$data);
echo json_encode($results);
?>
