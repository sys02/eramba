--
-- Table structure for table `compliance_audit_tbl`
--

DROP TABLE IF EXISTS `compliance_audit_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_audit_tbl` (
  `compliance_audit_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_audit_title` varchar(200) DEFAULT NULL,
  `compliance_audit_date` date DEFAULT NULL,
  `compliance_audit_package_id` int(11) DEFAULT NULL,
  `compliance_audit_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_audit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `compliance_finding_status_tbl`
--

DROP TABLE IF EXISTS `compliance_finding_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_finding_status_tbl` (
  `compliance_finding_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_finding_status_name` varchar(45) DEFAULT NULL,
  `compliance_finding_status_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_finding_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compliance_finding_status_tbl`
--

LOCK TABLES `compliance_finding_status_tbl` WRITE;
/*!40000 ALTER TABLE `compliance_finding_status_tbl` DISABLE KEYS */;
INSERT INTO `compliance_finding_status_tbl` VALUES (1,'Open Item',0),(2,'Closed Item',0);
/*!40000 ALTER TABLE `compliance_finding_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compliance_finding_tbl`
--

DROP TABLE IF EXISTS `compliance_finding_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_finding_tbl` (
  `compliance_finding_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_audit_id` int(11) DEFAULT NULL,
  `compliance_finding_title` varchar(200) DEFAULT NULL,
  `compliance_finding_description` text,
  `compliance_finding_deadline` date DEFAULT NULL,
  `compliance_finding_status` int(11) DEFAULT NULL,
  `compliance_finding_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_finding_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `system_authorization_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_authorization_tbl` (
  `system_authorization_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_authorization_order` int(11) DEFAULT NULL,
  `system_authorization_action_type` varchar(1) DEFAULT NULL,
  `system_authorization_section_name` varchar(100) DEFAULT NULL,
  `system_authorization_section_cute_name` varchar(100) DEFAULT NULL,
  `system_authorization_subsection_name` varchar(100) DEFAULT NULL,
  `system_authorization_subsection_cute_name` varchar(100) DEFAULT NULL,
  `system_authorization_subsection_submenu` int(1) NOT NULL DEFAULT '1',
  `system_authorization_target_url` varchar(100) DEFAULT NULL,
  `system_authorization_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`system_authorization_id`)
) ENGINE=InnoDB AUTO_INCREMENT=99 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_authorization_tbl`
--

LOCK TABLES `system_authorization_tbl` WRITE;
/*!40000 ALTER TABLE `system_authorization_tbl` DISABLE KEYS */;
INSERT INTO `system_authorization_tbl` VALUES (1,8,'r','system','System Management','system_records_list','System Records',1,'system/system_records_list.php',0),(2,8,'r','system','System Management','system_authorization_list','System Authorization',1,'system/system_authorization_list.php',0),(3,8,'r','system','System Management','system_roles_list','System Roles',1,'system/system_roles_list.php',0),(4,8,'w','system','System Management','system_records_edit','System Records',1,'system/system_records_edit.php',0),(5,8,'w','system','System Management','system_authorization_edit','System Authorization',1,'system/system_authorization_edit.php',0),(6,8,'w','system','System Management','system_roles_edit','System Roles',1,'system/system_roles_edit.php',0),(7,1,'r','organization','Organization','bu_list','Business Units',1,'organization/bu_list.php',0),(8,1,'w','organization','Organization','bu_edit','Business Units',1,'organization/bu_edit.php',0),(9,1,'r','organization','Organization','legal_list','Legal Constrains',1,'organization/legal_list.php',0),(10,1,'w','organization','Organization','legal_edit','Legal Constrains',1,'organization/legal_edit.php',0),(11,1,'r','organization','Organization','tp_list','Third Parties',1,'organization/tp_list.php',0),(12,1,'w','organization','Organization','tp_edit','Third Parties',1,'organization/tp_edit.php',0),(13,2,'r','asset','Asset Management','asset_classification_list','Asset Classification',1,'asset/asset_classification_list.php',0),(14,2,'w','asset','Asset Management','asset_classification_edit','Asset Classification',1,'asset/asset_classification_edit.php',0),(15,2,'r','asset','Asset Management','asset_list','Asset Identification',1,'asset/asset_list.php',0),(16,2,'w','asset','Asset Management','asset_edit','Asset Identification',1,'asset/asset_edit.php',0),(17,2,'r','asset','Asset Management','data_asset_list','Data Asset Analysis',1,'asset/data_asset_list.php',0),(18,2,'w','asset','Asset Management','data_asset_edit','Data Asset Analysis',1,'asset/data_asset_edit.php',0),(19,3,'r','risk','Risk Management','risk_classification_list','Risk Classification',1,'risk/risk_classification_list.php',0),(20,3,'w','risk','Risk Management','risk_classification_edit','Risk Classification',1,'risk/risk_classification_edit.php',0),(21,3,'r','risk','Risk Management','risk_management_list','Asset Risk Mgt',1,'risk/risk_management_list.php',0),(22,3,'w','risk','Risk Management','risk_management_edit','Asset Risk Mgt',1,'risk/risk_management_edit.php',0),(23,3,'r','risk','Risk Management','risk_exception_list','Risk Exception',1,'risk/risk_exception_list.php',0),(24,3,'w','risk','Risk Management','risk_exception_edit','Risk Exception',1,'risk/risk_exception_edit.php',0),(25,4,'r','security_services','Security Services','security_catalogue_list','Security Controls Catalogue',1,'services/security_catalogue_list.php',0),(26,4,'w','security_services','Security Services','security_catalogue_edit','Security Controls Catalogue',1,'services/security_catalogue_edit.php',0),(28,4,'w','security_services','Security Services','security_services_audit_edit','Security Services Audit',1,'services/security_services_audit_edit.php',0),(29,4,'r','security_services','Security Services','service_contracts_list','Service Contracts',1,'services/service_contracts_list.php',0),(30,4,'w','security_services','Security Services','service_contracts_edit','Service Contracts',1,'services/service_contracts_edit.php',0),(31,6,'r','compliance','Compliance Management','compliance_package_list','Compliance Packages',1,'compliance/compliance_package_list.php',0),(32,6,'w','compliance','Compliance Management','compliance_package_edit','Compliance Packages',1,'compliance/compliance_package_edit.php',0),(33,6,'w','compliance','Compliance Management','compliance_package_item_edit','Compliance Packages',1,'compliance/compliance_package_item_edit.php',0),(34,6,'w','compliance','Compliance Management','compliance_package_upload','Compliance Packages',1,'compliance/compliance_package_upload.php',0),(35,6,'r','compliance','Compliance Management','compliance_management_list','Compliance Analysis',1,'compliance/compliance_management_list.php',0),(36,6,'r','compliance','Compliance Management','compliance_management_step_two','Compliance Analysis',0,'compliance/compliance_management_list_step_two.php',0),(37,6,'w','compliance','Compliance Management','compliance_management_edit','Compliance Analysis',1,'compliance/compliance_management_edit.php',0),(39,6,'r','compliance','Compliance Management','compliance_management','Compliance Analysis',0,'compliance/compliance_management_list.php',0),(40,6,'r','compliance','Compliance Management','compliance_exception_list','Compliance Exception',1,'compliance/compliance_exception_list.php',0),(41,6,'w','compliance','Compliance Management','compliance_exception_edit','Compliance Exception',1,'compliance/compliance_exception_edit.php',0),(43,7,'r','operations','Security Operations','project_improvements_list','Project Improvements',1,'operations/project_improvements_list.php',0),(45,7,'w','operations','Security Operations','security_incident_edit','Security Incidents',1,'operations/security_incident_edit.php',0),(46,7,'r','operations','Security Operations','security_incident_list','Security Incidents',1,'operations/security_incident_list.php',0),(47,1,'w','organization','Organization','process_edit','Process',1,'organization/process_edit.php',0),(48,4,'r','security_services','Security Services','dashboard','Dashboard',0,'services/dashboard.php',0),(49,7,'r','operations','Security Operations','security_incident_classification_list','Security Incident Classification',1,'operations/security_incident_classification_list.php',0),(50,7,'w','operations','Security Operations','security_incident_classification_edit','Security Incident Classification',1,'operations/security_incident_classification_edit.php',0),(54,3,'r','risk','Risk Management','dashboard','Dashboard',0,'risk/dashboard.php',0),(55,2,'r','asset','Asset Management','dashboard','Dashboard',0,'asset/dashboard.php',0),(56,6,'r','compliance','Compliance Management','dashboard','Dashboard',0,'compliance/dashboard.php',0),(57,7,'r','operations','Security Operations','dashboard','Dashboard',0,'operations/dashboard.php',0),(58,8,'r','system','System Management','dashboard','Dashboard',0,'system/dashboard.php',0),(59,7,'r','operations','Security Operations','policy_exceptions_list','Policy Exceptions',1,'operations/policy_exceptions_list.php',0),(60,7,'w','operations','Security Operations','policy_exceptions_edit','Policy Exceptions',1,'operations/policy_exceptions_edit.php',0),(61,1,'r','organization','Organization','dashboard','Dashboard',0,'organization/dashboard.php',0),(62,0,'r','calendar','Calendar','dashboard','',1,'default_landpage.php',0),(63,8,'r','system','System Management','system_info','System Information',1,'system/system_information.php',0),(64,3,'r','risk','Risk Management','risk_tp_list','Third Party Risk Mgt',1,'risk/risk_tp_list.php',0),(65,3,'w','risk','Risk Management','risk_tp_edit','Third Party Risk Mgt',1,'risk/risk_tp_edit.php',0),(66,7,'w','operations','Security Operations','project_improvements_edit','Project Improvements',1,'operations/project_improvements_edit.php',0),(67,2,'r','asset','Asset Management','asset_label_list','Asset Labeling',1,'asset/asset_label_list.php',0),(68,2,'w','asset','Asset Management','asset_label_edit','Asset Labeling',1,'asset/asset_label_edit.php',0),(81,3,'r','risk','Risk Management','risk_buss_list','BU Risk Mgt',1,'risk/risk_buss_list.php',0),(82,3,'w','risk','Risk Management','risk_buss_edit','BU Risk Mgt',1,'risk/risk_buss_edit.php',0),(83,5,'r','bcm','BCM','bcm_plans_list','BCM Plans',1,'bcm/continuity_plans_list.php',0),(84,5,'w','bcm','BCM','bcm_plans_edit','BCM Plans',1,'bcm/continuity_plans_edit.php',0),(86,5,'w','bcm','BCM','bcm_plans_audit_edit','BCM Plans Audit',1,'bcm/bcm_plans_audit_edit.php',0),(87,5,'r','bcm','BCM','bcm_plans_audit_report','BCM Plans Audit',0,'bcm/bcm_plans_audit_report.php',0),(88,4,'r','security_services','Security Catalogue','security_services_audit_report','Security Services Audit Report',0,'services/security_services_audit_report.php',0),(89,5,'e','bcm','BCM','bcm_plans_details_edit','BCM Plans Task Edit',1,'bcm/bcm_plans_details_edit.php',0),(90,7,'w','operations','Security Operations','project_improvements_expenses_edit','Project Improvements',0,'operations/project_improvements_expenses_edit.php',0),(91,7,'r','operations','Security Operations','project_improvements_expenses_list','Project Improvement Expenses',0,'operations/project_improvements_expenses_list.php',0),(92,5,'r','bcm','BCM','dashboard','BCM Dashboard',0,'bcm/dashboard.php',0),(93,4,'w','security_services','Security Services','security_services_maintenance_edit','Security Services Maintenance Edit',0,'services/security_services_maintenance_edit.php',0),(94,4,'r','security_services','Security Services','security_services_maintenance_list','Security Services Maintenance Report',0,'services/security_services_maintenance_list.php',0),(95,6,'r','compliance','Compliance Management','compliance_audit_list','Audit Calendar',1,'compliance/compliance_audit_list.php',0),(96,6,'w','compliance','Compliance Management','compliance_audit_edit','Audit Calendar',1,'compliance/compliance_audit_edit.php',0),(97,6,'r','compliance','Compliance Management','compliance_finding_list','Audit Finding',0,'compliance/compliance_finding_list.php',0),(98,6,'w','compliance','Compliance Management','compliance_finding_edit','Audit Finding',0,'compliance/compliance_finding_edit.php',0);
/*!40000 ALTER TABLE `system_authorization_tbl` ENABLE KEYS */;
UNLOCK TABLES;

