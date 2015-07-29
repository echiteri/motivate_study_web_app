<?php
use google\appengine\api\users\User;
use google\appengine\api\users\UserService;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of db_transactions
 *
 * @author echiteri
 */

require_once("c_role.php");

class db_transactions {
    
    public function dbCon()
    {
        // Create a connection.
        $DB = null;
        if (isset($_SERVER['SERVER_SOFTWARE']) &&
        strpos($_SERVER['SERVER_SOFTWARE'],'Google App Engine') !== false) {
          // Connect from App Engine.
          try{
             $DB = new pdo('mysql:unix_socket=/cloudsql/motivatestudy-967:db; dbname=motivate', 'root', '');
          }catch(PDOException $ex){
              die(json_encode(
                  array('outcome' => false, 'message' => 'Unable to connect.')
                  )
              );
          }
        } else {
          // Connect from a development environment.
          try{
             $DB = new pdo('mysql:host=localhost;dbname=ODK_Local', 'root', 'root');
          }catch(PDOException $ex){
              die(json_encode(
                  array('outcome' => false, 'message' => 'Unable to connect')
                  )
              );
          }
        }
        return $DB;
    }
    
    public function setMenuSession()
    {
        $role = new Role();
         /*set menu sessions*/
                if (!isset($_SESSION["access"])) {
                    try {
                        $sql = "SELECT mod_modulegroupcode, mod_modulegroupname FROM module "
                                . " WHERE 1 GROUP BY 'mod_modulegroupcode' "
                                . " ORDER BY 'mod_modulegrouporder' ASC, 'mod_moduleorder' ASC  ";
                        $stmt = $this->dbCon()->prepare($sql);
                        $stmt->execute();
                        // modules group
                        $commonModules = $stmt->fetchAll();
                        $sql = "SELECT mod_modulegroupcode, mod_modulegroupname, mod_modulepagename,  mod_modulecode, mod_modulename FROM module "
                                . " WHERE 1 "
                                . " ORDER BY 'mod_modulegrouporder' ASC, 'mod_moduleorder' ASC  ";

                        $stmt = $this->dbCon()->prepare($sql);
                        $stmt->execute();
                        // all modules
                        $allModules = $stmt->fetchAll();
                        $sql = "SELECT rr_modulecode, rr_create,  rr_edit, rr_delete, rr_view FROM role_rights "
                                . " WHERE  rr_rolecode = :rc "
                                . " ORDER BY 'rr_modulecode' ASC  ";

                        $stmt = $this->dbCon()->prepare($sql);
                        $stmt->bindValue(":rc", $_SESSION["rolecode"]);//
                        $stmt->execute();
                        // modules based on user role
                        $userRights = $stmt->fetchAll();
                        $_SESSION["access"] = $role->set_rights($allModules, $userRights, $commonModules); 
                        //set dashboard counts
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                    }
                }
                /* end of seting menu sessions */
    }
    
