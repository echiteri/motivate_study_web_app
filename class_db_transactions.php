<?php

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

require_once("config.php");
//require_once("class_role.php");
class db_transactions {
   
    public function getTableCount($table)
    {
        /*
         * Make DB global
         */
        $DB = new PDO(DB_DRIVER.':host='.DB_SERVER.';dbname='.DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD , $dboptions);  
        try {
        
        ///
        
        $sql = "SELECT COUNT(*) AS num FROM ". $table;
        $stmt = $DB->prepare($sql);
        $stmt->execute();
        $row_count = $stmt->fetchAll();
        return $row_count[0]["num"] ;

        } catch (Exception $ex) {

            echo $ex->getMessage();
        }
    }
    //Create records functions
    public function insertDemographics()
    {
        $sql = "INSERT INTO demographics(study_id, abs_date, facility_id, anc_id, psc_id, visit_count, "
                ."anc_visit_date, birth_date, residence, parity, gravida, gestational_period, lmp, edd, "
                ."marital_status, hiv_status, initial_hiv_status, hiv_retest, woman_haart, haart_regimen, "
                ."counselling, hiv_status_partner, return_date) "
                ."VALUES (:val1,[value-2],[value-3],[value-4],[value-5],"
                . "[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],"
                . "[value-15],[value-16],[value-17],[value-18],[value-19],[value-20],"
                . "[value-21],[value-22],[value-23])";
        
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":val1", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $dem = $stmt->fetchAll();
        
    }
    
    public function insertRentention($val1, $val2, $val3)
    {
        try
        {
            $DB = new PDO(DB_DRIVER.':host='.DB_SERVER.';dbname='.DB_DATABASE, DB_SERVER_USERNAME, DB_SERVER_PASSWORD , $dboptions); 
            $sql = "INSERT INTO retention(r_study_id, hiv_visit, next_visit) "
                    . "VALUES ('".$val1."','".$val2. "','" .$val3."')";
            //echo $sql;
            $stmt = $DB->prepare($sql);
            //$stmt->bindValue(":val1", $val1);//
            //$stmt->bindValue(":val1", $val2);//
            //$stmt->bindValue(":val1", $val3);//
            $stmt->execute();
            // modules based on user role
            $ren = $stmt->rowCount();
            return $ren;
        } catch (Exception $ex) {
            echo $ex->getMessage();
        }
        return 0;
    }
    
    public function insertAdherence()
    {
            $stmt = "INSERT INTO adherence(adherence_id, a_study_id, weight, height, hemoglobin, hemoglobin_date, "
                    . "tb_status, haart_start_date, haart_regimen, art_effect, self_art_adherence, self_ctx_adherence, "
                    . "cd4_count, cd4_date, viral_load, viral_date, who_stage, preg_status, "
                    . "edd, fp_status, fp_method, disclosure, patner_tested) "
                    . "VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],"
                    . "[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],"
                    . "[value-13],[value-14],[value-15],[value-16],[value-17],[value-18],"
                    . "[value-19],[value-20],[value-21],[value-22],[value-23])";

            $stmt = $DB->prepare($sql);
            //$stmt->bindValue(":val1", $_SESSION["rolecode"]);//
            $stmt->execute();
            // modules based on user role
            $adh = $stmt->rowCount();
            return $adh;
    }
    
    public function insertInfantDiagnosis()
    {
        $sql = "INSERT INTO infant_diagnosis(diagnosis_id, hei_id, d_study_id, birth_date, birth_weight, sex, "
                . "delivery_place, arv_prophylaxis, arv_pro_other, enrol_date, enrol_age, visit_date, "
                . "weight, height, tb_contact, tb_ass_outcome, inf_milestones, imm_history, "
                . "next_appointment, first_sample_collection, first_results_collected, first_results, second_sample_collection, second_results_collected, "
                . "second_results, third_sample_collection, third_results_collected, third_results, forth_sample_collection, forth_results_collected, "
                . "forth_results, fifth_sample_collection, fifth_results_collected, fifth_results, sixth_sample_collection, sixth_results_collected, "
                . "sixth_results, hei_outcome, exit_date, feeding_6wks, feeding_10wks, "
                . "feeding_14wks, feeding_9mths, feeding_12mths, feeding_15mths, feeding_18mths) "
                . "VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],"
                . "[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],"
                . "[value-13],[value-14],[value-15],[value-16],[value-17],[value-18],"
                . "[value-19],[value-20],[value-21],[value-22],[value-23],[value-24],"
                . "[value-25],[value-26],[value-27],[value-28],[value-29],[value-30],"
                . "[value-31],[value-32],[value-33],[value-34],[value-35],[value-36],"
                . "[value-37],[value-38],[value-39],[value-40],[value-41],[value-42],"
                . "[value-43],[value-44],[value-45],[value-46])";
        
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":val1", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $inf = $stmt->rowCount();
        return $inf;
    }
    //upcate records functions
    public function editDemographics()
    {
        $sql = "UPDATE demographics SET study_id=[value-1],abs_date=[value-2],facility_id=[value-3],anc_id=[value-4],psc_id=[value-5],"
                . "visit_count=[value-6],anc_visit_date=[value-7],birth_date=[value-8],residence=[value-9],parity=[value-10],"
                . "gravida=[value-11],gestational_period=[value-12],lmp=[value-13],edd=[value-14],marital_status=[value-15],"
                . "hiv_status=[value-16],initial_hiv_status=[value-17],hiv_retest=[value-18],woman_haart=[value-19],haart_regimen=[value-20],"
                . "counselling=[value-21],hiv_status_partner=[value-22],return_date=[value-23] WHERE study_id = :st_id";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":st_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $dem = $stmt->rowCount();
        return $dem;
    }
    
