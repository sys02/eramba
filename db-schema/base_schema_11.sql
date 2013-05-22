-- MySQL dump 10.13  Distrib 5.5.15, for osx10.6 (i386)
--
-- Host: localhost    Database: globant_prod_v11
-- ------------------------------------------------------
-- Server version	5.5.15

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `asset_bu_join`
--

DROP TABLE IF EXISTS `asset_bu_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_bu_join` (
  `asset_bu_join_asset_id` int(11) NOT NULL,
  `asset_bu_join_bu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asset_classification_join`
--

DROP TABLE IF EXISTS `asset_classification_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_classification_join` (
  `asset_classification_join_asset_id` int(11) DEFAULT NULL,
  `asset_classification_join_asset_classification_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `asset_classification_tbl`
--

DROP TABLE IF EXISTS `asset_classification_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_classification_tbl` (
  `asset_classification_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_classification_name` varchar(100) DEFAULT NULL,
  `asset_classification_criteria` text,
  `asset_classification_type` varchar(45) DEFAULT NULL,
  `asset_classification_value` int(11) DEFAULT NULL,
  `asset_classification_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`asset_classification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=34 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `asset_dashboard_tbl`
--

DROP TABLE IF EXISTS `asset_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_dashboard_tbl` (
  `asset_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `count_assets_total` int(11) DEFAULT NULL,
  `count_assets_type_one` int(11) DEFAULT NULL,
  `count_assets_type_two` int(11) DEFAULT NULL,
  `count_assets_type_three` int(11) DEFAULT NULL,
  `count_assets_type_four` int(11) NOT NULL,
  `count_assets_type_five` int(11) NOT NULL,
  `percentage_of_missing_controls` int(11) NOT NULL,
  `percentage_of_wrong_controls` int(11) NOT NULL,
  `dashboard_date` date NOT NULL,
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`asset_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asset_label_tbl`
--

DROP TABLE IF EXISTS `asset_label_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_label_tbl` (
  `asset_label_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_label_name` varchar(100) DEFAULT NULL,
  `asset_label_criteria` text,
  `asset_label_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`asset_label_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `asset_media_type_tbl`
--

DROP TABLE IF EXISTS `asset_media_type_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_media_type_tbl` (
  `asset_media_type_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `asset_media_type_name` varchar(100) DEFAULT NULL,
  `asset_media_type_description` text,
  `asset_media_type_disabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`asset_media_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `asset_media_type_tbl`
--

LOCK TABLES `asset_media_type_tbl` WRITE;
/*!40000 ALTER TABLE `asset_media_type_tbl` DISABLE KEYS */;
INSERT INTO `asset_media_type_tbl` VALUES (1,'Data Asset',NULL,0),(2,'Information System Asset',NULL,0),(3,'Human Assets',NULL,0),(4,'Hardware',NULL,0),(5,'Software',NULL,0);
/*!40000 ALTER TABLE `asset_media_type_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `asset_tbl`
--

DROP TABLE IF EXISTS `asset_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `asset_tbl` (
  `asset_id` int(11) NOT NULL AUTO_INCREMENT,
  `asset_name` varchar(100) DEFAULT NULL,
  `asset_description` text,
  `asset_media_type_id` int(11) DEFAULT NULL,
  `asset_label_id` int(11) DEFAULT NULL,
  `asset_legal_id` int(11) DEFAULT NULL,
  `asset_owner_id` int(11) DEFAULT NULL,
  `asset_guardian_id` int(11) DEFAULT NULL,
  `asset_user_id` int(11) DEFAULT NULL,
  `asset_container_id` int(11) DEFAULT NULL,
  `asset_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`asset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=100 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `attachments_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `attachments_tbl` (
  `attachments_id` int(11) NOT NULL AUTO_INCREMENT,
  `attachments_original_name` varchar(256) DEFAULT NULL,
  `attachments_unique_name` varchar(45) DEFAULT NULL,
  `attachments_ref_section` varchar(100) DEFAULT NULL,
  `attachments_ref_subsection` varchar(100) DEFAULT NULL,
  `attachments_ref_id` int(11) DEFAULT NULL,
  `attachments_upload_date` date DEFAULT NULL,
  `attachments_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`attachments_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bcm_plans_audit_tbl`
--

DROP TABLE IF EXISTS `bcm_plans_audit_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bcm_plans_audit_tbl` (
  `bcm_plans_audit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `bcm_plans_audit_bcm_plans_id` int(11) DEFAULT NULL,
  `bcm_plans_audit_status` int(11) DEFAULT NULL,
  `bcm_plans_audit_calendar_id` int(11) DEFAULT NULL,
  `bcm_plans_audit_planned_year` int(11) DEFAULT NULL,
  `bcm_plans_audit_metric` text NOT NULL,
  `bcm_plans_audit_criteria` text NOT NULL,
  `bcm_plans_audit_start_audit_date` date DEFAULT NULL,
  `bcm_plans_audit_end_audit_date` date DEFAULT NULL,
  `bcm_plans_audit_auditor` varchar(100) DEFAULT NULL,
  `bcm_plans_audit_result` int(11) DEFAULT '1',
  `bcm_plans_audit_result_description` text,
  `bcm_plans_audit_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`bcm_plans_audit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bcm_plans_catalogue_audit_calendar_join`
--

DROP TABLE IF EXISTS `bcm_plans_catalogue_audit_calendar_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bcm_plans_catalogue_audit_calendar_join` (
  `bcm_plans_catalogue_id` int(11) NOT NULL,
  `bcm_plans_audit_calendar_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


DROP TABLE IF EXISTS `bcm_plans_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bcm_plans_dashboard_tbl` (
  `bcm_plans_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `bcm_plans_dashboard_count` int(11) DEFAULT NULL,
  `bcm_plans_dashboard_failed_audits` int(11) DEFAULT NULL,
  `dashboard_date` date DEFAULT NULL,
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`bcm_plans_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bcm_plans_details_tbl`
--

DROP TABLE IF EXISTS `bcm_plans_details_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bcm_plans_details_tbl` (
  `bcm_plans_details_id` int(11) NOT NULL AUTO_INCREMENT,
  `bcm_plans_details_bcm_plan_id` int(11) NOT NULL,
  `bcm_plans_details_step` int(11) NOT NULL,
  `bcm_plans_details_when` text NOT NULL,
  `bcm_plans_details_who` text NOT NULL,
  `bcm_plans_details_what` text NOT NULL,
  `bcm_plans_details_where` text NOT NULL,
  `bcm_plans_details_how` text NOT NULL,
  `bcm_plans_details_disabled` int(1) NOT NULL,
  PRIMARY KEY (`bcm_plans_details_id`)
) ENGINE=MyISAM AUTO_INCREMENT=28 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `bcm_plans_tbl`
--

DROP TABLE IF EXISTS `bcm_plans_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bcm_plans_tbl` (
  `bcm_plans_id` int(11) NOT NULL AUTO_INCREMENT,
  `bcm_plans_title` text NOT NULL,
  `bcm_plans_objective` text NOT NULL,
  `bcm_plans_lunch_criteria` text NOT NULL,
  `bcm_plans_sponsor_name` text NOT NULL,
  `bcm_plans_who_declares` text NOT NULL,
  `bcm_plans_status` int(11) NOT NULL,
  `bcm_plans_metric` text NOT NULL,
  `bcm_plans_success_criteria` text NOT NULL,
  `bcm_plans_disabled` int(1) NOT NULL,
  PRIMARY KEY (`bcm_plans_id`),
  UNIQUE KEY `bcm_plans_id` (`bcm_plans_id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `bu_tbl`
--

DROP TABLE IF EXISTS `bu_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `bu_tbl` (
  `bu_id` int(11) NOT NULL AUTO_INCREMENT,
  `bu_name` varchar(100) DEFAULT NULL,
  `bu_description` text,
  `bu_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`bu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=40 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


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
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `compliance_dashboard_tbl`
--

DROP TABLE IF EXISTS `compliance_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_dashboard_tbl` (
  `compliance_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_dashboard_comp_items` int(11) DEFAULT '0',
  `compliance_dashboard_strategy_mitigate` int(11) DEFAULT '0',
  `compliance_dashboard_strategy_na` int(11) DEFAULT '0',
  `compliance_dashboard_status_ongoing` int(11) DEFAULT '0',
  `compliance_dashboard_status_compliant` int(11) DEFAULT '0',
  `compliance_dashboard_status_noncomp` int(11) DEFAULT '0',
  `compliance_dashboard_status_na` int(11) DEFAULT '0',
  `compliance_dashboard_without_mitigation` int(11) DEFAULT '0',
  `compliance_dashboard_control_failed` int(11) DEFAULT '0',
  `dashboard_date` date DEFAULT '0000-00-00',
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `compliance_exception_tbl`
--

DROP TABLE IF EXISTS `compliance_exception_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_exception_tbl` (
  `compliance_exception_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_exception_title` varchar(100) DEFAULT NULL,
  `compliance_exception_description` text,
  `compliance_exception_author` varchar(100) DEFAULT NULL,
  `compliance_exception_expiration` date DEFAULT NULL,
  `compliance_exception_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_exception_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
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
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `compliance_management_tbl`
--

DROP TABLE IF EXISTS `compliance_management_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_management_tbl` (
  `compliance_management_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_management_item_id` int(11) DEFAULT NULL,
  `compliance_management_response_id` int(11) DEFAULT NULL,
  `compliance_management_status_id` int(11) DEFAULT NULL,
  `compliance_management_exception_id` int(11) DEFAULT NULL,
  `compliance_management_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_management_id`)
) ENGINE=InnoDB AUTO_INCREMENT=191 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `compliance_package_item_tbl`
--

DROP TABLE IF EXISTS `compliance_package_item_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_package_item_tbl` (
  `compliance_package_item_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_package_id` int(11) DEFAULT NULL,
  `compliance_package_item_original_id` varchar(45) DEFAULT NULL,
  `compliance_package_item_name` text,
  `compliance_package_item_description` text,
  `compliance_package_item_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_package_item_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2117 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `compliance_package_tbl`
--

DROP TABLE IF EXISTS `compliance_package_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_package_tbl` (
  `compliance_package_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_package_tp_id` int(11) DEFAULT NULL,
  `compliance_package_original_id` varchar(45) DEFAULT NULL,
  `compliance_package_name` text,
  `compliance_package_description` text,
  `compliance_package_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_package_id`)
) ENGINE=InnoDB AUTO_INCREMENT=107 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `compliance_response_strategy_tbl`
--

DROP TABLE IF EXISTS `compliance_response_strategy_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_response_strategy_tbl` (
  `compliance_response_strategy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `compliance_response_strategy_name` varchar(100) DEFAULT NULL,
  `compliance_response_strategy_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_response_strategy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compliance_response_strategy_tbl`
--

LOCK TABLES `compliance_response_strategy_tbl` WRITE;
/*!40000 ALTER TABLE `compliance_response_strategy_tbl` DISABLE KEYS */;
INSERT INTO `compliance_response_strategy_tbl` VALUES (1,'Mitigate',0),(2,'Not Applicable',0);
/*!40000 ALTER TABLE `compliance_response_strategy_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `compliance_security_services_join`
--

DROP TABLE IF EXISTS `compliance_security_services_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_security_services_join` (
  `compliance_security_services_join_compliance_id` int(11) DEFAULT NULL,
  `compliance_security_services_join_security_services_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `compliance_status_tbl`
--

DROP TABLE IF EXISTS `compliance_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `compliance_status_tbl` (
  `compliance_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `compliance_status_name` varchar(100) DEFAULT NULL,
  `compliance_status_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`compliance_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `compliance_status_tbl`
--

LOCK TABLES `compliance_status_tbl` WRITE;
/*!40000 ALTER TABLE `compliance_status_tbl` DISABLE KEYS */;
INSERT INTO `compliance_status_tbl` VALUES (1,'On-Going',0),(2,'Compliant',0),(3,'Non-Compliant',0),(4,'Not-Applicable',0);
/*!40000 ALTER TABLE `compliance_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_asset_security_services_join`
--

DROP TABLE IF EXISTS `data_asset_security_services_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_asset_security_services_join` (
  `data_asset_security_services_join_data_asset_id` int(11) DEFAULT NULL,
  `data_asset_security_services_join_security_services_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `data_asset_status_tbl`
--

DROP TABLE IF EXISTS `data_asset_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_asset_status_tbl` (
  `data_asset_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `data_asset_status_name` varchar(100) DEFAULT NULL,
  `data_asset_status_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`data_asset_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `data_asset_status_tbl`
--

LOCK TABLES `data_asset_status_tbl` WRITE;
/*!40000 ALTER TABLE `data_asset_status_tbl` DISABLE KEYS */;
INSERT INTO `data_asset_status_tbl` VALUES (1,'Created',0),(2,'Modified',0),(3,'Stored',0),(4,'Transit',0),(5,'Deleted',0),(6,'Tainted / Broken',0),(7,'Unnecessary',0);
/*!40000 ALTER TABLE `data_asset_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `data_asset_tbl`
--

DROP TABLE IF EXISTS `data_asset_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `data_asset_tbl` (
  `data_asset_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_asset_asset_id` int(11) DEFAULT NULL,
  `data_asset_status_id` int(11) DEFAULT NULL,
  `data_asset_description` text,
  `data_asset_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`data_asset_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `legal_tbl`
--

DROP TABLE IF EXISTS `legal_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `legal_tbl` (
  `legal_id` int(11) NOT NULL AUTO_INCREMENT,
  `legal_name` varchar(100) DEFAULT NULL,
  `legal_description` text,
  `legal_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`legal_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `organization_dashboard_tbl`
--

DROP TABLE IF EXISTS `organization_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `organization_dashboard_tbl` (
  `organization_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `organization_dashboard_count_bu` int(11) DEFAULT NULL,
  `organization_dashboard_count_process` int(11) DEFAULT NULL,
  `organization_dashboard_count_legal` int(11) DEFAULT NULL,
  `organization_dashboard_count_tp` int(11) DEFAULT NULL,
  `dashboard_date` date DEFAULT NULL,
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`organization_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=60 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `policy_exceptions_status_tbl`
--

DROP TABLE IF EXISTS `policy_exceptions_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `policy_exceptions_status_tbl` (
  `policy_exceptions_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_exceptions_status_name` varchar(45) DEFAULT NULL,
  `policy_exceptions_status_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`policy_exceptions_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `policy_exceptions_status_tbl`
--

LOCK TABLES `policy_exceptions_status_tbl` WRITE;
/*!40000 ALTER TABLE `policy_exceptions_status_tbl` DISABLE KEYS */;
INSERT INTO `policy_exceptions_status_tbl` VALUES (1,'Open',0),(2,'Closed',0),(3,'Expired',0),(4,'Approved',0);
/*!40000 ALTER TABLE `policy_exceptions_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `policy_exceptions_tbl`
--

DROP TABLE IF EXISTS `policy_exceptions_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `policy_exceptions_tbl` (
  `policy_exceptions_id` int(11) NOT NULL AUTO_INCREMENT,
  `policy_exceptions_title` varchar(100) DEFAULT NULL,
  `policy_exceptions_description` text,
  `policy_exceptions_status` int(11) DEFAULT NULL,
  `policy_exceptions_owner` varchar(45) DEFAULT NULL,
  `policy_exceptions_expiration_date` date DEFAULT NULL,
  `policy_exceptions_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`policy_exceptions_id`)
) ENGINE=InnoDB AUTO_INCREMENT=77 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `process_legal_join`
--

DROP TABLE IF EXISTS `process_legal_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `process_legal_join` (
  `process_legal_join_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_id` int(11) DEFAULT NULL,
  `legal_id` int(11) DEFAULT NULL,
  `process_legal_join_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`process_legal_join_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `process_tbl`
--

DROP TABLE IF EXISTS `process_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `process_tbl` (
  `process_id` int(11) NOT NULL AUTO_INCREMENT,
  `process_name` varchar(100) DEFAULT NULL,
  `bu_id` int(11) DEFAULT NULL,
  `process_description` text,
  `process_mto` int(11) DEFAULT NULL,
  `process_revenue` int(11) NOT NULL,
  `process_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`process_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `project_improvements_achievements_tbl`
--

DROP TABLE IF EXISTS `project_improvements_achievements_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_improvements_achievements_tbl` (
  `project_improvements_achievements_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_improvements_achievements_proj_id` int(11) DEFAULT NULL,
  `project_improvements_achievements_text` text,
  `project_improvements_achievements_owner` varchar(100) DEFAULT NULL,
  `project_improvements_achievements_date` date DEFAULT NULL,
  `project_improvements_achievements_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`project_improvements_achievements_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `project_improvements_expenses_tbl`
--

DROP TABLE IF EXISTS `project_improvements_expenses_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_improvements_expenses_tbl` (
  `project_improvements_expenses_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_improvements_expenses_project_id` int(11) NOT NULL,
  `project_improvements_expenses_description` text NOT NULL,
  `project_improvements_expenses_amount` int(11) NOT NULL,
  `project_improvements_expenses_date` date NOT NULL,
  `project_improvements_expenses_disabled` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`project_improvements_expenses_id`)
) ENGINE=MyISAM AUTO_INCREMENT=29 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `project_improvements_status_tbl`
--

DROP TABLE IF EXISTS `project_improvements_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_improvements_status_tbl` (
  `project_improvements_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_improvements_status_name` varchar(45) DEFAULT NULL,
  `project_improvements_status_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`project_improvements_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `project_improvements_status_tbl`
--

LOCK TABLES `project_improvements_status_tbl` WRITE;
/*!40000 ALTER TABLE `project_improvements_status_tbl` DISABLE KEYS */;
INSERT INTO `project_improvements_status_tbl` VALUES (1,'Planned',0),(2,'Ongoing',0),(3,'Completed',0);
/*!40000 ALTER TABLE `project_improvements_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `project_improvements_tbl`
--

DROP TABLE IF EXISTS `project_improvements_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `project_improvements_tbl` (
  `project_improvements_id` int(11) NOT NULL AUTO_INCREMENT,
  `project_improvements_title` varchar(100) DEFAULT NULL,
  `project_improvements_goal` text,
  `project_improvements_rca` text,
  `project_improvements_proactive` text,
  `project_improvements_reactive` text,
  `project_improvements_start` date DEFAULT NULL,
  `project_improvements_deadline` date DEFAULT NULL,
  `project_improvements_status_id` int(11) DEFAULT NULL,
  `project_improvements_plan_budget` int(11) DEFAULT NULL,
  `project_improvements_current_budget` int(11) NOT NULL,
  `project_improvements_owner_id` char(100) DEFAULT 'Undefined',
  `project_improvements_completion` int(11) DEFAULT '0',
  `project_improvements_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`project_improvements_id`)
) ENGINE=InnoDB AUTO_INCREMENT=134 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `risk_asset_join`
--

DROP TABLE IF EXISTS `risk_asset_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_asset_join` (
  `risk_asset_join_risk_id` int(11) NOT NULL,
  `risk_asset_join_asset_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_buss_process_join`
--

DROP TABLE IF EXISTS `risk_buss_process_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_buss_process_join` (
  `risk_buss_process_join_risk_id` int(11) NOT NULL,
  `risk_buss_process_join_bu_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_classification_join`
--

DROP TABLE IF EXISTS `risk_classification_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_classification_join` (
  `risk_classification_join_risk_id` int(11) DEFAULT NULL,
  `risk_classification_join_risk_classification_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_classification_tbl`
--

DROP TABLE IF EXISTS `risk_classification_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_classification_tbl` (
  `risk_classification_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `risk_classification_name` varchar(100) DEFAULT NULL,
  `risk_classification_criteria` text,
  `risk_classification_type` varchar(45) DEFAULT NULL,
  `risk_classification_value` int(11) DEFAULT NULL,
  `risk_classification_disabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`risk_classification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_dashboard_tbl`
--

DROP TABLE IF EXISTS `risk_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_dashboard_tbl` (
  `risk_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `risk_dashboard_count_asset_risks` int(11) DEFAULT '0',
  `risk_dashboard_count_tp_risks` int(11) DEFAULT '0',
  `risk_dashboard_count_buss_risks` int(11) DEFAULT '0',
  `risk_dashboard_percentage_expired_risks` int(11) DEFAULT '0',
  `risk_dashboard_percentage_expired_exceptions` int(11) DEFAULT '0',
  `risk_dashboard_percentage_fail_controls` int(11) DEFAULT '0',
  `risk_dashboard_count_risk_index` int(11) DEFAULT '0',
  `risk_dashboard_count_risk_residual_index` int(11) DEFAULT '0',
  `dashboard_date` date DEFAULT '0000-00-00',
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`risk_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=70 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_exception_tbl`
--

DROP TABLE IF EXISTS `risk_exception_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_exception_tbl` (
  `risk_exception_id` int(10) NOT NULL AUTO_INCREMENT,
  `risk_exception_title` varchar(100) DEFAULT NULL,
  `risk_exception_description` text,
  `risk_exception_author` varchar(100) DEFAULT NULL,
  `risk_exception_expiration` date DEFAULT NULL,
  `risk_exception_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`risk_exception_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_mitigation_strategy_tbl`
--

DROP TABLE IF EXISTS `risk_mitigation_strategy_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_mitigation_strategy_tbl` (
  `risk_mitigation_strategy_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `risk_mitigation_strategy_name` varchar(100) DEFAULT NULL,
  `risk_mitigation_strategy_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`risk_mitigation_strategy_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `risk_mitigation_strategy_tbl`
--

LOCK TABLES `risk_mitigation_strategy_tbl` WRITE;
/*!40000 ALTER TABLE `risk_mitigation_strategy_tbl` DISABLE KEYS */;
INSERT INTO `risk_mitigation_strategy_tbl` VALUES (1,'Accept',0),(2,'Avoid',0),(3,'Mitigate',0),(4,'Transfer',0);
/*!40000 ALTER TABLE `risk_mitigation_strategy_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `risk_risk_exception_join`
--

DROP TABLE IF EXISTS `risk_risk_exception_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_risk_exception_join` (
  `risk_risk_exception_join_risk_id` int(11) DEFAULT NULL,
  `risk_risk_exception_join_risk_exception_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_security_services_join`
--

DROP TABLE IF EXISTS `risk_security_services_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_security_services_join` (
  `risk_security_services_join_risk_id` int(11) DEFAULT NULL,
  `risk_security_services_join_security_services_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_tbl`
--

DROP TABLE IF EXISTS `risk_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_tbl` (
  `risk_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `risk_title` varchar(100) DEFAULT NULL,
  `risk_tp_what` text NOT NULL,
  `risk_tp_how` text NOT NULL,
  `risk_buss_what_if` text NOT NULL,
  `risk_threat` text,
  `risk_vulnerabilities` text,
  `risk_classification_score` int(11) DEFAULT NULL,
  `risk_mitigation_strategy_id` int(11) DEFAULT NULL,
  `risk_mitigation_bcm_id` int(11) NOT NULL,
  `risk_periodicity_review` date DEFAULT NULL,
  `risk_residual_score` int(11) DEFAULT NULL,
  `risk_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`risk_id`)
) ENGINE=InnoDB AUTO_INCREMENT=161 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_tp_asset_join`
--

DROP TABLE IF EXISTS `risk_tp_asset_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_tp_asset_join` (
  `risk_tp_asset_join_risk_id` int(11) NOT NULL,
  `risk_tp_asset_join_asset_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `risk_tp_join`
--

DROP TABLE IF EXISTS `risk_tp_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `risk_tp_join` (
  `risk_tp_join_risk_id` int(11) NOT NULL,
  `risk_tp_join_tp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_incident_classification_tbl`
--

DROP TABLE IF EXISTS `security_incident_classification_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_incident_classification_tbl` (
  `security_incident_classification_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_incident_classification_name` varchar(100) DEFAULT NULL,
  `security_incident_classification_criteria` text,
  `security_incident_classification_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_incident_classification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_incident_service_join`
--

DROP TABLE IF EXISTS `security_incident_service_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_incident_service_join` (
  `security_incident_service_incident_id` int(11) NOT NULL,
  `security_incident_service_service_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_incident_status_tbl`
--

DROP TABLE IF EXISTS `security_incident_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_incident_status_tbl` (
  `security_incident_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_incident_status_name` varchar(100) DEFAULT NULL,
  `security_incident_status_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_incident_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_incident_status_tbl`
--

LOCK TABLES `security_incident_status_tbl` WRITE;
/*!40000 ALTER TABLE `security_incident_status_tbl` DISABLE KEYS */;
INSERT INTO `security_incident_status_tbl` VALUES (1,'Reported',0),(2,'Ongoing',0),(3,'Closed',0);
/*!40000 ALTER TABLE `security_incident_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security_incident_tbl`
--

DROP TABLE IF EXISTS `security_incident_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_incident_tbl` (
  `security_incident_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_incident_owner_id` varchar(45) DEFAULT NULL,
  `security_incident_reporter_id` varchar(45) DEFAULT NULL,
  `security_incident_victim_id` varchar(45) DEFAULT NULL,
  `security_incident_tp_id` int(11) DEFAULT NULL,
  `security_incident_title` varchar(45) DEFAULT NULL,
  `security_incident_open_date` date DEFAULT NULL,
  `security_incident_description` text,
  `security_incident_compromised_asset_id` int(11) DEFAULT NULL,
  `security_incident_closure_date` date DEFAULT NULL,
  `security_incident_classification_id` int(11) DEFAULT NULL,
  `security_incident_status_id` int(11) DEFAULT NULL,
  `security_incident_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_incident_id`)
) ENGINE=InnoDB AUTO_INCREMENT=116 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_operations_dashboard_tbl`
--

DROP TABLE IF EXISTS `security_operations_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_operations_dashboard_tbl` (
  `security_operations_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_operations_dashboard_project_count` int(11) DEFAULT NULL,
  `security_operations_dashboard_project_idea` int(11) DEFAULT NULL,
  `security_operations_dashboard_project_initiated` int(11) DEFAULT NULL,
  `security_operations_dashboard_project_complet` int(11) DEFAULT NULL,
  `security_operations_dashboard_incident_count` int(11) DEFAULT NULL,
  `security_operations_dashboard_incident_reported` int(11) DEFAULT NULL,
  `security_operations_dashboard_incident_open` int(11) DEFAULT NULL,
  `security_operations_dashboard_incident_closed` int(11) DEFAULT NULL,
  `security_operations_dashboard_plan_budget_plan` int(11) DEFAULT NULL,
  `security_operations_dashboard_plan_budget_on` int(11) NOT NULL,
  `security_operations_dashboard_plan_budget_com` int(11) NOT NULL,
  `security_operations_dashboard_current_budget_plan` int(11) DEFAULT NULL,
  `security_operations_dashboard_current_budget_on` int(11) NOT NULL,
  `security_operations_dashboard_current_budget_com` int(11) NOT NULL,
  `dashboard_date` date DEFAULT NULL,
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_operations_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=67 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

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
) ENGINE=InnoDB AUTO_INCREMENT=5631 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_services_audit_calendar_tbl`
--

DROP TABLE IF EXISTS `security_services_audit_calendar_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_audit_calendar_tbl` (
  `security_services_audit_calendar_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `security_services_audit_calendar_name` varchar(45) DEFAULT NULL,
  `security_services_audit_calendar_value` int(11) DEFAULT NULL,
  PRIMARY KEY (`security_services_audit_calendar_id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_services_audit_calendar_tbl`
--

LOCK TABLES `security_services_audit_calendar_tbl` WRITE;
/*!40000 ALTER TABLE `security_services_audit_calendar_tbl` DISABLE KEYS */;
INSERT INTO `security_services_audit_calendar_tbl` VALUES (1,'January',1),(2,'February',2),(3,'March',3),(4,'April',4),(5,'May',5),(6,'June',6),(7,'July',7),(8,'August',8),(9,'September',9),(10,'October',10),(11,'November',11),(12,'December',12);
/*!40000 ALTER TABLE `security_services_audit_calendar_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security_services_audit_result_tbl`
--

DROP TABLE IF EXISTS `security_services_audit_result_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_audit_result_tbl` (
  `security_services_audit_result_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_services_audit_result_name` varchar(100) DEFAULT NULL,
  `security_services_audit_result_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_services_audit_result_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_services_audit_result_tbl`
--

LOCK TABLES `security_services_audit_result_tbl` WRITE;
/*!40000 ALTER TABLE `security_services_audit_result_tbl` DISABLE KEYS */;
INSERT INTO `security_services_audit_result_tbl` VALUES (1,'NA',1),(2,'Pass',0),(3,'Fail',0),(4,'Inconclusive',1);
/*!40000 ALTER TABLE `security_services_audit_result_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security_services_audit_status_tbl`
--

DROP TABLE IF EXISTS `security_services_audit_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_audit_status_tbl` (
  `security_services_audit_status_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_services_audit_status_name` varchar(100) DEFAULT NULL,
  `security_services_audit_status_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_services_audit_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_services_audit_status_tbl`
--

LOCK TABLES `security_services_audit_status_tbl` WRITE;
/*!40000 ALTER TABLE `security_services_audit_status_tbl` DISABLE KEYS */;
INSERT INTO `security_services_audit_status_tbl` VALUES (1,'Not Initiated',0),(2,'Initiated',0),(3,'Completed',0);
/*!40000 ALTER TABLE `security_services_audit_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security_services_audit_tbl`
--

DROP TABLE IF EXISTS `security_services_audit_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_audit_tbl` (
  `security_services_audit_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `security_services_audit_security_service_id` int(11) DEFAULT NULL,
  `security_services_audit_status` int(11) DEFAULT NULL,
  `security_services_audit_calendar_id` int(11) DEFAULT NULL,
  `security_services_audit_planned_year` int(11) DEFAULT NULL,
  `security_services_audit_metric` text,
  `security_services_audit_criteria` text,
  `security_services_audit_start_audit_date` date DEFAULT NULL,
  `security_services_audit_end_audit_date` date DEFAULT NULL,
  `security_services_audit_auditor` varchar(100) DEFAULT NULL,
  `security_services_audit_result` int(11) DEFAULT '1',
  `security_services_audit_result_description` text,
  `security_services_audit_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_services_audit_id`)
) ENGINE=InnoDB AUTO_INCREMENT=16280 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_services_catalogue_audit_calendar_join`
--

DROP TABLE IF EXISTS `security_services_catalogue_audit_calendar_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_catalogue_audit_calendar_join` (
  `security_service_catalogue_id` int(11) NOT NULL DEFAULT '0',
  `security_services_audit_calendar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `security_services_catalogue_maintenance_calendar_join`
--

DROP TABLE IF EXISTS `security_services_catalogue_maintenance_calendar_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_catalogue_maintenance_calendar_join` (
  `security_service_catalogue_id` int(11) NOT NULL DEFAULT '0',
  `security_services_maintenance_calendar_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_services_classification_tbl`
--

DROP TABLE IF EXISTS `security_services_classification_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_classification_tbl` (
  `security_services_classification_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `security_services_classification_name` varchar(100) DEFAULT NULL,
  `security_services_classification_criteria` text,
  `security_services_classification_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_services_classification_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_services_dashboard_tbl`
--

DROP TABLE IF EXISTS `security_services_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_dashboard_tbl` (
  `security_services_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_services_dashboard_op_prop` int(11) DEFAULT NULL,
  `security_services_dashboard_op_des` int(11) NOT NULL,
  `security_services_dashboard_op_tran` int(11) NOT NULL,
  `security_services_dashboard_op_prod` int(11) NOT NULL,
  `security_services_dashboard_cap_prop` int(11) DEFAULT NULL,
  `security_services_dashboard_cap_des` int(11) NOT NULL,
  `security_services_dashboard_cap_tran` int(11) NOT NULL,
  `security_services_dashboard_cap_prod` int(11) NOT NULL,
  `security_services_dashboard_resource` int(11) DEFAULT NULL,
  `security_services_dashboard_proposed` int(11) DEFAULT NULL,
  `security_services_dashboard_design` int(11) DEFAULT NULL,
  `security_services_dashboard_transition` int(11) DEFAULT NULL,
  `security_services_dashboard_production` int(11) DEFAULT NULL,
  `security_services_dashboard_retired` int(11) DEFAULT NULL,
  `security_services_dashboard_total` int(11) DEFAULT NULL,
  `service_audit_errors` int(11) NOT NULL,
  `dashboard_date` date DEFAULT NULL,
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_services_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=85 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `security_services_maintenance_tbl`
--

DROP TABLE IF EXISTS `security_services_maintenance_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_maintenance_tbl` (
  `security_services_maintenance_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `security_services_maintenance_security_service_id` int(11) DEFAULT NULL,
  `security_services_maintenance_status` int(11) DEFAULT NULL,
  `security_services_maintenance_calendar_id` int(11) DEFAULT NULL,
  `security_services_maintenance_planned_year` int(11) DEFAULT NULL,
  `security_services_maintenance_task` text,
  `security_services_maintenance_start_maintenance_date` date DEFAULT NULL,
  `security_services_maintenance_end_maintenance_date` date DEFAULT NULL,
  `security_services_maintenance_engineer` varchar(100) DEFAULT NULL,
  `security_services_maintenance_result` int(11) DEFAULT '1',
  `security_services_maintenance_result_description` text,
  `security_services_maintenance_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_services_maintenance_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14910 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `security_services_status_tbl`
--

DROP TABLE IF EXISTS `security_services_status_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_status_tbl` (
  `security_services_status_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `security_services_status_name` varchar(100) DEFAULT NULL,
  `security_services_status_disabled` int(11) DEFAULT NULL,
  PRIMARY KEY (`security_services_status_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `security_services_status_tbl`
--

LOCK TABLES `security_services_status_tbl` WRITE;
/*!40000 ALTER TABLE `security_services_status_tbl` DISABLE KEYS */;
INSERT INTO `security_services_status_tbl` VALUES (1,'Proposed',0),(2,'Design',0),(3,'Transition',0),(4,'Production',0),(5,'Retired',0);
/*!40000 ALTER TABLE `security_services_status_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `security_services_tbl`
--

DROP TABLE IF EXISTS `security_services_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `security_services_tbl` (
  `security_services_id` int(11) NOT NULL AUTO_INCREMENT,
  `security_services_name` varchar(100) DEFAULT NULL,
  `security_services_objective` text,
  `security_services_documentation_url` text,
  `security_services_status` int(11) DEFAULT NULL,
  `security_services_classification_id` int(11) DEFAULT NULL,
  `security_services_audit_metric` text,
  `security_services_audit_success_criteria` text,
  `security_services_regular_maintenance` text NOT NULL,
  `security_services_cost_opex` int(11) DEFAULT NULL,
  `security_services_cost_capex` int(11) DEFAULT NULL,
  `security_services_cost_operational_resource` decimal(10,2) DEFAULT NULL,
  `security_services_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`security_services_id`)
) ENGINE=InnoDB AUTO_INCREMENT=642 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `service_contracts_security_services_join`
--

DROP TABLE IF EXISTS `service_contracts_security_services_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_contracts_security_services_join` (
  `security_services_id` int(11) DEFAULT NULL,
  `service_contracts_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `service_contracts_tbl`
--

DROP TABLE IF EXISTS `service_contracts_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `service_contracts_tbl` (
  `service_contracts_id` int(11) NOT NULL AUTO_INCREMENT,
  `service_contracts_name` varchar(100) DEFAULT NULL,
  `service_contracts_description` text,
  `service_contracts_value` int(11) DEFAULT NULL,
  `service_contracts_start` date DEFAULT NULL,
  `service_contracts_end` date DEFAULT NULL,
  `service_contracts_provider_id` int(11) DEFAULT NULL,
  `service_contracts_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`service_contracts_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `system_authorization_group_role_join`
--

DROP TABLE IF EXISTS `system_authorization_group_role_join`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_authorization_group_role_join` (
  `system_authorization_group_role_role_id` int(11) DEFAULT NULL,
  `system_authorization_group_auth_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Table structure for table `system_authorization_tbl`
--

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
) ENGINE=InnoDB AUTO_INCREMENT=106 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `system_conf_pwd_tbl`
--

DROP TABLE IF EXISTS `system_conf_pwd_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_conf_pwd_tbl` (
  `system_conf_pwd_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_conf_timestamp` int(11) DEFAULT NULL,
  `system_conf_login_id` int(11) DEFAULT NULL,
  `system_conf_pwd` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`system_conf_pwd_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_conf_pwd_tbl`
--

LOCK TABLES `system_conf_pwd_tbl` WRITE;
/*!40000 ALTER TABLE `system_conf_pwd_tbl` DISABLE KEYS */;
INSERT INTO `system_conf_pwd_tbl` VALUES (19,1359891402,1,'5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),(20,1367836784,2,'8fcf0e2be31fb9cc8c59ce84b1166c93dccb3b56'),(21,1367837729,1,'5af9c3959a9bd7b25614beea8954059e8eb478a1'),(22,1368705583,2,'8047f74d3ce165d90c4d68b5994bfa394584bf3f'),(23,1368715241,2,'97baabf7f85ec256df68ceef3432519b9de8f077');
/*!40000 ALTER TABLE `system_conf_pwd_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_dashboard_tbl`
--

DROP TABLE IF EXISTS `system_dashboard_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_dashboard_tbl` (
  `system_dashboard_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_dashboard_login_ok` int(11) DEFAULT NULL,
  `system_dashboard_login_not_ok` int(11) DEFAULT NULL,
  `dashboard_date` date DEFAULT NULL,
  `dashboard_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`system_dashboard_id`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `system_group_role_tbl`
--

DROP TABLE IF EXISTS `system_group_role_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_group_role_tbl` (
  `system_group_role_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_group_role_name` varchar(100) DEFAULT NULL,
  `system_group_role_description` text,
  `system_group_role_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`system_group_role_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_group_role_tbl`
--

LOCK TABLES `system_group_role_tbl` WRITE;
/*!40000 ALTER TABLE `system_group_role_tbl` DISABLE KEYS */;
INSERT INTO `system_group_role_tbl` VALUES (1,'CISO','Can do all',0);
/*!40000 ALTER TABLE `system_group_role_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_records_tbl`
--

DROP TABLE IF EXISTS `system_records_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_records_tbl` (
  `system_records_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `system_records_section` varchar(100) DEFAULT NULL,
  `system_records_subsection` varchar(100) DEFAULT NULL,
  `system_records_item_id` varchar(100) DEFAULT NULL,
  `system_records_author` int(100) DEFAULT NULL,
  `system_records_action` varchar(100) DEFAULT NULL,
  `system_records_notes` text,
  `system_records_date` datetime DEFAULT NULL,
  PRIMARY KEY (`system_records_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10183 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_records_tbl`
--

LOCK TABLES `system_records_tbl` WRITE;
/*!40000 ALTER TABLE `system_records_tbl` DISABLE KEYS */;
INSERT INTO `system_records_tbl` VALUES (7667,'system','system_authorization_edit','1',1,'Login','','2013-04-27 00:47:52'),(7668,'asset','asset_classification_edit','22',1,'Insert','','2013-04-27 00:53:45'),(7669,'asset','asset_classification_edit','23',1,'Insert','','2013-04-27 00:54:08'),(7670,'asset','asset_classification_edit','24',1,'Insert','','2013-04-27 00:54:24'),(7671,'asset','asset_classification_edit','25',1,'Insert','','2013-04-27 00:54:55'),(7672,'asset','asset_classification_edit','26',1,'Insert','','2013-04-27 00:55:18'),(7673,'asset','asset_classification_edit','27',1,'Insert','','2013-04-27 00:55:39'),(7674,'asset','asset_classification_edit','28',1,'Insert','','2013-04-27 00:56:08'),(7675,'asset','asset_classification_edit','29',1,'Insert','','2013-04-27 00:56:28'),(7676,'asset','asset_classification_edit','30',1,'Insert','','2013-04-27 00:56:46'),(7677,'asset','asset_classification_edit','31',1,'Insert','','2013-04-27 00:57:40'),(7678,'asset','asset_classification_edit','32',1,'Insert','','2013-04-27 00:57:50'),(7679,'asset','asset_classification_edit','33',1,'Insert','','2013-04-27 00:57:57'),(7680,'asset','asset_label','',1,'Insert','','2013-04-27 00:58:29'),(7681,'asset','asset_label','',1,'Insert','','2013-04-27 00:58:48'),(7682,'asset','asset_label','',1,'Insert','','2013-04-27 00:59:12'),(7683,'organization','bu_edit','33',1,'Insert','','2013-04-27 01:00:47'),(7684,'organization','bu_edit','34',1,'Insert','','2013-04-27 01:00:52'),(7685,'organization','bu_edit','35',1,'Insert','','2013-04-27 01:01:01'),(7686,'organization','bu_edit','36',1,'Insert','','2013-04-27 01:01:07'),(7687,'organization','bu_edit','37',1,'Insert','','2013-04-27 01:01:14'),(7688,'organization','bu_edit','38',1,'Insert','','2013-04-27 01:01:20'),(7689,'organization','tp_edit','25',1,'Insert','','2013-04-27 01:03:29'),(7690,'organization','tp_edit','26',1,'Insert','','2013-04-27 01:03:41'),(7691,'organization','tp_edit','27',1,'Insert','','2013-04-27 01:04:13'),(7692,'organization','tp_edit','28',1,'Insert','','2013-04-27 01:04:29'),(7693,'organization','tp_edit','29',1,'Insert','','2013-04-27 01:04:47'),(7694,'organization','tp_edit','30',1,'Insert','','2013-04-27 01:04:55'),(7695,'organization','tp_edit','31',1,'Insert','','2013-04-27 01:05:26'),(7696,'organization','tp_edit','32',1,'Insert','','2013-04-27 01:05:41'),(7697,'organization','tp_edit','33',1,'Insert','','2013-04-27 01:05:49'),(7698,'organization','tp_edit','34',1,'Insert','','2013-04-27 01:05:59'),(7699,'organization','legal_edit','10',1,'Insert','','2013-04-27 01:06:27'),(7700,'organization','legal_edit','11',1,'Insert','','2013-04-27 01:06:44'),(7701,'organization','tp_edit','32',1,'Update','','2013-04-27 01:07:03'),(7702,'organization','tp_edit','29',1,'Update','','2013-04-27 01:07:12'),(7703,'organization','tp_edit','30',1,'Update','','2013-04-27 01:07:25'),(7704,'organization','tp_edit','28',1,'Update','','2013-04-27 01:07:38'),(7705,'asset','asset_edit','43',1,'Insert','','2013-04-27 01:11:54'),(7706,'asset','asset_edit','99',1,'Insert','','2013-04-27 17:29:38'),(7707,'asset','asset_edit','100',1,'Insert','','2013-04-27 17:30:40'),(7708,'asset','asset_edit','101',1,'Insert','','2013-04-27 17:30:45'),(7709,'asset','asset_edit','102',1,'Insert','','2013-04-27 17:31:40'),(7710,'asset','asset_edit','103',1,'Insert','','2013-04-27 17:32:46'),(7711,'asset','asset_edit','104',1,'Insert','','2013-04-27 17:33:47'),(7712,'asset','asset_edit','105',1,'Insert','','2013-04-27 17:36:46'),(7713,'asset','asset_edit','106',1,'Insert','','2013-04-27 17:39:47'),(7714,'asset','asset_edit','107',1,'Insert','','2013-04-27 17:40:14'),(7715,'asset','asset_edit','108',1,'Insert','','2013-04-27 17:40:18'),(7716,'asset','asset_edit','44',1,'Update','','2013-04-27 17:52:05'),(7717,'asset','asset_edit','44',1,'Update','','2013-04-27 17:53:11'),(7718,'asset','asset_edit','46',1,'Update','','2013-04-27 17:56:16'),(7719,'asset','asset_edit','45',1,'Update','','2013-04-27 17:56:31'),(7720,'asset','asset_edit','45',1,'Disable','','2013-04-27 17:56:37'),(7721,'asset','asset_edit','48',1,'Update','','2013-04-27 17:56:49'),(7722,'asset','asset_edit','49',1,'Update','','2013-04-27 17:57:06'),(7723,'asset','asset_edit','47',1,'Update','','2013-04-27 17:57:54'),(7724,'asset','asset_edit','50',1,'Update','','2013-04-27 17:58:02'),(7725,'asset','asset_edit','51',1,'Update','','2013-04-27 17:58:12'),(7726,'asset','asset_edit','52',1,'Update','','2013-04-27 17:58:20'),(7727,'asset','asset_edit','53',1,'Update','','2013-04-27 17:58:26'),(7728,'asset','asset_edit','54',1,'Update','','2013-04-27 17:58:32'),(7729,'asset','asset_edit','55',1,'Update','','2013-04-27 17:58:43'),(7730,'asset','asset_edit','56',1,'Update','','2013-04-27 17:58:49'),(7731,'asset','asset_edit','57',1,'Update','','2013-04-27 17:58:55'),(7732,'asset','asset_edit','58',1,'Update','','2013-04-27 17:59:04'),(7733,'asset','asset_edit','59',1,'Update','','2013-04-27 17:59:12'),(7734,'asset','asset_edit','98',1,'Update','','2013-04-27 17:59:46'),(7735,'asset','asset_edit','97',1,'Update','','2013-04-27 17:59:52'),(7736,'asset','asset_edit','95',1,'Update','','2013-04-27 17:59:58'),(7737,'asset','asset_edit','94',1,'Update','','2013-04-27 18:00:04'),(7738,'asset','asset_edit','93',1,'Update','','2013-04-27 18:00:09'),(7739,'asset','asset_edit','92',1,'Update','','2013-04-27 18:00:14'),(7740,'asset','asset_edit','91',1,'Update','','2013-04-27 18:00:23'),(7741,'asset','asset_edit','90',1,'Update','','2013-04-27 18:00:28'),(7742,'asset','asset_edit','89',1,'Update','','2013-04-27 18:00:37'),(7743,'asset','asset_edit','74',1,'Update','','2013-04-27 18:01:11'),(7744,'asset','asset_edit','75',1,'Update','','2013-04-27 18:01:17'),(7745,'asset','asset_edit','76',1,'Update','','2013-04-27 18:01:27'),(7746,'asset','asset_edit','73',1,'Update','','2013-04-27 18:01:31'),(7747,'asset','asset_edit','72',1,'Update','','2013-04-27 18:01:36'),(7748,'asset','asset_edit','71',1,'Update','','2013-04-27 18:01:41'),(7749,'asset','asset_edit','69',1,'Update','','2013-04-27 18:01:47'),(7750,'asset','asset_edit','68',1,'Update','','2013-04-27 18:01:51'),(7751,'asset','asset_edit','67',1,'Update','','2013-04-27 18:01:56'),(7752,'asset','asset_edit','60',1,'Update','','2013-04-27 18:02:31'),(7753,'asset','asset_edit','61',1,'Update','','2013-04-27 18:02:36'),(7754,'asset','asset_edit','62',1,'Update','','2013-04-27 18:02:41'),(7755,'asset','asset_edit','63',1,'Update','','2013-04-27 18:02:49'),(7756,'asset','asset_edit','64',1,'Update','','2013-04-27 18:02:53'),(7757,'asset','asset_edit','65',1,'Update','','2013-04-27 18:02:58'),(7758,'asset','asset_edit','66',1,'Update','','2013-04-27 18:03:08'),(7759,'asset','asset_edit','70',1,'Update','','2013-04-27 18:03:13'),(7760,'asset','asset_edit','77',1,'Update','','2013-04-27 18:03:18'),(7761,'asset','asset_edit','78',1,'Update','','2013-04-27 18:03:23'),(7762,'asset','asset_edit','80',1,'Update','','2013-04-27 18:03:56'),(7763,'asset','asset_edit','81',1,'Update','','2013-04-27 18:04:01'),(7764,'asset','asset_edit','79',1,'Update','','2013-04-27 18:04:05'),(7765,'asset','asset_edit','82',1,'Update','','2013-04-27 18:04:17'),(7766,'asset','asset_edit','83',1,'Update','','2013-04-27 18:04:21'),(7767,'asset','asset_edit','84',1,'Update','','2013-04-27 18:04:26'),(7768,'asset','asset_edit','85',1,'Update','','2013-04-27 18:04:31'),(7769,'asset','asset_edit','86',1,'Update','','2013-04-27 18:04:55'),(7770,'asset','asset_edit','87',1,'Update','','2013-04-27 18:05:07'),(7771,'asset','asset_edit','88',1,'Update','','2013-04-27 18:05:13'),(7772,'asset','asset_edit','96',1,'Update','','2013-04-27 18:05:18'),(7773,'security_services','security_catalogue_edit','557',1,'Update','','2013-04-28 00:03:41'),(7774,'security_services','security_services_maintenance_edit','14855',0,'Insert','','2013-04-28 00:03:41'),(7775,'security_services','security_services_maintenance_edit','14856',0,'Insert','','2013-04-28 00:03:41'),(7776,'security_services','security_catalogue_edit','557',1,'Update','','2013-04-28 00:04:10'),(7777,'security_services','security_services_audit_edit','14832',0,'Insert','','2013-04-28 00:04:11'),(7778,'security_services','security_services_audit_edit','14833',0,'Insert','','2013-04-28 00:04:11'),(7779,'security_services','security_services_maintenance_edit','14857',0,'Insert','','2013-04-28 00:04:11'),(7780,'security_services','security_services_maintenance_edit','14858',0,'Insert','','2013-04-28 00:04:11'),(7781,'security_services','security_services_maintenance_edit','14855',1,'Disable','','2013-04-28 00:09:04'),(7782,'security_services','security_services_maintenance_edit','14856',1,'Disable','','2013-04-28 00:09:55'),(7783,'security_services','security_catalogue_edit','557',1,'Update','','2013-04-28 00:10:32'),(7784,'security_services','security_services_maintenance_edit','14859',0,'Insert','','2013-04-28 00:10:32'),(7785,'security_services','security_catalogue_edit','557',1,'Update','','2013-04-28 00:29:02'),(7786,'security_services','security_services_maintenance_edit','14860',0,'Insert','','2013-04-28 00:29:02'),(7787,'security_services','security_catalogue_edit','557',1,'Update','','2013-04-28 00:34:10'),(7788,'security_services','security_catalogue_edit','557',1,'Update','','2013-04-28 00:42:38'),(7789,'organization','tp_edit','35',1,'Insert','','2013-04-28 00:49:02'),(7790,'organization','tp_edit','36',1,'Insert','','2013-04-28 00:49:11'),(7791,'risk','risk_classification_edit','30',1,'Insert','','2013-04-28 18:38:08'),(7792,'risk','risk_classification_edit','31',1,'Insert','','2013-04-28 18:38:24'),(7793,'risk','risk_classification_edit','32',1,'Insert','','2013-04-28 18:38:34'),(7794,'organization','process_edit','10',1,'Insert','','2013-04-28 18:39:23'),(7795,'organization','process_edit','10',1,'Update','','2013-04-28 18:39:43'),(7796,'organization','process_edit','11',1,'Insert','','2013-04-28 18:39:59'),(7797,'organization','process_edit','12',1,'Insert','','2013-04-28 18:40:15'),(7798,'organization','process_edit','13',1,'Insert','','2013-04-28 18:40:25'),(7799,'organization','process_edit','14',1,'Insert','','2013-04-28 18:40:38'),(7800,'organization','process_edit','15',1,'Insert','','2013-04-28 18:40:56'),(7801,'organization','process_edit','16',1,'Insert','','2013-04-28 18:41:11'),(7802,'organization','process_edit','17',1,'Insert','','2013-04-28 18:41:21'),(7803,'organization','process_edit','18',1,'Insert','','2013-04-28 18:41:34'),(7804,'organization','process_edit','19',1,'Insert','','2013-04-28 18:42:02'),(7805,'organization','process_edit','20',1,'Insert','','2013-04-28 18:42:14'),(7806,'risk','risk_classification_edit','33',1,'Insert','','2013-04-28 18:47:36'),(7807,'risk','risk_classification_edit','34',1,'Insert','','2013-04-28 18:47:50'),(7808,'risk','risk_classification_edit','35',1,'Insert','','2013-04-28 18:48:03'),(7809,'risk','risk_classification_edit','36',1,'Insert','','2013-04-28 18:48:25'),(7810,'risk','risk_classification_edit','37',1,'Insert','','2013-04-28 18:48:39'),(7811,'risk','risk_classification_edit','38',1,'Insert','','2013-04-28 18:48:53'),(7812,'risk','risk_classification_edit','39',1,'Insert','','2013-04-28 18:49:14'),(7813,'risk','risk_classification_edit','40',1,'Insert','','2013-04-28 18:49:31'),(7814,'risk','risk_classification_edit','41',1,'Insert','','2013-04-28 18:49:50'),(7815,'security_services','service_contracts_edit','2',1,'Insert','','2013-04-28 18:50:27'),(7816,'security_services','service_contracts_edit','3',1,'Insert','','2013-04-28 18:50:39'),(7817,'organization','tp_edit','37',1,'Insert','','2013-04-28 18:52:02'),(7818,'risk','risk_exception_edit','12',1,'Update','','2013-04-28 19:37:54'),(7819,'security_services','security_catalogue_edit','631',1,'Insert','','2013-05-02 12:50:50'),(7820,'security_services','security_services_maintenance_edit','14861',0,'Insert','','2013-05-02 12:50:50'),(7821,'compliance','compliance_management_edit','1',1,'Insert','','2013-05-02 12:51:17'),(7822,'compliance','compliance_management_edit','2',1,'Insert','','2013-05-02 12:51:36'),(7823,'compliance','compliance_management_edit','3',1,'Insert','','2013-05-02 12:51:49'),(7824,'compliance','compliance_management_edit','4',1,'Insert','','2013-05-02 12:51:52'),(7825,'compliance','compliance_management_edit','5',1,'Insert','','2013-05-02 12:52:24'),(7826,'compliance','compliance_management_edit','6',1,'Insert','','2013-05-02 12:52:36'),(7827,'compliance','compliance_management_edit','7',1,'Insert','','2013-05-02 12:52:47'),(7828,'compliance','compliance_management_edit','8',1,'Insert','','2013-05-02 12:52:59'),(7829,'compliance','compliance_management_edit','9',1,'Insert','','2013-05-02 12:53:02'),(7830,'compliance','compliance_management_edit','10',1,'Insert','','2013-05-02 12:54:02'),(7831,'compliance','compliance_management_edit','11',1,'Insert','','2013-05-02 12:54:08'),(7832,'compliance','compliance_management_edit','12',1,'Insert','','2013-05-02 12:54:43'),(7833,'compliance','compliance_management_edit','13',1,'Insert','','2013-05-02 12:54:52'),(7834,'compliance','compliance_management_edit','14',1,'Insert','','2013-05-02 12:54:55'),(7835,'compliance','compliance_management_edit','13',1,'Update','','2013-05-02 12:56:25'),(7836,'compliance','compliance_management_edit','15',1,'Insert','','2013-05-02 12:56:45'),(7837,'compliance','compliance_management_edit','16',1,'Insert','','2013-05-02 12:56:57'),(7838,'compliance','compliance_management_edit','17',1,'Insert','','2013-05-02 12:57:11'),(7839,'compliance','compliance_management_edit','18',1,'Insert','','2013-05-02 12:58:19'),(7840,'compliance','compliance_management_edit','19',1,'Insert','','2013-05-02 12:58:49'),(7841,'compliance','compliance_management_edit','20',1,'Insert','','2013-05-02 12:59:29'),(7842,'compliance','compliance_management_edit','21',1,'Insert','','2013-05-02 12:59:39'),(7843,'compliance','compliance_management_edit','22',1,'Insert','','2013-05-02 13:00:16'),(7844,'compliance','compliance_management_edit','23',1,'Insert','','2013-05-02 13:00:26'),(7845,'compliance','compliance_management_edit','24',1,'Insert','','2013-05-02 13:00:29'),(7846,'compliance','compliance_management_edit','25',1,'Insert','','2013-05-02 13:00:54'),(7847,'compliance','compliance_management_edit','26',1,'Insert','','2013-05-02 13:00:58'),(7848,'compliance','compliance_management_edit','27',1,'Insert','','2013-05-02 13:01:23'),(7849,'compliance','compliance_management_edit','28',1,'Insert','','2013-05-02 13:01:33'),(7850,'compliance','compliance_management_edit','29',1,'Insert','','2013-05-02 13:01:42'),(7851,'compliance','compliance_management_edit','30',1,'Insert','','2013-05-02 13:01:45'),(7852,'compliance','compliance_management_edit','31',1,'Insert','','2013-05-02 13:02:38'),(7853,'compliance','compliance_management_edit','32',1,'Insert','','2013-05-02 13:02:47'),(7854,'compliance','compliance_management_edit','33',1,'Insert','','2013-05-02 13:02:50'),(7855,'compliance','compliance_management_edit','34',1,'Insert','','2013-05-02 13:03:18'),(7856,'compliance','compliance_management_edit','35',1,'Insert','','2013-05-02 13:03:38'),(7857,'compliance','compliance_management_edit','36',1,'Insert','','2013-05-02 13:03:49'),(7858,'compliance','compliance_management_edit','37',1,'Insert','','2013-05-02 13:03:52'),(7859,'compliance','compliance_management_edit','38',1,'Insert','','2013-05-02 13:04:20'),(7860,'compliance','compliance_management_edit','39',1,'Insert','','2013-05-02 13:04:58'),(7861,'compliance','compliance_management_edit','40',1,'Insert','','2013-05-02 13:05:05'),(7862,'compliance','compliance_management_edit','39',1,'Update','','2013-05-02 13:05:23'),(7863,'compliance','compliance_management_edit','41',1,'Insert','','2013-05-02 13:05:49'),(7864,'compliance','compliance_management_edit','42',1,'Insert','','2013-05-02 13:05:52'),(7865,'compliance','compliance_management_edit','43',1,'Insert','','2013-05-02 13:11:46'),(7866,'compliance','compliance_management_edit','44',1,'Insert','','2013-05-02 13:12:07'),(7867,'compliance','compliance_management_edit','45',1,'Insert','','2013-05-02 13:12:40'),(7868,'compliance','compliance_management_edit','46',1,'Insert','','2013-05-02 13:13:05'),(7869,'compliance','compliance_management_edit','47',1,'Insert','','2013-05-02 13:13:26'),(7870,'compliance','compliance_management_edit','48',1,'Insert','','2013-05-02 13:14:02'),(7871,'compliance','compliance_management_edit','49',1,'Insert','','2013-05-02 13:14:05'),(7872,'compliance','compliance_management_edit','50',1,'Insert','','2013-05-02 13:14:27'),(7873,'compliance','compliance_management_edit','51',1,'Insert','','2013-05-02 13:14:50'),(7874,'compliance','compliance_management_edit','52',1,'Insert','','2013-05-02 13:15:10'),(7875,'compliance','compliance_management_edit','53',1,'Insert','','2013-05-02 13:15:28'),(7876,'compliance','compliance_management_edit','54',1,'Insert','','2013-05-02 13:15:53'),(7877,'compliance','compliance_management_edit','55',1,'Insert','','2013-05-02 13:16:12'),(7878,'compliance','compliance_management_edit','56',1,'Insert','','2013-05-02 13:16:17'),(7879,'compliance','compliance_management_edit','57',1,'Insert','','2013-05-02 13:16:54'),(7880,'compliance','compliance_management_edit','58',1,'Insert','','2013-05-02 13:17:17'),(7881,'compliance','compliance_management_edit','59',1,'Insert','','2013-05-02 13:18:17'),(7882,'compliance','compliance_management_edit','60',1,'Insert','','2013-05-02 13:18:27'),(7883,'compliance','compliance_management_edit','61',1,'Insert','','2013-05-02 13:18:30'),(7884,'compliance','compliance_management_edit','62',1,'Insert','','2013-05-02 13:19:12'),(7885,'compliance','compliance_management_edit','63',1,'Insert','','2013-05-02 13:19:44'),(7886,'compliance','compliance_management_edit','64',1,'Insert','','2013-05-02 13:19:57'),(7887,'compliance','compliance_management_edit','65',1,'Insert','','2013-05-02 13:20:00'),(7888,'compliance','compliance_management_edit','66',1,'Insert','','2013-05-02 13:20:56'),(7889,'compliance','compliance_management_edit','67',1,'Insert','','2013-05-02 13:21:13'),(7890,'compliance','compliance_management_edit','68',1,'Insert','','2013-05-02 13:21:16'),(7891,'compliance','compliance_management_edit','69',1,'Insert','','2013-05-02 13:21:31'),(7892,'compliance','compliance_management_edit','70',1,'Insert','','2013-05-02 13:21:42'),(7893,'compliance','compliance_management_edit','71',1,'Insert','','2013-05-02 13:22:44'),(7894,'compliance','compliance_management_edit','72',1,'Insert','','2013-05-02 13:22:51'),(7895,'compliance','compliance_management_edit','73',1,'Insert','','2013-05-02 13:22:59'),(7896,'compliance','compliance_management_edit','74',1,'Insert','','2013-05-02 13:24:08'),(7897,'compliance','compliance_management_edit','75',1,'Insert','','2013-05-02 13:24:19'),(7898,'compliance','compliance_management_edit','76',1,'Insert','','2013-05-02 13:24:27'),(7899,'compliance','compliance_management_edit','77',1,'Insert','','2013-05-02 13:24:36'),(7900,'compliance','compliance_management_edit','78',1,'Insert','','2013-05-02 13:24:45'),(7901,'compliance','compliance_management_edit','78',1,'Update','','2013-05-02 13:25:02'),(7902,'compliance','compliance_management_edit','79',1,'Insert','','2013-05-02 13:25:44'),(7903,'compliance','compliance_management_edit','80',1,'Insert','','2013-05-02 13:26:02'),(7904,'compliance','compliance_management_edit','81',1,'Insert','','2013-05-02 13:26:04'),(7905,'compliance','compliance_management_edit','82',1,'Insert','','2013-05-02 13:26:46'),(7906,'compliance','compliance_management_edit','83',1,'Insert','','2013-05-02 13:26:55'),(7907,'compliance','compliance_management_edit','84',1,'Insert','','2013-05-02 13:27:05'),(7908,'compliance','compliance_management_edit','85',1,'Insert','','2013-05-02 13:27:15'),(7909,'compliance','compliance_management_edit','86',1,'Insert','','2013-05-02 13:27:23'),(7910,'compliance','compliance_management_edit','87',1,'Insert','','2013-05-02 13:27:25'),(7911,'compliance','compliance_management_edit','88',1,'Insert','','2013-05-02 13:27:39'),(7912,'compliance','compliance_management_edit','89',1,'Insert','','2013-05-02 13:27:40'),(7913,'compliance','compliance_management_edit','90',1,'Insert','','2013-05-02 13:28:04'),(7914,'compliance','compliance_management_edit','91',1,'Insert','','2013-05-02 13:28:06'),(7915,'compliance','compliance_management_edit','92',1,'Insert','','2013-05-02 13:29:19'),(7916,'compliance','compliance_management_edit','93',1,'Insert','','2013-05-02 13:30:04'),(7917,'compliance','compliance_management_edit','94',1,'Insert','','2013-05-02 13:30:07'),(7918,'compliance','compliance_management_edit','95',1,'Insert','','2013-05-02 13:30:18'),(7919,'compliance','compliance_management_edit','96',1,'Insert','','2013-05-02 13:30:20'),(7920,'compliance','compliance_management_edit','97',1,'Insert','','2013-05-02 13:31:14'),(7921,'compliance','compliance_management_edit','98',1,'Insert','','2013-05-02 13:32:17'),(7922,'compliance','compliance_management_edit','99',1,'Insert','','2013-05-02 13:32:36'),(7923,'compliance','compliance_management_edit','100',1,'Insert','','2013-05-02 13:32:46'),(7924,'compliance','compliance_management_edit','101',1,'Insert','','2013-05-02 13:35:22'),(7925,'compliance','compliance_management_edit','102',1,'Insert','','2013-05-02 13:35:30'),(7926,'compliance','compliance_management_edit','103',1,'Insert','','2013-05-02 13:35:39'),(7927,'compliance','compliance_management_edit','104',1,'Insert','','2013-05-02 13:35:56'),(7928,'compliance','compliance_management_edit','105',1,'Insert','','2013-05-02 13:36:02'),(7929,'compliance','compliance_management_edit','106',1,'Insert','','2013-05-02 13:36:09'),(7930,'compliance','compliance_management_edit','107',1,'Insert','','2013-05-02 13:36:18'),(7931,'compliance','compliance_management_edit','108',1,'Insert','','2013-05-02 13:36:53'),(7932,'compliance','compliance_management_edit','109',1,'Insert','','2013-05-02 13:36:59'),(7933,'compliance','compliance_management_edit','110',1,'Insert','','2013-05-02 13:37:22'),(7934,'compliance','compliance_management_edit','111',1,'Insert','','2013-05-02 13:37:33'),(7935,'compliance','compliance_management_edit','112',1,'Insert','','2013-05-02 13:38:22'),(7936,'compliance','compliance_management_edit','113',1,'Insert','','2013-05-02 13:38:38'),(7937,'compliance','compliance_management_edit','114',1,'Insert','','2013-05-02 13:38:40'),(7938,'compliance','compliance_management_edit','115',1,'Insert','','2013-05-02 13:39:07'),(7939,'compliance','compliance_management_edit','116',1,'Insert','','2013-05-02 13:39:11'),(7940,'compliance','compliance_management_edit','117',1,'Insert','','2013-05-02 13:39:23'),(7941,'compliance','compliance_management_edit','118',1,'Insert','','2013-05-02 13:39:29'),(7942,'compliance','compliance_management_edit','119',1,'Insert','','2013-05-02 13:39:35'),(7943,'compliance','compliance_management_edit','120',1,'Insert','','2013-05-02 13:39:36'),(7944,'compliance','compliance_management_edit','121',1,'Insert','','2013-05-02 13:39:55'),(7945,'compliance','compliance_management_edit','122',1,'Insert','','2013-05-02 13:39:56'),(7946,'compliance','compliance_management_edit','123',1,'Insert','','2013-05-02 13:40:25'),(7947,'compliance','compliance_management_edit','124',1,'Insert','','2013-05-02 13:40:42'),(7948,'compliance','compliance_management_edit','125',1,'Insert','','2013-05-02 13:41:00'),(7949,'compliance','compliance_management_edit','126',1,'Insert','','2013-05-02 13:41:16'),(7950,'compliance','compliance_management_edit','127',1,'Insert','','2013-05-02 13:41:18'),(7951,'compliance','compliance_management_edit','128',1,'Insert','','2013-05-02 13:41:36'),(7952,'compliance','compliance_management_edit','129',1,'Insert','','2013-05-02 13:41:46'),(7953,'compliance','compliance_management_edit','130',1,'Insert','','2013-05-02 13:41:48'),(7954,'compliance','compliance_management_edit','131',1,'Insert','','2013-05-02 13:42:10'),(7955,'compliance','compliance_management_edit','132',1,'Insert','','2013-05-02 13:42:12'),(7956,'compliance','compliance_management_edit','133',1,'Insert','','2013-05-02 13:42:23'),(7957,'compliance','compliance_management_edit','134',1,'Insert','','2013-05-02 13:42:29'),(7958,'compliance','compliance_management_edit','135',1,'Insert','','2013-05-02 13:42:31'),(7959,'compliance','compliance_management_edit','136',1,'Insert','','2013-05-02 13:42:52'),(7960,'compliance','compliance_management_edit','137',1,'Insert','','2013-05-02 13:43:06'),(7961,'compliance','compliance_management_edit','138',1,'Insert','','2013-05-02 13:43:14'),(7962,'compliance','compliance_management_edit','139',1,'Insert','','2013-05-02 13:43:15'),(7963,'compliance','compliance_management_edit','140',1,'Insert','','2013-05-02 13:43:29'),(7964,'compliance','compliance_management_edit','141',1,'Insert','','2013-05-02 13:43:45'),(7965,'compliance','compliance_management_edit','142',1,'Insert','','2013-05-02 13:43:47'),(7966,'compliance','compliance_management_edit','143',1,'Insert','','2013-05-02 13:44:07'),(7967,'compliance','compliance_management_edit','144',1,'Insert','','2013-05-02 13:44:08'),(7968,'compliance','compliance_management_edit','145',1,'Insert','','2013-05-02 13:44:26'),(7969,'compliance','compliance_management_edit','146',1,'Insert','','2013-05-02 13:44:35'),(7970,'compliance','compliance_management_edit','147',1,'Insert','','2013-05-02 13:44:36'),(7971,'compliance','compliance_management_edit','148',1,'Insert','','2013-05-02 13:44:58'),(7972,'compliance','compliance_management_edit','149',1,'Insert','','2013-05-02 13:45:08'),(7973,'compliance','compliance_management_edit','150',1,'Insert','','2013-05-02 13:45:18'),(7974,'compliance','compliance_management_edit','151',1,'Insert','','2013-05-02 13:45:19'),(7975,'compliance','compliance_management_edit','152',1,'Insert','','2013-05-02 13:45:55'),(7976,'compliance','compliance_management_edit','153',1,'Insert','','2013-05-02 13:46:05'),(7977,'compliance','compliance_management_edit','154',1,'Insert','','2013-05-02 13:46:13'),(7978,'compliance','compliance_management_edit','155',1,'Insert','','2013-05-02 13:46:21'),(7979,'compliance','compliance_management_edit','156',1,'Insert','','2013-05-02 13:46:30'),(7980,'compliance','compliance_management_edit','157',1,'Insert','','2013-05-02 13:46:31'),(7981,'compliance','compliance_management_edit','158',1,'Insert','','2013-05-02 13:46:57'),(7982,'compliance','compliance_management_edit','159',1,'Insert','','2013-05-02 13:47:02'),(7983,'compliance','compliance_management_edit','160',1,'Insert','','2013-05-02 13:47:07'),(7984,'compliance','compliance_management_edit','161',1,'Insert','','2013-05-02 13:47:14'),(7985,'compliance','compliance_management_edit','162',1,'Insert','','2013-05-02 13:47:20'),(7986,'compliance','compliance_management_edit','163',1,'Insert','','2013-05-02 13:47:27'),(7987,'compliance','compliance_management_edit','164',1,'Insert','','2013-05-02 13:47:28'),(7988,'compliance','compliance_management_edit','165',1,'Insert','','2013-05-02 13:47:47'),(7989,'compliance','compliance_management_edit','166',1,'Insert','','2013-05-02 13:47:52'),(7990,'compliance','compliance_management_edit','167',1,'Insert','','2013-05-02 13:47:58'),(7991,'compliance','compliance_management_edit','168',1,'Insert','','2013-05-02 13:48:03'),(7992,'compliance','compliance_management_edit','169',1,'Insert','','2013-05-02 13:48:05'),(7993,'compliance','compliance_management_edit','170',1,'Insert','','2013-05-02 13:48:32'),(7994,'compliance','compliance_management_edit','171',1,'Insert','','2013-05-02 13:48:47'),(7995,'compliance','compliance_management_edit','172',1,'Insert','','2013-05-02 13:48:55'),(7996,'compliance','compliance_management_edit','173',1,'Insert','','2013-05-02 13:49:01'),(7997,'compliance','compliance_management_edit','174',1,'Insert','','2013-05-02 13:49:07'),(7998,'compliance','compliance_management_edit','175',1,'Insert','','2013-05-02 13:49:09'),(7999,'compliance','compliance_audit_edit','1',1,'Insert','','2013-05-02 13:51:45'),(8000,'compliance','compliance_finding_edit','1',1,'Insert','','2013-05-02 13:52:24'),(8001,'compliance','compliance_audit_edit','2',1,'Insert','','2013-05-02 13:52:45'),(8002,'compliance','compliance_audit_edit','3',1,'Insert','','2013-05-02 13:53:01'),(8003,'compliance','compliance_finding_edit','2',1,'Insert','','2013-05-02 13:53:44'),(8004,'compliance','compliance_finding_edit','3',1,'Insert','','2013-05-02 13:54:26'),(8005,'compliance','compliance_exception_edit','1',1,'Insert','','2013-05-02 14:00:19'),(8006,'compliance','compliance_management_edit','47',1,'Update','','2013-05-02 14:01:07'),(8007,'compliance','compliance_management_edit','73',1,'Update','','2013-05-02 14:01:12'),(8008,'compliance','compliance_management_edit','72',1,'Update','','2013-05-02 14:01:16'),(8009,'compliance','compliance_management_edit','140',1,'Update','','2013-05-02 14:01:20'),(8010,'compliance','compliance_management_edit','158',1,'Update','','2013-05-02 14:01:24'),(8011,'organization','legal_edit','12',1,'Insert','','2013-05-03 14:48:23'),(8012,'organization','legal_edit','13',1,'Insert','','2013-05-03 14:48:41'),(8013,'bcm','bcm_plans_edit','25',1,'Insert','','2013-05-03 15:02:10'),(8014,'bcm','bcm_plans_audit_edit','1',0,'Insert','','2013-05-03 15:02:10'),(8015,'risk','risk_management_edit','2',1,'Update','','2013-05-03 15:45:12'),(8016,'risk','risk_management_edit','2',1,'Update','','2013-05-03 15:45:25'),(8017,'risk','risk_management_edit','3',1,'Update','','2013-05-03 15:46:58'),(8018,'risk','risk_management_edit','4',1,'Update','','2013-05-03 15:47:12'),(8019,'asset','asset_edit','99',1,'Insert','','2013-05-03 17:32:15'),(8020,'risk','risk_management_edit','16',1,'Update','','2013-05-03 17:36:55'),(8021,'risk','risk_tp_edit','156',1,'Insert','','2013-05-03 19:33:34'),(8022,'risk','risk_tp_edit','156',1,'Update','','2013-05-03 19:33:49'),(8023,'risk','risk_tp_edit','157',1,'Insert','','2013-05-03 19:35:56'),(8024,'risk','risk_tp_edit','158',1,'Insert','','2013-05-03 19:39:13'),(8025,'risk','risk_exception_edit','10',1,'Update','','2013-05-03 19:39:51'),(8026,'risk','risk_tp_edit','159',1,'Insert','','2013-05-03 19:43:37'),(8027,'risk','risk_exception_edit','18',1,'Insert','','2013-05-03 19:45:19'),(8028,'risk','risk_tp_edit','159',1,'Update','','2013-05-03 19:45:31'),(8029,'risk','risk_tp_edit','160',1,'Insert','','2013-05-03 19:49:33'),(8030,'system','system_authorization_edit','1',1,'Login','','2013-05-06 12:39:25'),(8031,'system','system_authorization_edit','2',1,'Insert','','2013-05-06 12:39:44'),(8032,'system','system_authorization_edit','2',2,'Login','','2013-05-06 12:39:59'),(8033,'system','system_authorization_edit','1',1,'Login','','2013-05-06 12:40:06'),(8034,'system','system_roles_edit','1',1,'Update','','2013-05-06 12:40:29'),(8035,'system','system_authorization_edit','2',2,'Login','','2013-05-06 12:40:36'),(8036,'system','system_authorization_edit','2',2,'Login','','2013-05-06 12:55:08'),(8037,'security_services','security_services_audit_edit','14834',0,'Insert','','2013-05-06 12:55:08'),(8038,'security_services','security_services_audit_edit','14835',0,'Insert','','2013-05-06 12:55:08'),(8039,'security_services','security_services_audit_edit','14836',0,'Insert','','2013-05-06 12:55:08'),(8040,'security_services','security_services_audit_edit','14837',0,'Insert','','2013-05-06 12:55:08'),(8041,'security_services','security_services_audit_edit','14838',0,'Insert','','2013-05-06 12:55:08'),(8042,'security_services','security_services_audit_edit','14839',0,'Insert','','2013-05-06 12:55:08'),(8043,'security_services','security_services_audit_edit','14840',0,'Insert','','2013-05-06 12:55:08'),(8044,'security_services','security_services_audit_edit','14841',0,'Insert','','2013-05-06 12:55:08'),(8045,'security_services','security_services_audit_edit','14842',0,'Insert','','2013-05-06 12:55:08'),(8046,'security_services','security_services_audit_edit','14843',0,'Insert','','2013-05-06 12:55:08'),(8047,'security_services','security_services_audit_edit','14844',0,'Insert','','2013-05-06 12:55:08'),(8048,'security_services','security_services_audit_edit','14845',0,'Insert','','2013-05-06 12:55:08'),(8049,'security_services','security_services_audit_edit','14846',0,'Insert','','2013-05-06 12:55:08'),(8050,'security_services','security_services_audit_edit','14847',0,'Insert','','2013-05-06 12:55:08'),(8051,'security_services','security_services_audit_edit','14848',0,'Insert','','2013-05-06 12:55:08'),(8052,'security_services','security_services_audit_edit','14849',0,'Insert','','2013-05-06 12:55:08'),(8053,'security_services','security_services_audit_edit','14850',0,'Insert','','2013-05-06 12:55:08'),(8054,'security_services','security_services_audit_edit','14851',0,'Insert','','2013-05-06 12:55:08'),(8055,'security_services','security_services_audit_edit','14852',0,'Insert','','2013-05-06 12:55:08'),(8056,'security_services','security_services_audit_edit','14853',0,'Insert','','2013-05-06 12:55:08'),(8057,'security_services','security_services_audit_edit','14854',0,'Insert','','2013-05-06 12:55:08'),(8058,'security_services','security_services_audit_edit','14855',0,'Insert','','2013-05-06 12:55:08'),(8059,'security_services','security_services_audit_edit','14856',0,'Insert','','2013-05-06 12:55:08'),(8060,'security_services','security_services_audit_edit','14857',0,'Insert','','2013-05-06 12:55:08'),(8061,'security_services','security_services_audit_edit','14858',0,'Insert','','2013-05-06 12:55:08'),(8062,'security_services','security_services_audit_edit','14859',0,'Insert','','2013-05-06 12:55:08'),(8063,'security_services','security_services_audit_edit','14860',0,'Insert','','2013-05-06 12:55:08'),(8064,'security_services','security_services_audit_edit','14861',0,'Insert','','2013-05-06 12:55:08'),(8065,'security_services','security_services_audit_edit','14862',0,'Insert','','2013-05-06 12:55:08'),(8066,'security_services','security_services_audit_edit','14863',0,'Insert','','2013-05-06 12:55:08'),(8067,'security_services','security_services_audit_edit','14864',0,'Insert','','2013-05-06 12:55:08'),(8068,'security_services','security_services_audit_edit','14865',0,'Insert','','2013-05-06 12:55:08'),(8069,'security_services','security_services_audit_edit','14866',0,'Insert','','2013-05-06 12:55:08'),(8070,'security_services','security_services_audit_edit','14867',0,'Insert','','2013-05-06 12:55:08'),(8071,'security_services','security_services_audit_edit','14868',0,'Insert','','2013-05-06 12:55:08'),(8072,'security_services','security_services_audit_edit','14869',0,'Insert','','2013-05-06 12:55:08'),(8073,'security_services','security_services_audit_edit','14870',0,'Insert','','2013-05-06 12:55:08'),(8074,'security_services','security_services_audit_edit','14871',0,'Insert','','2013-05-06 12:55:08'),(8075,'security_services','security_services_audit_edit','14872',0,'Insert','','2013-05-06 12:55:08'),(8076,'security_services','security_services_audit_edit','14873',0,'Insert','','2013-05-06 12:55:08'),(8077,'security_services','security_services_audit_edit','14874',0,'Insert','','2013-05-06 12:55:08'),(8078,'security_services','security_services_audit_edit','14875',0,'Insert','','2013-05-06 12:55:08'),(8079,'security_services','security_services_audit_edit','14876',0,'Insert','','2013-05-06 12:55:08'),(8080,'security_services','security_services_audit_edit','14877',0,'Insert','','2013-05-06 12:55:08'),(8081,'security_services','security_services_audit_edit','14878',0,'Insert','','2013-05-06 12:55:08'),(8082,'security_services','security_services_audit_edit','14879',0,'Insert','','2013-05-06 12:55:08'),(8083,'security_services','security_services_audit_edit','14880',0,'Insert','','2013-05-06 12:55:08'),(8084,'security_services','security_services_audit_edit','14881',0,'Insert','','2013-05-06 12:55:08'),(8085,'security_services','security_services_audit_edit','14882',0,'Insert','','2013-05-06 12:55:08'),(8086,'security_services','security_services_audit_edit','14883',0,'Insert','','2013-05-06 12:55:08'),(8087,'security_services','security_services_audit_edit','14884',0,'Insert','','2013-05-06 12:55:08'),(8088,'security_services','security_services_audit_edit','14885',0,'Insert','','2013-05-06 12:55:08'),(8089,'security_services','security_services_audit_edit','14886',0,'Insert','','2013-05-06 12:55:08'),(8090,'security_services','security_services_audit_edit','14887',0,'Insert','','2013-05-06 12:55:08'),(8091,'security_services','security_services_audit_edit','14888',0,'Insert','','2013-05-06 12:55:08'),(8092,'security_services','security_services_audit_edit','14889',0,'Insert','','2013-05-06 12:55:08'),(8093,'security_services','security_services_audit_edit','14890',0,'Insert','','2013-05-06 12:55:08'),(8094,'security_services','security_services_audit_edit','14891',0,'Insert','','2013-05-06 12:55:08'),(8095,'security_services','security_services_audit_edit','14892',0,'Insert','','2013-05-06 12:55:08'),(8096,'security_services','security_services_audit_edit','14893',0,'Insert','','2013-05-06 12:55:08'),(8097,'security_services','security_services_audit_edit','14894',0,'Insert','','2013-05-06 12:55:08'),(8098,'security_services','security_services_audit_edit','14895',0,'Insert','','2013-05-06 12:55:08'),(8099,'security_services','security_services_audit_edit','14896',0,'Insert','','2013-05-06 12:55:08'),(8100,'security_services','security_services_audit_edit','14897',0,'Insert','','2013-05-06 12:55:08'),(8101,'security_services','security_services_audit_edit','14898',0,'Insert','','2013-05-06 12:55:08'),(8102,'security_services','security_services_audit_edit','14899',0,'Insert','','2013-05-06 12:55:08'),(8103,'security_services','security_services_audit_edit','14900',0,'Insert','','2013-05-06 12:55:08'),(8104,'security_services','security_services_audit_edit','14901',0,'Insert','','2013-05-06 12:55:08'),(8105,'security_services','security_services_audit_edit','14902',0,'Insert','','2013-05-06 12:55:08'),(8106,'security_services','security_services_audit_edit','14903',0,'Insert','','2013-05-06 12:55:08'),(8107,'security_services','security_services_audit_edit','14904',0,'Insert','','2013-05-06 12:55:08'),(8108,'security_services','security_services_audit_edit','14905',0,'Insert','','2013-05-06 12:55:08'),(8109,'security_services','security_services_audit_edit','14906',0,'Insert','','2013-05-06 12:55:08'),(8110,'security_services','security_services_audit_edit','14907',0,'Insert','','2013-05-06 12:55:08'),(8111,'security_services','security_services_audit_edit','14908',0,'Insert','','2013-05-06 12:55:08'),(8112,'system','system_authorization_edit','1',2,'Update','','2013-05-06 12:55:29'),(8113,'organization','bu_edit','39',2,'Insert','','2013-05-06 13:07:02'),(8114,'system','system_authorization_edit','2',2,'Login','','2013-05-07 00:45:24'),(8115,'security_services','security_services_audit_edit','14909',0,'Insert','','2013-05-07 00:45:24'),(8116,'security_services','security_services_audit_edit','14910',0,'Insert','','2013-05-07 00:45:24'),(8117,'security_services','security_services_audit_edit','14911',0,'Insert','','2013-05-07 00:45:24'),(8118,'security_services','security_services_audit_edit','14912',0,'Insert','','2013-05-07 00:45:24'),(8119,'security_services','security_services_audit_edit','14913',0,'Insert','','2013-05-07 00:45:24'),(8120,'security_services','security_services_audit_edit','14914',0,'Insert','','2013-05-07 00:45:24'),(8121,'security_services','security_services_audit_edit','14915',0,'Insert','','2013-05-07 00:45:24'),(8122,'security_services','security_services_audit_edit','14916',0,'Insert','','2013-05-07 00:45:24'),(8123,'security_services','security_services_audit_edit','14917',0,'Insert','','2013-05-07 00:45:24'),(8124,'security_services','security_services_audit_edit','14918',0,'Insert','','2013-05-07 00:45:24'),(8125,'security_services','security_services_audit_edit','14919',0,'Insert','','2013-05-07 00:45:24'),(8126,'security_services','security_services_audit_edit','14920',0,'Insert','','2013-05-07 00:45:24'),(8127,'security_services','security_services_audit_edit','14921',0,'Insert','','2013-05-07 00:45:24'),(8128,'security_services','security_services_audit_edit','14922',0,'Insert','','2013-05-07 00:45:24'),(8129,'security_services','security_services_audit_edit','14923',0,'Insert','','2013-05-07 00:45:24'),(8130,'security_services','security_services_audit_edit','14924',0,'Insert','','2013-05-07 00:45:24'),(8131,'security_services','security_services_audit_edit','14925',0,'Insert','','2013-05-07 00:45:24'),(8132,'security_services','security_services_audit_edit','14926',0,'Insert','','2013-05-07 00:45:24'),(8133,'security_services','security_services_audit_edit','14927',0,'Insert','','2013-05-07 00:45:24'),(8134,'security_services','security_services_audit_edit','14928',0,'Insert','','2013-05-07 00:45:24'),(8135,'security_services','security_services_audit_edit','14929',0,'Insert','','2013-05-07 00:45:24'),(8136,'security_services','security_services_audit_edit','14930',0,'Insert','','2013-05-07 00:45:24'),(8137,'security_services','security_services_audit_edit','14931',0,'Insert','','2013-05-07 00:45:24'),(8138,'security_services','security_services_audit_edit','14932',0,'Insert','','2013-05-07 00:45:24'),(8139,'security_services','security_services_audit_edit','14933',0,'Insert','','2013-05-07 00:45:24'),(8140,'security_services','security_services_audit_edit','14934',0,'Insert','','2013-05-07 00:45:24'),(8141,'security_services','security_services_audit_edit','14935',0,'Insert','','2013-05-07 00:45:24'),(8142,'security_services','security_services_audit_edit','14936',0,'Insert','','2013-05-07 00:45:24'),(8143,'security_services','security_services_audit_edit','14937',0,'Insert','','2013-05-07 00:45:24'),(8144,'security_services','security_services_audit_edit','14938',0,'Insert','','2013-05-07 00:45:24'),(8145,'security_services','security_services_audit_edit','14939',0,'Insert','','2013-05-07 00:45:24'),(8146,'security_services','security_services_audit_edit','14940',0,'Insert','','2013-05-07 00:45:24'),(8147,'security_services','security_services_audit_edit','14941',0,'Insert','','2013-05-07 00:45:24'),(8148,'security_services','security_services_audit_edit','14942',0,'Insert','','2013-05-07 00:45:24'),(8149,'security_services','security_services_audit_edit','14943',0,'Insert','','2013-05-07 00:45:24'),(8150,'security_services','security_services_audit_edit','14944',0,'Insert','','2013-05-07 00:45:24'),(8151,'security_services','security_services_audit_edit','14945',0,'Insert','','2013-05-07 00:45:24'),(8152,'security_services','security_services_audit_edit','14946',0,'Insert','','2013-05-07 00:45:24'),(8153,'security_services','security_services_audit_edit','14947',0,'Insert','','2013-05-07 00:45:24'),(8154,'security_services','security_services_audit_edit','14948',0,'Insert','','2013-05-07 00:45:24'),(8155,'security_services','security_services_audit_edit','14949',0,'Insert','','2013-05-07 00:45:24'),(8156,'security_services','security_services_audit_edit','14950',0,'Insert','','2013-05-07 00:45:24'),(8157,'security_services','security_services_audit_edit','14951',0,'Insert','','2013-05-07 00:45:24'),(8158,'security_services','security_services_audit_edit','14952',0,'Insert','','2013-05-07 00:45:24'),(8159,'security_services','security_services_audit_edit','14953',0,'Insert','','2013-05-07 00:45:24'),(8160,'security_services','security_services_audit_edit','14954',0,'Insert','','2013-05-07 00:45:24'),(8161,'security_services','security_services_audit_edit','14955',0,'Insert','','2013-05-07 00:45:24'),(8162,'security_services','security_services_audit_edit','14956',0,'Insert','','2013-05-07 00:45:24'),(8163,'security_services','security_services_audit_edit','14957',0,'Insert','','2013-05-07 00:45:24'),(8164,'security_services','security_services_audit_edit','14958',0,'Insert','','2013-05-07 00:45:24'),(8165,'security_services','security_services_audit_edit','14959',0,'Insert','','2013-05-07 00:45:24'),(8166,'security_services','security_services_audit_edit','14960',0,'Insert','','2013-05-07 00:45:24'),(8167,'security_services','security_services_audit_edit','14961',0,'Insert','','2013-05-07 00:45:24'),(8168,'security_services','security_services_audit_edit','14962',0,'Insert','','2013-05-07 00:45:24'),(8169,'security_services','security_services_audit_edit','14963',0,'Insert','','2013-05-07 00:45:24'),(8170,'security_services','security_services_audit_edit','14964',0,'Insert','','2013-05-07 00:45:24'),(8171,'security_services','security_services_audit_edit','14965',0,'Insert','','2013-05-07 00:45:24'),(8172,'security_services','security_services_audit_edit','14966',0,'Insert','','2013-05-07 00:45:24'),(8173,'security_services','security_services_audit_edit','14967',0,'Insert','','2013-05-07 00:45:24'),(8174,'security_services','security_services_audit_edit','14968',0,'Insert','','2013-05-07 00:45:24'),(8175,'security_services','security_services_audit_edit','14969',0,'Insert','','2013-05-07 00:45:24'),(8176,'security_services','security_services_audit_edit','14970',0,'Insert','','2013-05-07 00:45:24'),(8177,'security_services','security_services_audit_edit','14971',0,'Insert','','2013-05-07 00:45:24'),(8178,'security_services','security_services_audit_edit','14972',0,'Insert','','2013-05-07 00:45:24'),(8179,'security_services','security_services_audit_edit','14973',0,'Insert','','2013-05-07 00:45:24'),(8180,'security_services','security_services_audit_edit','14974',0,'Insert','','2013-05-07 00:45:24'),(8181,'security_services','security_services_audit_edit','14975',0,'Insert','','2013-05-07 00:45:24'),(8182,'security_services','security_services_audit_edit','14976',0,'Insert','','2013-05-07 00:45:24'),(8183,'security_services','security_services_audit_edit','14977',0,'Insert','','2013-05-07 00:45:24'),(8184,'security_services','security_services_audit_edit','14978',0,'Insert','','2013-05-07 00:45:24'),(8185,'security_services','security_services_audit_edit','14979',0,'Insert','','2013-05-07 00:45:24'),(8186,'security_services','security_services_audit_edit','14980',0,'Insert','','2013-05-07 00:45:24'),(8187,'security_services','security_services_audit_edit','14981',0,'Insert','','2013-05-07 00:45:24'),(8188,'security_services','security_services_audit_edit','14982',0,'Insert','','2013-05-07 00:45:24'),(8189,'security_services','security_services_audit_edit','14983',0,'Insert','','2013-05-07 00:45:24'),(8190,'system','system_authorization_edit','2',2,'Login','','2013-05-07 18:33:19'),(8191,'security_services','security_services_audit_edit','14984',0,'Insert','','2013-05-07 18:33:19'),(8192,'security_services','security_services_audit_edit','14985',0,'Insert','','2013-05-07 18:33:19'),(8193,'security_services','security_services_audit_edit','14986',0,'Insert','','2013-05-07 18:33:19'),(8194,'security_services','security_services_audit_edit','14987',0,'Insert','','2013-05-07 18:33:19'),(8195,'security_services','security_services_audit_edit','14988',0,'Insert','','2013-05-07 18:33:19'),(8196,'security_services','security_services_audit_edit','14989',0,'Insert','','2013-05-07 18:33:19'),(8197,'security_services','security_services_audit_edit','14990',0,'Insert','','2013-05-07 18:33:19'),(8198,'security_services','security_services_audit_edit','14991',0,'Insert','','2013-05-07 18:33:19'),(8199,'security_services','security_services_audit_edit','14992',0,'Insert','','2013-05-07 18:33:19'),(8200,'security_services','security_services_audit_edit','14993',0,'Insert','','2013-05-07 18:33:19'),(8201,'security_services','security_services_audit_edit','14994',0,'Insert','','2013-05-07 18:33:19'),(8202,'security_services','security_services_audit_edit','14995',0,'Insert','','2013-05-07 18:33:19'),(8203,'security_services','security_services_audit_edit','14996',0,'Insert','','2013-05-07 18:33:19'),(8204,'security_services','security_services_audit_edit','14997',0,'Insert','','2013-05-07 18:33:19'),(8205,'security_services','security_services_audit_edit','14998',0,'Insert','','2013-05-07 18:33:19'),(8206,'security_services','security_services_audit_edit','14999',0,'Insert','','2013-05-07 18:33:19'),(8207,'security_services','security_services_audit_edit','15000',0,'Insert','','2013-05-07 18:33:19'),(8208,'security_services','security_services_audit_edit','15001',0,'Insert','','2013-05-07 18:33:19'),(8209,'security_services','security_services_audit_edit','15002',0,'Insert','','2013-05-07 18:33:19'),(8210,'security_services','security_services_audit_edit','15003',0,'Insert','','2013-05-07 18:33:19'),(8211,'security_services','security_services_audit_edit','15004',0,'Insert','','2013-05-07 18:33:19'),(8212,'security_services','security_services_audit_edit','15005',0,'Insert','','2013-05-07 18:33:19'),(8213,'security_services','security_services_audit_edit','15006',0,'Insert','','2013-05-07 18:33:19'),(8214,'security_services','security_services_audit_edit','15007',0,'Insert','','2013-05-07 18:33:19'),(8215,'security_services','security_services_audit_edit','15008',0,'Insert','','2013-05-07 18:33:19'),(8216,'security_services','security_services_audit_edit','15009',0,'Insert','','2013-05-07 18:33:19'),(8217,'security_services','security_services_audit_edit','15010',0,'Insert','','2013-05-07 18:33:19'),(8218,'security_services','security_services_audit_edit','15011',0,'Insert','','2013-05-07 18:33:19'),(8219,'security_services','security_services_audit_edit','15012',0,'Insert','','2013-05-07 18:33:19'),(8220,'security_services','security_services_audit_edit','15013',0,'Insert','','2013-05-07 18:33:19'),(8221,'security_services','security_services_audit_edit','15014',0,'Insert','','2013-05-07 18:33:19'),(8222,'security_services','security_services_audit_edit','15015',0,'Insert','','2013-05-07 18:33:19'),(8223,'security_services','security_services_audit_edit','15016',0,'Insert','','2013-05-07 18:33:19'),(8224,'security_services','security_services_audit_edit','15017',0,'Insert','','2013-05-07 18:33:19'),(8225,'security_services','security_services_audit_edit','15018',0,'Insert','','2013-05-07 18:33:19'),(8226,'security_services','security_services_audit_edit','15019',0,'Insert','','2013-05-07 18:33:19'),(8227,'security_services','security_services_audit_edit','15020',0,'Insert','','2013-05-07 18:33:19'),(8228,'security_services','security_services_audit_edit','15021',0,'Insert','','2013-05-07 18:33:19'),(8229,'security_services','security_services_audit_edit','15022',0,'Insert','','2013-05-07 18:33:19'),(8230,'security_services','security_services_audit_edit','15023',0,'Insert','','2013-05-07 18:33:19'),(8231,'security_services','security_services_audit_edit','15024',0,'Insert','','2013-05-07 18:33:19'),(8232,'security_services','security_services_audit_edit','15025',0,'Insert','','2013-05-07 18:33:19'),(8233,'security_services','security_services_audit_edit','15026',0,'Insert','','2013-05-07 18:33:19'),(8234,'security_services','security_services_audit_edit','15027',0,'Insert','','2013-05-07 18:33:19'),(8235,'security_services','security_services_audit_edit','15028',0,'Insert','','2013-05-07 18:33:19'),(8236,'security_services','security_services_audit_edit','15029',0,'Insert','','2013-05-07 18:33:19'),(8237,'security_services','security_services_audit_edit','15030',0,'Insert','','2013-05-07 18:33:19'),(8238,'security_services','security_services_audit_edit','15031',0,'Insert','','2013-05-07 18:33:19'),(8239,'security_services','security_services_audit_edit','15032',0,'Insert','','2013-05-07 18:33:19'),(8240,'security_services','security_services_audit_edit','15033',0,'Insert','','2013-05-07 18:33:19'),(8241,'security_services','security_services_audit_edit','15034',0,'Insert','','2013-05-07 18:33:19'),(8242,'security_services','security_services_audit_edit','15035',0,'Insert','','2013-05-07 18:33:19'),(8243,'security_services','security_services_audit_edit','15036',0,'Insert','','2013-05-07 18:33:19'),(8244,'security_services','security_services_audit_edit','15037',0,'Insert','','2013-05-07 18:33:19'),(8245,'security_services','security_services_audit_edit','15038',0,'Insert','','2013-05-07 18:33:19'),(8246,'security_services','security_services_audit_edit','15039',0,'Insert','','2013-05-07 18:33:19'),(8247,'security_services','security_services_audit_edit','15040',0,'Insert','','2013-05-07 18:33:19'),(8248,'security_services','security_services_audit_edit','15041',0,'Insert','','2013-05-07 18:33:19'),(8249,'security_services','security_services_audit_edit','15042',0,'Insert','','2013-05-07 18:33:19'),(8250,'security_services','security_services_audit_edit','15043',0,'Insert','','2013-05-07 18:33:19'),(8251,'security_services','security_services_audit_edit','15044',0,'Insert','','2013-05-07 18:33:19'),(8252,'security_services','security_services_audit_edit','15045',0,'Insert','','2013-05-07 18:33:19'),(8253,'security_services','security_services_audit_edit','15046',0,'Insert','','2013-05-07 18:33:19'),(8254,'security_services','security_services_audit_edit','15047',0,'Insert','','2013-05-07 18:33:19'),(8255,'security_services','security_services_audit_edit','15048',0,'Insert','','2013-05-07 18:33:19'),(8256,'security_services','security_services_audit_edit','15049',0,'Insert','','2013-05-07 18:33:19'),(8257,'security_services','security_services_audit_edit','15050',0,'Insert','','2013-05-07 18:33:19'),(8258,'security_services','security_services_audit_edit','15051',0,'Insert','','2013-05-07 18:33:19'),(8259,'security_services','security_services_audit_edit','15052',0,'Insert','','2013-05-07 18:33:19'),(8260,'security_services','security_services_audit_edit','15053',0,'Insert','','2013-05-07 18:33:19'),(8261,'security_services','security_services_audit_edit','15054',0,'Insert','','2013-05-07 18:33:19'),(8262,'security_services','security_services_audit_edit','15055',0,'Insert','','2013-05-07 18:33:19'),(8263,'security_services','security_services_audit_edit','15056',0,'Insert','','2013-05-07 18:33:19'),(8264,'security_services','security_services_audit_edit','15057',0,'Insert','','2013-05-07 18:33:19'),(8265,'security_services','security_services_audit_edit','15058',0,'Insert','','2013-05-07 18:33:19'),(8266,'asset','asset_edit','46',2,'Update','','2013-05-07 18:57:12'),(8267,'asset','asset_edit','47',2,'Update','','2013-05-07 19:00:06'),(8268,'asset','asset_edit','87',2,'Update','','2013-05-07 19:04:44'),(8269,'risk','risk_management_edit','2',2,'Update','','2013-05-07 19:10:15'),(8270,'risk','risk_management_edit','3',2,'Update','','2013-05-07 19:13:59'),(8271,'risk','risk_management_edit','4',2,'Update','','2013-05-07 19:15:36'),(8272,'system','system_authorization','',0,'Wrong Login','','2013-05-07 23:03:10'),(8273,'system','system_authorization_edit','2',2,'Login','','2013-05-07 23:03:21'),(8274,'security_services','security_services_audit_edit','15059',0,'Insert','','2013-05-07 23:03:21'),(8275,'security_services','security_services_audit_edit','15060',0,'Insert','','2013-05-07 23:03:21'),(8276,'security_services','security_services_audit_edit','15061',0,'Insert','','2013-05-07 23:03:21'),(8277,'security_services','security_services_audit_edit','15062',0,'Insert','','2013-05-07 23:03:21'),(8278,'security_services','security_services_audit_edit','15063',0,'Insert','','2013-05-07 23:03:21'),(8279,'security_services','security_services_audit_edit','15064',0,'Insert','','2013-05-07 23:03:21'),(8280,'security_services','security_services_audit_edit','15065',0,'Insert','','2013-05-07 23:03:21'),(8281,'security_services','security_services_audit_edit','15066',0,'Insert','','2013-05-07 23:03:21'),(8282,'security_services','security_services_audit_edit','15067',0,'Insert','','2013-05-07 23:03:21'),(8283,'security_services','security_services_audit_edit','15068',0,'Insert','','2013-05-07 23:03:21'),(8284,'security_services','security_services_audit_edit','15069',0,'Insert','','2013-05-07 23:03:21'),(8285,'security_services','security_services_audit_edit','15070',0,'Insert','','2013-05-07 23:03:21'),(8286,'security_services','security_services_audit_edit','15071',0,'Insert','','2013-05-07 23:03:21'),(8287,'security_services','security_services_audit_edit','15072',0,'Insert','','2013-05-07 23:03:21'),(8288,'security_services','security_services_audit_edit','15073',0,'Insert','','2013-05-07 23:03:21'),(8289,'security_services','security_services_audit_edit','15074',0,'Insert','','2013-05-07 23:03:21'),(8290,'security_services','security_services_audit_edit','15075',0,'Insert','','2013-05-07 23:03:21'),(8291,'security_services','security_services_audit_edit','15076',0,'Insert','','2013-05-07 23:03:21'),(8292,'security_services','security_services_audit_edit','15077',0,'Insert','','2013-05-07 23:03:21'),(8293,'security_services','security_services_audit_edit','15078',0,'Insert','','2013-05-07 23:03:21'),(8294,'security_services','security_services_audit_edit','15079',0,'Insert','','2013-05-07 23:03:21'),(8295,'security_services','security_services_audit_edit','15080',0,'Insert','','2013-05-07 23:03:21'),(8296,'security_services','security_services_audit_edit','15081',0,'Insert','','2013-05-07 23:03:21'),(8297,'security_services','security_services_audit_edit','15082',0,'Insert','','2013-05-07 23:03:21'),(8298,'security_services','security_services_audit_edit','15083',0,'Insert','','2013-05-07 23:03:21'),(8299,'security_services','security_services_audit_edit','15084',0,'Insert','','2013-05-07 23:03:21'),(8300,'security_services','security_services_audit_edit','15085',0,'Insert','','2013-05-07 23:03:21'),(8301,'security_services','security_services_audit_edit','15086',0,'Insert','','2013-05-07 23:03:21'),(8302,'security_services','security_services_audit_edit','15087',0,'Insert','','2013-05-07 23:03:21'),(8303,'security_services','security_services_audit_edit','15088',0,'Insert','','2013-05-07 23:03:21'),(8304,'security_services','security_services_audit_edit','15089',0,'Insert','','2013-05-07 23:03:22'),(8305,'security_services','security_services_audit_edit','15090',0,'Insert','','2013-05-07 23:03:22'),(8306,'security_services','security_services_audit_edit','15091',0,'Insert','','2013-05-07 23:03:22'),(8307,'security_services','security_services_audit_edit','15092',0,'Insert','','2013-05-07 23:03:22'),(8308,'security_services','security_services_audit_edit','15093',0,'Insert','','2013-05-07 23:03:22'),(8309,'security_services','security_services_audit_edit','15094',0,'Insert','','2013-05-07 23:03:22'),(8310,'security_services','security_services_audit_edit','15095',0,'Insert','','2013-05-07 23:03:22'),(8311,'security_services','security_services_audit_edit','15096',0,'Insert','','2013-05-07 23:03:22'),(8312,'security_services','security_services_audit_edit','15097',0,'Insert','','2013-05-07 23:03:22'),(8313,'security_services','security_services_audit_edit','15098',0,'Insert','','2013-05-07 23:03:22'),(8314,'security_services','security_services_audit_edit','15099',0,'Insert','','2013-05-07 23:03:22'),(8315,'security_services','security_services_audit_edit','15100',0,'Insert','','2013-05-07 23:03:22'),(8316,'security_services','security_services_audit_edit','15101',0,'Insert','','2013-05-07 23:03:22'),(8317,'security_services','security_services_audit_edit','15102',0,'Insert','','2013-05-07 23:03:22'),(8318,'security_services','security_services_audit_edit','15103',0,'Insert','','2013-05-07 23:03:22'),(8319,'security_services','security_services_audit_edit','15104',0,'Insert','','2013-05-07 23:03:22'),(8320,'security_services','security_services_audit_edit','15105',0,'Insert','','2013-05-07 23:03:22'),(8321,'security_services','security_services_audit_edit','15106',0,'Insert','','2013-05-07 23:03:22'),(8322,'security_services','security_services_audit_edit','15107',0,'Insert','','2013-05-07 23:03:22'),(8323,'security_services','security_services_audit_edit','15108',0,'Insert','','2013-05-07 23:03:22'),(8324,'security_services','security_services_audit_edit','15109',0,'Insert','','2013-05-07 23:03:22'),(8325,'security_services','security_services_audit_edit','15110',0,'Insert','','2013-05-07 23:03:22'),(8326,'security_services','security_services_audit_edit','15111',0,'Insert','','2013-05-07 23:03:22'),(8327,'security_services','security_services_audit_edit','15112',0,'Insert','','2013-05-07 23:03:22'),(8328,'security_services','security_services_audit_edit','15113',0,'Insert','','2013-05-07 23:03:22'),(8329,'security_services','security_services_audit_edit','15114',0,'Insert','','2013-05-07 23:03:22'),(8330,'security_services','security_services_audit_edit','15115',0,'Insert','','2013-05-07 23:03:22'),(8331,'security_services','security_services_audit_edit','15116',0,'Insert','','2013-05-07 23:03:22'),(8332,'security_services','security_services_audit_edit','15117',0,'Insert','','2013-05-07 23:03:22'),(8333,'security_services','security_services_audit_edit','15118',0,'Insert','','2013-05-07 23:03:22'),(8334,'security_services','security_services_audit_edit','15119',0,'Insert','','2013-05-07 23:03:22'),(8335,'security_services','security_services_audit_edit','15120',0,'Insert','','2013-05-07 23:03:22'),(8336,'security_services','security_services_audit_edit','15121',0,'Insert','','2013-05-07 23:03:22'),(8337,'security_services','security_services_audit_edit','15122',0,'Insert','','2013-05-07 23:03:22'),(8338,'security_services','security_services_audit_edit','15123',0,'Insert','','2013-05-07 23:03:22'),(8339,'security_services','security_services_audit_edit','15124',0,'Insert','','2013-05-07 23:03:22'),(8340,'security_services','security_services_audit_edit','15125',0,'Insert','','2013-05-07 23:03:22'),(8341,'security_services','security_services_audit_edit','15126',0,'Insert','','2013-05-07 23:03:22'),(8342,'security_services','security_services_audit_edit','15127',0,'Insert','','2013-05-07 23:03:22'),(8343,'security_services','security_services_audit_edit','15128',0,'Insert','','2013-05-07 23:03:22'),(8344,'security_services','security_services_audit_edit','15129',0,'Insert','','2013-05-07 23:03:22'),(8345,'security_services','security_services_audit_edit','15130',0,'Insert','','2013-05-07 23:03:22'),(8346,'security_services','security_services_audit_edit','15131',0,'Insert','','2013-05-07 23:03:22'),(8347,'security_services','security_services_audit_edit','15132',0,'Insert','','2013-05-07 23:03:22'),(8348,'security_services','security_services_audit_edit','15133',0,'Insert','','2013-05-07 23:03:22'),(8349,'system','system_authorization_edit','2',2,'Login','','2013-05-07 23:19:34'),(8350,'security_services','security_services_audit_edit','15134',0,'Insert','','2013-05-07 23:19:34'),(8351,'security_services','security_services_audit_edit','15135',0,'Insert','','2013-05-07 23:19:34'),(8352,'security_services','security_services_audit_edit','15136',0,'Insert','','2013-05-07 23:19:34'),(8353,'security_services','security_services_audit_edit','15137',0,'Insert','','2013-05-07 23:19:34'),(8354,'security_services','security_services_audit_edit','15138',0,'Insert','','2013-05-07 23:19:34'),(8355,'security_services','security_services_audit_edit','15139',0,'Insert','','2013-05-07 23:19:34'),(8356,'security_services','security_services_audit_edit','15140',0,'Insert','','2013-05-07 23:19:34'),(8357,'security_services','security_services_audit_edit','15141',0,'Insert','','2013-05-07 23:19:34'),(8358,'security_services','security_services_audit_edit','15142',0,'Insert','','2013-05-07 23:19:34'),(8359,'security_services','security_services_audit_edit','15143',0,'Insert','','2013-05-07 23:19:34'),(8360,'security_services','security_services_audit_edit','15144',0,'Insert','','2013-05-07 23:19:34'),(8361,'security_services','security_services_audit_edit','15145',0,'Insert','','2013-05-07 23:19:34'),(8362,'security_services','security_services_audit_edit','15146',0,'Insert','','2013-05-07 23:19:34'),(8363,'security_services','security_services_audit_edit','15147',0,'Insert','','2013-05-07 23:19:34'),(8364,'security_services','security_services_audit_edit','15148',0,'Insert','','2013-05-07 23:19:34'),(8365,'security_services','security_services_audit_edit','15149',0,'Insert','','2013-05-07 23:19:34'),(8366,'security_services','security_services_audit_edit','15150',0,'Insert','','2013-05-07 23:19:35'),(8367,'security_services','security_services_audit_edit','15151',0,'Insert','','2013-05-07 23:19:35'),(8368,'security_services','security_services_audit_edit','15152',0,'Insert','','2013-05-07 23:19:35'),(8369,'security_services','security_services_audit_edit','15153',0,'Insert','','2013-05-07 23:19:35'),(8370,'security_services','security_services_audit_edit','15154',0,'Insert','','2013-05-07 23:19:35'),(8371,'security_services','security_services_audit_edit','15155',0,'Insert','','2013-05-07 23:19:35'),(8372,'security_services','security_services_audit_edit','15156',0,'Insert','','2013-05-07 23:19:35'),(8373,'security_services','security_services_audit_edit','15157',0,'Insert','','2013-05-07 23:19:35'),(8374,'security_services','security_services_audit_edit','15158',0,'Insert','','2013-05-07 23:19:35'),(8375,'security_services','security_services_audit_edit','15159',0,'Insert','','2013-05-07 23:19:35'),(8376,'security_services','security_services_audit_edit','15160',0,'Insert','','2013-05-07 23:19:35'),(8377,'security_services','security_services_audit_edit','15161',0,'Insert','','2013-05-07 23:19:35'),(8378,'security_services','security_services_audit_edit','15162',0,'Insert','','2013-05-07 23:19:35'),(8379,'security_services','security_services_audit_edit','15163',0,'Insert','','2013-05-07 23:19:35'),(8380,'security_services','security_services_audit_edit','15164',0,'Insert','','2013-05-07 23:19:35'),(8381,'security_services','security_services_audit_edit','15165',0,'Insert','','2013-05-07 23:19:35'),(8382,'security_services','security_services_audit_edit','15166',0,'Insert','','2013-05-07 23:19:35'),(8383,'security_services','security_services_audit_edit','15167',0,'Insert','','2013-05-07 23:19:35'),(8384,'security_services','security_services_audit_edit','15168',0,'Insert','','2013-05-07 23:19:35'),(8385,'security_services','security_services_audit_edit','15169',0,'Insert','','2013-05-07 23:19:35'),(8386,'security_services','security_services_audit_edit','15170',0,'Insert','','2013-05-07 23:19:35'),(8387,'security_services','security_services_audit_edit','15171',0,'Insert','','2013-05-07 23:19:35'),(8388,'security_services','security_services_audit_edit','15172',0,'Insert','','2013-05-07 23:19:35'),(8389,'security_services','security_services_audit_edit','15173',0,'Insert','','2013-05-07 23:19:35'),(8390,'security_services','security_services_audit_edit','15174',0,'Insert','','2013-05-07 23:19:35'),(8391,'security_services','security_services_audit_edit','15175',0,'Insert','','2013-05-07 23:19:35'),(8392,'security_services','security_services_audit_edit','15176',0,'Insert','','2013-05-07 23:19:35'),(8393,'security_services','security_services_audit_edit','15177',0,'Insert','','2013-05-07 23:19:35'),(8394,'security_services','security_services_audit_edit','15178',0,'Insert','','2013-05-07 23:19:35'),(8395,'security_services','security_services_audit_edit','15179',0,'Insert','','2013-05-07 23:19:35'),(8396,'security_services','security_services_audit_edit','15180',0,'Insert','','2013-05-07 23:19:35'),(8397,'security_services','security_services_audit_edit','15181',0,'Insert','','2013-05-07 23:19:35'),(8398,'security_services','security_services_audit_edit','15182',0,'Insert','','2013-05-07 23:19:35'),(8399,'security_services','security_services_audit_edit','15183',0,'Insert','','2013-05-07 23:19:35'),(8400,'security_services','security_services_audit_edit','15184',0,'Insert','','2013-05-07 23:19:35'),(8401,'security_services','security_services_audit_edit','15185',0,'Insert','','2013-05-07 23:19:35'),(8402,'security_services','security_services_audit_edit','15186',0,'Insert','','2013-05-07 23:19:35'),(8403,'security_services','security_services_audit_edit','15187',0,'Insert','','2013-05-07 23:19:35'),(8404,'security_services','security_services_audit_edit','15188',0,'Insert','','2013-05-07 23:19:35'),(8405,'security_services','security_services_audit_edit','15189',0,'Insert','','2013-05-07 23:19:35'),(8406,'security_services','security_services_audit_edit','15190',0,'Insert','','2013-05-07 23:19:35'),(8407,'security_services','security_services_audit_edit','15191',0,'Insert','','2013-05-07 23:19:35'),(8408,'security_services','security_services_audit_edit','15192',0,'Insert','','2013-05-07 23:19:35'),(8409,'security_services','security_services_audit_edit','15193',0,'Insert','','2013-05-07 23:19:35'),(8410,'security_services','security_services_audit_edit','15194',0,'Insert','','2013-05-07 23:19:35'),(8411,'security_services','security_services_audit_edit','15195',0,'Insert','','2013-05-07 23:19:35'),(8412,'security_services','security_services_audit_edit','15196',0,'Insert','','2013-05-07 23:19:35'),(8413,'security_services','security_services_audit_edit','15197',0,'Insert','','2013-05-07 23:19:35'),(8414,'security_services','security_services_audit_edit','15198',0,'Insert','','2013-05-07 23:19:35'),(8415,'security_services','security_services_audit_edit','15199',0,'Insert','','2013-05-07 23:19:35'),(8416,'security_services','security_services_audit_edit','15200',0,'Insert','','2013-05-07 23:19:35'),(8417,'security_services','security_services_audit_edit','15201',0,'Insert','','2013-05-07 23:19:35'),(8418,'security_services','security_services_audit_edit','15202',0,'Insert','','2013-05-07 23:19:35'),(8419,'security_services','security_services_audit_edit','15203',0,'Insert','','2013-05-07 23:19:35'),(8420,'security_services','security_services_audit_edit','15204',0,'Insert','','2013-05-07 23:19:35'),(8421,'security_services','security_services_audit_edit','15205',0,'Insert','','2013-05-07 23:19:35'),(8422,'security_services','security_services_audit_edit','15206',0,'Insert','','2013-05-07 23:19:35'),(8423,'security_services','security_services_audit_edit','15207',0,'Insert','','2013-05-07 23:19:35'),(8424,'security_services','security_services_audit_edit','15208',0,'Insert','','2013-05-07 23:19:35'),(8425,'asset','asset_edit','46',2,'Update','','2013-05-07 23:21:42'),(8426,'risk','risk_management_edit','2',2,'Update','','2013-05-07 23:23:46'),(8427,'risk','risk_management_edit','3',2,'Update','','2013-05-07 23:25:29'),(8428,'risk','risk_management_edit','2',2,'Update','','2013-05-07 23:25:42'),(8429,'risk','risk_management_edit','3',2,'Update','','2013-05-07 23:27:23'),(8430,'risk','risk_management_edit','4',2,'Update','','2013-05-07 23:29:05'),(8431,'asset','asset_edit','46',2,'Update','','2013-05-07 23:42:30'),(8432,'system','system_authorization_edit','2',2,'Login','','2013-05-07 23:47:57'),(8433,'security_services','security_services_audit_edit','15209',0,'Insert','','2013-05-07 23:47:57'),(8434,'security_services','security_services_audit_edit','15210',0,'Insert','','2013-05-07 23:47:57'),(8435,'security_services','security_services_audit_edit','15211',0,'Insert','','2013-05-07 23:47:57'),(8436,'security_services','security_services_audit_edit','15212',0,'Insert','','2013-05-07 23:47:57'),(8437,'security_services','security_services_audit_edit','15213',0,'Insert','','2013-05-07 23:47:57'),(8438,'security_services','security_services_audit_edit','15214',0,'Insert','','2013-05-07 23:47:57'),(8439,'security_services','security_services_audit_edit','15215',0,'Insert','','2013-05-07 23:47:57'),(8440,'security_services','security_services_audit_edit','15216',0,'Insert','','2013-05-07 23:47:57'),(8441,'security_services','security_services_audit_edit','15217',0,'Insert','','2013-05-07 23:47:57'),(8442,'security_services','security_services_audit_edit','15218',0,'Insert','','2013-05-07 23:47:57'),(8443,'security_services','security_services_audit_edit','15219',0,'Insert','','2013-05-07 23:47:57'),(8444,'security_services','security_services_audit_edit','15220',0,'Insert','','2013-05-07 23:47:57'),(8445,'security_services','security_services_audit_edit','15221',0,'Insert','','2013-05-07 23:47:57'),(8446,'security_services','security_services_audit_edit','15222',0,'Insert','','2013-05-07 23:47:57'),(8447,'security_services','security_services_audit_edit','15223',0,'Insert','','2013-05-07 23:47:57'),(8448,'security_services','security_services_audit_edit','15224',0,'Insert','','2013-05-07 23:47:57'),(8449,'security_services','security_services_audit_edit','15225',0,'Insert','','2013-05-07 23:47:57'),(8450,'security_services','security_services_audit_edit','15226',0,'Insert','','2013-05-07 23:47:57'),(8451,'security_services','security_services_audit_edit','15227',0,'Insert','','2013-05-07 23:47:57'),(8452,'security_services','security_services_audit_edit','15228',0,'Insert','','2013-05-07 23:47:57'),(8453,'security_services','security_services_audit_edit','15229',0,'Insert','','2013-05-07 23:47:57'),(8454,'security_services','security_services_audit_edit','15230',0,'Insert','','2013-05-07 23:47:57'),(8455,'security_services','security_services_audit_edit','15231',0,'Insert','','2013-05-07 23:47:57'),(8456,'security_services','security_services_audit_edit','15232',0,'Insert','','2013-05-07 23:47:57'),(8457,'security_services','security_services_audit_edit','15233',0,'Insert','','2013-05-07 23:47:57'),(8458,'security_services','security_services_audit_edit','15234',0,'Insert','','2013-05-07 23:47:57'),(8459,'security_services','security_services_audit_edit','15235',0,'Insert','','2013-05-07 23:47:57'),(8460,'security_services','security_services_audit_edit','15236',0,'Insert','','2013-05-07 23:47:57'),(8461,'security_services','security_services_audit_edit','15237',0,'Insert','','2013-05-07 23:47:57'),(8462,'security_services','security_services_audit_edit','15238',0,'Insert','','2013-05-07 23:47:57'),(8463,'security_services','security_services_audit_edit','15239',0,'Insert','','2013-05-07 23:47:57'),(8464,'security_services','security_services_audit_edit','15240',0,'Insert','','2013-05-07 23:47:57'),(8465,'security_services','security_services_audit_edit','15241',0,'Insert','','2013-05-07 23:47:57'),(8466,'security_services','security_services_audit_edit','15242',0,'Insert','','2013-05-07 23:47:57'),(8467,'security_services','security_services_audit_edit','15243',0,'Insert','','2013-05-07 23:47:57'),(8468,'security_services','security_services_audit_edit','15244',0,'Insert','','2013-05-07 23:47:57'),(8469,'security_services','security_services_audit_edit','15245',0,'Insert','','2013-05-07 23:47:57'),(8470,'security_services','security_services_audit_edit','15246',0,'Insert','','2013-05-07 23:47:57'),(8471,'security_services','security_services_audit_edit','15247',0,'Insert','','2013-05-07 23:47:57'),(8472,'security_services','security_services_audit_edit','15248',0,'Insert','','2013-05-07 23:47:57'),(8473,'security_services','security_services_audit_edit','15249',0,'Insert','','2013-05-07 23:47:57'),(8474,'security_services','security_services_audit_edit','15250',0,'Insert','','2013-05-07 23:47:57'),(8475,'security_services','security_services_audit_edit','15251',0,'Insert','','2013-05-07 23:47:57'),(8476,'security_services','security_services_audit_edit','15252',0,'Insert','','2013-05-07 23:47:57'),(8477,'security_services','security_services_audit_edit','15253',0,'Insert','','2013-05-07 23:47:57'),(8478,'security_services','security_services_audit_edit','15254',0,'Insert','','2013-05-07 23:47:57'),(8479,'security_services','security_services_audit_edit','15255',0,'Insert','','2013-05-07 23:47:57'),(8480,'security_services','security_services_audit_edit','15256',0,'Insert','','2013-05-07 23:47:57'),(8481,'security_services','security_services_audit_edit','15257',0,'Insert','','2013-05-07 23:47:57'),(8482,'security_services','security_services_audit_edit','15258',0,'Insert','','2013-05-07 23:47:57'),(8483,'security_services','security_services_audit_edit','15259',0,'Insert','','2013-05-07 23:47:57'),(8484,'security_services','security_services_audit_edit','15260',0,'Insert','','2013-05-07 23:47:57'),(8485,'security_services','security_services_audit_edit','15261',0,'Insert','','2013-05-07 23:47:57'),(8486,'security_services','security_services_audit_edit','15262',0,'Insert','','2013-05-07 23:47:57'),(8487,'security_services','security_services_audit_edit','15263',0,'Insert','','2013-05-07 23:47:57'),(8488,'security_services','security_services_audit_edit','15264',0,'Insert','','2013-05-07 23:47:57'),(8489,'security_services','security_services_audit_edit','15265',0,'Insert','','2013-05-07 23:47:57'),(8490,'security_services','security_services_audit_edit','15266',0,'Insert','','2013-05-07 23:47:57'),(8491,'security_services','security_services_audit_edit','15267',0,'Insert','','2013-05-07 23:47:57'),(8492,'security_services','security_services_audit_edit','15268',0,'Insert','','2013-05-07 23:47:57'),(8493,'security_services','security_services_audit_edit','15269',0,'Insert','','2013-05-07 23:47:57'),(8494,'security_services','security_services_audit_edit','15270',0,'Insert','','2013-05-07 23:47:57'),(8495,'security_services','security_services_audit_edit','15271',0,'Insert','','2013-05-07 23:47:57'),(8496,'security_services','security_services_audit_edit','15272',0,'Insert','','2013-05-07 23:47:57'),(8497,'security_services','security_services_audit_edit','15273',0,'Insert','','2013-05-07 23:47:57'),(8498,'security_services','security_services_audit_edit','15274',0,'Insert','','2013-05-07 23:47:57'),(8499,'security_services','security_services_audit_edit','15275',0,'Insert','','2013-05-07 23:47:57'),(8500,'security_services','security_services_audit_edit','15276',0,'Insert','','2013-05-07 23:47:57'),(8501,'security_services','security_services_audit_edit','15277',0,'Insert','','2013-05-07 23:47:57'),(8502,'security_services','security_services_audit_edit','15278',0,'Insert','','2013-05-07 23:47:57'),(8503,'security_services','security_services_audit_edit','15279',0,'Insert','','2013-05-07 23:47:57'),(8504,'security_services','security_services_audit_edit','15280',0,'Insert','','2013-05-07 23:47:57'),(8505,'security_services','security_services_audit_edit','15281',0,'Insert','','2013-05-07 23:47:57'),(8506,'security_services','security_services_audit_edit','15282',0,'Insert','','2013-05-07 23:47:57'),(8507,'security_services','security_services_audit_edit','15283',0,'Insert','','2013-05-07 23:47:57'),(8508,'asset','asset_edit','48',2,'Update','','2013-05-08 00:10:54'),(8509,'asset','asset_edit','87',2,'Update','','2013-05-08 00:13:16'),(8510,'system','system_authorization_edit','2',2,'Login','','2013-05-08 13:03:16'),(8511,'security_services','security_services_audit_edit','15284',0,'Insert','','2013-05-08 13:03:16'),(8512,'security_services','security_services_audit_edit','15285',0,'Insert','','2013-05-08 13:03:16'),(8513,'security_services','security_services_audit_edit','15286',0,'Insert','','2013-05-08 13:03:16'),(8514,'security_services','security_services_audit_edit','15287',0,'Insert','','2013-05-08 13:03:16'),(8515,'security_services','security_services_audit_edit','15288',0,'Insert','','2013-05-08 13:03:16'),(8516,'security_services','security_services_audit_edit','15289',0,'Insert','','2013-05-08 13:03:16'),(8517,'security_services','security_services_audit_edit','15290',0,'Insert','','2013-05-08 13:03:16'),(8518,'security_services','security_services_audit_edit','15291',0,'Insert','','2013-05-08 13:03:16'),(8519,'security_services','security_services_audit_edit','15292',0,'Insert','','2013-05-08 13:03:16'),(8520,'security_services','security_services_audit_edit','15293',0,'Insert','','2013-05-08 13:03:16'),(8521,'security_services','security_services_audit_edit','15294',0,'Insert','','2013-05-08 13:03:16'),(8522,'security_services','security_services_audit_edit','15295',0,'Insert','','2013-05-08 13:03:16'),(8523,'security_services','security_services_audit_edit','15296',0,'Insert','','2013-05-08 13:03:16'),(8524,'security_services','security_services_audit_edit','15297',0,'Insert','','2013-05-08 13:03:16'),(8525,'security_services','security_services_audit_edit','15298',0,'Insert','','2013-05-08 13:03:16'),(8526,'security_services','security_services_audit_edit','15299',0,'Insert','','2013-05-08 13:03:16'),(8527,'security_services','security_services_audit_edit','15300',0,'Insert','','2013-05-08 13:03:16'),(8528,'security_services','security_services_audit_edit','15301',0,'Insert','','2013-05-08 13:03:16'),(8529,'security_services','security_services_audit_edit','15302',0,'Insert','','2013-05-08 13:03:16'),(8530,'security_services','security_services_audit_edit','15303',0,'Insert','','2013-05-08 13:03:16'),(8531,'security_services','security_services_audit_edit','15304',0,'Insert','','2013-05-08 13:03:16'),(8532,'security_services','security_services_audit_edit','15305',0,'Insert','','2013-05-08 13:03:16'),(8533,'security_services','security_services_audit_edit','15306',0,'Insert','','2013-05-08 13:03:16'),(8534,'security_services','security_services_audit_edit','15307',0,'Insert','','2013-05-08 13:03:16'),(8535,'security_services','security_services_audit_edit','15308',0,'Insert','','2013-05-08 13:03:16'),(8536,'security_services','security_services_audit_edit','15309',0,'Insert','','2013-05-08 13:03:16'),(8537,'security_services','security_services_audit_edit','15310',0,'Insert','','2013-05-08 13:03:16'),(8538,'security_services','security_services_audit_edit','15311',0,'Insert','','2013-05-08 13:03:16'),(8539,'security_services','security_services_audit_edit','15312',0,'Insert','','2013-05-08 13:03:16'),(8540,'security_services','security_services_audit_edit','15313',0,'Insert','','2013-05-08 13:03:16'),(8541,'security_services','security_services_audit_edit','15314',0,'Insert','','2013-05-08 13:03:16'),(8542,'security_services','security_services_audit_edit','15315',0,'Insert','','2013-05-08 13:03:16'),(8543,'security_services','security_services_audit_edit','15316',0,'Insert','','2013-05-08 13:03:16'),(8544,'security_services','security_services_audit_edit','15317',0,'Insert','','2013-05-08 13:03:16'),(8545,'security_services','security_services_audit_edit','15318',0,'Insert','','2013-05-08 13:03:16'),(8546,'security_services','security_services_audit_edit','15319',0,'Insert','','2013-05-08 13:03:16'),(8547,'security_services','security_services_audit_edit','15320',0,'Insert','','2013-05-08 13:03:16'),(8548,'security_services','security_services_audit_edit','15321',0,'Insert','','2013-05-08 13:03:16'),(8549,'security_services','security_services_audit_edit','15322',0,'Insert','','2013-05-08 13:03:16'),(8550,'security_services','security_services_audit_edit','15323',0,'Insert','','2013-05-08 13:03:16'),(8551,'security_services','security_services_audit_edit','15324',0,'Insert','','2013-05-08 13:03:16'),(8552,'security_services','security_services_audit_edit','15325',0,'Insert','','2013-05-08 13:03:16'),(8553,'security_services','security_services_audit_edit','15326',0,'Insert','','2013-05-08 13:03:16'),(8554,'security_services','security_services_audit_edit','15327',0,'Insert','','2013-05-08 13:03:16'),(8555,'security_services','security_services_audit_edit','15328',0,'Insert','','2013-05-08 13:03:16'),(8556,'security_services','security_services_audit_edit','15329',0,'Insert','','2013-05-08 13:03:16'),(8557,'security_services','security_services_audit_edit','15330',0,'Insert','','2013-05-08 13:03:16'),(8558,'security_services','security_services_audit_edit','15331',0,'Insert','','2013-05-08 13:03:16'),(8559,'security_services','security_services_audit_edit','15332',0,'Insert','','2013-05-08 13:03:16'),(8560,'security_services','security_services_audit_edit','15333',0,'Insert','','2013-05-08 13:03:16'),(8561,'security_services','security_services_audit_edit','15334',0,'Insert','','2013-05-08 13:03:16'),(8562,'security_services','security_services_audit_edit','15335',0,'Insert','','2013-05-08 13:03:16'),(8563,'security_services','security_services_audit_edit','15336',0,'Insert','','2013-05-08 13:03:16'),(8564,'security_services','security_services_audit_edit','15337',0,'Insert','','2013-05-08 13:03:16'),(8565,'security_services','security_services_audit_edit','15338',0,'Insert','','2013-05-08 13:03:16'),(8566,'security_services','security_services_audit_edit','15339',0,'Insert','','2013-05-08 13:03:16'),(8567,'security_services','security_services_audit_edit','15340',0,'Insert','','2013-05-08 13:03:16'),(8568,'security_services','security_services_audit_edit','15341',0,'Insert','','2013-05-08 13:03:16'),(8569,'security_services','security_services_audit_edit','15342',0,'Insert','','2013-05-08 13:03:16'),(8570,'security_services','security_services_audit_edit','15343',0,'Insert','','2013-05-08 13:03:16'),(8571,'security_services','security_services_audit_edit','15344',0,'Insert','','2013-05-08 13:03:16'),(8572,'security_services','security_services_audit_edit','15345',0,'Insert','','2013-05-08 13:03:16'),(8573,'security_services','security_services_audit_edit','15346',0,'Insert','','2013-05-08 13:03:16'),(8574,'security_services','security_services_audit_edit','15347',0,'Insert','','2013-05-08 13:03:16'),(8575,'security_services','security_services_audit_edit','15348',0,'Insert','','2013-05-08 13:03:16'),(8576,'security_services','security_services_audit_edit','15349',0,'Insert','','2013-05-08 13:03:16'),(8577,'security_services','security_services_audit_edit','15350',0,'Insert','','2013-05-08 13:03:16'),(8578,'security_services','security_services_audit_edit','15351',0,'Insert','','2013-05-08 13:03:16'),(8579,'security_services','security_services_audit_edit','15352',0,'Insert','','2013-05-08 13:03:16'),(8580,'security_services','security_services_audit_edit','15353',0,'Insert','','2013-05-08 13:03:16'),(8581,'security_services','security_services_audit_edit','15354',0,'Insert','','2013-05-08 13:03:16'),(8582,'security_services','security_services_audit_edit','15355',0,'Insert','','2013-05-08 13:03:16'),(8583,'security_services','security_services_audit_edit','15356',0,'Insert','','2013-05-08 13:03:16'),(8584,'security_services','security_services_audit_edit','15357',0,'Insert','','2013-05-08 13:03:16'),(8585,'security_services','security_services_audit_edit','15358',0,'Insert','','2013-05-08 13:03:16'),(8586,'asset','asset_edit','99',2,'Update','','2013-05-08 13:05:54'),(8587,'asset','asset_edit','49',2,'Update','','2013-05-08 13:10:45'),(8588,'risk','risk_management_edit','5',2,'Update','','2013-05-08 13:13:18'),(8589,'asset','asset_edit','50',2,'Update','','2013-05-08 13:16:32'),(8590,'risk','risk_management_edit','6',2,'Update','','2013-05-08 13:19:44'),(8591,'asset','asset_edit','51',2,'Update','','2013-05-08 13:22:13'),(8592,'risk','risk_management_edit','7',2,'Update','','2013-05-08 13:25:37'),(8593,'asset','asset_edit','52',2,'Update','','2013-05-08 13:27:09'),(8594,'risk','risk_management_edit','8',2,'Update','','2013-05-08 13:30:39'),(8595,'asset','asset_edit','53',2,'Update','','2013-05-08 13:34:38'),(8596,'risk','risk_management_edit','9',2,'Update','','2013-05-08 13:37:25'),(8597,'asset','asset_edit','54',2,'Update','','2013-05-08 13:40:31'),(8598,'risk','risk_management_edit','10',2,'Update','','2013-05-08 13:43:47'),(8599,'asset','asset_edit','55',2,'Update','','2013-05-08 13:49:09'),(8600,'risk','risk_management_edit','11',2,'Update','','2013-05-08 13:55:40'),(8601,'asset','asset_edit','56',2,'Update','','2013-05-08 13:58:06'),(8602,'risk','risk_management_edit','12',2,'Update','','2013-05-08 13:59:03'),(8603,'risk','risk_management_edit','12',2,'Update','','2013-05-08 14:00:25'),(8604,'asset','asset_edit','57',2,'Update','','2013-05-08 14:01:59'),(8605,'risk','risk_management_edit','13',2,'Update','','2013-05-08 14:04:47'),(8606,'asset','asset_edit','58',2,'Update','','2013-05-08 14:07:57'),(8607,'risk','risk_management_edit','14',2,'Update','','2013-05-08 14:09:58'),(8608,'asset','asset_edit','59',2,'Update','','2013-05-08 14:14:20'),(8609,'risk','risk_management_edit','15',2,'Update','','2013-05-08 14:17:11'),(8610,'asset','asset_edit','60',2,'Update','','2013-05-08 14:18:29'),(8611,'risk','risk_management_edit','16',2,'Update','','2013-05-08 14:19:54'),(8612,'risk','risk_management_edit','2',2,'Update','','2013-05-08 14:22:50'),(8613,'risk','risk_management_edit','3',2,'Update','','2013-05-08 14:23:09'),(8614,'risk','risk_management_edit','4',2,'Update','','2013-05-08 14:23:32'),(8615,'risk','risk_management_edit','5',2,'Update','','2013-05-08 14:24:11'),(8616,'risk','risk_management_edit','6',2,'Update','','2013-05-08 14:24:30'),(8617,'risk','risk_management_edit','7',2,'Update','','2013-05-08 14:24:55'),(8618,'risk','risk_management_edit','8',2,'Update','','2013-05-08 14:25:17'),(8619,'risk','risk_management_edit','9',2,'Update','','2013-05-08 14:25:52'),(8620,'risk','risk_management_edit','10',2,'Update','','2013-05-08 14:26:11'),(8621,'risk','risk_management_edit','11',2,'Update','','2013-05-08 14:26:29'),(8622,'risk','risk_management_edit','12',2,'Update','','2013-05-08 14:26:49'),(8623,'risk','risk_management_edit','13',2,'Update','','2013-05-08 14:27:12'),(8624,'risk','risk_management_edit','14',2,'Update','','2013-05-08 14:27:30'),(8625,'risk','risk_management_edit','15',2,'Update','','2013-05-08 14:27:45'),(8626,'risk','risk_management_edit','16',2,'Update','','2013-05-08 14:28:03'),(8627,'system','system_authorization_edit','2',2,'Login','','2013-05-08 20:52:05'),(8628,'security_services','security_services_audit_edit','15359',0,'Insert','','2013-05-08 20:52:05'),(8629,'security_services','security_services_audit_edit','15360',0,'Insert','','2013-05-08 20:52:05'),(8630,'security_services','security_services_audit_edit','15361',0,'Insert','','2013-05-08 20:52:05'),(8631,'security_services','security_services_audit_edit','15362',0,'Insert','','2013-05-08 20:52:05'),(8632,'security_services','security_services_audit_edit','15363',0,'Insert','','2013-05-08 20:52:05'),(8633,'security_services','security_services_audit_edit','15364',0,'Insert','','2013-05-08 20:52:05'),(8634,'security_services','security_services_audit_edit','15365',0,'Insert','','2013-05-08 20:52:05'),(8635,'security_services','security_services_audit_edit','15366',0,'Insert','','2013-05-08 20:52:05'),(8636,'security_services','security_services_audit_edit','15367',0,'Insert','','2013-05-08 20:52:05'),(8637,'security_services','security_services_audit_edit','15368',0,'Insert','','2013-05-08 20:52:05'),(8638,'security_services','security_services_audit_edit','15369',0,'Insert','','2013-05-08 20:52:05'),(8639,'security_services','security_services_audit_edit','15370',0,'Insert','','2013-05-08 20:52:05'),(8640,'security_services','security_services_audit_edit','15371',0,'Insert','','2013-05-08 20:52:05'),(8641,'security_services','security_services_audit_edit','15372',0,'Insert','','2013-05-08 20:52:05'),(8642,'security_services','security_services_audit_edit','15373',0,'Insert','','2013-05-08 20:52:05'),(8643,'security_services','security_services_audit_edit','15374',0,'Insert','','2013-05-08 20:52:05'),(8644,'security_services','security_services_audit_edit','15375',0,'Insert','','2013-05-08 20:52:05'),(8645,'security_services','security_services_audit_edit','15376',0,'Insert','','2013-05-08 20:52:05'),(8646,'security_services','security_services_audit_edit','15377',0,'Insert','','2013-05-08 20:52:05'),(8647,'security_services','security_services_audit_edit','15378',0,'Insert','','2013-05-08 20:52:05'),(8648,'security_services','security_services_audit_edit','15379',0,'Insert','','2013-05-08 20:52:05'),(8649,'security_services','security_services_audit_edit','15380',0,'Insert','','2013-05-08 20:52:05'),(8650,'security_services','security_services_audit_edit','15381',0,'Insert','','2013-05-08 20:52:05'),(8651,'security_services','security_services_audit_edit','15382',0,'Insert','','2013-05-08 20:52:05'),(8652,'security_services','security_services_audit_edit','15383',0,'Insert','','2013-05-08 20:52:05'),(8653,'security_services','security_services_audit_edit','15384',0,'Insert','','2013-05-08 20:52:05'),(8654,'security_services','security_services_audit_edit','15385',0,'Insert','','2013-05-08 20:52:05'),(8655,'security_services','security_services_audit_edit','15386',0,'Insert','','2013-05-08 20:52:05'),(8656,'security_services','security_services_audit_edit','15387',0,'Insert','','2013-05-08 20:52:05'),(8657,'security_services','security_services_audit_edit','15388',0,'Insert','','2013-05-08 20:52:05'),(8658,'security_services','security_services_audit_edit','15389',0,'Insert','','2013-05-08 20:52:05'),(8659,'security_services','security_services_audit_edit','15390',0,'Insert','','2013-05-08 20:52:05'),(8660,'security_services','security_services_audit_edit','15391',0,'Insert','','2013-05-08 20:52:05'),(8661,'security_services','security_services_audit_edit','15392',0,'Insert','','2013-05-08 20:52:05'),(8662,'security_services','security_services_audit_edit','15393',0,'Insert','','2013-05-08 20:52:05'),(8663,'security_services','security_services_audit_edit','15394',0,'Insert','','2013-05-08 20:52:05'),(8664,'security_services','security_services_audit_edit','15395',0,'Insert','','2013-05-08 20:52:05'),(8665,'security_services','security_services_audit_edit','15396',0,'Insert','','2013-05-08 20:52:05'),(8666,'security_services','security_services_audit_edit','15397',0,'Insert','','2013-05-08 20:52:05'),(8667,'security_services','security_services_audit_edit','15398',0,'Insert','','2013-05-08 20:52:05'),(8668,'security_services','security_services_audit_edit','15399',0,'Insert','','2013-05-08 20:52:05'),(8669,'security_services','security_services_audit_edit','15400',0,'Insert','','2013-05-08 20:52:05'),(8670,'security_services','security_services_audit_edit','15401',0,'Insert','','2013-05-08 20:52:05'),(8671,'security_services','security_services_audit_edit','15402',0,'Insert','','2013-05-08 20:52:05'),(8672,'security_services','security_services_audit_edit','15403',0,'Insert','','2013-05-08 20:52:05'),(8673,'security_services','security_services_audit_edit','15404',0,'Insert','','2013-05-08 20:52:05'),(8674,'security_services','security_services_audit_edit','15405',0,'Insert','','2013-05-08 20:52:05'),(8675,'security_services','security_services_audit_edit','15406',0,'Insert','','2013-05-08 20:52:05'),(8676,'security_services','security_services_audit_edit','15407',0,'Insert','','2013-05-08 20:52:05'),(8677,'security_services','security_services_audit_edit','15408',0,'Insert','','2013-05-08 20:52:05'),(8678,'security_services','security_services_audit_edit','15409',0,'Insert','','2013-05-08 20:52:05'),(8679,'security_services','security_services_audit_edit','15410',0,'Insert','','2013-05-08 20:52:05'),(8680,'security_services','security_services_audit_edit','15411',0,'Insert','','2013-05-08 20:52:05'),(8681,'security_services','security_services_audit_edit','15412',0,'Insert','','2013-05-08 20:52:05'),(8682,'security_services','security_services_audit_edit','15413',0,'Insert','','2013-05-08 20:52:05'),(8683,'security_services','security_services_audit_edit','15414',0,'Insert','','2013-05-08 20:52:05'),(8684,'security_services','security_services_audit_edit','15415',0,'Insert','','2013-05-08 20:52:05'),(8685,'security_services','security_services_audit_edit','15416',0,'Insert','','2013-05-08 20:52:05'),(8686,'security_services','security_services_audit_edit','15417',0,'Insert','','2013-05-08 20:52:05'),(8687,'security_services','security_services_audit_edit','15418',0,'Insert','','2013-05-08 20:52:05'),(8688,'security_services','security_services_audit_edit','15419',0,'Insert','','2013-05-08 20:52:05'),(8689,'security_services','security_services_audit_edit','15420',0,'Insert','','2013-05-08 20:52:05'),(8690,'security_services','security_services_audit_edit','15421',0,'Insert','','2013-05-08 20:52:05'),(8691,'security_services','security_services_audit_edit','15422',0,'Insert','','2013-05-08 20:52:05'),(8692,'security_services','security_services_audit_edit','15423',0,'Insert','','2013-05-08 20:52:05'),(8693,'security_services','security_services_audit_edit','15424',0,'Insert','','2013-05-08 20:52:05'),(8694,'security_services','security_services_audit_edit','15425',0,'Insert','','2013-05-08 20:52:05'),(8695,'security_services','security_services_audit_edit','15426',0,'Insert','','2013-05-08 20:52:05'),(8696,'security_services','security_services_audit_edit','15427',0,'Insert','','2013-05-08 20:52:05'),(8697,'security_services','security_services_audit_edit','15428',0,'Insert','','2013-05-08 20:52:05'),(8698,'security_services','security_services_audit_edit','15429',0,'Insert','','2013-05-08 20:52:05'),(8699,'security_services','security_services_audit_edit','15430',0,'Insert','','2013-05-08 20:52:05'),(8700,'security_services','security_services_audit_edit','15431',0,'Insert','','2013-05-08 20:52:05'),(8701,'security_services','security_services_audit_edit','15432',0,'Insert','','2013-05-08 20:52:05'),(8702,'security_services','security_services_audit_edit','15433',0,'Insert','','2013-05-08 20:52:05'),(8703,'system','system_authorization_edit','2',2,'Login','','2013-05-09 10:37:02'),(8704,'security_services','security_services_audit_edit','15434',0,'Insert','','2013-05-09 10:37:02'),(8705,'security_services','security_services_audit_edit','15435',0,'Insert','','2013-05-09 10:37:02'),(8706,'security_services','security_services_audit_edit','15436',0,'Insert','','2013-05-09 10:37:02'),(8707,'security_services','security_services_audit_edit','15437',0,'Insert','','2013-05-09 10:37:02'),(8708,'security_services','security_services_audit_edit','15438',0,'Insert','','2013-05-09 10:37:02'),(8709,'security_services','security_services_audit_edit','15439',0,'Insert','','2013-05-09 10:37:02'),(8710,'security_services','security_services_audit_edit','15440',0,'Insert','','2013-05-09 10:37:02'),(8711,'security_services','security_services_audit_edit','15441',0,'Insert','','2013-05-09 10:37:02'),(8712,'security_services','security_services_audit_edit','15442',0,'Insert','','2013-05-09 10:37:02'),(8713,'security_services','security_services_audit_edit','15443',0,'Insert','','2013-05-09 10:37:02'),(8714,'security_services','security_services_audit_edit','15444',0,'Insert','','2013-05-09 10:37:02'),(8715,'security_services','security_services_audit_edit','15445',0,'Insert','','2013-05-09 10:37:02'),(8716,'security_services','security_services_audit_edit','15446',0,'Insert','','2013-05-09 10:37:02'),(8717,'security_services','security_services_audit_edit','15447',0,'Insert','','2013-05-09 10:37:02'),(8718,'security_services','security_services_audit_edit','15448',0,'Insert','','2013-05-09 10:37:02'),(8719,'security_services','security_services_audit_edit','15449',0,'Insert','','2013-05-09 10:37:02'),(8720,'security_services','security_services_audit_edit','15450',0,'Insert','','2013-05-09 10:37:02'),(8721,'security_services','security_services_audit_edit','15451',0,'Insert','','2013-05-09 10:37:02'),(8722,'security_services','security_services_audit_edit','15452',0,'Insert','','2013-05-09 10:37:02'),(8723,'security_services','security_services_audit_edit','15453',0,'Insert','','2013-05-09 10:37:02'),(8724,'security_services','security_services_audit_edit','15454',0,'Insert','','2013-05-09 10:37:02'),(8725,'security_services','security_services_audit_edit','15455',0,'Insert','','2013-05-09 10:37:02'),(8726,'security_services','security_services_audit_edit','15456',0,'Insert','','2013-05-09 10:37:02'),(8727,'security_services','security_services_audit_edit','15457',0,'Insert','','2013-05-09 10:37:02'),(8728,'security_services','security_services_audit_edit','15458',0,'Insert','','2013-05-09 10:37:02'),(8729,'security_services','security_services_audit_edit','15459',0,'Insert','','2013-05-09 10:37:02'),(8730,'security_services','security_services_audit_edit','15460',0,'Insert','','2013-05-09 10:37:02'),(8731,'security_services','security_services_audit_edit','15461',0,'Insert','','2013-05-09 10:37:02'),(8732,'security_services','security_services_audit_edit','15462',0,'Insert','','2013-05-09 10:37:02'),(8733,'security_services','security_services_audit_edit','15463',0,'Insert','','2013-05-09 10:37:02'),(8734,'security_services','security_services_audit_edit','15464',0,'Insert','','2013-05-09 10:37:02'),(8735,'security_services','security_services_audit_edit','15465',0,'Insert','','2013-05-09 10:37:02'),(8736,'security_services','security_services_audit_edit','15466',0,'Insert','','2013-05-09 10:37:02'),(8737,'security_services','security_services_audit_edit','15467',0,'Insert','','2013-05-09 10:37:02'),(8738,'security_services','security_services_audit_edit','15468',0,'Insert','','2013-05-09 10:37:02'),(8739,'security_services','security_services_audit_edit','15469',0,'Insert','','2013-05-09 10:37:02'),(8740,'security_services','security_services_audit_edit','15470',0,'Insert','','2013-05-09 10:37:02'),(8741,'security_services','security_services_audit_edit','15471',0,'Insert','','2013-05-09 10:37:02'),(8742,'security_services','security_services_audit_edit','15472',0,'Insert','','2013-05-09 10:37:02'),(8743,'security_services','security_services_audit_edit','15473',0,'Insert','','2013-05-09 10:37:02'),(8744,'security_services','security_services_audit_edit','15474',0,'Insert','','2013-05-09 10:37:02'),(8745,'security_services','security_services_audit_edit','15475',0,'Insert','','2013-05-09 10:37:02'),(8746,'security_services','security_services_audit_edit','15476',0,'Insert','','2013-05-09 10:37:02'),(8747,'security_services','security_services_audit_edit','15477',0,'Insert','','2013-05-09 10:37:02'),(8748,'security_services','security_services_audit_edit','15478',0,'Insert','','2013-05-09 10:37:02'),(8749,'security_services','security_services_audit_edit','15479',0,'Insert','','2013-05-09 10:37:02'),(8750,'security_services','security_services_audit_edit','15480',0,'Insert','','2013-05-09 10:37:02'),(8751,'security_services','security_services_audit_edit','15481',0,'Insert','','2013-05-09 10:37:02'),(8752,'security_services','security_services_audit_edit','15482',0,'Insert','','2013-05-09 10:37:02'),(8753,'security_services','security_services_audit_edit','15483',0,'Insert','','2013-05-09 10:37:02'),(8754,'security_services','security_services_audit_edit','15484',0,'Insert','','2013-05-09 10:37:02'),(8755,'security_services','security_services_audit_edit','15485',0,'Insert','','2013-05-09 10:37:02'),(8756,'security_services','security_services_audit_edit','15486',0,'Insert','','2013-05-09 10:37:02'),(8757,'security_services','security_services_audit_edit','15487',0,'Insert','','2013-05-09 10:37:02'),(8758,'security_services','security_services_audit_edit','15488',0,'Insert','','2013-05-09 10:37:02'),(8759,'security_services','security_services_audit_edit','15489',0,'Insert','','2013-05-09 10:37:02'),(8760,'security_services','security_services_audit_edit','15490',0,'Insert','','2013-05-09 10:37:02'),(8761,'security_services','security_services_audit_edit','15491',0,'Insert','','2013-05-09 10:37:02'),(8762,'security_services','security_services_audit_edit','15492',0,'Insert','','2013-05-09 10:37:02'),(8763,'security_services','security_services_audit_edit','15493',0,'Insert','','2013-05-09 10:37:02'),(8764,'security_services','security_services_audit_edit','15494',0,'Insert','','2013-05-09 10:37:02'),(8765,'security_services','security_services_audit_edit','15495',0,'Insert','','2013-05-09 10:37:02'),(8766,'security_services','security_services_audit_edit','15496',0,'Insert','','2013-05-09 10:37:02'),(8767,'security_services','security_services_audit_edit','15497',0,'Insert','','2013-05-09 10:37:02'),(8768,'security_services','security_services_audit_edit','15498',0,'Insert','','2013-05-09 10:37:02'),(8769,'security_services','security_services_audit_edit','15499',0,'Insert','','2013-05-09 10:37:02'),(8770,'security_services','security_services_audit_edit','15500',0,'Insert','','2013-05-09 10:37:02'),(8771,'security_services','security_services_audit_edit','15501',0,'Insert','','2013-05-09 10:37:02'),(8772,'security_services','security_services_audit_edit','15502',0,'Insert','','2013-05-09 10:37:02'),(8773,'security_services','security_services_audit_edit','15503',0,'Insert','','2013-05-09 10:37:02'),(8774,'security_services','security_services_audit_edit','15504',0,'Insert','','2013-05-09 10:37:02'),(8775,'security_services','security_services_audit_edit','15505',0,'Insert','','2013-05-09 10:37:02'),(8776,'security_services','security_services_audit_edit','15506',0,'Insert','','2013-05-09 10:37:02'),(8777,'security_services','security_services_audit_edit','15507',0,'Insert','','2013-05-09 10:37:02'),(8778,'security_services','security_services_audit_edit','15508',0,'Insert','','2013-05-09 10:37:02'),(8779,'asset','asset_edit','61',2,'Update','','2013-05-09 10:39:00'),(8780,'risk','risk_management_edit','17',2,'Update','','2013-05-09 10:40:42'),(8781,'risk','risk_management_edit','17',2,'Update','','2013-05-09 10:41:02'),(8782,'asset','asset_edit','62',2,'Update','','2013-05-09 10:43:10'),(8783,'risk','risk_management_edit','18',2,'Update','','2013-05-09 10:44:54'),(8784,'asset','asset_edit','63',2,'Update','','2013-05-09 10:47:27'),(8785,'risk','risk_management_edit','19',2,'Update','','2013-05-09 10:49:40'),(8786,'asset','asset_edit','64',2,'Update','','2013-05-09 10:50:56'),(8787,'risk','risk_management_edit','20',2,'Update','','2013-05-09 10:52:38'),(8788,'asset','asset_edit','65',2,'Update','','2013-05-09 10:54:10'),(8789,'risk','risk_management_edit','21',2,'Update','','2013-05-09 10:57:21'),(8790,'asset','asset_edit','66',2,'Update','','2013-05-09 11:01:12'),(8791,'risk','risk_management_edit','22',2,'Update','','2013-05-09 11:03:27'),(8792,'asset','asset_edit','67',2,'Update','','2013-05-09 11:06:23'),(8793,'risk','risk_management_edit','23',2,'Update','','2013-05-09 11:09:08'),(8794,'asset','asset_edit','68',2,'Update','','2013-05-09 11:11:46'),(8795,'risk','risk_management_edit','24',2,'Update','','2013-05-09 11:14:27'),(8796,'asset','asset_edit','69',2,'Update','','2013-05-09 11:15:44'),(8797,'risk','risk_management_edit','25',2,'Update','','2013-05-09 11:18:03'),(8798,'asset','asset_edit','70',2,'Update','','2013-05-09 11:20:29'),(8799,'risk','risk_management_edit','26',2,'Update','','2013-05-09 11:22:41'),(8800,'asset','asset_edit','71',2,'Update','','2013-05-09 11:39:28'),(8801,'risk','risk_management_edit','27',2,'Update','','2013-05-09 11:41:45'),(8802,'asset','asset_edit','72',2,'Update','','2013-05-09 11:43:27'),(8803,'risk','risk_management_edit','28',2,'Update','','2013-05-09 11:45:29'),(8804,'system','system_authorization_edit','2',2,'Login','','2013-05-10 15:15:23'),(8805,'security_services','security_services_audit_edit','15509',0,'Insert','','2013-05-10 15:15:24'),(8806,'security_services','security_services_audit_edit','15510',0,'Insert','','2013-05-10 15:15:24'),(8807,'security_services','security_services_audit_edit','15511',0,'Insert','','2013-05-10 15:15:24'),(8808,'security_services','security_services_audit_edit','15512',0,'Insert','','2013-05-10 15:15:24'),(8809,'security_services','security_services_audit_edit','15513',0,'Insert','','2013-05-10 15:15:24'),(8810,'security_services','security_services_audit_edit','15514',0,'Insert','','2013-05-10 15:15:24'),(8811,'security_services','security_services_audit_edit','15515',0,'Insert','','2013-05-10 15:15:24'),(8812,'security_services','security_services_audit_edit','15516',0,'Insert','','2013-05-10 15:15:24'),(8813,'security_services','security_services_audit_edit','15517',0,'Insert','','2013-05-10 15:15:24'),(8814,'security_services','security_services_audit_edit','15518',0,'Insert','','2013-05-10 15:15:24'),(8815,'security_services','security_services_audit_edit','15519',0,'Insert','','2013-05-10 15:15:24'),(8816,'security_services','security_services_audit_edit','15520',0,'Insert','','2013-05-10 15:15:24'),(8817,'security_services','security_services_audit_edit','15521',0,'Insert','','2013-05-10 15:15:24'),(8818,'security_services','security_services_audit_edit','15522',0,'Insert','','2013-05-10 15:15:24'),(8819,'security_services','security_services_audit_edit','15523',0,'Insert','','2013-05-10 15:15:24'),(8820,'security_services','security_services_audit_edit','15524',0,'Insert','','2013-05-10 15:15:24'),(8821,'security_services','security_services_audit_edit','15525',0,'Insert','','2013-05-10 15:15:24'),(8822,'security_services','security_services_audit_edit','15526',0,'Insert','','2013-05-10 15:15:24'),(8823,'security_services','security_services_audit_edit','15527',0,'Insert','','2013-05-10 15:15:24'),(8824,'security_services','security_services_audit_edit','15528',0,'Insert','','2013-05-10 15:15:24'),(8825,'security_services','security_services_audit_edit','15529',0,'Insert','','2013-05-10 15:15:24'),(8826,'security_services','security_services_audit_edit','15530',0,'Insert','','2013-05-10 15:15:24'),(8827,'security_services','security_services_audit_edit','15531',0,'Insert','','2013-05-10 15:15:24'),(8828,'security_services','security_services_audit_edit','15532',0,'Insert','','2013-05-10 15:15:24'),(8829,'security_services','security_services_audit_edit','15533',0,'Insert','','2013-05-10 15:15:24'),(8830,'security_services','security_services_audit_edit','15534',0,'Insert','','2013-05-10 15:15:24'),(8831,'security_services','security_services_audit_edit','15535',0,'Insert','','2013-05-10 15:15:24'),(8832,'security_services','security_services_audit_edit','15536',0,'Insert','','2013-05-10 15:15:24'),(8833,'security_services','security_services_audit_edit','15537',0,'Insert','','2013-05-10 15:15:24'),(8834,'security_services','security_services_audit_edit','15538',0,'Insert','','2013-05-10 15:15:24'),(8835,'security_services','security_services_audit_edit','15539',0,'Insert','','2013-05-10 15:15:24'),(8836,'security_services','security_services_audit_edit','15540',0,'Insert','','2013-05-10 15:15:24'),(8837,'security_services','security_services_audit_edit','15541',0,'Insert','','2013-05-10 15:15:24'),(8838,'security_services','security_services_audit_edit','15542',0,'Insert','','2013-05-10 15:15:24'),(8839,'security_services','security_services_audit_edit','15543',0,'Insert','','2013-05-10 15:15:24'),(8840,'security_services','security_services_audit_edit','15544',0,'Insert','','2013-05-10 15:15:24'),(8841,'security_services','security_services_audit_edit','15545',0,'Insert','','2013-05-10 15:15:24'),(8842,'security_services','security_services_audit_edit','15546',0,'Insert','','2013-05-10 15:15:24'),(8843,'security_services','security_services_audit_edit','15547',0,'Insert','','2013-05-10 15:15:24'),(8844,'security_services','security_services_audit_edit','15548',0,'Insert','','2013-05-10 15:15:24'),(8845,'security_services','security_services_audit_edit','15549',0,'Insert','','2013-05-10 15:15:24'),(8846,'security_services','security_services_audit_edit','15550',0,'Insert','','2013-05-10 15:15:24'),(8847,'security_services','security_services_audit_edit','15551',0,'Insert','','2013-05-10 15:15:24'),(8848,'security_services','security_services_audit_edit','15552',0,'Insert','','2013-05-10 15:15:24'),(8849,'security_services','security_services_audit_edit','15553',0,'Insert','','2013-05-10 15:15:24'),(8850,'security_services','security_services_audit_edit','15554',0,'Insert','','2013-05-10 15:15:24'),(8851,'security_services','security_services_audit_edit','15555',0,'Insert','','2013-05-10 15:15:24'),(8852,'security_services','security_services_audit_edit','15556',0,'Insert','','2013-05-10 15:15:24'),(8853,'security_services','security_services_audit_edit','15557',0,'Insert','','2013-05-10 15:15:24'),(8854,'security_services','security_services_audit_edit','15558',0,'Insert','','2013-05-10 15:15:24'),(8855,'security_services','security_services_audit_edit','15559',0,'Insert','','2013-05-10 15:15:24'),(8856,'security_services','security_services_audit_edit','15560',0,'Insert','','2013-05-10 15:15:24'),(8857,'security_services','security_services_audit_edit','15561',0,'Insert','','2013-05-10 15:15:24'),(8858,'security_services','security_services_audit_edit','15562',0,'Insert','','2013-05-10 15:15:24'),(8859,'security_services','security_services_audit_edit','15563',0,'Insert','','2013-05-10 15:15:24'),(8860,'security_services','security_services_audit_edit','15564',0,'Insert','','2013-05-10 15:15:24'),(8861,'security_services','security_services_audit_edit','15565',0,'Insert','','2013-05-10 15:15:24'),(8862,'security_services','security_services_audit_edit','15566',0,'Insert','','2013-05-10 15:15:24'),(8863,'security_services','security_services_audit_edit','15567',0,'Insert','','2013-05-10 15:15:24'),(8864,'security_services','security_services_audit_edit','15568',0,'Insert','','2013-05-10 15:15:24'),(8865,'security_services','security_services_audit_edit','15569',0,'Insert','','2013-05-10 15:15:24'),(8866,'security_services','security_services_audit_edit','15570',0,'Insert','','2013-05-10 15:15:24'),(8867,'security_services','security_services_audit_edit','15571',0,'Insert','','2013-05-10 15:15:24'),(8868,'security_services','security_services_audit_edit','15572',0,'Insert','','2013-05-10 15:15:24'),(8869,'security_services','security_services_audit_edit','15573',0,'Insert','','2013-05-10 15:15:24'),(8870,'security_services','security_services_audit_edit','15574',0,'Insert','','2013-05-10 15:15:24'),(8871,'security_services','security_services_audit_edit','15575',0,'Insert','','2013-05-10 15:15:24'),(8872,'security_services','security_services_audit_edit','15576',0,'Insert','','2013-05-10 15:15:24'),(8873,'security_services','security_services_audit_edit','15577',0,'Insert','','2013-05-10 15:15:24'),(8874,'security_services','security_services_audit_edit','15578',0,'Insert','','2013-05-10 15:15:24'),(8875,'security_services','security_services_audit_edit','15579',0,'Insert','','2013-05-10 15:15:24'),(8876,'security_services','security_services_audit_edit','15580',0,'Insert','','2013-05-10 15:15:24'),(8877,'security_services','security_services_audit_edit','15581',0,'Insert','','2013-05-10 15:15:24'),(8878,'security_services','security_services_audit_edit','15582',0,'Insert','','2013-05-10 15:15:24'),(8879,'security_services','security_services_audit_edit','15583',0,'Insert','','2013-05-10 15:15:24'),(8880,'asset','asset_edit','73',2,'Update','','2013-05-10 15:19:40'),(8881,'risk','risk_management_edit','29',2,'Update','','2013-05-10 15:21:56'),(8882,'asset','asset_edit','74',2,'Update','','2013-05-10 15:23:38'),(8883,'risk','risk_management_edit','30',2,'Update','','2013-05-10 15:25:13'),(8884,'asset','asset_edit','75',2,'Update','','2013-05-10 15:26:32'),(8885,'risk','risk_management_edit','31',2,'Update','','2013-05-10 15:27:44'),(8886,'asset','asset_edit','76',2,'Update','','2013-05-10 15:29:37'),(8887,'risk','risk_management_edit','32',2,'Update','','2013-05-10 15:32:07'),(8888,'risk','risk_management_edit','32',2,'Update','','2013-05-10 15:32:26'),(8889,'asset','asset_edit','77',2,'Update','','2013-05-10 15:35:15'),(8890,'risk','risk_management_edit','33',2,'Update','','2013-05-10 15:37:02'),(8891,'asset','asset_edit','78',2,'Update','','2013-05-10 15:38:20'),(8892,'risk','risk_management_edit','34',2,'Update','','2013-05-10 15:40:33'),(8893,'asset','asset_edit','79',2,'Update','','2013-05-10 15:41:52'),(8894,'risk','risk_management_edit','35',2,'Update','','2013-05-10 15:43:22'),(8895,'asset','asset_edit','80',2,'Update','','2013-05-10 15:45:02'),(8896,'risk','risk_management_edit','36',2,'Update','','2013-05-10 15:46:42'),(8897,'asset','asset_edit','81',2,'Update','','2013-05-10 15:48:40'),(8898,'risk','risk_management_edit','37',2,'Update','','2013-05-10 15:50:14'),(8899,'risk','risk_management_edit','37',2,'Update','','2013-05-10 15:50:31'),(8900,'system','system_authorization_edit','2',2,'Login','','2013-05-10 16:11:32'),(8901,'security_services','security_services_audit_edit','15584',0,'Insert','','2013-05-10 16:11:32'),(8902,'security_services','security_services_audit_edit','15585',0,'Insert','','2013-05-10 16:11:32'),(8903,'security_services','security_services_audit_edit','15586',0,'Insert','','2013-05-10 16:11:32'),(8904,'security_services','security_services_audit_edit','15587',0,'Insert','','2013-05-10 16:11:32'),(8905,'security_services','security_services_audit_edit','15588',0,'Insert','','2013-05-10 16:11:32'),(8906,'security_services','security_services_audit_edit','15589',0,'Insert','','2013-05-10 16:11:32'),(8907,'security_services','security_services_audit_edit','15590',0,'Insert','','2013-05-10 16:11:32'),(8908,'security_services','security_services_audit_edit','15591',0,'Insert','','2013-05-10 16:11:32'),(8909,'security_services','security_services_audit_edit','15592',0,'Insert','','2013-05-10 16:11:32'),(8910,'security_services','security_services_audit_edit','15593',0,'Insert','','2013-05-10 16:11:32'),(8911,'security_services','security_services_audit_edit','15594',0,'Insert','','2013-05-10 16:11:32'),(8912,'security_services','security_services_audit_edit','15595',0,'Insert','','2013-05-10 16:11:32'),(8913,'security_services','security_services_audit_edit','15596',0,'Insert','','2013-05-10 16:11:32'),(8914,'security_services','security_services_audit_edit','15597',0,'Insert','','2013-05-10 16:11:32'),(8915,'security_services','security_services_audit_edit','15598',0,'Insert','','2013-05-10 16:11:32'),(8916,'security_services','security_services_audit_edit','15599',0,'Insert','','2013-05-10 16:11:32'),(8917,'security_services','security_services_audit_edit','15600',0,'Insert','','2013-05-10 16:11:32'),(8918,'security_services','security_services_audit_edit','15601',0,'Insert','','2013-05-10 16:11:32'),(8919,'security_services','security_services_audit_edit','15602',0,'Insert','','2013-05-10 16:11:32'),(8920,'security_services','security_services_audit_edit','15603',0,'Insert','','2013-05-10 16:11:32'),(8921,'security_services','security_services_audit_edit','15604',0,'Insert','','2013-05-10 16:11:32'),(8922,'security_services','security_services_audit_edit','15605',0,'Insert','','2013-05-10 16:11:32'),(8923,'security_services','security_services_audit_edit','15606',0,'Insert','','2013-05-10 16:11:32'),(8924,'security_services','security_services_audit_edit','15607',0,'Insert','','2013-05-10 16:11:32'),(8925,'security_services','security_services_audit_edit','15608',0,'Insert','','2013-05-10 16:11:32'),(8926,'security_services','security_services_audit_edit','15609',0,'Insert','','2013-05-10 16:11:32'),(8927,'security_services','security_services_audit_edit','15610',0,'Insert','','2013-05-10 16:11:32'),(8928,'security_services','security_services_audit_edit','15611',0,'Insert','','2013-05-10 16:11:32'),(8929,'security_services','security_services_audit_edit','15612',0,'Insert','','2013-05-10 16:11:32'),(8930,'security_services','security_services_audit_edit','15613',0,'Insert','','2013-05-10 16:11:32'),(8931,'security_services','security_services_audit_edit','15614',0,'Insert','','2013-05-10 16:11:32'),(8932,'security_services','security_services_audit_edit','15615',0,'Insert','','2013-05-10 16:11:33'),(8933,'security_services','security_services_audit_edit','15616',0,'Insert','','2013-05-10 16:11:33'),(8934,'security_services','security_services_audit_edit','15617',0,'Insert','','2013-05-10 16:11:33'),(8935,'security_services','security_services_audit_edit','15618',0,'Insert','','2013-05-10 16:11:33'),(8936,'security_services','security_services_audit_edit','15619',0,'Insert','','2013-05-10 16:11:33'),(8937,'security_services','security_services_audit_edit','15620',0,'Insert','','2013-05-10 16:11:33'),(8938,'security_services','security_services_audit_edit','15621',0,'Insert','','2013-05-10 16:11:33'),(8939,'security_services','security_services_audit_edit','15622',0,'Insert','','2013-05-10 16:11:33'),(8940,'security_services','security_services_audit_edit','15623',0,'Insert','','2013-05-10 16:11:33'),(8941,'security_services','security_services_audit_edit','15624',0,'Insert','','2013-05-10 16:11:33'),(8942,'security_services','security_services_audit_edit','15625',0,'Insert','','2013-05-10 16:11:33'),(8943,'security_services','security_services_audit_edit','15626',0,'Insert','','2013-05-10 16:11:33'),(8944,'security_services','security_services_audit_edit','15627',0,'Insert','','2013-05-10 16:11:33'),(8945,'security_services','security_services_audit_edit','15628',0,'Insert','','2013-05-10 16:11:33'),(8946,'security_services','security_services_audit_edit','15629',0,'Insert','','2013-05-10 16:11:33'),(8947,'security_services','security_services_audit_edit','15630',0,'Insert','','2013-05-10 16:11:33'),(8948,'security_services','security_services_audit_edit','15631',0,'Insert','','2013-05-10 16:11:33'),(8949,'security_services','security_services_audit_edit','15632',0,'Insert','','2013-05-10 16:11:33'),(8950,'security_services','security_services_audit_edit','15633',0,'Insert','','2013-05-10 16:11:33'),(8951,'security_services','security_services_audit_edit','15634',0,'Insert','','2013-05-10 16:11:33'),(8952,'security_services','security_services_audit_edit','15635',0,'Insert','','2013-05-10 16:11:33'),(8953,'security_services','security_services_audit_edit','15636',0,'Insert','','2013-05-10 16:11:33'),(8954,'security_services','security_services_audit_edit','15637',0,'Insert','','2013-05-10 16:11:33'),(8955,'security_services','security_services_audit_edit','15638',0,'Insert','','2013-05-10 16:11:33'),(8956,'security_services','security_services_audit_edit','15639',0,'Insert','','2013-05-10 16:11:33'),(8957,'security_services','security_services_audit_edit','15640',0,'Insert','','2013-05-10 16:11:33'),(8958,'security_services','security_services_audit_edit','15641',0,'Insert','','2013-05-10 16:11:33'),(8959,'security_services','security_services_audit_edit','15642',0,'Insert','','2013-05-10 16:11:33'),(8960,'security_services','security_services_audit_edit','15643',0,'Insert','','2013-05-10 16:11:33'),(8961,'security_services','security_services_audit_edit','15644',0,'Insert','','2013-05-10 16:11:33'),(8962,'security_services','security_services_audit_edit','15645',0,'Insert','','2013-05-10 16:11:33'),(8963,'security_services','security_services_audit_edit','15646',0,'Insert','','2013-05-10 16:11:33'),(8964,'security_services','security_services_audit_edit','15647',0,'Insert','','2013-05-10 16:11:33'),(8965,'security_services','security_services_audit_edit','15648',0,'Insert','','2013-05-10 16:11:33'),(8966,'security_services','security_services_audit_edit','15649',0,'Insert','','2013-05-10 16:11:33'),(8967,'security_services','security_services_audit_edit','15650',0,'Insert','','2013-05-10 16:11:33'),(8968,'security_services','security_services_audit_edit','15651',0,'Insert','','2013-05-10 16:11:33'),(8969,'security_services','security_services_audit_edit','15652',0,'Insert','','2013-05-10 16:11:33'),(8970,'security_services','security_services_audit_edit','15653',0,'Insert','','2013-05-10 16:11:33'),(8971,'security_services','security_services_audit_edit','15654',0,'Insert','','2013-05-10 16:11:33'),(8972,'security_services','security_services_audit_edit','15655',0,'Insert','','2013-05-10 16:11:33'),(8973,'security_services','security_services_audit_edit','15656',0,'Insert','','2013-05-10 16:11:33'),(8974,'security_services','security_services_audit_edit','15657',0,'Insert','','2013-05-10 16:11:33'),(8975,'security_services','security_services_audit_edit','15658',0,'Insert','','2013-05-10 16:11:33'),(8976,'asset','asset_edit','82',2,'Update','','2013-05-10 16:12:40'),(8977,'risk','risk_management_edit','38',2,'Update','','2013-05-10 16:15:50'),(8978,'asset','asset_edit','83',2,'Update','','2013-05-10 16:17:07'),(8979,'risk','risk_management_edit','39',2,'Update','','2013-05-10 16:17:54'),(8980,'risk','risk_management_edit','39',2,'Update','','2013-05-10 16:19:37'),(8981,'risk','risk_management_edit','38',2,'Update','','2013-05-10 16:19:52'),(8982,'asset','asset_edit','84',2,'Update','','2013-05-10 16:21:17'),(8983,'risk','risk_management_edit','40',2,'Update','','2013-05-10 16:22:05'),(8984,'risk','risk_management_edit','40',2,'Update','','2013-05-10 16:22:55'),(8985,'asset','asset_edit','85',2,'Update','','2013-05-10 16:24:17'),(8986,'risk','risk_management_edit','41',2,'Update','','2013-05-10 16:25:44'),(8987,'asset','asset_edit','86',2,'Update','','2013-05-10 16:27:16'),(8988,'risk','risk_management_edit','42',2,'Update','','2013-05-10 16:29:15'),(8989,'asset','asset_edit','87',2,'Update','','2013-05-10 16:31:40'),(8990,'risk','risk_management_edit','43',2,'Update','','2013-05-10 16:34:59'),(8991,'asset','asset_edit','88',2,'Update','','2013-05-10 16:40:05'),(8992,'risk','risk_management_edit','44',2,'Update','','2013-05-10 16:41:26'),(8993,'asset','asset_edit','89',2,'Update','','2013-05-10 16:42:44'),(8994,'risk','risk_management_edit','45',2,'Update','','2013-05-10 16:44:41'),(8995,'asset','asset_edit','90',2,'Update','','2013-05-10 16:45:52'),(8996,'risk','risk_management_edit','46',2,'Update','','2013-05-10 16:48:23'),(8997,'asset','asset_edit','91',2,'Update','','2013-05-10 16:51:56'),(8998,'risk','risk_management_edit','47',2,'Update','','2013-05-10 16:53:23'),(8999,'asset','asset_edit','92',2,'Update','','2013-05-10 16:54:54'),(9000,'risk','risk_management_edit','48',2,'Update','','2013-05-10 16:56:37'),(9001,'asset','asset_edit','93',2,'Update','','2013-05-10 16:58:09'),(9002,'risk','risk_management_edit','49',2,'Update','','2013-05-10 16:59:49'),(9003,'asset','asset_edit','94',2,'Update','','2013-05-10 17:01:07'),(9004,'risk','risk_management_edit','50',2,'Update','','2013-05-10 17:04:30'),(9005,'asset','asset_edit','95',2,'Update','','2013-05-10 17:06:20'),(9006,'risk','risk_management_edit','51',2,'Update','','2013-05-10 17:07:58'),(9007,'asset','asset_edit','96',2,'Update','','2013-05-10 17:09:29'),(9008,'risk','risk_management_edit','52',2,'Update','','2013-05-10 17:18:43'),(9009,'asset','asset_edit','97',2,'Update','','2013-05-10 17:20:32'),(9010,'risk','risk_management_edit','53',2,'Update','','2013-05-10 17:22:13'),(9011,'asset','asset_edit','98',2,'Update','','2013-05-10 17:23:22'),(9012,'risk','risk_management_edit','54',2,'Update','','2013-05-10 17:24:57'),(9013,'system','system_authorization_edit','2',2,'Login','','2013-05-10 17:35:18'),(9014,'security_services','security_services_audit_edit','15659',0,'Insert','','2013-05-10 17:35:18'),(9015,'security_services','security_services_audit_edit','15660',0,'Insert','','2013-05-10 17:35:18'),(9016,'security_services','security_services_audit_edit','15661',0,'Insert','','2013-05-10 17:35:18'),(9017,'security_services','security_services_audit_edit','15662',0,'Insert','','2013-05-10 17:35:18'),(9018,'security_services','security_services_audit_edit','15663',0,'Insert','','2013-05-10 17:35:18'),(9019,'security_services','security_services_audit_edit','15664',0,'Insert','','2013-05-10 17:35:18'),(9020,'security_services','security_services_audit_edit','15665',0,'Insert','','2013-05-10 17:35:18'),(9021,'security_services','security_services_audit_edit','15666',0,'Insert','','2013-05-10 17:35:18'),(9022,'security_services','security_services_audit_edit','15667',0,'Insert','','2013-05-10 17:35:18'),(9023,'security_services','security_services_audit_edit','15668',0,'Insert','','2013-05-10 17:35:18'),(9024,'security_services','security_services_audit_edit','15669',0,'Insert','','2013-05-10 17:35:18'),(9025,'security_services','security_services_audit_edit','15670',0,'Insert','','2013-05-10 17:35:18'),(9026,'security_services','security_services_audit_edit','15671',0,'Insert','','2013-05-10 17:35:18'),(9027,'security_services','security_services_audit_edit','15672',0,'Insert','','2013-05-10 17:35:18'),(9028,'security_services','security_services_audit_edit','15673',0,'Insert','','2013-05-10 17:35:18'),(9029,'security_services','security_services_audit_edit','15674',0,'Insert','','2013-05-10 17:35:18'),(9030,'security_services','security_services_audit_edit','15675',0,'Insert','','2013-05-10 17:35:18'),(9031,'security_services','security_services_audit_edit','15676',0,'Insert','','2013-05-10 17:35:18'),(9032,'security_services','security_services_audit_edit','15677',0,'Insert','','2013-05-10 17:35:18'),(9033,'security_services','security_services_audit_edit','15678',0,'Insert','','2013-05-10 17:35:18'),(9034,'security_services','security_services_audit_edit','15679',0,'Insert','','2013-05-10 17:35:18'),(9035,'security_services','security_services_audit_edit','15680',0,'Insert','','2013-05-10 17:35:18'),(9036,'security_services','security_services_audit_edit','15681',0,'Insert','','2013-05-10 17:35:18'),(9037,'security_services','security_services_audit_edit','15682',0,'Insert','','2013-05-10 17:35:18'),(9038,'security_services','security_services_audit_edit','15683',0,'Insert','','2013-05-10 17:35:18'),(9039,'security_services','security_services_audit_edit','15684',0,'Insert','','2013-05-10 17:35:18'),(9040,'security_services','security_services_audit_edit','15685',0,'Insert','','2013-05-10 17:35:18'),(9041,'security_services','security_services_audit_edit','15686',0,'Insert','','2013-05-10 17:35:18'),(9042,'security_services','security_services_audit_edit','15687',0,'Insert','','2013-05-10 17:35:18'),(9043,'security_services','security_services_audit_edit','15688',0,'Insert','','2013-05-10 17:35:18'),(9044,'security_services','security_services_audit_edit','15689',0,'Insert','','2013-05-10 17:35:18'),(9045,'security_services','security_services_audit_edit','15690',0,'Insert','','2013-05-10 17:35:18'),(9046,'security_services','security_services_audit_edit','15691',0,'Insert','','2013-05-10 17:35:18'),(9047,'security_services','security_services_audit_edit','15692',0,'Insert','','2013-05-10 17:35:18'),(9048,'security_services','security_services_audit_edit','15693',0,'Insert','','2013-05-10 17:35:18'),(9049,'security_services','security_services_audit_edit','15694',0,'Insert','','2013-05-10 17:35:18'),(9050,'security_services','security_services_audit_edit','15695',0,'Insert','','2013-05-10 17:35:18'),(9051,'security_services','security_services_audit_edit','15696',0,'Insert','','2013-05-10 17:35:18'),(9052,'security_services','security_services_audit_edit','15697',0,'Insert','','2013-05-10 17:35:18'),(9053,'security_services','security_services_audit_edit','15698',0,'Insert','','2013-05-10 17:35:18'),(9054,'security_services','security_services_audit_edit','15699',0,'Insert','','2013-05-10 17:35:18'),(9055,'security_services','security_services_audit_edit','15700',0,'Insert','','2013-05-10 17:35:18'),(9056,'security_services','security_services_audit_edit','15701',0,'Insert','','2013-05-10 17:35:18'),(9057,'security_services','security_services_audit_edit','15702',0,'Insert','','2013-05-10 17:35:18'),(9058,'security_services','security_services_audit_edit','15703',0,'Insert','','2013-05-10 17:35:18'),(9059,'security_services','security_services_audit_edit','15704',0,'Insert','','2013-05-10 17:35:18'),(9060,'security_services','security_services_audit_edit','15705',0,'Insert','','2013-05-10 17:35:18'),(9061,'security_services','security_services_audit_edit','15706',0,'Insert','','2013-05-10 17:35:18'),(9062,'security_services','security_services_audit_edit','15707',0,'Insert','','2013-05-10 17:35:18'),(9063,'security_services','security_services_audit_edit','15708',0,'Insert','','2013-05-10 17:35:18'),(9064,'security_services','security_services_audit_edit','15709',0,'Insert','','2013-05-10 17:35:18'),(9065,'security_services','security_services_audit_edit','15710',0,'Insert','','2013-05-10 17:35:18'),(9066,'security_services','security_services_audit_edit','15711',0,'Insert','','2013-05-10 17:35:18'),(9067,'security_services','security_services_audit_edit','15712',0,'Insert','','2013-05-10 17:35:18'),(9068,'security_services','security_services_audit_edit','15713',0,'Insert','','2013-05-10 17:35:18'),(9069,'security_services','security_services_audit_edit','15714',0,'Insert','','2013-05-10 17:35:18'),(9070,'security_services','security_services_audit_edit','15715',0,'Insert','','2013-05-10 17:35:18'),(9071,'security_services','security_services_audit_edit','15716',0,'Insert','','2013-05-10 17:35:18'),(9072,'security_services','security_services_audit_edit','15717',0,'Insert','','2013-05-10 17:35:18'),(9073,'security_services','security_services_audit_edit','15718',0,'Insert','','2013-05-10 17:35:18'),(9074,'security_services','security_services_audit_edit','15719',0,'Insert','','2013-05-10 17:35:18'),(9075,'security_services','security_services_audit_edit','15720',0,'Insert','','2013-05-10 17:35:18'),(9076,'security_services','security_services_audit_edit','15721',0,'Insert','','2013-05-10 17:35:18'),(9077,'security_services','security_services_audit_edit','15722',0,'Insert','','2013-05-10 17:35:18'),(9078,'security_services','security_services_audit_edit','15723',0,'Insert','','2013-05-10 17:35:18'),(9079,'security_services','security_services_audit_edit','15724',0,'Insert','','2013-05-10 17:35:18'),(9080,'security_services','security_services_audit_edit','15725',0,'Insert','','2013-05-10 17:35:18'),(9081,'security_services','security_services_audit_edit','15726',0,'Insert','','2013-05-10 17:35:18'),(9082,'security_services','security_services_audit_edit','15727',0,'Insert','','2013-05-10 17:35:18'),(9083,'security_services','security_services_audit_edit','15728',0,'Insert','','2013-05-10 17:35:18'),(9084,'security_services','security_services_audit_edit','15729',0,'Insert','','2013-05-10 17:35:18'),(9085,'security_services','security_services_audit_edit','15730',0,'Insert','','2013-05-10 17:35:18'),(9086,'security_services','security_services_audit_edit','15731',0,'Insert','','2013-05-10 17:35:18'),(9087,'security_services','security_services_audit_edit','15732',0,'Insert','','2013-05-10 17:35:18'),(9088,'security_services','security_services_audit_edit','15733',0,'Insert','','2013-05-10 17:35:18'),(9089,'security_services','security_catalogue_edit','557',2,'Update','','2013-05-10 17:40:22'),(9090,'security_services','security_services_audit_edit','15734',0,'Insert','','2013-05-10 17:40:22'),(9091,'security_services','security_services_audit_edit','15735',0,'Insert','','2013-05-10 17:40:22'),(9092,'security_services','security_catalogue_edit','558',2,'Update','','2013-05-10 17:40:54'),(9093,'security_services','security_services_audit_edit','15736',0,'Insert','','2013-05-10 17:40:54'),(9094,'security_services','security_services_audit_edit','15737',0,'Insert','','2013-05-10 17:40:54'),(9095,'security_services','security_catalogue_edit','559',2,'Update','','2013-05-10 17:41:19'),(9096,'security_services','security_services_audit_edit','15738',0,'Insert','','2013-05-10 17:41:19'),(9097,'security_services','security_services_audit_edit','15739',0,'Insert','','2013-05-10 17:41:19'),(9098,'security_services','security_catalogue_edit','560',2,'Update','','2013-05-10 17:42:29'),(9099,'security_services','security_services_audit_edit','15740',0,'Insert','','2013-05-10 17:42:29'),(9100,'security_services','security_catalogue_edit','561',2,'Update','','2013-05-10 17:42:44'),(9101,'security_services','security_services_audit_edit','15741',0,'Insert','','2013-05-10 17:42:44'),(9102,'security_services','security_catalogue_edit','561',2,'Update','','2013-05-10 17:42:53'),(9103,'security_services','security_catalogue_edit','562',2,'Update','','2013-05-10 17:43:07'),(9104,'security_services','security_services_audit_edit','15742',0,'Insert','','2013-05-10 17:43:07'),(9105,'security_services','security_catalogue_edit','563',2,'Update','','2013-05-10 17:44:01'),(9106,'security_services','security_services_audit_edit','15743',0,'Insert','','2013-05-10 17:44:01'),(9107,'security_services','security_catalogue_edit','564',2,'Update','','2013-05-10 17:44:16'),(9108,'security_services','security_services_audit_edit','15744',0,'Insert','','2013-05-10 17:44:16'),(9109,'security_services','security_catalogue_edit','565',2,'Update','','2013-05-10 17:44:41'),(9110,'security_services','security_services_audit_edit','15745',0,'Insert','','2013-05-10 17:44:41'),(9111,'security_services','security_catalogue_edit','567',2,'Update','','2013-05-10 17:45:02'),(9112,'security_services','security_services_audit_edit','15746',0,'Insert','','2013-05-10 17:45:02'),(9113,'security_services','security_catalogue_edit','568',2,'Update','','2013-05-10 17:45:16'),(9114,'security_services','security_services_audit_edit','15747',0,'Insert','','2013-05-10 17:45:16'),(9115,'security_services','security_catalogue_edit','569',2,'Update','','2013-05-10 17:45:32'),(9116,'security_services','security_services_audit_edit','15748',0,'Insert','','2013-05-10 17:45:32'),(9117,'security_services','security_catalogue_edit','570',2,'Update','','2013-05-10 17:46:04'),(9118,'security_services','security_services_audit_edit','15749',0,'Insert','','2013-05-10 17:46:04'),(9119,'security_services','security_services_audit_edit','15750',0,'Insert','','2013-05-10 17:46:04'),(9120,'security_services','security_catalogue_edit','562',2,'Update','','2013-05-10 17:46:22'),(9121,'security_services','security_services_audit_edit','15751',0,'Insert','','2013-05-10 17:46:22'),(9122,'security_services','security_catalogue_edit','562',2,'Update','','2013-05-10 17:46:55'),(9123,'security_services','security_catalogue_edit','564',2,'Update','','2013-05-10 17:47:21'),(9124,'security_services','security_services_audit_edit','15752',0,'Insert','','2013-05-10 17:47:22'),(9125,'security_services','security_catalogue_edit','563',2,'Update','','2013-05-10 17:47:34'),(9126,'security_services','security_services_audit_edit','15753',0,'Insert','','2013-05-10 17:47:34'),(9127,'security_services','security_catalogue_edit','560',2,'Update','','2013-05-10 17:47:54'),(9128,'security_services','security_catalogue_edit','562',2,'Update','','2013-05-10 17:48:07'),(9129,'security_services','security_catalogue_edit','564',2,'Update','','2013-05-10 17:48:29'),(9130,'security_services','security_catalogue_edit','565',2,'Update','','2013-05-10 17:48:43'),(9131,'security_services','security_services_audit_edit','15754',0,'Insert','','2013-05-10 17:48:43'),(9132,'security_services','security_catalogue_edit','570',2,'Update','','2013-05-10 17:49:02'),(9133,'security_services','security_catalogue_edit','571',2,'Update','','2013-05-10 17:49:37'),(9134,'security_services','security_services_audit_edit','15755',0,'Insert','','2013-05-10 17:49:37'),(9135,'security_services','security_catalogue_edit','572',2,'Update','','2013-05-10 17:49:47'),(9136,'security_services','security_services_audit_edit','15756',0,'Insert','','2013-05-10 17:49:47'),(9137,'security_services','security_catalogue_edit','573',2,'Update','','2013-05-10 17:50:05'),(9138,'security_services','security_services_audit_edit','15757',0,'Insert','','2013-05-10 17:50:05'),(9139,'security_services','security_services_audit_edit','15758',0,'Insert','','2013-05-10 17:50:05'),(9140,'security_services','security_catalogue_edit','575',2,'Update','','2013-05-10 17:50:37'),(9141,'security_services','security_services_audit_edit','15759',0,'Insert','','2013-05-10 17:50:37'),(9142,'security_services','security_catalogue_edit','576',2,'Update','','2013-05-10 17:50:50'),(9143,'security_services','security_services_audit_edit','15760',0,'Insert','','2013-05-10 17:50:50'),(9144,'security_services','security_catalogue_edit','576',2,'Update','','2013-05-10 17:51:05'),(9145,'security_services','security_catalogue_edit','577',2,'Update','','2013-05-10 17:51:15'),(9146,'security_services','security_services_audit_edit','15761',0,'Insert','','2013-05-10 17:51:15'),(9147,'security_services','security_catalogue_edit','578',2,'Update','','2013-05-10 17:51:26'),(9148,'security_services','security_services_audit_edit','15762',0,'Insert','','2013-05-10 17:51:26'),(9149,'security_services','security_catalogue_edit','579',2,'Update','','2013-05-10 17:51:41'),(9150,'security_services','security_services_audit_edit','15763',0,'Insert','','2013-05-10 17:51:41'),(9151,'security_services','security_catalogue_edit','582',2,'Update','','2013-05-10 17:53:41'),(9152,'security_services','security_services_audit_edit','15764',0,'Insert','','2013-05-10 17:53:41'),(9153,'security_services','security_catalogue_edit','583',2,'Update','','2013-05-10 17:53:52'),(9154,'security_services','security_services_audit_edit','15765',0,'Insert','','2013-05-10 17:53:52'),(9155,'security_services','security_catalogue_edit','584',2,'Update','','2013-05-10 17:54:01'),(9156,'security_services','security_services_maintenance_edit','14862',0,'Insert','','2013-05-10 17:54:01'),(9157,'security_services','security_catalogue_edit','584',2,'Update','','2013-05-10 17:54:20'),(9158,'security_services','security_services_audit_edit','15766',0,'Insert','','2013-05-10 17:54:20'),(9159,'security_services','security_services_maintenance_edit','14863',0,'Insert','','2013-05-10 17:54:20'),(9160,'security_services','security_catalogue_edit','584',2,'Update','','2013-05-10 17:54:55'),(9161,'security_services','security_services_maintenance_edit','14864',0,'Insert','','2013-05-10 17:54:55'),(9162,'security_services','security_catalogue_edit','585',2,'Update','','2013-05-10 17:55:25'),(9163,'security_services','security_services_audit_edit','15767',0,'Insert','','2013-05-10 17:55:25'),(9164,'security_services','security_catalogue_edit','587',2,'Update','','2013-05-10 17:55:41'),(9165,'security_services','security_services_audit_edit','15768',0,'Insert','','2013-05-10 17:55:41'),(9166,'security_services','security_catalogue_edit','588',2,'Update','','2013-05-10 17:55:57'),(9167,'security_services','security_services_audit_edit','15769',0,'Insert','','2013-05-10 17:55:57'),(9168,'security_services','security_catalogue_edit','589',2,'Update','','2013-05-10 17:56:14'),(9169,'security_services','security_services_audit_edit','15770',0,'Insert','','2013-05-10 17:56:14'),(9170,'security_services','security_catalogue_edit','590',2,'Update','','2013-05-10 17:56:45'),(9171,'security_services','security_services_audit_edit','15771',0,'Insert','','2013-05-10 17:56:45'),(9172,'security_services','security_services_audit_edit','15772',0,'Insert','','2013-05-10 17:56:45'),(9173,'security_services','security_catalogue_edit','591',2,'Update','','2013-05-10 17:57:09'),(9174,'security_services','security_services_audit_edit','15773',0,'Insert','','2013-05-10 17:57:09'),(9175,'security_services','security_services_audit_edit','15774',0,'Insert','','2013-05-10 17:57:09'),(9176,'security_services','security_catalogue_edit','592',2,'Update','','2013-05-10 17:57:25'),(9177,'security_services','security_services_audit_edit','15775',0,'Insert','','2013-05-10 17:57:25'),(9178,'security_services','security_services_audit_edit','15776',0,'Insert','','2013-05-10 17:57:25'),(9179,'security_services','security_catalogue_edit','593',2,'Update','','2013-05-10 17:57:39'),(9180,'security_services','security_services_audit_edit','15777',0,'Insert','','2013-05-10 17:57:39'),(9181,'security_services','security_services_audit_edit','15778',0,'Insert','','2013-05-10 17:57:39'),(9182,'security_services','security_catalogue_edit','594',2,'Update','','2013-05-10 17:58:03'),(9183,'security_services','security_services_audit_edit','15779',0,'Insert','','2013-05-10 17:58:03'),(9184,'security_services','security_services_audit_edit','15780',0,'Insert','','2013-05-10 17:58:03'),(9185,'security_services','security_catalogue_edit','595',2,'Update','','2013-05-10 17:58:15'),(9186,'security_services','security_services_maintenance_edit','14865',0,'Insert','','2013-05-10 17:58:15'),(9187,'security_services','security_services_maintenance_edit','14866',0,'Insert','','2013-05-10 17:58:16'),(9188,'security_services','security_catalogue_edit','596',2,'Update','','2013-05-10 17:58:38'),(9189,'security_services','security_services_audit_edit','15781',0,'Insert','','2013-05-10 17:58:38'),(9190,'security_services','security_catalogue_edit','597',2,'Update','','2013-05-10 17:58:49'),(9191,'security_services','security_services_audit_edit','15782',0,'Insert','','2013-05-10 17:58:49'),(9192,'security_services','security_catalogue_edit','598',2,'Update','','2013-05-10 17:59:06'),(9193,'security_services','security_services_audit_edit','15783',0,'Insert','','2013-05-10 17:59:06'),(9194,'security_services','security_services_maintenance_edit','14867',0,'Insert','','2013-05-10 17:59:06'),(9195,'security_services','security_catalogue_edit','597',2,'Update','','2013-05-10 17:59:15'),(9196,'security_services','security_catalogue_edit','599',2,'Update','','2013-05-10 17:59:44'),(9197,'security_services','security_services_audit_edit','15784',0,'Insert','','2013-05-10 17:59:44'),(9198,'security_services','security_services_audit_edit','15785',0,'Insert','','2013-05-10 17:59:44'),(9199,'security_services','security_catalogue_edit','600',2,'Update','','2013-05-10 18:00:04'),(9200,'security_services','security_services_audit_edit','15786',0,'Insert','','2013-05-10 18:00:04'),(9201,'security_services','security_services_audit_edit','15787',0,'Insert','','2013-05-10 18:00:04'),(9202,'security_services','security_catalogue_edit','601',2,'Update','','2013-05-10 18:00:23'),(9203,'security_services','security_services_audit_edit','15788',0,'Insert','','2013-05-10 18:00:23'),(9204,'security_services','security_catalogue_edit','602',2,'Update','','2013-05-10 18:00:41'),(9205,'security_services','security_services_audit_edit','15789',0,'Insert','','2013-05-10 18:00:41'),(9206,'security_services','security_catalogue_edit','603',2,'Update','','2013-05-10 18:00:55'),(9207,'security_services','security_services_audit_edit','15790',0,'Insert','','2013-05-10 18:00:55'),(9208,'security_services','security_catalogue_edit','604',2,'Update','','2013-05-10 18:01:14'),(9209,'security_services','security_services_audit_edit','15791',0,'Insert','','2013-05-10 18:01:14'),(9210,'security_services','security_catalogue_edit','605',2,'Update','','2013-05-10 18:01:32'),(9211,'security_services','security_services_audit_edit','15792',0,'Insert','','2013-05-10 18:01:32'),(9212,'security_services','security_catalogue_edit','606',2,'Update','','2013-05-10 18:01:46'),(9213,'security_services','security_services_audit_edit','15793',0,'Insert','','2013-05-10 18:01:46'),(9214,'security_services','security_catalogue_edit','607',2,'Update','','2013-05-10 18:02:05'),(9215,'security_services','security_services_audit_edit','15794',0,'Insert','','2013-05-10 18:02:05'),(9216,'security_services','security_catalogue_edit','608',2,'Update','','2013-05-10 18:02:46'),(9217,'security_services','security_services_audit_edit','15795',0,'Insert','','2013-05-10 18:02:46'),(9218,'security_services','security_catalogue_edit','609',2,'Update','','2013-05-10 18:02:58'),(9219,'security_services','security_services_maintenance_edit','14868',0,'Insert','','2013-05-10 18:02:58'),(9220,'security_services','security_catalogue_edit','610',2,'Update','','2013-05-10 18:03:10'),(9221,'security_services','security_services_maintenance_edit','14869',0,'Insert','','2013-05-10 18:03:10'),(9222,'security_services','security_catalogue_edit','613',2,'Update','','2013-05-10 18:03:33'),(9223,'security_services','security_services_audit_edit','15796',0,'Insert','','2013-05-10 18:03:33'),(9224,'security_services','security_catalogue_edit','614',2,'Update','','2013-05-10 18:03:46'),(9225,'security_services','security_services_audit_edit','15797',0,'Insert','','2013-05-10 18:03:46'),(9226,'security_services','security_catalogue_edit','616',2,'Update','','2013-05-10 18:04:16'),(9227,'security_services','security_services_audit_edit','15798',0,'Insert','','2013-05-10 18:04:16'),(9228,'security_services','security_catalogue_edit','617',2,'Update','','2013-05-10 18:04:27'),(9229,'security_services','security_services_audit_edit','15799',0,'Insert','','2013-05-10 18:04:27'),(9230,'security_services','security_catalogue_edit','618',2,'Update','','2013-05-10 18:04:40'),(9231,'security_services','security_services_audit_edit','15800',0,'Insert','','2013-05-10 18:04:40'),(9232,'security_services','security_catalogue_edit','619',2,'Update','','2013-05-10 18:04:56'),(9233,'security_services','security_services_audit_edit','15801',0,'Insert','','2013-05-10 18:04:56'),(9234,'security_services','security_catalogue_edit','620',2,'Update','','2013-05-10 18:05:15'),(9235,'security_services','security_services_audit_edit','15802',0,'Insert','','2013-05-10 18:05:15'),(9236,'security_services','security_catalogue_edit','621',2,'Update','','2013-05-10 18:05:31'),(9237,'security_services','security_services_audit_edit','15803',0,'Insert','','2013-05-10 18:05:31'),(9238,'security_services','security_catalogue_edit','622',2,'Update','','2013-05-10 18:06:08'),(9239,'security_services','security_services_audit_edit','15804',0,'Insert','','2013-05-10 18:06:09'),(9240,'security_services','security_services_audit_edit','15805',0,'Insert','','2013-05-10 18:06:09'),(9241,'security_services','security_catalogue_edit','623',2,'Update','','2013-05-10 18:06:34'),(9242,'security_services','security_services_audit_edit','15806',0,'Insert','','2013-05-10 18:06:34'),(9243,'security_services','security_catalogue_edit','624',2,'Update','','2013-05-10 18:06:48'),(9244,'security_services','security_services_audit_edit','15807',0,'Insert','','2013-05-10 18:06:48'),(9245,'security_services','security_catalogue_edit','625',2,'Update','','2013-05-10 18:07:11'),(9246,'security_services','security_services_audit_edit','15808',0,'Insert','','2013-05-10 18:07:11'),(9247,'security_services','security_services_audit_edit','15809',0,'Insert','','2013-05-10 18:07:11'),(9248,'security_services','security_catalogue_edit','626',2,'Update','','2013-05-10 18:07:31'),(9249,'security_services','security_services_audit_edit','15810',0,'Insert','','2013-05-10 18:07:31'),(9250,'security_services','security_catalogue_edit','628',2,'Update','','2013-05-10 18:07:53'),(9251,'security_services','security_services_audit_edit','15811',0,'Insert','','2013-05-10 18:07:53'),(9252,'security_services','security_services_audit_edit','15812',0,'Insert','','2013-05-10 18:07:53'),(9253,'security_services','security_catalogue_edit','629',2,'Update','','2013-05-10 18:08:09'),(9254,'security_services','security_services_audit_edit','15813',0,'Insert','','2013-05-10 18:08:09'),(9255,'system','system_authorization','',0,'Wrong Login','','2013-05-13 19:23:10'),(9256,'system','system_authorization','',0,'Wrong Login','','2013-05-13 19:23:13'),(9257,'system','system_authorization','',0,'Wrong Login','','2013-05-13 19:23:18'),(9258,'system','system_authorization_edit','2',2,'Login','','2013-05-13 19:23:22'),(9259,'security_services','security_services_audit_edit','15814',0,'Insert','','2013-05-13 19:23:22'),(9260,'security_services','security_services_audit_edit','15815',0,'Insert','','2013-05-13 19:23:22'),(9261,'security_services','security_services_audit_edit','15816',0,'Insert','','2013-05-13 19:23:22'),(9262,'security_services','security_services_audit_edit','15817',0,'Insert','','2013-05-13 19:23:22'),(9263,'security_services','security_services_audit_edit','15818',0,'Insert','','2013-05-13 19:23:22'),(9264,'security_services','security_services_audit_edit','15819',0,'Insert','','2013-05-13 19:23:22'),(9265,'security_services','security_services_audit_edit','15820',0,'Insert','','2013-05-13 19:23:22'),(9266,'security_services','security_services_audit_edit','15821',0,'Insert','','2013-05-13 19:23:22'),(9267,'security_services','security_services_audit_edit','15822',0,'Insert','','2013-05-13 19:23:22'),(9268,'security_services','security_services_audit_edit','15823',0,'Insert','','2013-05-13 19:23:22'),(9269,'security_services','security_services_audit_edit','15824',0,'Insert','','2013-05-13 19:23:22'),(9270,'security_services','security_services_audit_edit','15825',0,'Insert','','2013-05-13 19:23:22'),(9271,'security_services','security_services_audit_edit','15826',0,'Insert','','2013-05-13 19:23:22'),(9272,'security_services','security_services_audit_edit','15827',0,'Insert','','2013-05-13 19:23:22'),(9273,'security_services','security_services_audit_edit','15828',0,'Insert','','2013-05-13 19:23:22'),(9274,'security_services','security_services_audit_edit','15829',0,'Insert','','2013-05-13 19:23:22'),(9275,'security_services','security_services_audit_edit','15830',0,'Insert','','2013-05-13 19:23:22'),(9276,'security_services','security_services_audit_edit','15831',0,'Insert','','2013-05-13 19:23:22'),(9277,'security_services','security_services_audit_edit','15832',0,'Insert','','2013-05-13 19:23:22'),(9278,'security_services','security_services_audit_edit','15833',0,'Insert','','2013-05-13 19:23:22'),(9279,'security_services','security_services_audit_edit','15834',0,'Insert','','2013-05-13 19:23:22'),(9280,'security_services','security_services_audit_edit','15835',0,'Insert','','2013-05-13 19:23:22'),(9281,'security_services','security_services_audit_edit','15836',0,'Insert','','2013-05-13 19:23:22'),(9282,'security_services','security_services_audit_edit','15837',0,'Insert','','2013-05-13 19:23:22'),(9283,'security_services','security_services_audit_edit','15838',0,'Insert','','2013-05-13 19:23:22'),(9284,'security_services','security_services_audit_edit','15839',0,'Insert','','2013-05-13 19:23:22'),(9285,'security_services','security_services_audit_edit','15840',0,'Insert','','2013-05-13 19:23:22'),(9286,'security_services','security_services_audit_edit','15841',0,'Insert','','2013-05-13 19:23:22'),(9287,'security_services','security_services_audit_edit','15842',0,'Insert','','2013-05-13 19:23:22'),(9288,'security_services','security_services_audit_edit','15843',0,'Insert','','2013-05-13 19:23:22'),(9289,'security_services','security_services_audit_edit','15844',0,'Insert','','2013-05-13 19:23:22'),(9290,'security_services','security_services_audit_edit','15845',0,'Insert','','2013-05-13 19:23:22'),(9291,'security_services','security_services_audit_edit','15846',0,'Insert','','2013-05-13 19:23:22'),(9292,'security_services','security_services_audit_edit','15847',0,'Insert','','2013-05-13 19:23:22'),(9293,'security_services','security_services_audit_edit','15848',0,'Insert','','2013-05-13 19:23:22'),(9294,'security_services','security_services_audit_edit','15849',0,'Insert','','2013-05-13 19:23:22'),(9295,'security_services','security_services_audit_edit','15850',0,'Insert','','2013-05-13 19:23:22'),(9296,'security_services','security_services_audit_edit','15851',0,'Insert','','2013-05-13 19:23:22'),(9297,'security_services','security_services_audit_edit','15852',0,'Insert','','2013-05-13 19:23:22'),(9298,'security_services','security_services_audit_edit','15853',0,'Insert','','2013-05-13 19:23:22'),(9299,'security_services','security_services_audit_edit','15854',0,'Insert','','2013-05-13 19:23:22'),(9300,'security_services','security_services_audit_edit','15855',0,'Insert','','2013-05-13 19:23:22'),(9301,'security_services','security_services_audit_edit','15856',0,'Insert','','2013-05-13 19:23:22'),(9302,'security_services','security_services_audit_edit','15857',0,'Insert','','2013-05-13 19:23:22'),(9303,'security_services','security_services_audit_edit','15858',0,'Insert','','2013-05-13 19:23:22'),(9304,'security_services','security_services_audit_edit','15859',0,'Insert','','2013-05-13 19:23:22'),(9305,'security_services','security_services_audit_edit','15860',0,'Insert','','2013-05-13 19:23:22'),(9306,'security_services','security_services_audit_edit','15861',0,'Insert','','2013-05-13 19:23:22'),(9307,'security_services','security_services_audit_edit','15862',0,'Insert','','2013-05-13 19:23:22'),(9308,'security_services','security_services_audit_edit','15863',0,'Insert','','2013-05-13 19:23:22'),(9309,'security_services','security_services_audit_edit','15864',0,'Insert','','2013-05-13 19:23:22'),(9310,'security_services','security_services_audit_edit','15865',0,'Insert','','2013-05-13 19:23:22'),(9311,'security_services','security_services_audit_edit','15866',0,'Insert','','2013-05-13 19:23:22'),(9312,'security_services','security_services_audit_edit','15867',0,'Insert','','2013-05-13 19:23:22'),(9313,'security_services','security_services_audit_edit','15868',0,'Insert','','2013-05-13 19:23:22'),(9314,'security_services','security_services_audit_edit','15869',0,'Insert','','2013-05-13 19:23:22'),(9315,'security_services','security_services_audit_edit','15870',0,'Insert','','2013-05-13 19:23:22'),(9316,'security_services','security_services_audit_edit','15871',0,'Insert','','2013-05-13 19:23:22'),(9317,'security_services','security_services_audit_edit','15872',0,'Insert','','2013-05-13 19:23:22'),(9318,'security_services','security_services_audit_edit','15873',0,'Insert','','2013-05-13 19:23:22'),(9319,'security_services','security_services_audit_edit','15874',0,'Insert','','2013-05-13 19:23:22'),(9320,'security_services','security_services_audit_edit','15875',0,'Insert','','2013-05-13 19:23:22'),(9321,'security_services','security_services_audit_edit','15876',0,'Insert','','2013-05-13 19:23:22'),(9322,'security_services','security_services_audit_edit','15877',0,'Insert','','2013-05-13 19:23:22'),(9323,'security_services','security_services_audit_edit','15878',0,'Insert','','2013-05-13 19:23:22'),(9324,'security_services','security_services_audit_edit','15879',0,'Insert','','2013-05-13 19:23:22'),(9325,'security_services','security_services_audit_edit','15880',0,'Insert','','2013-05-13 19:23:22'),(9326,'security_services','security_services_audit_edit','15881',0,'Insert','','2013-05-13 19:23:22'),(9327,'security_services','security_services_audit_edit','15882',0,'Insert','','2013-05-13 19:23:22'),(9328,'security_services','security_services_audit_edit','15883',0,'Insert','','2013-05-13 19:23:22'),(9329,'security_services','security_services_audit_edit','15884',0,'Insert','','2013-05-13 19:23:22'),(9330,'security_services','security_services_audit_edit','15885',0,'Insert','','2013-05-13 19:23:22'),(9331,'security_services','security_services_audit_edit','15886',0,'Insert','','2013-05-13 19:23:22'),(9332,'security_services','security_services_audit_edit','15887',0,'Insert','','2013-05-13 19:23:22'),(9333,'security_services','security_services_audit_edit','15888',0,'Insert','','2013-05-13 19:23:22'),(9334,'system','system_authorization_edit','2',2,'Login','','2013-05-16 13:59:23'),(9335,'security_services','security_services_audit_edit','15889',0,'Insert','','2013-05-16 13:59:23'),(9336,'security_services','security_services_audit_edit','15890',0,'Insert','','2013-05-16 13:59:23'),(9337,'security_services','security_services_audit_edit','15891',0,'Insert','','2013-05-16 13:59:23'),(9338,'security_services','security_services_audit_edit','15892',0,'Insert','','2013-05-16 13:59:23'),(9339,'security_services','security_services_audit_edit','15893',0,'Insert','','2013-05-16 13:59:23'),(9340,'security_services','security_services_audit_edit','15894',0,'Insert','','2013-05-16 13:59:23'),(9341,'security_services','security_services_audit_edit','15895',0,'Insert','','2013-05-16 13:59:23'),(9342,'security_services','security_services_audit_edit','15896',0,'Insert','','2013-05-16 13:59:23'),(9343,'security_services','security_services_audit_edit','15897',0,'Insert','','2013-05-16 13:59:23'),(9344,'security_services','security_services_audit_edit','15898',0,'Insert','','2013-05-16 13:59:23'),(9345,'security_services','security_services_audit_edit','15899',0,'Insert','','2013-05-16 13:59:23'),(9346,'security_services','security_services_audit_edit','15900',0,'Insert','','2013-05-16 13:59:23'),(9347,'security_services','security_services_audit_edit','15901',0,'Insert','','2013-05-16 13:59:23'),(9348,'security_services','security_services_audit_edit','15902',0,'Insert','','2013-05-16 13:59:23'),(9349,'security_services','security_services_audit_edit','15903',0,'Insert','','2013-05-16 13:59:23'),(9350,'security_services','security_services_audit_edit','15904',0,'Insert','','2013-05-16 13:59:23'),(9351,'security_services','security_services_audit_edit','15905',0,'Insert','','2013-05-16 13:59:23'),(9352,'security_services','security_services_audit_edit','15906',0,'Insert','','2013-05-16 13:59:23'),(9353,'security_services','security_services_audit_edit','15907',0,'Insert','','2013-05-16 13:59:23'),(9354,'security_services','security_services_audit_edit','15908',0,'Insert','','2013-05-16 13:59:23'),(9355,'security_services','security_services_audit_edit','15909',0,'Insert','','2013-05-16 13:59:23'),(9356,'security_services','security_services_audit_edit','15910',0,'Insert','','2013-05-16 13:59:23'),(9357,'security_services','security_services_audit_edit','15911',0,'Insert','','2013-05-16 13:59:23'),(9358,'security_services','security_services_audit_edit','15912',0,'Insert','','2013-05-16 13:59:23'),(9359,'security_services','security_services_audit_edit','15913',0,'Insert','','2013-05-16 13:59:23'),(9360,'security_services','security_services_audit_edit','15914',0,'Insert','','2013-05-16 13:59:23'),(9361,'security_services','security_services_audit_edit','15915',0,'Insert','','2013-05-16 13:59:23'),(9362,'security_services','security_services_audit_edit','15916',0,'Insert','','2013-05-16 13:59:23'),(9363,'security_services','security_services_audit_edit','15917',0,'Insert','','2013-05-16 13:59:23'),(9364,'security_services','security_services_audit_edit','15918',0,'Insert','','2013-05-16 13:59:23'),(9365,'security_services','security_services_audit_edit','15919',0,'Insert','','2013-05-16 13:59:23'),(9366,'security_services','security_services_audit_edit','15920',0,'Insert','','2013-05-16 13:59:23'),(9367,'security_services','security_services_audit_edit','15921',0,'Insert','','2013-05-16 13:59:23'),(9368,'security_services','security_services_audit_edit','15922',0,'Insert','','2013-05-16 13:59:23'),(9369,'security_services','security_services_audit_edit','15923',0,'Insert','','2013-05-16 13:59:23'),(9370,'security_services','security_services_audit_edit','15924',0,'Insert','','2013-05-16 13:59:23'),(9371,'security_services','security_services_audit_edit','15925',0,'Insert','','2013-05-16 13:59:23'),(9372,'security_services','security_services_audit_edit','15926',0,'Insert','','2013-05-16 13:59:23'),(9373,'security_services','security_services_audit_edit','15927',0,'Insert','','2013-05-16 13:59:23'),(9374,'security_services','security_services_audit_edit','15928',0,'Insert','','2013-05-16 13:59:23'),(9375,'security_services','security_services_audit_edit','15929',0,'Insert','','2013-05-16 13:59:23'),(9376,'security_services','security_services_audit_edit','15930',0,'Insert','','2013-05-16 13:59:23'),(9377,'security_services','security_services_audit_edit','15931',0,'Insert','','2013-05-16 13:59:23'),(9378,'security_services','security_services_audit_edit','15932',0,'Insert','','2013-05-16 13:59:23'),(9379,'security_services','security_services_audit_edit','15933',0,'Insert','','2013-05-16 13:59:23'),(9380,'security_services','security_services_audit_edit','15934',0,'Insert','','2013-05-16 13:59:23'),(9381,'security_services','security_services_audit_edit','15935',0,'Insert','','2013-05-16 13:59:23'),(9382,'security_services','security_services_audit_edit','15936',0,'Insert','','2013-05-16 13:59:23'),(9383,'security_services','security_services_audit_edit','15937',0,'Insert','','2013-05-16 13:59:23'),(9384,'security_services','security_services_audit_edit','15938',0,'Insert','','2013-05-16 13:59:23'),(9385,'security_services','security_services_audit_edit','15939',0,'Insert','','2013-05-16 13:59:23'),(9386,'security_services','security_services_audit_edit','15940',0,'Insert','','2013-05-16 13:59:23'),(9387,'security_services','security_services_audit_edit','15941',0,'Insert','','2013-05-16 13:59:23'),(9388,'security_services','security_services_audit_edit','15942',0,'Insert','','2013-05-16 13:59:23'),(9389,'security_services','security_services_audit_edit','15943',0,'Insert','','2013-05-16 13:59:23'),(9390,'security_services','security_services_audit_edit','15944',0,'Insert','','2013-05-16 13:59:23'),(9391,'security_services','security_services_audit_edit','15945',0,'Insert','','2013-05-16 13:59:23'),(9392,'security_services','security_services_audit_edit','15946',0,'Insert','','2013-05-16 13:59:23'),(9393,'security_services','security_services_audit_edit','15947',0,'Insert','','2013-05-16 13:59:23'),(9394,'security_services','security_services_audit_edit','15948',0,'Insert','','2013-05-16 13:59:23'),(9395,'security_services','security_services_audit_edit','15949',0,'Insert','','2013-05-16 13:59:23'),(9396,'security_services','security_services_audit_edit','15950',0,'Insert','','2013-05-16 13:59:23'),(9397,'security_services','security_services_audit_edit','15951',0,'Insert','','2013-05-16 13:59:23'),(9398,'security_services','security_services_audit_edit','15952',0,'Insert','','2013-05-16 13:59:23'),(9399,'security_services','security_services_audit_edit','15953',0,'Insert','','2013-05-16 13:59:23'),(9400,'security_services','security_services_audit_edit','15954',0,'Insert','','2013-05-16 13:59:23'),(9401,'security_services','security_services_audit_edit','15955',0,'Insert','','2013-05-16 13:59:23'),(9402,'security_services','security_services_audit_edit','15956',0,'Insert','','2013-05-16 13:59:23'),(9403,'security_services','security_services_audit_edit','15957',0,'Insert','','2013-05-16 13:59:23'),(9404,'security_services','security_services_audit_edit','15958',0,'Insert','','2013-05-16 13:59:23'),(9405,'security_services','security_services_audit_edit','15959',0,'Insert','','2013-05-16 13:59:23'),(9406,'security_services','security_services_audit_edit','15960',0,'Insert','','2013-05-16 13:59:23'),(9407,'security_services','security_services_audit_edit','15961',0,'Insert','','2013-05-16 13:59:24'),(9408,'security_services','security_services_audit_edit','15962',0,'Insert','','2013-05-16 13:59:24'),(9409,'security_services','security_services_audit_edit','15963',0,'Insert','','2013-05-16 13:59:24'),(9410,'system','system_authorization_edit','2',2,'Update','','2013-05-16 13:59:43'),(9411,'organization','tp_edit','38',2,'Insert','','2013-05-16 14:00:17'),(9412,'organization','tp_edit','39',2,'Insert','','2013-05-16 14:00:26'),(9413,'organization','tp_edit','40',2,'Insert','','2013-05-16 14:00:35'),(9414,'organization','tp_edit','41',2,'Insert','','2013-05-16 14:02:18'),(9415,'organization','tp_edit','42',2,'Insert','','2013-05-16 14:02:30'),(9416,'organization','tp_edit','43',2,'Insert','','2013-05-16 14:03:06'),(9417,'organization','tp_edit','44',2,'Insert','','2013-05-16 14:03:18'),(9418,'organization','tp_edit','45',2,'Insert','','2013-05-16 14:03:31'),(9419,'organization','tp_edit','46',2,'Insert','','2013-05-16 14:03:45'),(9420,'organization','tp_edit','47',2,'Insert','','2013-05-16 14:03:54'),(9421,'organization','compliance_package','94',2,'Insert','','2013-05-16 14:04:47'),(9422,'organization','compliance_package_item','2098',2,'Insert','','2013-05-16 14:05:23'),(9423,'security_services','security_catalogue_edit','632',2,'Insert','','2013-05-16 14:11:12'),(9424,'security_services','security_services_audit_edit','15964',0,'Insert','','2013-05-16 14:11:12'),(9425,'security_services','security_catalogue_edit','632',2,'Update','','2013-05-16 14:13:44'),(9426,'system','system_authorization','',0,'Wrong Login','','2013-05-16 16:40:07'),(9427,'system','system_authorization','',0,'Wrong Login','','2013-05-16 16:40:13'),(9428,'system','system_authorization','',0,'Wrong Login','','2013-05-16 16:40:18'),(9429,'system','system_authorization','',0,'Wrong Login','','2013-05-16 16:40:22'),(9430,'system','system_authorization','',0,'Wrong Login','','2013-05-16 16:40:27'),(9431,'system','system_authorization_edit','1',1,'Login','','2013-05-16 16:40:31'),(9432,'security_services','security_services_audit_edit','15965',0,'Insert','','2013-05-16 16:40:31'),(9433,'security_services','security_services_audit_edit','15966',0,'Insert','','2013-05-16 16:40:31'),(9434,'security_services','security_services_audit_edit','15967',0,'Insert','','2013-05-16 16:40:31'),(9435,'security_services','security_services_audit_edit','15968',0,'Insert','','2013-05-16 16:40:31'),(9436,'security_services','security_services_audit_edit','15969',0,'Insert','','2013-05-16 16:40:31'),(9437,'security_services','security_services_audit_edit','15970',0,'Insert','','2013-05-16 16:40:31'),(9438,'security_services','security_services_audit_edit','15971',0,'Insert','','2013-05-16 16:40:31'),(9439,'security_services','security_services_audit_edit','15972',0,'Insert','','2013-05-16 16:40:31'),(9440,'security_services','security_services_audit_edit','15973',0,'Insert','','2013-05-16 16:40:31'),(9441,'security_services','security_services_audit_edit','15974',0,'Insert','','2013-05-16 16:40:31'),(9442,'security_services','security_services_audit_edit','15975',0,'Insert','','2013-05-16 16:40:31'),(9443,'security_services','security_services_audit_edit','15976',0,'Insert','','2013-05-16 16:40:31'),(9444,'security_services','security_services_audit_edit','15977',0,'Insert','','2013-05-16 16:40:31'),(9445,'security_services','security_services_audit_edit','15978',0,'Insert','','2013-05-16 16:40:31'),(9446,'security_services','security_services_audit_edit','15979',0,'Insert','','2013-05-16 16:40:31'),(9447,'security_services','security_services_audit_edit','15980',0,'Insert','','2013-05-16 16:40:31'),(9448,'security_services','security_services_audit_edit','15981',0,'Insert','','2013-05-16 16:40:31'),(9449,'security_services','security_services_audit_edit','15982',0,'Insert','','2013-05-16 16:40:31'),(9450,'security_services','security_services_audit_edit','15983',0,'Insert','','2013-05-16 16:40:31'),(9451,'security_services','security_services_audit_edit','15984',0,'Insert','','2013-05-16 16:40:31'),(9452,'security_services','security_services_audit_edit','15985',0,'Insert','','2013-05-16 16:40:31'),(9453,'security_services','security_services_audit_edit','15986',0,'Insert','','2013-05-16 16:40:31'),(9454,'security_services','security_services_audit_edit','15987',0,'Insert','','2013-05-16 16:40:31'),(9455,'security_services','security_services_audit_edit','15988',0,'Insert','','2013-05-16 16:40:31'),(9456,'security_services','security_services_audit_edit','15989',0,'Insert','','2013-05-16 16:40:31'),(9457,'security_services','security_services_audit_edit','15990',0,'Insert','','2013-05-16 16:40:31'),(9458,'security_services','security_services_audit_edit','15991',0,'Insert','','2013-05-16 16:40:31'),(9459,'security_services','security_services_audit_edit','15992',0,'Insert','','2013-05-16 16:40:31'),(9460,'security_services','security_services_audit_edit','15993',0,'Insert','','2013-05-16 16:40:31'),(9461,'security_services','security_services_audit_edit','15994',0,'Insert','','2013-05-16 16:40:31'),(9462,'security_services','security_services_audit_edit','15995',0,'Insert','','2013-05-16 16:40:31'),(9463,'security_services','security_services_audit_edit','15996',0,'Insert','','2013-05-16 16:40:31'),(9464,'security_services','security_services_audit_edit','15997',0,'Insert','','2013-05-16 16:40:31'),(9465,'security_services','security_services_audit_edit','15998',0,'Insert','','2013-05-16 16:40:31'),(9466,'security_services','security_services_audit_edit','15999',0,'Insert','','2013-05-16 16:40:31'),(9467,'security_services','security_services_audit_edit','16000',0,'Insert','','2013-05-16 16:40:31'),(9468,'security_services','security_services_audit_edit','16001',0,'Insert','','2013-05-16 16:40:31'),(9469,'security_services','security_services_audit_edit','16002',0,'Insert','','2013-05-16 16:40:31'),(9470,'security_services','security_services_audit_edit','16003',0,'Insert','','2013-05-16 16:40:31'),(9471,'security_services','security_services_audit_edit','16004',0,'Insert','','2013-05-16 16:40:31'),(9472,'security_services','security_services_audit_edit','16005',0,'Insert','','2013-05-16 16:40:31'),(9473,'security_services','security_services_audit_edit','16006',0,'Insert','','2013-05-16 16:40:31'),(9474,'security_services','security_services_audit_edit','16007',0,'Insert','','2013-05-16 16:40:31'),(9475,'security_services','security_services_audit_edit','16008',0,'Insert','','2013-05-16 16:40:31'),(9476,'security_services','security_services_audit_edit','16009',0,'Insert','','2013-05-16 16:40:31'),(9477,'security_services','security_services_audit_edit','16010',0,'Insert','','2013-05-16 16:40:31'),(9478,'security_services','security_services_audit_edit','16011',0,'Insert','','2013-05-16 16:40:31'),(9479,'security_services','security_services_audit_edit','16012',0,'Insert','','2013-05-16 16:40:31'),(9480,'security_services','security_services_audit_edit','16013',0,'Insert','','2013-05-16 16:40:31'),(9481,'security_services','security_services_audit_edit','16014',0,'Insert','','2013-05-16 16:40:31'),(9482,'security_services','security_services_audit_edit','16015',0,'Insert','','2013-05-16 16:40:31'),(9483,'security_services','security_services_audit_edit','16016',0,'Insert','','2013-05-16 16:40:31'),(9484,'security_services','security_services_audit_edit','16017',0,'Insert','','2013-05-16 16:40:31'),(9485,'security_services','security_services_audit_edit','16018',0,'Insert','','2013-05-16 16:40:31'),(9486,'security_services','security_services_audit_edit','16019',0,'Insert','','2013-05-16 16:40:31'),(9487,'security_services','security_services_audit_edit','16020',0,'Insert','','2013-05-16 16:40:31'),(9488,'security_services','security_services_audit_edit','16021',0,'Insert','','2013-05-16 16:40:31'),(9489,'security_services','security_services_audit_edit','16022',0,'Insert','','2013-05-16 16:40:31'),(9490,'security_services','security_services_audit_edit','16023',0,'Insert','','2013-05-16 16:40:31'),(9491,'security_services','security_services_audit_edit','16024',0,'Insert','','2013-05-16 16:40:31'),(9492,'security_services','security_services_audit_edit','16025',0,'Insert','','2013-05-16 16:40:31'),(9493,'security_services','security_services_audit_edit','16026',0,'Insert','','2013-05-16 16:40:31'),(9494,'security_services','security_services_audit_edit','16027',0,'Insert','','2013-05-16 16:40:31'),(9495,'security_services','security_services_audit_edit','16028',0,'Insert','','2013-05-16 16:40:31'),(9496,'security_services','security_services_audit_edit','16029',0,'Insert','','2013-05-16 16:40:31'),(9497,'security_services','security_services_audit_edit','16030',0,'Insert','','2013-05-16 16:40:31'),(9498,'security_services','security_services_audit_edit','16031',0,'Insert','','2013-05-16 16:40:31'),(9499,'security_services','security_services_audit_edit','16032',0,'Insert','','2013-05-16 16:40:31'),(9500,'security_services','security_services_audit_edit','16033',0,'Insert','','2013-05-16 16:40:31'),(9501,'security_services','security_services_audit_edit','16034',0,'Insert','','2013-05-16 16:40:31'),(9502,'security_services','security_services_audit_edit','16035',0,'Insert','','2013-05-16 16:40:31'),(9503,'security_services','security_services_audit_edit','16036',0,'Insert','','2013-05-16 16:40:31'),(9504,'security_services','security_services_audit_edit','16037',0,'Insert','','2013-05-16 16:40:31'),(9505,'security_services','security_services_audit_edit','16038',0,'Insert','','2013-05-16 16:40:31'),(9506,'security_services','security_services_audit_edit','16039',0,'Insert','','2013-05-16 16:40:31'),(9507,'security_services','security_services_audit_edit','16040',0,'Insert','','2013-05-16 16:40:31'),(9508,'system','system_authorization_edit','2',1,'Update','','2013-05-16 16:40:41'),(9509,'organization','compliance_package','95',1,'Insert','','2013-05-16 17:44:08'),(9510,'organization','compliance_package','96',1,'Insert','','2013-05-16 17:44:19'),(9511,'organization','compliance_package','97',1,'Insert','','2013-05-16 17:44:31'),(9512,'organization','compliance_package_item','2099',1,'Insert','','2013-05-16 17:44:42'),(9513,'organization','compliance_package_item','2100',1,'Insert','','2013-05-16 17:45:10'),(9514,'organization','compliance_package_item','2101',1,'Insert','','2013-05-16 17:45:33'),(9515,'compliance','compliance_audit_edit','9',1,'Insert','','2013-05-16 17:45:57'),(9516,'compliance','compliance_finding_edit','6',1,'Insert','','2013-05-16 17:46:31'),(9517,'compliance','compliance_finding_edit','7',1,'Insert','','2013-05-16 17:47:05'),(9518,'compliance','compliance_finding_edit','7',1,'Update','','2013-05-16 17:47:26'),(9519,'security_services','security_catalogue_edit','633',1,'Insert','','2013-05-16 17:50:20'),(9520,'security_services','security_services_audit_edit','16041',0,'Insert','','2013-05-16 17:50:20'),(9521,'security_services','security_services_maintenance_edit','14870',0,'Insert','','2013-05-16 17:50:20'),(9522,'compliance','compliance_management_edit','176',1,'Insert','','2013-05-16 17:51:08'),(9523,'security_services','security_catalogue_edit','634',1,'Insert','','2013-05-16 17:52:58'),(9524,'security_services','security_services_audit_edit','16042',0,'Insert','','2013-05-16 17:52:58'),(9525,'compliance','compliance_management_edit','177',1,'Insert','','2013-05-16 17:53:16'),(9526,'security_services','security_catalogue_edit','635',1,'Insert','','2013-05-16 17:54:44'),(9527,'security_services','security_services_audit_edit','16043',0,'Insert','','2013-05-16 17:54:44'),(9528,'compliance','compliance_management_edit','178',1,'Insert','','2013-05-16 17:55:08'),(9529,'organization','compliance_package','98',1,'Insert','','2013-05-16 17:56:31'),(9530,'organization','compliance_package_item','2102',1,'Insert','','2013-05-16 17:57:00'),(9531,'organization','compliance_package_item','2103',1,'Insert','','2013-05-16 17:57:30'),(9532,'organization','compliance_package','99',1,'Insert','','2013-05-16 17:57:56'),(9533,'organization','compliance_package_item','2104',1,'Insert','','2013-05-16 17:58:18'),(9534,'organization','compliance_package','100',1,'Insert','','2013-05-16 17:59:28'),(9535,'organization','compliance_package_item','2105',1,'Insert','','2013-05-16 17:59:51'),(9536,'organization','compliance_package_item','2106',1,'Insert','','2013-05-16 18:00:12'),(9537,'security_services','security_catalogue_edit','636',1,'Insert','','2013-05-16 18:36:36'),(9538,'security_services','security_services_audit_edit','16044',0,'Insert','','2013-05-16 18:36:36'),(9539,'security_services','security_services_audit_edit','16045',0,'Insert','','2013-05-16 18:36:36'),(9540,'security_services','security_catalogue_edit','637',1,'Insert','','2013-05-16 18:37:53'),(9541,'security_services','security_services_audit_edit','16046',0,'Insert','','2013-05-16 18:37:53'),(9542,'security_services','security_services_maintenance_edit','14871',0,'Insert','','2013-05-16 18:37:53'),(9543,'security_services','security_catalogue_edit','638',1,'Insert','','2013-05-16 18:39:41'),(9544,'security_services','security_services_audit_edit','16047',0,'Insert','','2013-05-16 18:39:41'),(9545,'security_services','security_services_audit_edit','16048',0,'Insert','','2013-05-16 18:39:41'),(9546,'compliance','compliance_management_edit','179',1,'Insert','','2013-05-16 18:40:24'),(9547,'compliance','compliance_management_edit','180',1,'Insert','','2013-05-16 18:40:31'),(9548,'compliance','compliance_management_edit','181',1,'Insert','','2013-05-16 18:40:46'),(9549,'compliance','compliance_management_edit','182',1,'Insert','','2013-05-16 18:41:22'),(9550,'compliance','compliance_management_edit','183',1,'Insert','','2013-05-16 18:41:37'),(9551,'compliance','compliance_management_edit','184',1,'Insert','','2013-05-16 18:41:48'),(9552,'organization','compliance_package','101',1,'Insert','','2013-05-16 19:04:18'),(9553,'organization','compliance_package','102',1,'Insert','','2013-05-16 19:07:27'),(9554,'organization','compliance_package_item','2107',1,'Insert','','2013-05-16 19:07:38'),(9555,'organization','compliance_package_item','2108',1,'Insert','','2013-05-16 19:07:50'),(9556,'organization','compliance_package_item','2109',1,'Insert','','2013-05-16 19:08:17'),(9557,'organization','compliance_package_item','2110',1,'Insert','','2013-05-16 19:08:42'),(9558,'organization','compliance_package','103',1,'Insert','','2013-05-16 19:09:28'),(9559,'organization','compliance_package_item','2111',1,'Insert','','2013-05-16 19:09:54'),(9560,'security_services','security_catalogue_edit','639',1,'Insert','','2013-05-16 19:15:52'),(9561,'security_services','security_services_audit_edit','16049',0,'Insert','','2013-05-16 19:15:52'),(9562,'compliance','compliance_management_edit','185',1,'Insert','','2013-05-16 19:16:11'),(9563,'compliance','compliance_management_edit','186',1,'Insert','','2013-05-16 19:16:21'),(9564,'compliance','compliance_management_edit','187',1,'Insert','','2013-05-16 19:19:20'),(9565,'compliance','compliance_management_edit','188',1,'Insert','','2013-05-16 19:39:59'),(9566,'compliance','compliance_management_edit','189',1,'Insert','','2013-05-16 19:40:07'),(9567,'compliance','compliance_management_edit','188',1,'Update','','2013-05-16 19:40:29'),(9568,'compliance','compliance_management_edit','189',1,'Update','','2013-05-16 19:40:35'),(9569,'security_services','security_catalogue_edit','633',1,'Update','','2013-05-16 19:41:29'),(9570,'security_services','security_services_audit_edit','16050',0,'Insert','','2013-05-16 19:41:29'),(9571,'security_services','security_services_audit_edit','16050',1,'Update','','2013-05-16 19:42:11'),(9572,'security_services','security_catalogue_edit','640',1,'Insert','','2013-05-16 19:44:55'),(9573,'security_services','security_services_audit_edit','16051',0,'Insert','','2013-05-16 19:44:55'),(9574,'security_services','security_catalogue_edit','640',1,'Disable','','2013-05-16 19:45:32'),(9575,'compliance','compliance_management_edit','190',1,'Insert','','2013-05-16 19:45:47'),(9576,'operations','security_services_classification_edit','1',1,'Insert','','2013-05-16 19:51:39'),(9577,'organization','compliance_package','104',1,'Insert','','2013-05-16 19:58:06'),(9578,'organization','compliance_package','105',1,'Insert','','2013-05-16 19:58:20'),(9579,'organization','compliance_package','106',1,'Insert','','2013-05-16 19:58:30'),(9580,'organization','compliance_package_item','2112',1,'Insert','','2013-05-16 19:58:47'),(9581,'organization','compliance_package_item','2113',1,'Insert','','2013-05-16 19:59:12'),(9582,'organization','compliance_package_item','2114',1,'Insert','','2013-05-16 19:59:46'),(9583,'organization','compliance_package_item','0',1,'Update','','2013-05-16 19:59:55'),(9584,'organization','compliance_package_item','2115',1,'Insert','','2013-05-16 20:00:15'),(9585,'organization','compliance_package_item','2116',1,'Insert','','2013-05-16 20:00:33'),(9586,'operations','security_incident_classification_edit','1',1,'Insert','','2013-05-16 20:06:50'),(9587,'operations','security_incident_classification_edit','2',1,'Insert','','2013-05-16 20:07:02'),(9588,'operations','security_incident_classification_edit','3',1,'Insert','','2013-05-16 20:07:13'),(9589,'operations','security_incident_edit','11',1,'Update','','2013-05-16 20:26:41'),(9590,'operations','security_incident_edit','7',1,'Update','','2013-05-16 20:27:13'),(9591,'operations','security_incident_edit','7',1,'Update','','2013-05-16 20:30:00'),(9592,'operations','security_incident_edit','67',1,'Update','','2013-05-16 20:30:20'),(9593,'operations','security_incident_edit','70',1,'Update','','2013-05-16 20:30:52'),(9594,'operations','security_incident_edit','',1,'Export','','2013-05-16 20:39:42'),(9595,'security_services','security_catalogue_edit','557',1,'Update','','2013-05-16 20:42:44'),(9596,'security_services','security_catalogue_edit','557',1,'Update','','2013-05-16 20:42:55'),(9597,'security_services','security_services_audit_edit','14832',1,'Update','','2013-05-17 14:50:47'),(9598,'security_services','security_services_audit_edit','15734',1,'Update','','2013-05-17 14:51:24'),(9599,'security_services','security_services_maintenance_edit','14860',1,'Disable','','2013-05-17 14:52:07'),(9600,'security_services','security_services_maintenance_edit','14858',1,'Disable','','2013-05-17 14:52:08'),(9601,'security_services','security_services_maintenance_edit','14859',1,'Disable','','2013-05-17 14:52:09'),(9602,'security_services','security_services_maintenance_edit','14857',1,'Disable','','2013-05-17 14:52:10'),(9603,'security_services','security_services_audit_edit','15736',1,'Update','','2013-05-17 14:54:26'),(9604,'security_services','security_services_audit','15738',1,'Disable','','2013-05-17 14:55:04'),(9605,'security_services','security_services_audit','15734',1,'Disable','','2013-05-17 14:55:17'),(9606,'security_services','security_services_audit','14832',1,'Disable','','2013-05-17 14:55:18'),(9607,'security_services','security_services_audit','15751',1,'Disable','','2013-05-17 14:56:04'),(9608,'security_services','security_services_audit','15753',1,'Disable','','2013-05-17 14:57:07'),(9609,'security_services','security_services_audit','15752',1,'Disable','','2013-05-17 14:57:16'),(9610,'security_services','security_services_audit','15754',1,'Disable','','2013-05-17 14:57:27'),(9611,'security_services','security_catalogue_edit','563',1,'Update','','2013-05-17 14:58:04'),(9612,'security_services','security_services_audit_edit','16052',0,'Insert','','2013-05-17 14:58:04'),(9613,'security_services','security_services_audit','16052',1,'Disable','','2013-05-17 14:58:13'),(9614,'organization','tp_edit','48',1,'Insert','','2013-05-17 15:00:46'),(9615,'security_services','service_contracts_edit','4',1,'Insert','','2013-05-17 15:01:52'),(9616,'security_services','security_catalogue_edit','559',1,'Update','','2013-05-17 15:02:55'),(9617,'security_services','security_services_audit_edit','16053',0,'Insert','','2013-05-17 15:02:55'),(9618,'security_services','security_services_audit','16053',1,'Disable','','2013-05-17 15:03:26'),(9619,'security_services','security_services_audit','15749',1,'Disable','','2013-05-17 15:07:50'),(9620,'security_services','security_catalogue_edit','570',1,'Update','','2013-05-17 15:08:21'),(9621,'security_services','security_services_audit_edit','16054',0,'Insert','','2013-05-17 15:08:21'),(9622,'security_services','security_services_audit','16054',1,'Disable','','2013-05-17 15:08:35'),(9623,'security_services','security_catalogue_edit','561',1,'Update','','2013-05-17 15:11:12'),(9624,'security_services','security_catalogue_edit','561',1,'Update','','2013-05-17 15:11:19'),(9625,'security_services','security_catalogue_edit','562',1,'Update','','2013-05-17 15:11:30'),(9626,'security_services','security_catalogue_edit','560',1,'Update','','2013-05-17 15:12:04'),(9627,'security_services','security_catalogue_edit','560',1,'Update','','2013-05-17 15:12:08'),(9628,'security_services','security_catalogue_edit','557',1,'Update','','2013-05-17 15:13:03'),(9629,'security_services','security_services_audit_edit','16055',0,'Insert','','2013-05-17 15:13:03'),(9630,'security_services','security_services_maintenance_edit','14872',0,'Insert','','2013-05-17 15:13:03'),(9631,'security_services','security_services_audit','16055',1,'Disable','','2013-05-17 15:13:11'),(9632,'security_services','security_catalogue_edit','571',1,'Update','','2013-05-17 15:13:57'),(9633,'security_services','security_catalogue_edit','557',1,'Update','','2013-05-17 15:15:29'),(9634,'security_services','security_services_audit_edit','16056',0,'Insert','','2013-05-17 15:15:29'),(9635,'security_services','security_services_audit','16056',1,'Disable','','2013-05-17 15:15:35'),(9636,'security_services','security_catalogue_edit','572',1,'Update','','2013-05-17 15:15:59'),(9637,'security_services','security_services_audit','15757',1,'Disable','','2013-05-17 15:32:16'),(9638,'security_services','security_services_audit_edit','15759',1,'Update','','2013-05-17 15:38:09'),(9639,'organization','tp_edit','49',1,'Insert','','2013-05-17 15:39:43'),(9640,'security_services','service_contracts_edit','5',1,'Insert','','2013-05-17 15:41:00'),(9641,'security_services','security_catalogue_edit','576',1,'Update','','2013-05-17 15:46:49'),(9642,'security_services','security_catalogue_edit','580',1,'Update','','2013-05-17 15:48:41'),(9643,'security_services','security_services_audit_edit','16057',0,'Insert','','2013-05-17 15:48:41'),(9644,'security_services','security_services_audit_edit','16058',0,'Insert','','2013-05-17 15:48:41'),(9645,'security_services','security_catalogue_edit','581',1,'Update','','2013-05-17 15:53:14'),(9646,'security_services','security_services_audit_edit','16059',0,'Insert','','2013-05-17 15:53:14'),(9647,'security_services','security_services_audit_edit','16060',0,'Insert','','2013-05-17 15:53:14'),(9648,'security_services','security_services_maintenance_edit','14873',0,'Insert','','2013-05-17 15:53:14'),(9649,'security_services','security_services_maintenance_edit','14874',0,'Insert','','2013-05-17 15:53:14'),(9650,'security_services','security_services_maintenance_edit','14875',0,'Insert','','2013-05-17 15:53:14'),(9651,'security_services','security_services_maintenance_edit','14876',0,'Insert','','2013-05-17 15:53:14'),(9652,'security_services','security_services_maintenance_edit','14877',0,'Insert','','2013-05-17 15:53:14'),(9653,'security_services','security_services_maintenance_edit','14878',0,'Insert','','2013-05-17 15:53:14'),(9654,'security_services','security_services_maintenance_edit','14879',0,'Insert','','2013-05-17 15:53:14'),(9655,'security_services','security_services_maintenance_edit','14880',0,'Insert','','2013-05-17 15:53:14'),(9656,'security_services','security_services_maintenance_edit','14881',0,'Insert','','2013-05-17 15:53:14'),(9657,'security_services','security_services_maintenance_edit','14882',0,'Insert','','2013-05-17 15:53:14'),(9658,'security_services','security_services_maintenance_edit','14883',0,'Insert','','2013-05-17 15:53:14'),(9659,'security_services','security_services_maintenance_edit','14884',0,'Insert','','2013-05-17 15:53:14'),(9660,'organization','tp_edit','50',1,'Insert','','2013-05-17 15:53:33'),(9661,'security_services','service_contracts_edit','6',1,'Insert','','2013-05-17 15:54:36'),(9662,'security_services','security_catalogue_edit','581',1,'Update','','2013-05-17 15:54:49'),(9663,'organization','tp_edit','51',1,'Insert','','2013-05-17 15:55:28'),(9664,'security_services','service_contracts_edit','7',1,'Insert','','2013-05-17 15:56:14'),(9665,'security_services','service_contracts_edit','8',1,'Insert','','2013-05-17 15:57:03'),(9666,'security_services','service_contracts_edit','8',1,'Update','','2013-05-17 15:57:18'),(9667,'security_services','service_contracts_edit','9',1,'Insert','','2013-05-17 15:58:00'),(9668,'security_services','service_contracts_edit','9',1,'Update','','2013-05-17 15:59:55'),(9669,'security_services','service_contracts_edit','9',1,'Update','','2013-05-17 16:00:51'),(9670,'security_services','service_contracts_edit','10',1,'Insert','','2013-05-17 16:01:54'),(9671,'security_services','service_contracts_edit','9',1,'Update','','2013-05-17 16:02:01'),(9672,'security_services','service_contracts_edit','2',1,'Update','','2013-05-17 16:02:36'),(9673,'security_services','security_catalogue_edit','557',1,'Update','','2013-05-17 16:03:19'),(9674,'security_services','security_services_audit_edit','16061',0,'Insert','','2013-05-17 16:03:19'),(9675,'security_services','security_services_audit','16061',1,'Disable','','2013-05-17 16:03:26'),(9676,'security_services','security_services_audit','16059',1,'Disable','','2013-05-17 16:05:29'),(9677,'security_services','security_services_audit','15766',1,'Disable','','2013-05-17 17:35:06'),(9678,'security_services','security_catalogue_edit','582',1,'Update','','2013-05-17 17:57:27'),(9679,'security_services','security_services_audit','15767',1,'Disable','','2013-05-17 17:58:15'),(9680,'security_services','security_catalogue_edit','590',1,'Update','','2013-05-17 18:00:10'),(9681,'security_services','security_services_maintenance_edit','14885',0,'Insert','','2013-05-17 18:00:10'),(9682,'security_services','security_services_maintenance_edit','14886',0,'Insert','','2013-05-17 18:00:10'),(9683,'security_services','security_services_maintenance_edit','14887',0,'Insert','','2013-05-17 18:00:10'),(9684,'security_services','security_services_maintenance_edit','14888',0,'Insert','','2013-05-17 18:00:10'),(9685,'security_services','security_services_maintenance_edit','14889',0,'Insert','','2013-05-17 18:00:10'),(9686,'security_services','security_services_maintenance_edit','14890',0,'Insert','','2013-05-17 18:00:10'),(9687,'security_services','security_services_audit','15771',1,'Disable','','2013-05-17 18:00:18'),(9688,'security_services','security_services_audit','15768',1,'Disable','','2013-05-17 18:01:11'),(9689,'security_services','security_catalogue_edit','589',1,'Update','','2013-05-17 18:03:08'),(9690,'security_services','security_services_audit_edit','16062',0,'Insert','','2013-05-17 18:03:08'),(9691,'security_services','security_services_audit_edit','16063',0,'Insert','','2013-05-17 18:03:08'),(9692,'security_services','security_services_audit_edit','16064',0,'Insert','','2013-05-17 18:03:08'),(9693,'security_services','security_services_audit','16062',1,'Disable','','2013-05-17 18:03:21'),(9694,'security_services','security_services_audit','16063',1,'Disable','','2013-05-17 18:03:25'),(9695,'security_services','security_services_audit','15773',1,'Disable','','2013-05-17 18:04:39'),(9696,'security_services','security_services_audit','15775',1,'Disable','','2013-05-17 18:04:50'),(9697,'security_services','security_services_audit','15777',1,'Disable','','2013-05-17 18:04:59'),(9698,'security_services','security_services_audit','15779',1,'Disable','','2013-05-17 18:07:54'),(9699,'security_services','security_services_audit','15781',1,'Disable','','2013-05-17 18:11:04'),(9700,'security_services','security_services_maintenance_edit','14865',1,'Disable','','2013-05-17 18:11:37'),(9701,'security_services','security_services_audit','15784',1,'Disable','','2013-05-17 18:12:22'),(9702,'security_services','security_services_audit','15786',1,'Disable','','2013-05-17 18:13:06'),(9703,'security_services','security_services_audit','15788',1,'Disable','','2013-05-17 18:14:01'),(9704,'security_services','security_catalogue_edit','602',1,'Disable','','2013-05-17 18:14:38'),(9705,'security_services','security_services_audit','15792',1,'Disable','','2013-05-17 18:15:42'),(9706,'security_services','security_catalogue_edit','607',1,'Disable','','2013-05-17 18:16:06'),(9707,'security_services','security_catalogue_edit','608',1,'Update','','2013-05-17 18:16:45'),(9708,'security_services','security_catalogue_edit','609',1,'Update','','2013-05-17 18:19:00'),(9709,'security_services','security_services_audit_edit','16065',0,'Insert','','2013-05-17 18:19:00'),(9710,'security_services','security_services_audit_edit','16066',0,'Insert','','2013-05-17 18:19:00'),(9711,'security_services','security_services_maintenance_edit','14891',0,'Insert','','2013-05-17 18:19:00'),(9712,'security_services','security_services_maintenance_edit','14892',0,'Insert','','2013-05-17 18:19:00'),(9713,'security_services','security_services_maintenance_edit','14893',0,'Insert','','2013-05-17 18:19:00'),(9714,'security_services','security_services_maintenance_edit','14894',0,'Insert','','2013-05-17 18:19:00'),(9715,'security_services','security_services_maintenance_edit','14895',0,'Insert','','2013-05-17 18:19:00'),(9716,'security_services','security_services_maintenance_edit','14896',0,'Insert','','2013-05-17 18:19:00'),(9717,'security_services','security_services_maintenance_edit','14897',0,'Insert','','2013-05-17 18:19:00'),(9718,'security_services','security_services_maintenance_edit','14898',0,'Insert','','2013-05-17 18:19:00'),(9719,'security_services','security_services_maintenance_edit','14899',0,'Insert','','2013-05-17 18:19:00'),(9720,'security_services','security_services_maintenance_edit','14900',0,'Insert','','2013-05-17 18:19:00'),(9721,'security_services','security_services_maintenance_edit','14901',0,'Insert','','2013-05-17 18:19:00'),(9722,'security_services','security_services_maintenance_edit','14891',1,'Disable','','2013-05-17 18:19:11'),(9723,'security_services','security_services_maintenance_edit','14892',1,'Disable','','2013-05-17 18:19:14'),(9724,'security_services','security_services_maintenance_edit','14893',1,'Disable','','2013-05-17 18:19:15'),(9725,'security_services','security_services_maintenance_edit','14894',1,'Disable','','2013-05-17 18:19:16'),(9726,'security_services','security_services_maintenance_edit','14895',1,'Disable','','2013-05-17 18:19:17'),(9727,'security_services','security_catalogue_edit','609',1,'Update','','2013-05-17 18:19:48'),(9728,'security_services','security_services_maintenance_edit','14902',0,'Insert','','2013-05-17 18:19:48'),(9729,'security_services','security_services_maintenance_edit','14903',0,'Insert','','2013-05-17 18:19:48'),(9730,'security_services','security_services_maintenance_edit','14904',0,'Insert','','2013-05-17 18:19:48'),(9731,'security_services','security_services_maintenance_edit','14905',0,'Insert','','2013-05-17 18:19:48'),(9732,'security_services','security_services_maintenance_edit','14906',0,'Insert','','2013-05-17 18:19:48'),(9733,'security_services','service_contracts_edit','3',1,'Update','','2013-05-17 18:20:19'),(9734,'security_services','security_catalogue_edit','612',1,'Update','','2013-05-17 18:20:57'),(9735,'security_services','security_catalogue_edit','612',1,'Update','','2013-05-17 18:21:26'),(9736,'security_services','security_services_audit_edit','16067',0,'Insert','','2013-05-17 18:21:26'),(9737,'security_services','security_catalogue_edit','613',1,'Update','','2013-05-17 18:32:58'),(9738,'security_services','security_catalogue_edit','614',1,'Update','','2013-05-17 18:33:11'),(9739,'security_services','security_services_audit','15796',1,'Disable','','2013-05-17 18:33:24'),(9740,'security_services','security_services_audit','15798',1,'Disable','','2013-05-17 18:34:01'),(9741,'security_services','security_services_audit','15802',1,'Disable','','2013-05-17 18:36:57'),(9742,'security_services','security_catalogue_edit','621',1,'Disable','','2013-05-17 18:37:43'),(9743,'security_services','security_catalogue_edit','622',1,'Disable','','2013-05-17 18:37:59'),(9744,'security_services','security_catalogue_edit','623',1,'Disable','','2013-05-17 18:38:51'),(9745,'security_services','security_catalogue_edit','624',1,'Update','','2013-05-17 18:55:05'),(9746,'security_services','security_catalogue_edit','624',1,'Update','','2013-05-17 18:55:44'),(9747,'security_services','security_services_audit_edit','16068',0,'Insert','','2013-05-17 18:55:44'),(9748,'security_services','security_services_audit_edit','16069',0,'Insert','','2013-05-17 18:55:44'),(9749,'security_services','security_services_audit_edit','16070',0,'Insert','','2013-05-17 18:55:44'),(9750,'security_services','security_services_audit_edit','16071',0,'Insert','','2013-05-17 18:55:44'),(9751,'security_services','security_services_audit_edit','16072',0,'Insert','','2013-05-17 18:55:44'),(9752,'security_services','security_services_audit','16069',1,'Disable','','2013-05-17 18:56:00'),(9753,'security_services','security_services_audit','16068',1,'Disable','','2013-05-17 18:56:01'),(9754,'security_services','security_catalogue_edit','625',1,'Update','','2013-05-17 18:58:50'),(9755,'security_services','security_services_audit','15808',1,'Disable','','2013-05-17 18:58:56'),(9756,'security_services','security_catalogue_edit','626',1,'Update','','2013-05-17 18:59:46'),(9757,'security_services','security_services_audit_edit','16073',0,'Insert','','2013-05-17 18:59:47'),(9758,'security_services','security_services_audit','15810',1,'Disable','','2013-05-17 19:00:01'),(9759,'security_services','security_catalogue_edit','627',1,'Disable','','2013-05-17 19:00:19'),(9760,'security_services','security_catalogue_edit','572',1,'Update','','2013-05-17 19:01:18'),(9761,'security_services','security_services_audit_edit','16074',0,'Insert','','2013-05-17 19:01:18'),(9762,'security_services','security_services_audit_edit','16075',0,'Insert','','2013-05-17 19:01:18'),(9763,'security_services','security_services_audit_edit','16076',0,'Insert','','2013-05-17 19:01:18'),(9764,'security_services','security_catalogue_edit','628',1,'Update','','2013-05-17 19:01:53'),(9765,'security_services','security_services_audit_edit','16077',0,'Insert','','2013-05-17 19:01:53'),(9766,'security_services','security_services_audit_edit','16078',0,'Insert','','2013-05-17 19:01:53'),(9767,'security_services','security_services_audit_edit','16079',0,'Insert','','2013-05-17 19:01:53'),(9768,'security_services','security_services_audit','16075',1,'Disable','','2013-05-17 19:02:01'),(9769,'security_services','security_services_audit','16074',1,'Disable','','2013-05-17 19:02:02'),(9770,'security_services','security_catalogue_edit','572',1,'Update','','2013-05-17 19:02:42'),(9771,'security_services','security_services_audit_edit','16080',0,'Insert','','2013-05-17 19:02:42'),(9772,'security_services','security_services_audit_edit','16081',0,'Insert','','2013-05-17 19:02:42'),(9773,'security_services','security_services_audit','16080',1,'Disable','','2013-05-17 19:02:51'),(9774,'security_services','security_services_audit','16076',1,'Disable','','2013-05-17 19:02:54'),(9775,'security_services','security_services_audit','15811',1,'Disable','','2013-05-17 19:03:04'),(9776,'security_services','security_services_audit','16077',1,'Disable','','2013-05-17 19:03:06'),(9777,'security_services','security_catalogue_edit','628',1,'Update','','2013-05-17 19:03:19'),(9778,'security_services','security_services_audit_edit','16082',0,'Insert','','2013-05-17 19:03:19'),(9779,'security_services','security_services_audit_edit','16083',0,'Insert','','2013-05-17 19:03:19'),(9780,'security_services','security_services_audit','16082',1,'Disable','','2013-05-17 19:03:33'),(9781,'security_services','security_services_audit','16083',1,'Disable','','2013-05-17 19:03:35'),(9782,'security_services','security_services_audit','16079',1,'Disable','','2013-05-17 19:03:38'),(9783,'security_services','security_services_audit','15813',1,'Disable','','2013-05-17 19:04:18'),(9784,'security_services','security_catalogue_edit','575',1,'Update','','2013-05-18 19:01:07'),(9785,'risk','risk_tp_edit','158',1,'Disable','','2013-05-18 19:09:53'),(9786,'risk','risk_tp_edit','157',1,'Update','','2013-05-18 19:11:06'),(9787,'risk','risk_tp_edit','157',1,'Update','','2013-05-18 19:11:17'),(9788,'asset','data_asset_edit','1',1,'Insert','','2013-05-18 19:14:09'),(9789,'asset','data_asset_edit','2',1,'Insert','','2013-05-18 19:14:27'),(9790,'asset','data_asset_edit','1',1,'Disable','','2013-05-18 19:14:34'),(9791,'asset','data_asset_edit','2',1,'Disable','','2013-05-18 19:14:37'),(9792,'asset','data_asset_edit','3',1,'Insert','','2013-05-18 19:14:48'),(9793,'asset','data_asset_edit','3',1,'Disable','','2013-05-18 19:14:55'),(9794,'asset','data_asset_edit','4',1,'Insert','','2013-05-18 19:21:45'),(9795,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:45:21'),(9796,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:46:44'),(9797,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:48:06'),(9798,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:48:14'),(9799,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:48:21'),(9800,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:48:26'),(9801,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:49:31'),(9802,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:49:40'),(9803,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:51:07'),(9804,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:51:17'),(9805,'operations','security_incident_edit','67',1,'Update','','2013-05-18 19:51:32'),(9806,'organization','tp_edit','52',1,'Insert','','2013-05-18 19:54:16'),(9807,'organization','tp_edit','52',1,'Disable','','2013-05-18 19:54:22'),(9808,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:51:15'),(9809,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:52:30'),(9810,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:53:44'),(9811,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:55:06'),(9812,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:56:36'),(9813,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:57:24'),(9814,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:58:43'),(9815,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:59:18'),(9816,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 22:59:49'),(9817,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 23:01:37'),(9818,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 23:03:33'),(9819,'security_services','security_services_analysis_list','',1,'Export','','2013-05-18 23:05:25'),(9820,'security_services','security_catalogue_edit','637',1,'Update','','2013-05-19 11:42:29'),(9821,'risk','risk_tp_edit','157',1,'Update','','2013-05-19 11:59:02'),(9822,'risk','risk_tp_edit','157',1,'Update','','2013-05-19 11:59:18'),(9823,'risk','risk_management_edit','2',1,'Update','','2013-05-19 14:38:03'),(9824,'risk','risk_management_edit','2',1,'Update','','2013-05-19 14:41:22'),(9825,'risk','risk_management_edit','4',1,'Update','','2013-05-19 14:41:41'),(9826,'risk','risk_management_edit','4',1,'Update','','2013-05-19 14:41:55'),(9827,'risk','risk_management_edit','5',1,'Update','','2013-05-19 14:42:07'),(9828,'risk','risk_management_edit','8',1,'Update','','2013-05-19 14:43:04'),(9829,'risk','risk_management_edit','8',1,'Update','','2013-05-19 14:44:05'),(9830,'risk','risk_management_edit','8',1,'Update','','2013-05-19 14:44:21'),(9831,'risk','risk_management_edit','8',1,'Update','','2013-05-19 14:45:17'),(9832,'risk','risk_management_edit','11',1,'Update','','2013-05-19 14:45:42'),(9833,'risk','risk_management_edit','11',1,'Update','','2013-05-19 14:46:01'),(9834,'risk','risk_management_edit','12',1,'Update','','2013-05-19 14:46:10'),(9835,'risk','risk_management_edit','12',1,'Update','','2013-05-19 14:46:19'),(9836,'risk','risk_management_edit','14',1,'Update','','2013-05-19 14:46:39'),(9837,'risk','risk_management_edit','15',1,'Update','','2013-05-19 14:47:00'),(9838,'risk','risk_management_edit','18',1,'Update','','2013-05-19 14:49:59'),(9839,'risk','risk_management_edit','32',1,'Update','','2013-05-19 15:03:45'),(9840,'risk','risk_management_edit','35',1,'Update','','2013-05-19 15:04:32'),(9841,'risk','risk_management_edit','35',1,'Update','','2013-05-19 15:05:06'),(9842,'security_services','security_catalogue_edit','641',1,'Insert','','2013-05-19 15:07:02'),(9843,'risk','risk_management_edit','37',1,'Update','','2013-05-19 15:07:36'),(9844,'risk','risk_management_edit','17',1,'Update','','2013-05-19 15:10:09'),(9845,'risk','risk_management_edit','23',1,'Update','','2013-05-19 15:10:39'),(9846,'risk','risk_management_edit','37',1,'Update','','2013-05-19 15:11:08'),(9847,'risk','risk_management_edit','39',1,'Update','','2013-05-19 15:11:29'),(9848,'risk','risk_management_edit','39',1,'Update','','2013-05-19 15:11:38'),(9849,'risk','risk_management_edit','38',1,'Update','','2013-05-19 15:11:46'),(9850,'risk','risk_management_edit','42',1,'Update','','2013-05-19 15:12:15'),(9851,'asset','asset_edit','50',1,'Update','','2013-05-19 15:13:11'),(9852,'bcm','bcm_plans_edit','25',1,'Update','','2013-05-19 15:19:23'),(9853,'bcm','bcm_plans_details_edit','20',1,'Insert','','2013-05-19 15:20:34'),(9854,'bcm','bcm_plans_details_edit','21',1,'Insert','','2013-05-19 15:21:11'),(9855,'bcm','bcm_plans_details_edit','22',1,'Insert','','2013-05-19 15:21:38'),(9856,'bcm','bcm_plans_details_edit','23',1,'Insert','','2013-05-19 15:22:48'),(9857,'bcm','bcm_plans_details_edit','24',1,'Insert','','2013-05-19 15:23:06'),(9858,'bcm','bcm_plans_details_edit','25',1,'Insert','','2013-05-19 15:23:18'),(9859,'bcm','bcm_plans_details_edit','26',1,'Insert','','2013-05-19 15:23:27'),(9860,'bcm','bcm_plans_details_edit','27',1,'Insert','','2013-05-19 15:23:40'),(9861,'bcm','bcm_plans_details_edit','22',1,'Disable','','2013-05-19 15:23:55'),(9862,'bcm','bcm_plans_details_edit','25',1,'Disable','','2013-05-19 15:23:59'),(9863,'bcm','bcm_plans_details_edit','26',1,'Disable','','2013-05-19 15:24:03'),(9864,'bcm','bcm_plans_details_edit','24',1,'Disable','','2013-05-19 15:24:06'),(9865,'bcm','bcm_plans_details_edit','23',1,'Disable','','2013-05-19 15:24:09'),(9866,'operations','project_improvements_edit','3',1,'Disable','','2013-05-19 16:10:16'),(9867,'operations','project_improvements_edit','5',1,'Disable','','2013-05-19 16:10:21'),(9868,'operations','project_improvements_edit','4',1,'Disable','','2013-05-19 16:10:22'),(9869,'operations','project_improvements_edit','4',1,'Disable','','2013-05-19 16:10:24'),(9870,'operations','project_improvements_edit','6',1,'Disable','','2013-05-19 16:10:25'),(9871,'operations','project_improvements_edit','6',1,'Disable','','2013-05-19 16:12:57'),(9872,'operations','project_improvements_edit','7',1,'Disable','','2013-05-19 16:13:00'),(9873,'operations','project_improvements_edit','8',1,'Disable','','2013-05-19 16:13:01'),(9874,'compliance','compliance_finding_edit','6',1,'Update','','2013-05-19 16:15:13'),(9875,'operations','project_improvements_edit','108',1,'Disable','','2013-05-19 21:47:24'),(9876,'operations','project_improvements_edit','108',1,'Disable','','2013-05-19 21:49:19'),(9877,'operations','project_improvements_edit','108',1,'Disable','','2013-05-19 21:50:16'),(9878,'operations','project_improvements_edit','108',1,'Disable','','2013-05-19 21:50:51'),(9879,'operations','project_improvements_edit','110',1,'Update','','2013-05-19 21:54:46'),(9880,'operations','project_improvements_edit','112',1,'Update','','2013-05-19 21:55:10'),(9881,'operations','project_improvements_edit','111',1,'Update','','2013-05-19 21:55:32'),(9882,'operations','project_improvements_edit','118',1,'Update','','2013-05-19 21:56:01'),(9883,'operations','project_improvements_edit','122',1,'Update','','2013-05-19 21:56:31'),(9884,'operations','project_improvements_edit','123',1,'Update','','2013-05-19 21:56:58'),(9885,'operations','project_improvements_edit','124',1,'Update','','2013-05-19 21:57:19'),(9886,'operations','project_improvements_edit','126',1,'Update','','2013-05-19 21:57:36'),(9887,'operations','project_improvements_edit','127',1,'Update','','2013-05-19 21:57:54'),(9888,'operations','project_improvements_edit','129',1,'Update','','2013-05-19 21:58:12'),(9889,'operations','project_improvements_edit','131',1,'Update','','2013-05-19 21:58:29'),(9890,'operations','project_improvements_edit','113',1,'Update','','2013-05-19 21:59:15'),(9891,'operations','project_improvements_edit','114',1,'Update','','2013-05-19 21:59:30'),(9892,'operations','project_improvements_edit','115',1,'Update','','2013-05-19 21:59:49'),(9893,'operations','project_improvements_edit','116',1,'Update','','2013-05-19 22:00:24'),(9894,'operations','project_improvements_edit','117',1,'Update','','2013-05-19 22:00:52'),(9895,'operations','project_improvements_edit','121',1,'Update','','2013-05-19 22:01:22'),(9896,'operations','project_improvements_edit','130',1,'Update','','2013-05-19 22:01:45'),(9897,'operations','project_improvements_edit','132',1,'Update','','2013-05-19 22:02:06'),(9898,'operations','project_improvements_edit','109',1,'Update','','2013-05-19 22:12:56'),(9899,'operations','project_improvements_achievements_edit','1',1,'Insert','','2013-05-20 13:53:51'),(9900,'operations','project_improvements_achievements_edit','2',1,'Insert','','2013-05-20 13:55:29'),(9901,'operations','project_improvements_achievements_edit','3',1,'Insert','','2013-05-20 13:57:30'),(9902,'operations','project_improvements_achievements_edit','4',1,'Insert','','2013-05-20 13:59:44'),(9903,'operations','project_improvements_achievements_edit','',1,'Insert','','2013-05-20 14:00:10'),(9904,'operations','project_improvements_achievements_edit','5',1,'Insert','','2013-05-20 14:00:55'),(9905,'operations','project_improvements_achievements_edit','6',1,'Insert','','2013-05-20 14:01:20'),(9906,'operations','project_improvements_achievements_edit','7',1,'Insert','','2013-05-20 14:01:55'),(9907,'operations','project_improvements_achievements_edit','8',1,'Insert','','2013-05-20 14:02:16'),(9908,'operations','project_improvements_achievements_edit','9',1,'Insert','','2013-05-20 14:07:44'),(9909,'operations','project_improvements_achievements_edit','9',1,'Disable','','2013-05-20 14:17:16'),(9910,'operations','project_improvements_achievements_edit','',1,'Update','','2013-05-20 14:21:20'),(9911,'operations','project_improvements_achievements_edit','0',1,'Update','','2013-05-20 14:21:58'),(9912,'operations','project_improvements_achievements_edit','10',1,'Insert','','2013-05-20 14:22:11'),(9913,'operations','project_improvements','',1,'Export','','2013-05-20 14:30:47'),(9914,'operations','project_improvements_achievements_edit','$',1,'Export','','2013-05-20 14:32:49'),(9915,'operations','project_improvements_achievements_edit','$',1,'Export','','2013-05-20 14:33:45'),(9916,'operations','project_improvements_achievements_edit','$',1,'Export','','2013-05-20 14:35:21'),(9917,'operations','project_improvements_achievements_edit','$',1,'Export','','2013-05-20 14:35:35'),(9918,'operations','project_improvements_achievements_edit','$',1,'Export','','2013-05-20 14:38:30'),(9919,'security_services','security_catalogue_edit','608',1,'Update','','2013-05-20 15:44:18'),(9920,'security_services','security_services_audit_edit','16084',0,'Insert','','2013-05-20 15:44:18'),(9921,'security_services','security_catalogue_edit','595',1,'Update','','2013-05-20 15:46:29'),(9922,'security_services','security_services_audit_edit','16085',0,'Insert','','2013-05-20 15:46:29'),(9923,'security_services','security_services_audit_edit','16086',0,'Insert','','2013-05-20 15:46:29'),(9924,'security_services','security_services_maintenance_edit','14907',0,'Insert','','2013-05-20 15:46:29'),(9925,'security_services','security_catalogue_edit','586',1,'Update','','2013-05-20 15:47:59'),(9926,'security_services','security_services_maintenance_edit','14908',0,'Insert','','2013-05-20 15:47:59'),(9927,'security_services','security_services_maintenance_edit','14909',0,'Insert','','2013-05-20 15:47:59'),(9928,'security_services','security_catalogue_edit','571',1,'Update','','2013-05-20 15:53:55'),(9929,'security_services','security_services_audit_edit','16087',0,'Insert','','2013-05-20 15:53:55'),(9930,'security_services','security_services_audit_edit','16088',0,'Insert','','2013-05-20 15:53:55'),(9931,'security_services','security_services_audit_edit','16089',0,'Insert','','2013-05-20 15:53:55'),(9932,'security_services','security_catalogue_edit','625',1,'Update','','2013-05-20 16:03:31'),(9933,'security_services','security_services_audit_edit','16090',0,'Insert','','2013-05-20 16:03:31'),(9934,'security_services','security_services_audit_edit','16091',0,'Insert','','2013-05-20 16:03:31'),(9935,'security_services','security_services_audit_edit','16092',0,'Insert','','2013-05-20 16:03:31'),(9936,'security_services','security_catalogue_edit','575',1,'Update','','2013-05-20 17:09:59'),(9937,'security_services','security_services_audit_edit','16093',0,'Insert','','2013-05-20 17:09:59'),(9938,'security_services','security_catalogue_edit','580',1,'Update','','2013-05-20 17:11:43'),(9939,'security_services','security_services_audit_edit','16094',0,'Insert','','2013-05-20 17:11:43'),(9940,'security_services','security_services_audit_edit','16095',0,'Insert','','2013-05-20 17:11:43'),(9941,'security_services','security_services_audit_edit','16096',0,'Insert','','2013-05-20 17:11:43'),(9942,'security_services','security_services_audit_edit','16097',0,'Insert','','2013-05-20 17:11:43'),(9943,'security_services','security_services_audit_edit','16098',0,'Insert','','2013-05-20 17:11:43'),(9944,'security_services','security_services_audit_edit','16099',0,'Insert','','2013-05-20 17:11:43'),(9945,'security_services','security_services_audit_edit','16100',0,'Insert','','2013-05-20 17:11:43'),(9946,'security_services','security_services_audit_edit','16101',0,'Insert','','2013-05-20 17:11:43'),(9947,'security_services','security_services_audit_edit','16102',0,'Insert','','2013-05-20 17:11:43'),(9948,'security_services','security_services_audit_edit','16103',0,'Insert','','2013-05-20 17:11:43'),(9949,'security_services','security_catalogue_edit','581',1,'Update','','2013-05-20 17:12:15'),(9950,'security_services','security_services_audit_edit','16104',0,'Insert','','2013-05-20 17:12:15'),(9951,'security_services','security_services_audit_edit','16105',0,'Insert','','2013-05-20 17:12:15'),(9952,'security_services','security_services_audit_edit','16106',0,'Insert','','2013-05-20 17:12:15'),(9953,'security_services','security_services_audit_edit','16107',0,'Insert','','2013-05-20 17:12:15'),(9954,'security_services','security_services_audit_edit','16108',0,'Insert','','2013-05-20 17:12:15'),(9955,'security_services','security_services_audit_edit','16109',0,'Insert','','2013-05-20 17:12:15'),(9956,'security_services','security_services_audit_edit','16110',0,'Insert','','2013-05-20 17:12:15'),(9957,'security_services','security_services_audit_edit','16111',0,'Insert','','2013-05-20 17:12:15'),(9958,'security_services','security_services_audit_edit','16112',0,'Insert','','2013-05-20 17:12:15'),(9959,'security_services','security_services_audit_edit','16113',0,'Insert','','2013-05-20 17:12:15'),(9960,'security_services','security_services_audit_edit','16114',0,'Insert','','2013-05-20 17:12:15'),(9961,'security_services','security_catalogue_edit','580',1,'Update','','2013-05-20 17:19:50'),(9962,'attachments','attachments_list','2',1,'File uploaded: 519a68857d6151.47233155','','2013-05-20 20:16:37'),(9963,'attachments','attachments_list','3',1,'File uploaded: 519a68e87be1c7.55444221','','2013-05-20 20:18:16'),(9964,'attachments','attachments_list','4',1,'File uploaded: 519a6955e5aa34.22786635','','2013-05-20 20:20:05'),(9965,'attachments','attachments_list','5',1,'File uploaded: 519a696f479f77.12459940','','2013-05-20 20:20:31'),(9966,'attachments','attachments_list','6',1,'File uploaded: 519a698bb40e64.26704072','','2013-05-20 20:20:59'),(9967,'attachments','attachments_list','7',1,'File uploaded: 519a69937fc681.15914841','','2013-05-20 20:21:07'),(9968,'attachments','attachments_list','8',1,'File uploaded: 519a6f6bccdd48.63826749','','2013-05-20 20:46:03'),(9969,'attachments','attachments_list','9',1,'File uploaded: 519a6fa187fbd3.38255234','','2013-05-20 20:46:57'),(9970,'attachments','attachments_list','10',1,'File uploaded: 519a6fc79bef48.40449700','','2013-05-20 20:47:35'),(9971,'compliance','compliance_audit_edit','10',1,'Insert','','2013-05-20 20:50:11'),(9972,'attachments','attachments_list','11',1,'File uploaded: 519a706ac8a606.88882899','','2013-05-20 20:50:18'),(9973,'attachments','attachments_list','12',1,'File uploaded: 519a71ab47f7f2.45039915','','2013-05-20 20:55:39'),(9974,'compliance','attachments_edit','',1,'Disable','','2013-05-20 21:03:39'),(9975,'compliance','attachments_edit','',1,'Disable','','2013-05-20 21:07:09'),(9976,'compliance','attachments_edit','',1,'Disable','','2013-05-20 21:11:30'),(9977,'compliance','attachments_edit','',1,'Disable','','2013-05-20 21:11:52'),(9978,'compliance','attachments_edit','12',1,'Disable','','2013-05-20 21:13:03'),(9979,'compliance','attachments_edit','12',1,'Disable','','2013-05-20 21:13:24'),(9980,'compliance','attachments_edit','10',1,'Disable','','2013-05-20 21:14:47'),(9981,'compliance','attachments_edit','9',1,'Disable','','2013-05-20 21:14:48'),(9982,'compliance','attachments_edit','8',1,'Disable','','2013-05-20 21:14:50'),(9983,'attachments','attachments_list','13',1,'File uploaded: 519a7640988ec3.88122021','','2013-05-20 21:15:12'),(9984,'security_services','security_catalogue_edit','616',1,'Update','','2013-05-20 22:41:39'),(9985,'security_services','security_services_audit_edit','16115',0,'Insert','','2013-05-20 22:41:39'),(9986,'security_services','security_catalogue_edit','617',1,'Update','','2013-05-20 22:41:47'),(9987,'security_services','security_catalogue_edit','618',1,'Update','','2013-05-20 22:41:59'),(9988,'security_services','security_catalogue_edit','619',1,'Update','','2013-05-20 22:42:05'),(9989,'security_services','security_catalogue_edit','620',1,'Update','','2013-05-20 22:42:14'),(9990,'security_services','security_services_audit_edit','16116',0,'Insert','','2013-05-20 22:42:14'),(9991,'security_services','security_catalogue_edit','624',1,'Update','','2013-05-20 22:42:22'),(9992,'security_services','security_services_audit_edit','16117',0,'Insert','','2013-05-20 22:42:22'),(9993,'security_services','security_services_audit_edit','16118',0,'Insert','','2013-05-20 22:42:22'),(9994,'security_services','security_catalogue_edit','625',1,'Update','','2013-05-20 22:42:34'),(9995,'security_services','security_catalogue_edit','626',1,'Update','','2013-05-20 22:42:42'),(9996,'security_services','security_services_audit_edit','16119',0,'Insert','','2013-05-20 22:42:42'),(9997,'security_services','security_catalogue_edit','628',1,'Update','','2013-05-20 22:42:51'),(9998,'security_services','security_services_audit_edit','16120',0,'Insert','','2013-05-20 22:42:51'),(9999,'security_services','security_services_audit_edit','16121',0,'Insert','','2013-05-20 22:42:51'),(10000,'security_services','security_services_audit_edit','16122',0,'Insert','','2013-05-20 22:42:51'),(10001,'security_services','security_catalogue_edit','629',1,'Update','','2013-05-20 22:43:09'),(10002,'security_services','security_services_audit_edit','16123',0,'Insert','','2013-05-20 22:43:09'),(10003,'security_services','security_catalogue_edit','631',1,'Update','','2013-05-20 22:43:38'),(10004,'security_services','security_catalogue_edit','632',1,'Update','','2013-05-20 22:43:46'),(10005,'security_services','security_catalogue_edit','633',1,'Update','','2013-05-20 22:43:51'),(10006,'security_services','security_catalogue_edit','634',1,'Update','','2013-05-20 22:44:02'),(10007,'security_services','security_catalogue_edit','635',1,'Update','','2013-05-20 22:44:06'),(10008,'security_services','security_catalogue_edit','636',1,'Update','','2013-05-20 22:44:25'),(10009,'security_services','security_catalogue_edit','637',1,'Update','','2013-05-20 22:44:31'),(10010,'security_services','security_catalogue_edit','638',1,'Update','','2013-05-20 22:44:37'),(10011,'security_services','security_catalogue_edit','639',1,'Update','','2013-05-20 22:44:45'),(10012,'security_services','security_catalogue_edit','641',1,'Update','','2013-05-20 22:44:54'),(10013,'system','system_authorization','',0,'Wrong Login','','2013-05-21 13:59:34'),(10014,'system','system_authorization','',0,'Wrong Login','','2013-05-21 13:59:43'),(10015,'system','system_authorization','',0,'Wrong Login','','2013-05-21 13:59:48'),(10016,'system','system_authorization','',0,'Wrong Login','','2013-05-21 13:59:58'),(10017,'system','system_authorization','',0,'Wrong Login','','2013-05-21 14:00:05'),(10018,'system','system_authorization_edit','1',1,'Login','','2013-05-21 14:00:10'),(10019,'security_services','security_services_audit_edit','16124',0,'Insert','','2013-05-21 14:00:10'),(10020,'security_services','security_services_audit_edit','16125',0,'Insert','','2013-05-21 14:00:10'),(10021,'security_services','security_services_audit_edit','16126',0,'Insert','','2013-05-21 14:00:10'),(10022,'security_services','security_services_audit_edit','16127',0,'Insert','','2013-05-21 14:00:10'),(10023,'security_services','security_services_audit_edit','16128',0,'Insert','','2013-05-21 14:00:10'),(10024,'security_services','security_services_audit_edit','16129',0,'Insert','','2013-05-21 14:00:10'),(10025,'security_services','security_services_audit_edit','16130',0,'Insert','','2013-05-21 14:00:10'),(10026,'security_services','security_services_audit_edit','16131',0,'Insert','','2013-05-21 14:00:10'),(10027,'security_services','security_services_audit_edit','16132',0,'Insert','','2013-05-21 14:00:10'),(10028,'security_services','security_services_audit_edit','16133',0,'Insert','','2013-05-21 14:00:10'),(10029,'security_services','security_services_audit_edit','16134',0,'Insert','','2013-05-21 14:00:10'),(10030,'security_services','security_services_audit_edit','16135',0,'Insert','','2013-05-21 14:00:10'),(10031,'security_services','security_services_audit_edit','16136',0,'Insert','','2013-05-21 14:00:10'),(10032,'security_services','security_services_audit_edit','16137',0,'Insert','','2013-05-21 14:00:10'),(10033,'security_services','security_services_audit_edit','16138',0,'Insert','','2013-05-21 14:00:10'),(10034,'security_services','security_services_audit_edit','16139',0,'Insert','','2013-05-21 14:00:10'),(10035,'security_services','security_services_audit_edit','16140',0,'Insert','','2013-05-21 14:00:10'),(10036,'security_services','security_services_audit_edit','16141',0,'Insert','','2013-05-21 14:00:10'),(10037,'security_services','security_services_audit_edit','16142',0,'Insert','','2013-05-21 14:00:10'),(10038,'security_services','security_services_audit_edit','16143',0,'Insert','','2013-05-21 14:00:10'),(10039,'security_services','security_services_audit_edit','16144',0,'Insert','','2013-05-21 14:00:10'),(10040,'security_services','security_services_audit_edit','16145',0,'Insert','','2013-05-21 14:00:10'),(10041,'security_services','security_services_audit_edit','16146',0,'Insert','','2013-05-21 14:00:10'),(10042,'security_services','security_services_audit_edit','16147',0,'Insert','','2013-05-21 14:00:10'),(10043,'security_services','security_services_audit_edit','16148',0,'Insert','','2013-05-21 14:00:10'),(10044,'security_services','security_services_audit_edit','16149',0,'Insert','','2013-05-21 14:00:10'),(10045,'security_services','security_services_audit_edit','16150',0,'Insert','','2013-05-21 14:00:10'),(10046,'security_services','security_services_audit_edit','16151',0,'Insert','','2013-05-21 14:00:10'),(10047,'security_services','security_services_audit_edit','16152',0,'Insert','','2013-05-21 14:00:10'),(10048,'security_services','security_services_audit_edit','16153',0,'Insert','','2013-05-21 14:00:10'),(10049,'security_services','security_services_audit_edit','16154',0,'Insert','','2013-05-21 14:00:10'),(10050,'security_services','security_services_audit_edit','16155',0,'Insert','','2013-05-21 14:00:10'),(10051,'security_services','security_services_audit_edit','16156',0,'Insert','','2013-05-21 14:00:10'),(10052,'security_services','security_services_audit_edit','16157',0,'Insert','','2013-05-21 14:00:10'),(10053,'security_services','security_services_audit_edit','16158',0,'Insert','','2013-05-21 14:00:10'),(10054,'security_services','security_services_audit_edit','16159',0,'Insert','','2013-05-21 14:00:10'),(10055,'security_services','security_services_audit_edit','16160',0,'Insert','','2013-05-21 14:00:10'),(10056,'security_services','security_services_audit_edit','16161',0,'Insert','','2013-05-21 14:00:10'),(10057,'security_services','security_services_audit_edit','16162',0,'Insert','','2013-05-21 14:00:10'),(10058,'security_services','security_services_audit_edit','16163',0,'Insert','','2013-05-21 14:00:10'),(10059,'security_services','security_services_audit_edit','16164',0,'Insert','','2013-05-21 14:00:10'),(10060,'security_services','security_services_audit_edit','16165',0,'Insert','','2013-05-21 14:00:10'),(10061,'security_services','security_services_audit_edit','16166',0,'Insert','','2013-05-21 14:00:10'),(10062,'security_services','security_services_audit_edit','16167',0,'Insert','','2013-05-21 14:00:10'),(10063,'security_services','security_services_audit_edit','16168',0,'Insert','','2013-05-21 14:00:10'),(10064,'security_services','security_services_audit_edit','16169',0,'Insert','','2013-05-21 14:00:10'),(10065,'security_services','security_services_audit_edit','16170',0,'Insert','','2013-05-21 14:00:10'),(10066,'security_services','security_services_audit_edit','16171',0,'Insert','','2013-05-21 14:00:10'),(10067,'security_services','security_services_audit_edit','16172',0,'Insert','','2013-05-21 14:00:10'),(10068,'security_services','security_services_audit_edit','16173',0,'Insert','','2013-05-21 14:00:10'),(10069,'security_services','security_services_audit_edit','16174',0,'Insert','','2013-05-21 14:00:10'),(10070,'security_services','security_services_audit_edit','16175',0,'Insert','','2013-05-21 14:00:10'),(10071,'security_services','security_services_audit_edit','16176',0,'Insert','','2013-05-21 14:00:10'),(10072,'security_services','security_services_audit_edit','16177',0,'Insert','','2013-05-21 14:00:10'),(10073,'security_services','security_services_audit_edit','16178',0,'Insert','','2013-05-21 14:00:10'),(10074,'security_services','security_services_audit_edit','16179',0,'Insert','','2013-05-21 14:00:10'),(10075,'security_services','security_services_audit_edit','16180',0,'Insert','','2013-05-21 14:00:10'),(10076,'security_services','security_services_audit_edit','16181',0,'Insert','','2013-05-21 14:00:10'),(10077,'security_services','security_services_audit_edit','16182',0,'Insert','','2013-05-21 14:00:10'),(10078,'security_services','security_services_audit_edit','16183',0,'Insert','','2013-05-21 14:00:10'),(10079,'security_services','security_services_audit_edit','16184',0,'Insert','','2013-05-21 14:00:10'),(10080,'security_services','security_services_audit_edit','16185',0,'Insert','','2013-05-21 14:00:10'),(10081,'security_services','security_services_audit_edit','16186',0,'Insert','','2013-05-21 14:00:10'),(10082,'security_services','security_services_audit_edit','16187',0,'Insert','','2013-05-21 14:00:10'),(10083,'security_services','security_services_audit_edit','16188',0,'Insert','','2013-05-21 14:00:10'),(10084,'security_services','security_services_audit_edit','16189',0,'Insert','','2013-05-21 14:00:10'),(10085,'security_services','security_services_audit_edit','16190',0,'Insert','','2013-05-21 14:00:10'),(10086,'security_services','security_services_audit_edit','16191',0,'Insert','','2013-05-21 14:00:10'),(10087,'security_services','security_services_audit_edit','16192',0,'Insert','','2013-05-21 14:00:10'),(10088,'security_services','security_services_audit_edit','16193',0,'Insert','','2013-05-21 14:00:11'),(10089,'security_services','security_services_audit_edit','16194',0,'Insert','','2013-05-21 14:00:11'),(10090,'security_services','security_services_audit_edit','16195',0,'Insert','','2013-05-21 14:00:11'),(10091,'security_services','security_services_audit_edit','16196',0,'Insert','','2013-05-21 14:00:11'),(10092,'security_services','security_services_audit_edit','16197',0,'Insert','','2013-05-21 14:00:11'),(10093,'security_services','security_services_audit_edit','16198',0,'Insert','','2013-05-21 14:00:11'),(10094,'security_services','security_services_audit_edit','16199',0,'Insert','','2013-05-21 14:00:11'),(10095,'security_services','security_services_audit_edit','16200',0,'Insert','','2013-05-21 14:00:11'),(10096,'security_services','security_services_audit_edit','16201',0,'Insert','','2013-05-21 14:00:11'),(10097,'system','system_authorization','',0,'Wrong Login','','2013-05-22 19:09:50'),(10098,'system','system_authorization','',0,'Wrong Login','','2013-05-22 19:09:57'),(10099,'system','system_authorization','',0,'Wrong Login','','2013-05-22 19:10:05'),(10100,'system','system_authorization','',0,'Wrong Login','','2013-05-22 19:10:10'),(10101,'system','system_authorization','',0,'Wrong Login','','2013-05-22 19:10:16'),(10102,'system','system_authorization','',0,'Wrong Login','','2013-05-22 19:10:21'),(10103,'system','system_authorization','',0,'Wrong Login','','2013-05-22 19:10:26'),(10104,'system','system_authorization_edit','1',1,'Login','','2013-05-22 19:10:29'),(10105,'security_services','security_services_audit_edit','16202',0,'Insert','','2013-05-22 19:10:29'),(10106,'security_services','security_services_audit_edit','16203',0,'Insert','','2013-05-22 19:10:29'),(10107,'security_services','security_services_audit_edit','16204',0,'Insert','','2013-05-22 19:10:29'),(10108,'security_services','security_services_audit_edit','16205',0,'Insert','','2013-05-22 19:10:29'),(10109,'security_services','security_services_audit_edit','16206',0,'Insert','','2013-05-22 19:10:29'),(10110,'security_services','security_services_audit_edit','16207',0,'Insert','','2013-05-22 19:10:29'),(10111,'security_services','security_services_audit_edit','16208',0,'Insert','','2013-05-22 19:10:29'),(10112,'security_services','security_services_audit_edit','16209',0,'Insert','','2013-05-22 19:10:29'),(10113,'security_services','security_services_audit_edit','16210',0,'Insert','','2013-05-22 19:10:29'),(10114,'security_services','security_services_audit_edit','16211',0,'Insert','','2013-05-22 19:10:30'),(10115,'security_services','security_services_audit_edit','16212',0,'Insert','','2013-05-22 19:10:30'),(10116,'security_services','security_services_audit_edit','16213',0,'Insert','','2013-05-22 19:10:30'),(10117,'security_services','security_services_audit_edit','16214',0,'Insert','','2013-05-22 19:10:30'),(10118,'security_services','security_services_audit_edit','16215',0,'Insert','','2013-05-22 19:10:30'),(10119,'security_services','security_services_audit_edit','16216',0,'Insert','','2013-05-22 19:10:30'),(10120,'security_services','security_services_audit_edit','16217',0,'Insert','','2013-05-22 19:10:30'),(10121,'security_services','security_services_audit_edit','16218',0,'Insert','','2013-05-22 19:10:30'),(10122,'security_services','security_services_audit_edit','16219',0,'Insert','','2013-05-22 19:10:30'),(10123,'security_services','security_services_audit_edit','16220',0,'Insert','','2013-05-22 19:10:30'),(10124,'security_services','security_services_audit_edit','16221',0,'Insert','','2013-05-22 19:10:30'),(10125,'security_services','security_services_audit_edit','16222',0,'Insert','','2013-05-22 19:10:30'),(10126,'security_services','security_services_audit_edit','16223',0,'Insert','','2013-05-22 19:10:30'),(10127,'security_services','security_services_audit_edit','16224',0,'Insert','','2013-05-22 19:10:30'),(10128,'security_services','security_services_audit_edit','16225',0,'Insert','','2013-05-22 19:10:30'),(10129,'security_services','security_services_audit_edit','16226',0,'Insert','','2013-05-22 19:10:30'),(10130,'security_services','security_services_audit_edit','16227',0,'Insert','','2013-05-22 19:10:30'),(10131,'security_services','security_services_audit_edit','16228',0,'Insert','','2013-05-22 19:10:30'),(10132,'security_services','security_services_audit_edit','16229',0,'Insert','','2013-05-22 19:10:30'),(10133,'security_services','security_services_audit_edit','16230',0,'Insert','','2013-05-22 19:10:30'),(10134,'security_services','security_services_audit_edit','16231',0,'Insert','','2013-05-22 19:10:30'),(10135,'security_services','security_services_audit_edit','16232',0,'Insert','','2013-05-22 19:10:30'),(10136,'security_services','security_services_audit_edit','16233',0,'Insert','','2013-05-22 19:10:30'),(10137,'security_services','security_services_audit_edit','16234',0,'Insert','','2013-05-22 19:10:30'),(10138,'security_services','security_services_audit_edit','16235',0,'Insert','','2013-05-22 19:10:30'),(10139,'security_services','security_services_audit_edit','16236',0,'Insert','','2013-05-22 19:10:30'),(10140,'security_services','security_services_audit_edit','16237',0,'Insert','','2013-05-22 19:10:30'),(10141,'security_services','security_services_audit_edit','16238',0,'Insert','','2013-05-22 19:10:30'),(10142,'security_services','security_services_audit_edit','16239',0,'Insert','','2013-05-22 19:10:30'),(10143,'security_services','security_services_audit_edit','16240',0,'Insert','','2013-05-22 19:10:30'),(10144,'security_services','security_services_audit_edit','16241',0,'Insert','','2013-05-22 19:10:30'),(10145,'security_services','security_services_audit_edit','16242',0,'Insert','','2013-05-22 19:10:30'),(10146,'security_services','security_services_audit_edit','16243',0,'Insert','','2013-05-22 19:10:30'),(10147,'security_services','security_services_audit_edit','16244',0,'Insert','','2013-05-22 19:10:30'),(10148,'security_services','security_services_audit_edit','16245',0,'Insert','','2013-05-22 19:10:30'),(10149,'security_services','security_services_audit_edit','16246',0,'Insert','','2013-05-22 19:10:30'),(10150,'security_services','security_services_audit_edit','16247',0,'Insert','','2013-05-22 19:10:30'),(10151,'security_services','security_services_audit_edit','16248',0,'Insert','','2013-05-22 19:10:30'),(10152,'security_services','security_services_audit_edit','16249',0,'Insert','','2013-05-22 19:10:30'),(10153,'security_services','security_services_audit_edit','16250',0,'Insert','','2013-05-22 19:10:30'),(10154,'security_services','security_services_audit_edit','16251',0,'Insert','','2013-05-22 19:10:30'),(10155,'security_services','security_services_audit_edit','16252',0,'Insert','','2013-05-22 19:10:30'),(10156,'security_services','security_services_audit_edit','16253',0,'Insert','','2013-05-22 19:10:30'),(10157,'security_services','security_services_audit_edit','16254',0,'Insert','','2013-05-22 19:10:30'),(10158,'security_services','security_services_audit_edit','16255',0,'Insert','','2013-05-22 19:10:30'),(10159,'security_services','security_services_audit_edit','16256',0,'Insert','','2013-05-22 19:10:30'),(10160,'security_services','security_services_audit_edit','16257',0,'Insert','','2013-05-22 19:10:30'),(10161,'security_services','security_services_audit_edit','16258',0,'Insert','','2013-05-22 19:10:30'),(10162,'security_services','security_services_audit_edit','16259',0,'Insert','','2013-05-22 19:10:30'),(10163,'security_services','security_services_audit_edit','16260',0,'Insert','','2013-05-22 19:10:30'),(10164,'security_services','security_services_audit_edit','16261',0,'Insert','','2013-05-22 19:10:30'),(10165,'security_services','security_services_audit_edit','16262',0,'Insert','','2013-05-22 19:10:30'),(10166,'security_services','security_services_audit_edit','16263',0,'Insert','','2013-05-22 19:10:30'),(10167,'security_services','security_services_audit_edit','16264',0,'Insert','','2013-05-22 19:10:30'),(10168,'security_services','security_services_audit_edit','16265',0,'Insert','','2013-05-22 19:10:30'),(10169,'security_services','security_services_audit_edit','16266',0,'Insert','','2013-05-22 19:10:30'),(10170,'security_services','security_services_audit_edit','16267',0,'Insert','','2013-05-22 19:10:30'),(10171,'security_services','security_services_audit_edit','16268',0,'Insert','','2013-05-22 19:10:30'),(10172,'security_services','security_services_audit_edit','16269',0,'Insert','','2013-05-22 19:10:30'),(10173,'security_services','security_services_audit_edit','16270',0,'Insert','','2013-05-22 19:10:30'),(10174,'security_services','security_services_audit_edit','16271',0,'Insert','','2013-05-22 19:10:30'),(10175,'security_services','security_services_audit_edit','16272',0,'Insert','','2013-05-22 19:10:30'),(10176,'security_services','security_services_audit_edit','16273',0,'Insert','','2013-05-22 19:10:30'),(10177,'security_services','security_services_audit_edit','16274',0,'Insert','','2013-05-22 19:10:30'),(10178,'security_services','security_services_audit_edit','16275',0,'Insert','','2013-05-22 19:10:30'),(10179,'security_services','security_services_audit_edit','16276',0,'Insert','','2013-05-22 19:10:30'),(10180,'security_services','security_services_audit_edit','16277',0,'Insert','','2013-05-22 19:10:30'),(10181,'security_services','security_services_audit_edit','16278',0,'Insert','','2013-05-22 19:10:30'),(10182,'security_services','security_services_audit_edit','16279',0,'Insert','','2013-05-22 19:10:30');
/*!40000 ALTER TABLE `system_records_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `system_users_tbl`
--

DROP TABLE IF EXISTS `system_users_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `system_users_tbl` (
  `system_users_id` int(11) NOT NULL AUTO_INCREMENT,
  `system_users_name` varchar(45) DEFAULT NULL,
  `system_users_surname` varchar(45) DEFAULT NULL,
  `system_users_group_role_id` int(11) DEFAULT NULL,
  `system_users_login` varchar(45) DEFAULT NULL,
  `system_users_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`system_users_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `system_users_tbl`
--

LOCK TABLES `system_users_tbl` WRITE;
/*!40000 ALTER TABLE `system_users_tbl` DISABLE KEYS */;
INSERT INTO `system_users_tbl` VALUES (1,'System','Administrator',-1,'admin',0);
/*!40000 ALTER TABLE `system_users_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
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
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tiv_vuln_tbl`
--

LOCK TABLES `tiv_vuln_tbl` WRITE;
/*!40000 ALTER TABLE `tiv_vuln_tbl` DISABLE KEYS */;
INSERT INTO `tiv_vuln_tbl` VALUES (1,'Nature and Accidents','Seismic Areas',0),(2,'Nature and Accidents','Flooding Prone Areas',0),(3,'Nature and Accidents','Loose of Energy',0),(4,'Nature and Accidents','Warm Climate',0),(5,'Nature and Accidents','Cold Climate',0),(6,'Nature and Accidents','Ice',0),(7,'Nature and Accidents','Tornados',0),(8,'Nature and Accidents','Hurricane',0),(9,'Current and Past Employees','Intentional Theft',0),(10,'Current and Past Employees','Creeping Accounts',0),(11,'Current and Past Employees','Weak Check-Out Process',0),(12,'Current and Past Employees','Complot',0),(13,'Current and Past Employees','Employee Rotation',0),(14,'Current and Past Employees','Lack of Segregation of Duties',0),(30,'Criminals','Complot',0),(31,'Criminals','Intellectual Property Theft',0),(40,'The Press','Reputational Issues',0),(43,'Hacking','Weak Systems',0),(44,'Hacking','Lack of Patching',0),(45,'Hacking','Creeping Accounts',0),(46,'Hacking','Weak Passwords',0),(47,'Hacking','Weak Authetication Systems',0),(48,'Hacking','Lack of Account Reviews',0),(49,'Hacking','Lack of Anti-Virus',0),(50,'Hacking','Lack of Processes',0),(51,'Hacking','Weak Change Management',0),(52,'Hacking','Weak Authorization Systems',0),(53,'Hacking','Web-Application Vulnerabilities',0),(54,'Hacking','Wrong Configurations',0),(55,'Hacking','Open Network Ports',0),(56,'Hacking','Weak Encryption',0),(57,'Hacking','Weak Security Awareness',0),(58,'Hacking','Lack of Integrity Checks',0),(59,'Hacking','Social Engineering',0),(65,'Current and Past Employees','Unintentional Theft',0),(66,'Current and Past Employees','Unintentional Loss',0),(67,'Current and Past Employees','Unintentional Disclosure of Information',0),(68,'Criminals','Intentional Disclosure of Information',0),(75,'Governments','Counter-Intelligence',0);
/*!40000 ALTER TABLE `tiv_vuln_tbl` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `tp_risk_tbl`
--

DROP TABLE IF EXISTS `tp_risk_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tp_risk_tbl` (
  `tp_risk_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `tp_risk_title` varchar(100) NOT NULL,
  `tp_risk_threat` text NOT NULL,
  `tp_risk_vulnerabilities` text NOT NULL,
  `tp_risk_why` text NOT NULL,
  `tp_risk_how` text NOT NULL,
  `tp_risk_whom` text NOT NULL,
  `tp_risk_classification_score` int(11) NOT NULL,
  `tp_risk_mitigation_strategy_id` int(11) NOT NULL,
  `tp_risk_periodicity_review` date NOT NULL,
  `tp_risk_residual_score` int(11) NOT NULL,
  `tp_risk_disabled` int(11) NOT NULL DEFAULT '1',
  PRIMARY KEY (`tp_risk_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `tp_tbl`
--

DROP TABLE IF EXISTS `tp_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tp_tbl` (
  `tp_id` int(11) NOT NULL AUTO_INCREMENT,
  `tp_name` varchar(100) DEFAULT NULL,
  `tp_description` text,
  `tp_type_id` int(11) DEFAULT NULL,
  `tp_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`tp_id`)
) ENGINE=InnoDB AUTO_INCREMENT=53 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;


--
-- Table structure for table `tp_type_tbl`
--

DROP TABLE IF EXISTS `tp_type_tbl`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `tp_type_tbl` (
  `tp_type_id` int(11) NOT NULL AUTO_INCREMENT,
  `tp_type_name` varchar(100) DEFAULT NULL,
  `tp_type_disabled` int(11) DEFAULT '1',
  PRIMARY KEY (`tp_type_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `tp_type_tbl`
--

LOCK TABLES `tp_type_tbl` WRITE;
/*!40000 ALTER TABLE `tp_type_tbl` DISABLE KEYS */;
INSERT INTO `tp_type_tbl` VALUES (1,'Customers',0),(2,'Suppliers',0),(3,'Regulators',0);
/*!40000 ALTER TABLE `tp_type_tbl` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2013-05-22 19:40:12
