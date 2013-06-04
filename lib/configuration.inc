<?php

# cant touch this! (mc-hammer stuff)
$system_conf['app_version'] = "1.1";
$system_conf['license_number'] = "GPL v2";
$system_conf['debug'] = 1;
$system_conf['timezone'] = "America/Los_Angeles";

$system_conf['source_email'] = "";
$system_conf['mail_server'] = "";
$system_conf['mail_tag'] = "";

# HIGH RISK OPTION, DONT ENABLE UNLESS:
# YOU HAVE PROTECTED DOWNLOADS/UPLOADS/ DIRECTORY
# IMPORTANT !
$system_conf['permit_uploads'] = NULL;

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

# when should i send emails?
$mail_enabled_for['risk_exceptions'] = "email@email.com";

?>
