UPDATE system_authorization_tbl SET system_authorization_section_cute_name = "Compliance & Audit" WHERE system_authorization_section_name = "compliance";
UPDATE system_authorization_tbl SET system_authorization_subsection_cute_name  = "Audit Mgt" WHERE system_authorization_subsection_cute_name = "Audit Calendar";
UPDATE system_authorization_tbl SET system_authorization_subsection_cute_name  = "Compliance Mgt" WHERE system_authorization_subsection_cute_name = "Compliance Analysis";

ALTER TABLE `compliance_audit_tbl` ADD COLUMN `compliance_audit_start_date` DATE NULL  AFTER `compliance_audit_package_id` , ADD COLUMN `compliance_audit_end_date` DATE NULL  AFTER `compliance_audit_start_date` , ADD COLUMN `compliance_audit_status` INT NULL DEFAULT 0  AFTER `compliance_audit_end_date` ;

INSERT INTO `system_authorization_tbl` (`system_authorization_order`, `system_authorization_action_type`, `system_authorization_section_name`, `system_authorization_section_cute_name`, `system_authorization_subsection_name`, `system_authorization_subsection_cute_name`, `system_authorization_subsection_submenu`, `system_authorization_target_url`, `system_authorization_disabled`) VALUES (6, 'w', 'compliance', 'Compliance & Audit', 'compliance_audit_management_edit', 'Compliance Audit Management', 0, 'compliance/compliance_audit_management_edit.php', 0);

CREATE  TABLE `compliance_audit_management_tbl` (
  `compliance_audit_management_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `compliance_audit_management_comp_item_id` INT NULL ,
  `compliance_audit_management_audit_name` VARCHAR(100) NULL ,
  `compliance_audit_management_feedback` TEXT NULL ,
  PRIMARY KEY (`compliance_audit_management_id`) );

ALTER TABLE `compliance_audit_management_tbl` ADD COLUMN `compliance_audit_management_audit_id` INT NULL  AFTER `compliance_audit_management_id` ;

ALTER TABLE `compliance_package_item_tbl` ADD COLUMN `compliance_package_item_auditor_faq` TEXT NULL  AFTER `compliance_package_item_description` ;

INSERT INTO `system_authorization_tbl` (`system_authorization_order`, `system_authorization_action_type`, `system_authorization_section_name`, `system_authorization_section_cute_name`, `system_authorization_subsection_name`, `system_authorization_subsection_cute_name`, `system_authorization_subsection_submenu`, `system_authorization_target_url`, `system_authorization_disabled`) VALUES (8, 'w', 'system', 'System Management', 'system_workflows', 'System Workflows', 1, 'system/workflows_select.php', 0);

INSERT INTO `system_authorization_tbl` (`system_authorization_order`, `system_authorization_action_type`, `system_authorization_section_name`, `system_authorization_section_cute_name`, `system_authorization_subsection_name`, `system_authorization_subsection_cute_name`, `system_authorization_subsection_submenu`, `system_authorization_target_url`, `system_authorization_disabled`) VALUES (3, 'r', 'risk', 'Risk Management', 'risk_summary_list', 'Risk Summary', 1, 'risk/risk_summary_list.php', `0`);

CREATE  TABLE `risk_summary_tbl` (
  `risk_summary_id` INT NOT NULL AUTO_INCREMENT ,
  `risk_summary_type` VARCHAR(45) NULL ,
  `risk_summary_name` VARCHAR(100) NULL ,
  `risk_summary_risk_counter` INT NULL ,
  `risk_summary_opex` INT NULL ,
  `risk_summary_capex` INT NULL ,
  `risk_summary_resources` DECIMAL(10,2) NULL ,
  `risk_summary_score` INT NULL ,
  `risk_summary_residual` INT NULL ,
  `risk_summary_incident_counter` INT NULL ,
  `risk_summary_disabled` INT NULL DEFAULT 1 ,
  PRIMARY KEY (`risk_summary_id`) );

UPDATE `system_authorization_tbl` SET `system_authorization_subsection_cute_name`='Security Services Summary' WHERE `system_authorization_id`='103';

INSERT INTO `system_authorization_tbl` (`system_authorization_order`, `system_authorization_action_type`, `system_authorization_section_name`, `system_authorization_section_cute_name`, `system_authorization_subsection_name`, `system_authorization_subsection_cute_name`, `system_authorization_subsection_submenu`, `system_authorization_target_url`, `system_authorization_disabled`) VALUES (7, 'r', 'operations', 'Security Operations', 'project_improvements_summary_list', 'Project Summary', 1, 'operations/project_summary_list.php', 0);

CREATE  TABLE `project_improvements_summary_tbl` (
  `project_improvements_id` INT NOT NULL AUTO_INCREMENT ,
  `project_improvements_name` VARCHAR(100) NULL ,
  `project_improvements_completion` INT NULL ,
  `project_improvements_owner` VARCHAR(100) NULL ,
  `project_improvements_planned_end` DATE NULL ,
  `project_improvements_current_bud` INT NULL ,
  `project_improvements_planned_bud` INT NULL ,
  `project_improvements_velocity` INT NULL ,
  `project_improvements_disabled` INT NULL DEFAULT 1 ,
  PRIMARY KEY (`project_improvements_id`) );

