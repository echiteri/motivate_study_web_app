<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT
        id AS Reg_ID,
        d_study_id AS Mother_StudyID,
        hei_id AS HEI_ID,
        birth_date AS DOB,
        arv_prophylaxis AS ARV_Prophylaxis,
        enrol_date AS Enrolled_Date,
        enrol_age AS Age_Enrolled_In_Weeks
        FROM infant_registration
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
