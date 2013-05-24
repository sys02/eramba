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
$system_conf['permit_uploads'] = "";

# you must define this 
$sytem_conf['ad_dn'] = "";

# you must define this
$db_conf['db_hostname'] = "localhost";
$db_conf['db_name'] = "eramba_prod_v11";
$db_conf['db_username'] = "root";
$db_conf['db_password'] = "";

# optional, define your currency.
$services_conf['system_currency'] = "$";

# set this to True or False 
$risk_conf['use_eramba_formulas'] = "True";

?>
