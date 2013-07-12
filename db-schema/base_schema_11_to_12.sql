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


