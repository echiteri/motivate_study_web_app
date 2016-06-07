<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
adherence_id AS AdherenceID, 
a_study_id AS StudyID,
haart_change_date AS HAART_Change_Date,
cd4_count AS CD4_Count,
cd4_date AS CD4_Date,
viral_load AS Viral_Load,
viral_date AS Viral_Load_Date,
self_art_adherence AS ART_Adherence,
self_ctx_adherence AS CTX_Adherence,
next_visit_date AS Next_Visit_Date                                                    
FROM adherence";
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