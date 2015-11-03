<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
diagnosis_id AS DiagID, 
i_hei_id AS HEI_ID,
feeding_6wks AS Feeding_method_6_Weeks,
feeding_10wks AS Feeding_method_10_Weeks,
feeding_14wks AS Feeding_method_14_Weeeks,
feeding_9mths AS Feeding_method_6_Months,
feeding_12mths AS Feeding_method_9_Months,
feeding_15mths AS Feeding_method_12_Months,
feeding_18mths AS Feeding_method_15_Months,
first_results AS 1st_DNA_PCR,
forth_results  AS Confirmatory_PCR,
third_results  AS 1st_Antibody_Test,
fifth_results  AS Repeat_Confirmatory_PCR,
sixth_results  AS Final_Antibody_Test,
hei_outcome AS HEI_Outcome,
next_appointment AS Next_Visit_Date
FROM infant_diagnosis";
$data = $db->getAssoArray($sql);
$results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"=>$data);
echo json_encode($results);
?>
