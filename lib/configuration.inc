<?php

# cant touch this! (mc-hammer stuff)
$system_conf['app_version'] = "1.1";
$system_conf['license_number'] = "GPL v2";
$system_conf['debug'] = 1;
$system_conf['timezone'] = "America/Los_Angeles";

# HIGH RISK OPTION, DONT ENABLE UNLESS:
# YOU HAVE PROTECTED DOWNLOADS/UPLOADS/ DIRECTORY
# IMPORTANT !
 $system_conf['permit_uploads'] = "True";
# $system_conf['permit_uploads'] = NULL;

# you must define this database parameters
$db_conf['db_hostname'] = "localhost";
$db_conf['db_name'] = "globant_prod_v11";
$db_conf['db_username'] = "root";
$db_conf['db_password'] = "";

# optional, define your currency.
$services_conf['system_currency'] = "$";

# lpdap auth .. change NULL for "True" if you want to use ldap for authentcation
$ldap['auth_with_ldap'] = "True";
$ldap['ldap_dn'] = "CN=Users,DC=corp,DC=eramba,DC=org";
$ldap['usr_dom'] = "@corp.eramba.org";
$ldap['ldap_server'] = "192.168.1.50";

# Mail configuration
# Do you want to send emails? set this to "true" .. otehrwuse set it to NULL
$mail_conf['send_emails'] = "true";
#$mail_conf['send_emails'] = NULL;

# If you set "smtp_server" with something different to "NULL" he will try to send the email trough this server
# If you set "smtp_server" to NULL, then he will try to send the email with the local sendmail (should work by default on most linux, unix, mac).
$mail_conf['smtp_server'] = "";
$mail_conf['smtp_port'] = "25";
$mail_conf['smtp_username'] = "";
$mail_conf['smtp_password'] = "";

# all mails sent should which source email address 
$mail_conf['mail_source_address'] = "eramba@eramba.org";
# all mails sent should which source email name and surname 
$mail_conf['mail_source_name'] = "eramba system";

# the calendar can also send email notifications .. you need to specify 
# to which email i send emails for each type of calendar event
$mail_enabled_for['risk_exception_edit'] = "kisero@gmail.com";
$mail_enabled_for['risk_management_edit'] = "kisero@gmail.com";
$mail_enabled_for['risk_tp_edit'] = "kisero@gmail.com";
$mail_enabled_for['risk_buss_edit'] = "kisero@gmail.com";
$mail_enabled_for['compliance_exception_edit'] = "kisero@gmail.com";
$mail_enabled_for['compliance_finding_edit'] = "kisero@gmail.com";
$mail_enabled_for['compliance_audit_edit'] = "kisero@gmail.com";
$mail_enabled_for['policy_exceptions_edit'] = "kisero@gmail.com";
$mail_enabled_for['project_improvements_edit'] = "kisero@gmail.com";
$mail_enabled_for['security_incident_edit'] = "kisero@gmail.com";
$mail_enabled_for['service_contracts_edit'] = "kisero@gmail.com";
$mail_enabled_for['security_services_audit_edit'] = "kisero@gmail.com";
$mail_enabled_for['security_services_maintenance_edit'] = "kisero@gmail.com";

# define how many days in advance you want to receive an email notification about a calendar item
$mail_enabled_for['warning_days_advance'] = "3";

# automatic risk score calculation?
$risk_conf['automatic_calculator_risk_score'] = "True";

?>
