<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT id AS RegID, hei_id AS HEI_ID, "
        . "d_study_id AS StudyID, "
        . "birth_date AS DOB, "
        . "birth_weight AS BTH_Weight, "
        . "sex AS Sex, "
        . "delivery_place AS BTH_Place, "
        . "arv_prophylaxis AS ARV_Prophylaxis, "
        . "arv_pro_other AS ARV_Other, "
        . "enrol_date AS Enrolled, "
        . "enrol_age AS Enrol_Age "
        . "FROM infant_registration";
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
