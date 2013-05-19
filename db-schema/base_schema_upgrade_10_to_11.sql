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
  `compliance_finding_package_item_id` int(11) DEFAULT NULL,
  `compliance_finding_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_finding_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;



--
-- Table structure for table `attachments_tbl`
--

DROP TABLE IF EXISTS `attachments_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments_tbl` (
  `attachments_id` int(11) NOT NULL AUTO_INCREMENT,
  `attachments_original_name` varchar(256) DEFAULT NULL,
  `attachments_ref_section` varchar(100) DEFAULT NULL,
  `attachments_ref_subsection` varchar(100) DEFAULT NULL,
  `attachments_ref_id` int(11) DEFAULT NULL,
  `attachments_upload_date` date DEFAULT NULL,
  `attachments_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`attachments_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
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

INSERT INTO `system_authorization_tbl` VALUES (1,8,'r','system','System Management','system_records_list','System Records',1,'system/system_records_list.php',0),(2,8,'r','system','System Management','system_authorization_list','System Authorization',1,'system/system_authorization_list.php',0),(3,8,'r','system','System Management','system_roles_list','System Roles',1,'system/system_roles_list.php',0),(4,8,'w','system','System Management','system_records_edit','System Records',1,'system/system_records_edit.php',0),(5,8,'w','system','System Management','system_authorization_edit','System Authorization',1,'system/system_authorization_edit.php',0),(6,8,'w','system','System Management','system_roles_edit','System Roles',1,'system/system_roles_edit.php',0),(7,1,'r','organization','Organization','bu_list','Business Units',1,'organization/bu_list.php',0),(8,1,'w','organization','Organization','bu_edit','Business Units',1,'organization/bu_edit.php',0),(9,1,'r','organization','Organization','legal_list','Legal Constrains',1,'organization/legal_list.php',0),(10,1,'w','organization','Organization','legal_edit','Legal Constrains',1,'organization/legal_edit.php',0),(11,1,'r','organization','Organization','tp_list','Third Parties',1,'organization/tp_list.php',0),(12,1,'w','organization','Organization','tp_edit','Third Parties',1,'organization/tp_edit.php',0),(13,2,'r','asset','Asset Management','asset_classification_list','Asset Classification',1,'asset/asset_classification_list.php',0),(14,2,'w','asset','Asset Management','asset_classification_edit','Asset Classification',1,'asset/asset_classification_edit.php',0),(15,2,'r','asset','Asset Management','asset_list','Asset Identification',1,'asset/asset_list.php',0),(16,2,'w','asset','Asset Management','asset_edit','Asset Identification',1,'asset/asset_edit.php',0),(17,2,'r','asset','Asset Management','data_asset_list','Data Asset Analysis',1,'asset/data_asset_list.php',0),(18,2,'w','asset','Asset Management','data_asset_edit','Data Asset Analysis',1,'asset/data_asset_edit.php',0),(19,3,'r','risk','Risk Management','risk_classification_list','Risk Classification',1,'risk/risk_classification_list.php',0),(20,3,'w','risk','Risk Management','risk_classification_edit','Risk Classification',1,'risk/risk_classification_edit.php',0),(21,3,'r','risk','Risk Management','risk_management_list','Asset Risk Mgt',1,'risk/risk_management_list.php',0),(22,3,'w','risk','Risk Management','risk_management_edit','Asset Risk Mgt',1,'risk/risk_management_edit.php',0),(23,3,'r','risk','Risk Management','risk_exception_list','Risk Exception',1,'risk/risk_exception_list.php',0),(24,3,'w','risk','Risk Management','risk_exception_edit','Risk Exception',1,'risk/risk_exception_edit.php',0),(25,4,'r','security_services','Security Services','security_catalogue_list','Security Controls Catalogue',1,'services/security_catalogue_list.php',0),(26,4,'w','security_services','Security Services','security_catalogue_edit','Security Controls Catalogue',1,'services/security_catalogue_edit.php',0),(28,4,'w','security_services','Security Services','security_services_audit_edit','Security Services Audit',1,'services/security_services_audit_edit.php',0),(29,4,'r','security_services','Security Services','service_contracts_list','Service Contracts',1,'services/service_contracts_list.php',0),(30,4,'w','security_services','Security Services','service_contracts_edit','Service Contracts',1,'services/service_contracts_edit.php',0),(31,6,'r','compliance','Compliance Management','compliance_package_list','Compliance Packages',1,'compliance/compliance_package_list.php',0),(32,6,'w','compliance','Compliance Management','compliance_package_edit','Compliance Packages',1,'compliance/compliance_package_edit.php',0),(33,6,'w','compliance','Compliance Management','compliance_package_item_edit','Compliance Packages',1,'compliance/compliance_package_item_edit.php',0),(34,6,'w','compliance','Compliance Management','compliance_package_upload','Compliance Packages',1,'compliance/compliance_package_upload.php',0),(35,6,'r','compliance','Compliance Management','compliance_management_list','Compliance Analysis',1,'compliance/compliance_management_list.php',0),(36,6,'r','compliance','Compliance Management','compliance_management_step_two','Compliance Analysis',0,'compliance/compliance_management_list_step_two.php',0),(37,6,'w','compliance','Compliance Management','compliance_management_edit','Compliance Analysis',1,'compliance/compliance_management_edit.php',0),(39,6,'r','compliance','Compliance Management','compliance_management','Compliance Analysis',0,'compliance/compliance_management_list.php',0),(40,6,'r','compliance','Compliance Management','compliance_exception_list','Compliance Exception',1,'compliance/compliance_exception_list.php',0),(41,6,'w','compliance','Compliance Management','compliance_exception_edit','Compliance Exception',1,'compliance/compliance_exception_edit.php',0),(43,7,'r','operations','Security Operations','project_improvements_list','Project Improvements',1,'operations/project_improvements_list.php',0),(45,7,'w','operations','Security Operations','security_incident_edit','Security Incidents',1,'operations/security_incident_edit.php',0),(46,7,'r','operations','Security Operations','security_incident_list','Security Incidents',1,'operations/security_incident_list.php',0),(47,1,'w','organization','Organization','process_edit','Process',1,'organization/process_edit.php',0),(48,4,'r','security_services','Security Services','dashboard','Dashboard',0,'services/dashboard.php',0),(49,7,'r','operations','Security Operations','security_incident_classification_list','Security Incident Classification',1,'operations/security_incident_classification_list.php',0),(50,7,'w','operations','Security Operations','security_incident_classification_edit','Security Incident Classification',1,'operations/security_incident_classification_edit.php',0),(54,3,'r','risk','Risk Management','dashboard','Dashboard',0,'risk/dashboard.php',0),(55,2,'r','asset','Asset Management','dashboard','Dashboard',0,'asset/dashboard.php',0),(56,6,'r','compliance','Compliance Management','dashboard','Dashboard',0,'compliance/dashboard.php',0),(57,7,'r','operations','Security Operations','dashboard','Dashboard',0,'operations/dashboard.php',0),(58,8,'r','system','System Management','dashboard','Dashboard',0,'system/dashboard.php',0),(59,7,'r','operations','Security Operations','policy_exceptions_list','Policy Exceptions',1,'operations/policy_exceptions_list.php',0),(60,7,'w','operations','Security Operations','policy_exceptions_edit','Policy Exceptions',1,'operations/policy_exceptions_edit.php',0),(61,1,'r','organization','Organization','dashboard','Dashboard',0,'organization/dashboard.php',0),(62,0,'r','calendar','Calendar','dashboard','',1,'default_landpage.php',0),(63,8,'r','system','System Management','system_info','System Information',1,'system/system_information.php',0),(64,3,'r','risk','Risk Management','risk_tp_list','Third Party Risk Mgt',1,'risk/risk_tp_list.php',0),(65,3,'w','risk','Risk Management','risk_tp_edit','Third Party Risk Mgt',1,'risk/risk_tp_edit.php',0),(66,7,'w','operations','Security Operations','project_improvements_edit','Project Improvements',1,'operations/project_improvements_edit.php',0),(67,2,'r','asset','Asset Management','asset_label_list','Asset Labeling',1,'asset/asset_label_list.php',0),(68,2,'w','asset','Asset Management','asset_label_edit','Asset Labeling',1,'asset/asset_label_edit.php',0),(81,3,'r','risk','Risk Management','risk_buss_list','BU Risk Mgt',1,'risk/risk_buss_list.php',0),(82,3,'w','risk','Risk Management','risk_buss_edit','BU Risk Mgt',1,'risk/risk_buss_edit.php',0),(83,5,'r','bcm','BCM','bcm_plans_list','BCM Plans',1,'bcm/continuity_plans_list.php',0),(84,5,'w','bcm','BCM','bcm_plans_edit','BCM Plans',1,'bcm/continuity_plans_edit.php',0),(86,5,'w','bcm','BCM','bcm_plans_audit_edit','BCM Plans Audit',1,'bcm/bcm_plans_audit_edit.php',0),(87,5,'r','bcm','BCM','bcm_plans_audit_report','BCM Plans Audit',0,'bcm/bcm_plans_audit_report.php',0),(88,4,'r','security_services','Security Catalogue','security_services_audit_report','Security Services Audit Report',0,'services/security_services_audit_report.php',0),(89,5,'e','bcm','BCM','bcm_plans_details_edit','BCM Plans Task Edit',1,'bcm/bcm_plans_details_edit.php',0),(90,7,'w','operations','Security Operations','project_improvements_expenses_edit','Project Improvements',0,'operations/project_improvements_expenses_edit.php',0),(91,7,'r','operations','Security Operations','project_improvements_expenses_list','Project Improvement Expenses',0,'operations/project_improvements_expenses_list.php',0),(92,5,'r','bcm','BCM','dashboard','BCM Dashboard',0,'bcm/dashboard.php',0),(93,4,'w','security_services','Security Services','security_services_maintenance_edit','Security Services Maintenance Edit',0,'services/security_services_maintenance_edit.php',0),(94,4,'r','security_services','Security Services','security_services_maintenance_list','Security Services Maintenance Report',0,'services/security_services_maintenance_list.php',0),(95,6,'r','compliance','Compliance Management','compliance_audit_list','Audit Calendar',1,'compliance/compliance_audit_list.php',0),(96,6,'w','compliance','Compliance Management','compliance_audit_edit','Audit Calendar',1,'compliance/compliance_audit_edit.php',0),(97,6,'r','compliance','Compliance Management','compliance_finding_list','Audit Finding',0,'compliance/compliance_finding_list.php',0),(98,6,'w','compliance','Compliance Management','compliance_finding_edit','Audit Finding',0,'compliance/compliance_finding_edit.php',0),(99,1,'w','attachments','Uploads','attachments_edit','Upload Files',0,'attachments/attachments_edit.php',0),(100,1,'w','attachments','Uploads','attachments_list','Browse Uploads',0,'attachments/attachments_list.php',0),(101,4,'w','security_services','Security Services','security_services_classification_edit','Security Services Classification',1,'services/security_services_classification_edit.php',0),(102,4,'r','security_services','Security Services','security_services_classification_list','Security Services Classification',1,'services/security_services_classification_list.php',0);

/*!40000 ALTER TABLE `system_authorization_tbl` DISABLE KEYS */;
/*!40000 ALTER TABLE `system_authorization_tbl` ENABLE KEYS */;
UNLOCK TABLES;


-- Table structure for table `tiv_threats_tbl`
--

DROP TABLE IF EXISTS `tiv_threats_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiv_threats_tbl` (
  `tiv_threats_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tiv_threats_category` varchar(100) DEFAULT NULL,
  `tiv_threats_name` varchar(100) DEFAULT NULL,
  `tiv_threats_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`tiv_threats_id`)
) ENGINE=InnoDB AUTO_INCREMENT=98 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiv_threats_tbl`
--

LOCK TABLES `tiv_threats_tbl` WRITE;
/*!40000 ALTER TABLE `tiv_threats_tbl` DISABLE KEYS */;
INSERT INTO `tiv_threats_tbl` VALUES (14,'Nature and Accidents','Earthquakes',0),(15,'Nature and Accidents','Landslides',0),(16,'Nature and Accidents','Volcanoes',0),(17,'Nature and Accidents','Fires ',0),(18,'Nature and Accidents','Storms and floods ',0),(19,'Nature and Accidents','Transportation accidents',0),(20,'Nature and Accidents','Hazardous materials related events ',0),(21,'Nature and Accidents','Solar flares',0),(22,'Current and Past Employees','Human error ',0),(23,'Current and Past Employees','Sabotage ',0),(24,'Current and Past Employees','Tampering ',0),(25,'Current and Past Employees','Vandalism ',0),(26,'Current and Past Employees','Theft ',0),(27,'Current and Past Employees','Unions',0),(28,'Current and Past Employees','Pandemics and disease ',0),(29,'Current and Past Employees','Insider trading ',0),(30,'Current and Past Employees','Fraud ',0),(31,'Current and Past Employees','Liability for employee actions ',0),(32,'Current and Past Employees','Scandals ',0),(33,'Current and Past Employees','Corporate crime ',0),(34,'Current and Past Employees','Discriminatory abuse ',0),(35,'Current and Past Employees','Workplace bullying ',0),(36,'Current and Past Employees','Sexual harassment ',0),(37,'Current and Past Employees','Professional misconduct ',0),(38,'Current and Past Employees','Negligence ',0),(39,'Current and Past Employees','Passive–aggressive behaviour ',0),(40,'Current and Past Employees','Workplace revenge ',0),(41,'Current and Past Employees','Insurance fraud ',0),(42,'Current and Past Employees','Lawsuits against employer ',0),(43,'Competitors','Industrial espionage ',0),(44,'Competitors','Intellectual property theft ',0),(45,'Competitors','Copyright infringement ',0),(46,'Competitors','Mudslinging ',0),(47,'Competitors','Illegal infiltration ',0),(48,'Competitors','Dirty tricks ',0),(49,'Competitors','Patent infringement ',0),(50,'Competitors','Competitive research ',0),(51,'Competitors','Price surveillance ',0),(52,'Litigants','Seeking confidential data as evidence ',0),(53,'The Press','Bad publicity ',0),(54,'The Press','Exposing trade secrets ',0),(55,'The Press','Exposing strategy and new products ',0),(56,'Hacking','IP Spoofing ',0),(57,'Hacking','Social engineering ',0),(58,'Hacking','Man-in-the-middle spoofing ',0),(59,'Hacking','DNS Poisoning ',0),(60,'Hacking','Trojan ',0),(61,'Hacking','Cracks ',0),(62,'Hacking','Worms ',0),(63,'Hacking','Viruses ',0),(64,'Hacking','Eavesdropping ',0),(65,'Hacking','Spam ',0),(66,'Hacking','Phishing ',0),(67,'Hacking','Spyware ',0),(68,'Hacking','Malware ',0),(69,'Hacking','Password Cracking ',0),(70,'Hacking','Network sniffing ',0),(71,'Hacking','Back door/trap door ',0),(72,'Hacking','Tunnelling ',0),(73,'Hacking','Website defacement ',0),(74,'Hacking','TCP/IP hijacking ',0),(75,'Hacking','Replay Attacks ',0),(76,'Hacking','System tampering ',0),(77,'Hacking','System penetration ',0),(78,'Criminals','Kidnapping ',0),(79,'Criminals','Bribery ',0),(80,'Criminals','Extortion ',0),(81,'Criminals','Fraud ',0),(82,'Criminals','Theft ',0),(83,'Criminals','Physical infrastructure attacks ',0),(84,'Criminals','Information blackmail ',0),(85,'Criminals','Assault ',0),(86,'Criminals','Sale of stolen information ',0),(87,'Criminals','Cyberstalking ',0),(88,'Governments','Acts of war',0),(89,'Governments','Nuclear war ',0),(90,'Governments','Biological warfare ',0),(91,'Governments','Chemical warfare ',0),(92,'Governments','Computer warfare',0),(93,'Governments','Espionage ',0),(94,'Governments','Terrorism ',0),(95,'Governments','Cyberwarfare ',0),(96,'Governments','Electromagnetic weapons ',0),(97,'Governments','Wiretapping ',0);
/*!40000 ALTER TABLE `tiv_threats_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tiv_vuln_tbl`
--

DROP TABLE IF EXISTS `tiv_vuln_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiv_vuln_tbl` (
  `tiv_vuln_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tiv_vuln_category` varchar(100) DEFAULT NULL,
  `tiv_vuln_name` varchar(100) DEFAULT NULL,
  `tiv_vuln_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`tiv_vuln_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiv_vuln_tbl`
