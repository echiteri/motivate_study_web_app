<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT retention_id AS VisitID, r_study_id AS StudyID, hiv_visit AS VisitDate, next_visit AS Next_Visit_Date FROM retention WHERE voided = 0";
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