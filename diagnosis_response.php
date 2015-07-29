<?php
require_once("c_transactions.php");
$db = new db_transactions();
$sql = "SELECT 
diagnosis_id AS DiagID, 
i_hei_id AS HEI_ID,
visit_date AS VisitDate,
weight AS WeightDate, 
height AS Height,
tb_contact AS TB_Contact,
tb_ass_outcome AS TB_Status, 
inf_milestones AS Milestone,
imm_history AS ImmHistory,
next_appointment AS NextAppmnt
FROM infant_diagnosis";
$data = $db->getAssoArray($sql);
$results = array(
            "sEcho" => 1,
            "iTotalRecords" => count($data),
            "iTotalDisplayRecords" => count($data),
            "aaData"=>$data);
echo json_encode($results);
?>