--

LOCK TABLES `tiv_vuln_tbl` WRITE;
/*!40000 ALTER TABLE `tiv_vuln_tbl` DISABLE KEYS */;
INSERT INTO `tiv_vuln_tbl` VALUES (1,'Nature and Accidents','abcd',0),(2,'Nature and Accidents','sdf',0),(3,'Nature and Accidents','adaf',0),(4,'Nature and Accidents','dfas',0),(5,'Nature and Accidents','sf',0),(6,'Nature and Accidents','sf',0),(7,'Nature and Accidents','asf',0),(8,'Nature and Accidents','',0),(9,'Current and Past Employees','',0),(10,'Current and Past Employees','',0),(11,'Current and Past Employees','',0),(12,'Current and Past Employees','',0),(13,'Current and Past Employees','',0),(14,'Current and Past Employees','',0),(15,'Current and Past Employees','',0),(16,'Current and Past Employees','',0),(17,'Current and Past Employees','',0),(18,'Current and Past Employees','',0),(19,'Current and Past Employees','',0),(20,'Current and Past Employees','',0),(21,'Current and Past Employees','',0),(22,'Current and Past Employees','',0),(23,'Current and Past Employees','',0),(24,'Current and Past Employees','',0),(25,'Current and Past Employees','',0),(26,'Current and Past Employees','',0),(27,'Current and Past Employees','',0),(28,'Current and Past Employees','',0),(29,'Current and Past Employees','',0),(30,'Competitors','',0),(31,'Competitors','',0),(32,'Competitors','',0),(33,'Competitors','',0),(34,'Competitors','',0),(35,'Competitors','',0),(36,'Competitors','',0),(37,'Competitors','',0),(38,'Competitors','',0),(39,'Litigants','',0),(40,'The Press','',0),(41,'The Press','',0),(42,'The Press','',0),(43,'Hacking','',0),(44,'Hacking','',0),(45,'Hacking','',0),(46,'Hacking','',0),(47,'Hacking','',0),(48,'Hacking','',0),(49,'Hacking','',0),(50,'Hacking','',0),(51,'Hacking','',0),(52,'Hacking','',0),(53,'Hacking','',0),(54,'Hacking','',0),(55,'Hacking','',0),(56,'Hacking','',0),(57,'Hacking','',0),(58,'Hacking','',0),(59,'Hacking','',0),(60,'Hacking','',0),(61,'Hacking','',0),(62,'Hacking','',0),(63,'Hacking','',0),(64,'Hacking','',0),(65,'Criminals','',0),(66,'Criminals','',0),(67,'Criminals','',0),(68,'Criminals','',0),(69,'Criminals','',0),(70,'Criminals','',0),(71,'Criminals','',0),(72,'Criminals','',0),(73,'Criminals','',0),(74,'Criminals','',0),(75,'Governments','',0),(76,'Governments','',0),(77,'Governments','',0),(78,'Governments','',0),(79,'Governments','',0),(80,'Governments','',0),(81,'Governments','',0),(82,'Governments','',0),(83,'Governments','',0),(84,'Governments','',0);
/*!40000 ALTER TABLE `tiv_vuln_tbl` ENABLE KEYS */;
UNLOCK TABLES;

