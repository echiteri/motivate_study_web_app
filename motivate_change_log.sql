UPDATE  module SET mod_modulecode = 'ANC VISIT', mod_modulename = 'ANC Visit'  WHERE mod_modulepagename = 'women_anc.php';

/* 
Change log:
Date: June 2016
Comments: Added haart_start_date to demographics, haart_change_date to anc_followup, haart_change to anc_followup and adherence table
*/
ALTER TABLE demographics ADD COLUMN haart_start_date date NULL AFTER haart_regimen;
ALTER TABLE  anc_followup ADD COLUMN haart_change_date date NULL AFTER haart_regimen;
ALTER TABLE  anc_followup ADD COLUMN haart_change varchar(2) NULL AFTER gestational_period;
ALTER TABLE  adherence ADD COLUMN haart_change varchar(2) NULL AFTER visit_date;

/* 
Change log:
Date: July 19 2016
Comments: Added weight and height columns to infant_diagnosis table
*/
ALTER TABLE  infant_diagnosis MODIFY weight float(5,2);
ALTER TABLE  infant_diagnosis MODIFY height float(5,2);

/* 
Change log:
Date: Aug 1 2016
Comments: Added column feeding_6mths to infant_diagnosis table
*/
ALTER TABLE  infant_diagnosis ADD COLUMN feeding_6mths varchar(3) NULL AFTER feeding_14wks;
/* 
Change log:
Date: Aug 25 2016
Comments: Added columns weight and birth_weight to variables and infant_registration respectively
*/
ALTER TABLE  variables MODIFY weight float(5,2);
ALTER TABLE  infant_registration MODIFY birth_weight float(5,2);
 /* 
Change log:
Date: Oct 10 2016
Comments: Added column old_mflcode to demographics table
*/

ALTER TABLE  demographics ADD COLUMN old_mflcode varchar(16) NULL AFTER outdate;
/* 
Change log:
Date: June 3 2017
Comments: Added columns 2nd_pcr_sample_collection, 2nd_pcr_results_collected, 2nd_pcr_results, 
					3nd_pcr_sample_collection, 3nd_pcr_results_collected, 3nd_pcr_results to infant_diagnosis table
*/

ALTER TABLE  infant_diagnosis ADD COLUMN 2nd_pcr_sample_collection Date NULL AFTER second_results;
ALTER TABLE  infant_diagnosis ADD COLUMN 2nd_pcr_results_collected Date NULL AFTER 2nd_pcr_sample_collection;
ALTER TABLE  infant_diagnosis ADD COLUMN 2nd_pcr_results varchar(3) NULL AFTER 2nd_pcr_results_collected;
ALTER TABLE  infant_diagnosis ADD COLUMN 3nd_pcr_sample_collection Date NULL AFTER 2nd_pcr_results;
ALTER TABLE  infant_diagnosis ADD COLUMN 3nd_pcr_results_collected Date NULL AFTER 3nd_pcr_sample_collection;
ALTER TABLE  infant_diagnosis ADD COLUMN 3nd_pcr_results varchar(3) NULL AFTER 

/* 
Change log:
Date: 27th MAY 2019
Comments: Add fields to track deleted records by flagging if its marked for deletion, by who and when
*/

ALTER TABLE `motivate`.`adherence` 
ADD COLUMN `voided` int(1) NOT NULL DEFAULT 0 COMMENT 'deleted flag' AFTER `next_visit_date`,
ADD COLUMN `voided_by` varchar(20) NULL DEFAULT NULL COMMENT 'person deleting' AFTER `voided`,
ADD COLUMN `voided_datetime` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'date deleted' AFTER `voided_by`;

ALTER TABLE `motivate`.`anc_followup` 
ADD COLUMN `voided` int(1) NOT NULL DEFAULT 0 COMMENT 'delete flag' AFTER `created_date`,
ADD COLUMN `voided_by` varchar(20) NULL DEFAULT NULL COMMENT 'person deleting' AFTER `voided`,
ADD COLUMN `voided_datetime` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'date deleted' AFTER `voided_by`;

ALTER TABLE `motivate`.`demographics` 
ADD COLUMN `voided` int(1) NOT NULL DEFAULT 0 COMMENT 'delete flag' AFTER `created_date`,
ADD COLUMN `voided_by` varchar(20) NULL DEFAULT NULL COMMENT 'person deleting' AFTER `voided`,
ADD COLUMN `voided_datetime` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'date deleted' AFTER `voided_by`;

ALTER TABLE `motivate`.`infant_diagnosis` 
ADD COLUMN `voided` int(1) NOT NULL DEFAULT 0 COMMENT 'delete flag' AFTER `created_date`,
ADD COLUMN `voided_by` varchar(20) NULL DEFAULT NULL COMMENT 'deleted by' AFTER `voided`,
ADD COLUMN `voided_datetime` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'date deleted' AFTER `voided_by`;

ALTER TABLE `motivate`.`infant_registration` 
ADD COLUMN `voided` int(1) NOT NULL DEFAULT 0 COMMENT 'delete flag' AFTER `created_date`,
ADD COLUMN `voided_by` varchar(20) NULL DEFAULT NULL COMMENT 'person deleting' AFTER `voided`,
ADD COLUMN `voided_datetime` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'date deleted' AFTER `voided_by`;

ALTER TABLE `motivate`.`retention` 
ADD COLUMN `voided` int(1) NOT NULL DEFAULT 0 COMMENT 'delete flag' AFTER `created_date`,
ADD COLUMN `voided_by` varchar(20) NULL DEFAULT NULL COMMENT 'person deleting' AFTER `voided`,
ADD COLUMN `voided_datetime` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'date deleted' AFTER `voided_by`;

ALTER TABLE `motivate`.`variables` 
ADD COLUMN `voided` int(1) NOT NULL DEFAULT 0 COMMENT 'delete flag' AFTER `next_visit_date`,
ADD COLUMN `voided_by` varchar(20) NULL DEFAULT NULL COMMENT 'person deleting' AFTER `voided`,
ADD COLUMN `voided_datetime` timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0) COMMENT 'date deleted' AFTER `voided_by`;