    public function editRentention()
    {
        $sql = "UPDATE retention SET retention_id=[value-1],r_study_id=[value-2],hiv_visit=[value-3],next_visit=[value-4] WHERE retention_id = :rt_id";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":rt_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $ret = $stmt->rowCount();
        return $ret;
    }
    
    public function editAdherence()
    {
        $sql = "UPDATE adherence "
                . "SET adherence_id=[value-1],a_study_id=[value-2],weight=[value-3],height=[value-4],hemoglobin=[value-5],"
                . "hemoglobin_date=[value-6],tb_status=[value-7],haart_start_date=[value-8],haart_regimen=[value-9],art_effect=[value-10],"
                . "self_art_adherence=[value-11],self_ctx_adherence=[value-12],cd4_count=[value-13],cd4_date=[value-14],viral_load=[value-15],"
                . "viral_date=[value-16],who_stage=[value-17],preg_status=[value-18],edd=[value-19],fp_status=[value-20],"
                . "fp_method=[value-21],disclosure=[value-22],patner_tested=[value-23] WHERE adherence_id = :ad_id";
        
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":ad_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $adh = $stmt->rowCount();
        return $adh;
        
    }
    
    public function editInfantDiagnosis()
    {
        $sql = "UPDATE infant_diagnosis SET diagnosis_id=[value-1],hei_id=[value-2],d_study_id=[value-3],birth_date=[value-4],"
                . "birth_weight=[value-5],sex=[value-6],delivery_place=[value-7],arv_prophylaxis=[value-8],arv_pro_other=[value-9],"
                . "enrol_date=[value-10],enrol_age=[value-11],visit_date=[value-12],weight=[value-13],height=[value-14],"
                . "tb_contact=[value-15],tb_ass_outcome=[value-16],inf_milestones=[value-17],imm_history=[value-18],"
                . "next_appointment=[value-19],first_sample_collection=[value-20],first_results_collected=[value-21],"
                . "first_results=[value-22],second_sample_collection=[value-23],second_results_collected=[value-24],"
                . "second_results=[value-25],third_sample_collection=[value-26],third_results_collected=[value-27],"
                . "third_results=[value-28],forth_sample_collection=[value-29],forth_results_collected=[value-30],"
                . "forth_results=[value-31],fifth_sample_collection=[value-32],fifth_results_collected=[value-33],"
                . "fifth_results=[value-34],sixth_sample_collection=[value-35],sixth_results_collected=[value-36],"
                . "sixth_results=[value-37],hei_outcome=[value-38],exit_date=[value-39],feeding_6wks=[value-40],"
                . "feeding_10wks=[value-41],feeding_14wks=[value-42],feeding_9mths=[value-43],feeding_12mths=[value-44],"
                . "feeding_15mths=[value-45],feeding_18mths=[value-46] WHERE diagnosis_id = :dg_id";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":gd_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $inf = $stmt->rowCount();
        return $inf;
    }
   //delete records functions
    public function deleteDemographics()
    {
        $sql = "DELETE FROM demographics WHERE study_id = :st_id";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":st_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $dem = $stmt->rowCount();
        return $dem;
    }
    
    public function deleteRentention()
    {
        $sql = "DELETE FROM retention WHERE retention_id = :rt_id";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":rt_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $ret = $stmt->rowCount();
        return $ret;
    }
    
    public function deleteAdherence()
    {
        $sql = "DELETE FROM adherence WHERE adherence_id = :ad_id";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":ad_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $adh = $stmt->rowCount();
        return $adh;
    }
    
    public function deleteInfantDiagnosis()
    {
        $sql = "DELETE FROM infant_diagnosis WHERE diagnosis_id = :dg_id";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":gd_id", $_SESSION["rolecode"]);//
        $stmt->execute();
        // modules based on user role
        $inf = $stmt->rowCount();
        return $inf;
    }
}
 