ALTER TABLE `security_incident_tbl` ADD COLUMN `security_incident_tp_id` INT NULL  AFTER `security_incident_owner_id` ;

CREATE  TABLE `security_services_classification_tbl` (
  `security_services_classification_id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,
  `security_services_classification_name` VARCHAR(100) NULL ,
  `security_services_classification_criteria` TEXT NULL ,
  `security_services_classification_disabled` INT NULL DEFAULT 1 ,
  PRIMARY KEY (`security_services_classification_id`) );

ALTER TABLE `security_services_tbl` ADD COLUMN `security_services_classification_id` INT NULL  AFTER `security_services_status` ;

ALTER TABLE `security_incident_tbl` ADD COLUMN `security_incident_reporter_id` VARCHAR(45) NULL  AFTER `security_incident_owner_id` , ADD COLUMN `security_incident_victim_id` VARCHAR(45) NULL  AFTER `security_incident_reporter_id` ;

INSERT INTO `system_authorization_tbl` (`system_authorization_order`, `system_authorization_action_type`, `system_authorization_section_name`, `system_authorization_section_cute_name`, `system_authorization_subsection_name`, `system_authorization_subsection_cute_name`, `system_authorization_subsection_submenu`, `system_authorization_target_url`, `system_authorization_disabled`) VALUES (4, 'r', 'security_services', 'Security Services', 'security_services_analysis_list', 'Security Services Analysis', 1, 'services/security_services_analysis_list.php', 0);

--
-- Table structure for table `security_services_analysis_tbl`
--

DROP TABLE IF EXISTS `security_services_analysis_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_analysis_tbl` (
  `security_services_analysis_id` int(10) NOT NULL AUTO_INCREMENT,
  `security_services_analysis_control_name` varchar(100) DEFAULT NULL,
  `security_services_analysis_control_id` int(11) DEFAULT NULL,
  `security_services_analysis_fa` int(11) DEFAULT NULL,
  `security_services_analysis_resource` decimal(10,2) DEFAULT NULL,
  `security_services_analysis_opex` int(11) DEFAULT NULL,
  `security_services_analysis_contracts` int(11) DEFAULT NULL,
  `security_services_analysis_capex` int(11) DEFAULT NULL,
  `security_services_analysis_classification_name` varchar(100) DEFAULT NULL,
  `security_services_analysis_risk_score` int(11) DEFAULT NULL,
  `security_services_analysis_risk_asset` int(11) DEFAULT NULL,
  `security_services_analysis_tp_risk` int(11) DEFAULT NULL,
  `security_services_analysis_data_flows` int(11) DEFAULT NULL,
  `security_services_analysis_compliance` int(11) DEFAULT NULL,
  `security_services_analysis_mit_total` int(11) DEFAULT NULL,
  `security_services_analysis_disabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`security_services_analysis_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3227 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

-- Table structure for table `tiv_vuln_tbl`
--

DROP TABLE IF EXISTS `tiv_vuln_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tiv_vuln_tbl` (
  `tiv_vuln_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `tiv_vuln_category` varchar(100) DEFAULT NULL,
  `tiv_vuln_name` varchar(100) DEFAULT NULL,
  `tiv_vuln_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`tiv_vuln_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiv_vuln_tbl`
--

LOCK TABLES `tiv_vuln_tbl` WRITE;
/*!40000 ALTER TABLE `tiv_vuln_tbl` DISABLE KEYS */;
INSERT INTO `tiv_vuln_tbl` VALUES (1,'Nature and Accidents','Seismic Areas',0),(2,'Nature and Accidents','Flooding Prone Areas',0),(3,'Nature and Accidents','Loose of Energy',0),(4,'Nature and Accidents','Warm Climate',0),(5,'Nature and Accidents','Cold Climate',0),(6,'Nature and Accidents','Ice',0),(7,'Nature and Accidents','Tornados',0),(8,'Nature and Accidents','Hurricane',0),(9,'Current and Past Employees','Intentional Theft',0),(10,'Current and Past Employees','Creeping Accounts',0),(11,'Current and Past Employees','Weak Check-Out Process',0),(12,'Current and Past Employees','Complot',0),(13,'Current and Past Employees','Employee Rotation',0),(14,'Current and Past Employees','Lack of Segregation of Duties',0),(30,'Criminals','Complot',0),(31,'Criminals','Intellectual Property Theft',0),(40,'The Press','Reputational Issues',0),(43,'Hacking','Weak Systems',0),(44,'Hacking','Lack of Patching',0),(45,'Hacking','Creeping Accounts',0),(46,'Hacking','Weak Passwords',0),(47,'Hacking','Weak Authetication Systems',0),(48,'Hacking','Lack of Account Reviews',0),(49,'Hacking','Lack of Anti-Virus',0),(50,'Hacking','Lack of Processes',0),(51,'Hacking','Weak Change Management',0),(52,'Hacking','Weak Authorization Systems',0),(53,'Hacking','Web-Application Vulnerabilities',0),(54,'Hacking','Wrong Configurations',0),(55,'Hacking','Open Network Ports',0),(56,'Hacking','Weak Encryption',0),(57,'Hacking','Weak Security Awareness',0),(58,'Hacking','Lack of Integrity Checks',0),(59,'Hacking','Social Engineering',0),(65,'Current and Past Employees','Unintentional Theft',0),(66,'Current and Past Employees','Unintentional Loss',0),(67,'Current and Past Employees','Unintentional Disclosure of Information',0),(68,'Criminals','Intentional Disclosure of Information',0),(75,'Governments','Counter-Intelligence',0);
/*!40000 ALTER TABLE `tiv_vuln_tbl` ENABLE KEYS */;
UNLOCK TABLES;