    public function getTableCount($table)
    {
        try {
        
        ///
        
        $sql = "SELECT COUNT(*) AS num FROM ". $table;
        $stmt = $this->dbCon()->prepare($sql);
        $stmt->execute();
        $row_count = $stmt->fetchAll();
        return $row_count[0]["num"] ;

        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }
    //Create records functions
    public function insertDemographics($arr_val)
    {
        //$DB = new PDO(DB_DRIVER.':host='.DB_SERVER.';dbname='.DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD , $dboptions);
        try{
            $sql = "INSERT INTO demographics(study_id, abs_date, facility_id, anc_id, psc_id, visit_count, "
                ."anc_visit_date, birth_date, residence, parity, gravida, gestational_period, lmp, edd, "
                ."marital_status, hiv_status, initial_hiv_status, hiv_retest, woman_haart, haart_regimen, "
                ."counselling, hiv_status_partner, return_date, user_initial) "
                ."VALUES ('".$arr_val[0]."','".$arr_val[1]. "','" .$arr_val[2]."','" .$arr_val[3]."','" .$arr_val[4]."'"
                . ",'" .$arr_val[5]."','" .$arr_val[6]."','" .$arr_val[7]."','" .$arr_val[8]."','" .$arr_val[9]."'"
                . ",'" .$arr_val[10]."','" .$arr_val[11]."','" .$arr_val[12]."','" .$arr_val[13]."','" .$arr_val[14]."'"
                . ",'" .$arr_val[15]."','" .$arr_val[16]."','" .$arr_val[17]."','" .$arr_val[18]."','" .$arr_val[19]."'"
                . ",'" .$arr_val[20]."','" .$arr_val[21]."','" .$arr_val[22]."','". $_SESSION["username"]."')";
            
        //echo $sql;
        $stmt = $this->dbCon()->prepare($sql);
        $stmt->execute();
        $dem = $stmt->rowCount();
        return $dem;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return 0;
    }
    
    public function insertRentention($arr_val)
    {
        try
        {
            $sql = "INSERT INTO retention(r_study_id, hiv_visit, next_visit, user_initial) "
                    . "VALUES ('".$arr_val[0]."','".$arr_val[1]. "','" .$arr_val[2]."','". $_SESSION["username"]."')";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $ren = $stmt->rowCount();
            return $ren;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return 0;
    }
    
    public function insertAdherence($arr_val)
    {
        try
        {
            $sql = "INSERT INTO adherence(a_study_id, haart_start_date, haart_regimen, art_effect, "
                    . "self_art_adherence, self_ctx_adherence, cd4_count, cd4_date, viral_load, "
                    . "viral_date, who_stage, user_initial) "
                    . "VALUES ('".$arr_val[0]."','".$arr_val[1]. "','" .$arr_val[2]."','" .$arr_val[3]."','" .$arr_val[4]."'"
                    . ",'" .$arr_val[5]."','" .$arr_val[6]."','" .$arr_val[7]."','" .$arr_val[8]."','" .$arr_val[9]."'"
                    . ",'" .$arr_val[10]."','". $_SESSION["username"]."')";

            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $adh = $stmt->rowCount();
            return $adh;
        } catch (Exception $ex){
            echo $ex->getMessage();
        }
        return 0;
    }
    public function insertVariables($arr_val)
    {
        try{
            $sql = "INSERT INTO variables(v_study_id, weight, height, hemoglobin, hemoglobin_date, "
                    . "tb_status, preg_status, edd, fp_status, fp_method, "
                    . "disclosure, patner_tested, user_initial) "
                    . "VALUES ('".$arr_val[0]."','".$arr_val[1]. "','" .$arr_val[2]."','" .$arr_val[3]."','" .$arr_val[4]."'"
                    . ",'" .$arr_val[5]."','" .$arr_val[6]."','" .$arr_val[7]."','" .$arr_val[8]."','" .$arr_val[9]."'"
                    . ",'" .$arr_val[10]."','" .$arr_val[11]."','". $_SESSION["username"]."')";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $adh = $stmt->rowCount();
            return $adh;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
            
    }
    public function insertInfantRegistration($arr_val)
    {
        try{
             $sql = "INSERT INTO infant_registration(hei_id, d_study_id, birth_date, birth_weight, sex, "
                . "delivery_place, arv_prophylaxis, arv_pro_other, enrol_date, enrol_age, user_initial) "
                . "VALUES ('".$arr_val[0]."','".$arr_val[1]. "','" .$arr_val[2]."','" .$arr_val[3]."','" .$arr_val[4]."'"
                . ",'" .$arr_val[5]."','" .$arr_val[6]."','" .$arr_val[7]."','" .$arr_val[8]."','" .$arr_val[9]."'"
                . ", '". $_SESSION["username"]."')";
        
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $inf = $stmt->rowCount();
            return $inf;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
       
    }
    
    public function insertInfantDiagnosis($arr_val)
    {
        try{
             $sql = "INSERT INTO infant_diagnosis(i_hei_id, visit_date, "
                . "weight, height, tb_contact, tb_ass_outcome, inf_milestones, imm_history, "
                . "next_appointment, user_initial) "
                . "VALUES ('".$arr_val[0]."','".$arr_val[1]. "','" .$arr_val[2]."','" .$arr_val[3]."','" .$arr_val[4]."'"
                . ",'" .$arr_val[5]."','" .$arr_val[6]."','" .$arr_val[7]."','" .$arr_val[8]."','". $_SESSION["username"]."')";
        
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $inf = $stmt->rowCount();
            return $inf;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
       
    }
    
    public function insertUser($arr_val)
    {
        try{
            $sql = "INSERT INTO system_users(u_username, u_password, u_rolecode, u_name) "
                    . "VALUES ('".$arr_val[0]."','".MD5($arr_val[1]). "','" .$arr_val[2]."','" .$arr_val[3]."')";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $usr = $stmt->rowCount();
            return $usr;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
            
    }
     public function updateInfantHivTests($arr_val, $record_id, $column_part, $sec_id)
    {
         
         try{
             if($sec_id == "EXIT"){
                 $sql = "UPDATE infant_diagnosis SET ".$column_part."_6wks = '".$arr_val[0]."' ,"
                 .$column_part."_10wks = '".$arr_val[1]."' ,".$column_part."_14wks = '".$arr_val[2]."', "
                 .$column_part."_9mths = '".$arr_val[3]."' ,".$column_part."_12mths = '".$arr_val[4]."', "
                 .$column_part."_15mths = '".$arr_val[5]."' ,".$column_part."_18mths = '".$arr_val[6]."', user_initial = '". $_SESSION["username"]."'"
                 ."WHERE diagnosis_id = '".$record_id."'";
             } else if($sec_id == "ANT_BDY_18") {
                 $sql = "UPDATE infant_diagnosis SET ".$column_part."_sample_collection = '".$arr_val[0]."' ,"
                 .$column_part."_results_collected = '".$arr_val[1]."' ,".$column_part."_results = '".$arr_val[2]."' ,"
                 ."hei_outcome = '".$arr_val[3]."' ,exit_date = '".$arr_val[4]."', user_initial = '". $_SESSION["username"]."'"
                 ."WHERE diagnosis_id = '".$record_id."'";
             } else {
                $sql = "UPDATE infant_diagnosis SET ".$column_part."_sample_collection = '".$arr_val[0]."' ,"
                  .$column_part."_results_collected = '".$arr_val[1]."' ,".$column_part."_results = '".$arr_val[2]."', user_initial = '". $_SESSION["username"]."'"
                  ."WHERE diagnosis_id = '".$record_id."'";
             }
        
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $inf = $stmt->rowCount();
            return $inf;
             
         } catch (Exception $ex) {
            echo $ex->getMessage();
         }
        
    }
    //upcate records functions
    public function editDemographics($arr_val, $record_id)
    {
        try{
            $sql = "UPDATE demographics SET abs_date='".$arr_val[1]."',facility_id='".$arr_val[2]."',anc_id='".$arr_val[3]."',psc_id='".$arr_val[4]."',"
                    . "visit_count='".$arr_val[5]."',anc_visit_date='".$arr_val[6]."',birth_date='".$arr_val[7]."',residence='".$arr_val[8]."',parity='".$arr_val[9]."',"
                    . "gravida='".$arr_val[10]."',gestational_period='".$arr_val[11]."',lmp='".$arr_val[12]."',edd='".$arr_val[13]."',marital_status='".$arr_val[14]."',"
                    . "hiv_status='".$arr_val[15]."',initial_hiv_status='".$arr_val[16]."',hiv_retest='".$arr_val[17]."',woman_haart='".$arr_val[18]."',haart_regimen='".$arr_val[19]."',"
                    . "counselling='".$arr_val[20]."',hiv_status_partner='".$arr_val[21]."',return_date='".$arr_val[22]."', user_initial = '". $_SESSION["username"]."'"
                    . "WHERE study_id = '".$record_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $dem = $stmt->rowCount();
            return $dem;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function editRentention($arr_val, $record_id)
    {
        try{
            $sql = "UPDATE retention SET r_study_id='".$arr_val[0]."',hiv_visit='".$arr_val[1]."',next_visit='".$arr_val[2]."', user_initial = '". $_SESSION["username"]."'"
                . "WHERE retention_id = '".$record_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $ret = $stmt->rowCount();
        return $ret;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
    }
    
    public function editAdherence($arr_val, $record_id)
    {
        try{
            $sql = "UPDATE adherence "
                . "SET a_study_id='".$arr_val[0]."',haart_start_date='".$arr_val[1]."',haart_regimen='".$arr_val[2]."',art_effect='".$arr_val[3]."',"
                . "self_art_adherence='".$arr_val[4]."',self_ctx_adherence='".$arr_val[5]."',cd4_count='".$arr_val[6]."',cd4_date='".$arr_val[7]."',viral_load='".$arr_val[8]."',"
                . "viral_date='".$arr_val[9]."',who_stage='".$arr_val[10]."', user_initial = '". $_SESSION["username"]."'"
                . "WHERE adherence_id = '".$record_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $adh = $stmt->rowCount();
        return $adh;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }    
    }
    
    public function editVariables($arr_val, $record_id)
    {
          try{
            $sql = "UPDATE variables "
                . "SET v_study_id='".$arr_val[0]."',weight='".$arr_val[1]."',height='".$arr_val[2]."',hemoglobin='".$arr_val[3]."',"
                . "hemoglobin_date='".$arr_val[4]."',tb_status='".$arr_val[5]."',preg_status='".$arr_val[6]."',edd='".$arr_val[7]."',fp_status='".$arr_val[8]."',"
                . "fp_method='".$arr_val[9]."', disclosure='".$arr_val[10]."',patner_tested='".$arr_val[11]."', user_initial = '". $_SESSION["username"]."'"
                . "WHERE variables_id = '".$record_id."'";
        
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $adh = $stmt->rowCount();
        return $adh;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }    
    }

    public function editInfantRegistration($arr_val, $record_id)
    {
        try{
            $sql = "UPDATE infant_registration SET d_study_id='".$arr_val[0]."', birth_date='".$arr_val[1]."',"
                . "birth_weight='".$arr_val[2]."',sex='".$arr_val[3]."',delivery_place='".$arr_val[4]."',arv_prophylaxis='".$arr_val[5]."',arv_pro_other='".$arr_val[6]."',"
                . "enrol_date='".$arr_val[7]."',enrol_age='".$arr_val[8]."', user_initial = '". $_SESSION["username"]."'"
                . "WHERE hei_id = '".$record_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $inf = $stmt->rowCount();
            return $inf;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function editInfantDiagnosis($arr_val, $record_id)
    {
        try{
            $sql = "UPDATE infant_diagnosis SET i_hei_id='".$arr_val[0]."', visit_date='".$arr_val[1]."',weight='".$arr_val[2]."',height='".$arr_val[3]."',"
                . " tb_contact='".$arr_val[4]."',tb_ass_outcome='".$arr_val[5]."',inf_milestones='".$arr_val[6]."',imm_history='".$arr_val[7]."',"
                . " next_appointment='".$arr_val[8]."', user_initial = '". $_SESSION["username"]."'"
                . " WHERE diagnosis_id = '".$record_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $inf = $stmt->rowCount();
            return $inf;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }

       public function editUser($arr_val, $record_id)
    {
        try{
            $sql = "UPDATE system_users SET u_username='".$arr_val[0]."',u_password='".MD5($arr_val[1])."', u_rolecode='".$arr_val[2]."',"
                . "u_name='".$arr_val[3]."'"
                . "WHERE u_userid = '".$record_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $usr = $stmt->rowCount();
            return $usr;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function editRoleRights($arr_val, $record_id)
    {
        try{
            $sql = "UPDATE role_rights SET rr_create ='".$arr_val[0]."', rr_edit ='".$arr_val[1]."', rr_delete ='".$arr_val[2]."',"
                . "rr_view ='".$arr_val[3]."'"
                . "WHERE rr_roleid = '".$record_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $usr = $stmt->rowCount();
            return $usr;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
   //delete records functions
    public function deleteDemographics($record_id)
    {
        try{
            $sql = "DELETE FROM demographics WHERE study_id = :st_id";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->bindParam(':st_id', $record_id, PDO::PARAM_INT);
            $stmt->execute();
            $dem = $stmt->rowCount();
            return $dem;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    
    public function deleteRentention($record_id)
    {
        try{
            $sql = "DELETE FROM retention WHERE retention_id = :rt_id";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->bindParam(':rt_id', $record_id, PDO::PARAM_INT);
            $stmt->execute();
            $ret = $stmt->rowCount();
            return $ret;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
    }
    
    public function deleteAdherence($record_id)
    {
        try{
            $sql = "DELETE FROM adherence WHERE adherence_id = :ad_id";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->bindParam(':ad_id', $record_id, PDO::PARAM_INT);
            $stmt->execute();
            $adh = $stmt->rowCount();
            return $adh;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
    }
    public function deleteVariables($record_id)
    {
        try{
            $sql = "DELETE FROM variables WHERE variables_id = :va_id";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->bindParam(':va_id', $record_id, PDO::PARAM_INT);
            $stmt->execute();
            $var = $stmt->rowCount();
            return $var;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        
    }
    
    public function deleteInfantDiagnosis($record_id)
    {
        try{
            $sql = "DELETE FROM infant_diagnosis WHERE diagnosis_id = :dg_id";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->bindParam(':dg_id', $record_id, PDO::PARAM_INT);
            $stmt->execute();
            $inf = $stmt->rowCount();
        return $inf;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
    }
    public function getAssoArray($sql)
    {
        $assocArray = array();
        $stmt = $this->dbCon()->prepare($sql);
        $stmt->execute();
        while($row = $stmt->fetchAll(PDO::FETCH_ASSOC)) {
            $assocArray = $row;
           }
        return $assocArray;
    }
    public function getData($sql)
    {
        try{
            //$sql = "SELECT * FROM ".$table;
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $rs = $stmt->fetchAll();
            return $rs;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }  
    }
    public function selectAll($table)
    {
        try{
            $sql = "SELECT * FROM ".$table;
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $rs = $stmt->fetchAll();
            return $rs;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }  
    }
    public function selectRecord($table,$id,$select_id)
    {
        try{
            $sql = "SELECT * FROM ".$table." WHERE ".$id."='".$select_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $rs = $stmt->fetch();
            return $rs;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }  
    }
    public function selectDefinedRecords($variables, $table,$id,$select_id)
    {
        try{
            $sql = "SELECT ".$variables." FROM ".$table." WHERE ".$id."='".$select_id."'";
            $stmt = $this->dbCon()->prepare($sql);
            $stmt->execute();
            $rs = $stmt->fetchAll();
            return $rs;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }  
    }
}
 