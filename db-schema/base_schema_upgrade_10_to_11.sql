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

