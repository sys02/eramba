<?

date_default_timezone_set('Europe/Bratislava');

function give_me_this_month() {
	
	$unix_time = time();	
	$date = date('m', $unix_time); 
	return $date;
}

function give_me_this_year() {
	
	$unix_time = time();	
	$date = date('Y', $unix_time); 
	return $date;
}

function give_me_date() {
	
	$unix_time = time();	
	$date = date('Y-m-d', $unix_time); 
	return $date;
}

function give_me_date_time() {
	
	$unix_time = time();	
	$datetime = date('Y-m-d H:i:s', $unix_time); 
	return $datetime;
}

function check_valid_date($date) {
	$split_date = explode("-"  , $date);
	#echo "DATE: $split_date[1] - $split_date[2] - $split_date[0]";
	if (!is_numeric($split_date[0]) or !is_numeric($split_date[1]) or !is_numeric($split_date[2])) {
		#echo "wrong date";
		return 1;
	}
	if( !checkdate($split_date[1], $split_date[2], $split_date[0]) ) {
		#echo "wrong date";
		return 1;
	}
	#echo "date ok";
	return;
}

/* <li><a href="?section=organization&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "organization")?>>Organization</a></li> */
function show_menu_main() {
	$user_access = getUserAccess();

	$query = "SELECT * FROM `system_authorization_tbl` WHERE `system_authorization_action_type`='r' ORDER BY `system_authorization_order`";

	$result = mysql_query($query);
	if (!$result) {
		die("Invalid query (runQuery) ($query): " . mysql_error());
	}

	if (mysql_num_rows($result) > 0) {
		$used_section = '';
		while($row = mysql_fetch_assoc($result)) {

			if ($used_section != $row['system_authorization_section_name']) {
				if ( (!is_array($user_access) && $user_access == 'admin') || (is_array($user_access) && in_array($row['system_authorization_id'], $user_access)) ) {
					echo '<li><a href="?section='.$row['system_authorization_section_name'].'&subsection=dashboard" ' . (is_this_menu_active(@$_GET["section"], $row['system_authorization_section_name'])) . '>'.$row['system_authorization_section_cute_name'].'</a></li>';
					$used_section = $row['system_authorization_section_name'];
				}
			}
		}
	}

}

function show_menu_sub($section) {

	$user_access = getUserAccess();
	
	$query = "SELECT * FROM `system_authorization_tbl` WHERE `system_authorization_section_name`='" . $section . "' AND `system_authorization_action_type`='r' AND `system_authorization_subsection_submenu`=1";

	$result = mysql_query($query);
	if (!$result) {
		die("Invalid query (runQuery) ($query): " . mysql_error());
	}
	
	//$sub_menu = array();

	if (mysql_num_rows($result) > 0) {
		while($row = mysql_fetch_assoc($result)) {
			if ( (!is_array($user_access) && $user_access == 'admin') || (is_array($user_access) && in_array($row['system_authorization_id'], $user_access)) ) {
				echo "<li><a href=\"?section=" . $section . "&subsection=" . $row['system_authorization_subsection_name'] . "\">" . $row['system_authorization_subsection_cute_name'] . "</a></li>";
			}
		}
	}

}

function is_this_menu_active($section_received, $section) {
	
	if ($section_received == $section) {
		return "class=\"active\"";	
	}
	return;
}

function build_base_url($section,$subsection) {
	return "?section=".$section."&subsection=".$subsection."";	
}

function shorten_string($string, $limit = 100) {
    if(strlen($string) < $limit) {return $string;}
    $regex = "/(.{1,$limit})\b/";
    preg_match($regex, $string, $matches);
    return $matches[1];
}

function local_domain() {
	return "".$_SERVER["SERVER_NAME"]."/isms_v2";
}

/**
 * Reads data from database about what file needs to be included
 * @return [type] [description]
 */
function include_from_db($section = null, $subsection = 'dashboard', $action = 'list') {
	if ( $action == 'update' )
		$action = 'list';


#	$query = runSmallQuery( 
#		"SELECT * FROM `system_authorization_tbl` WHERE 
#		`system_authorization_section_name`='" . $section . "' AND 
#		`system_authorization_subsection_name`='" . $subsection . "' AND 
#		`system_authorization_action_name`='" . $action . "' AND 
#		`system_authorization_disabled`=0" 
#	);
	
	$query = runSmallQuery( 
		"SELECT * FROM `system_authorization_tbl` WHERE 
		`system_authorization_section_name`='" . $section . "' AND 
		`system_authorization_subsection_name`='" . $subsection . "' AND 
		`system_authorization_disabled`=0" 
	);

	echo '<pre>';
	# print_r($query);
	echo '</pre>';
	
	$user_access = getUserAccess();

	if ( $section == null ) {
		include_once( 'default_landpage.php' );
	}
	else if ( (!is_array($user_access) && $user_access == 'admin') || (is_array($user_access) && in_array($query['system_authorization_id'], $user_access)) ) {
		include_once( $query['system_authorization_target_url'] );
	}
	else if ($subsection != "dashboard") {
		include_once( 'tpl/permissions_error.php' );
	}
}


function getUserAccess() {
	$logged_user_data = runSmallQuery( 
		"SELECT * FROM `system_users_tbl` WHERE 
		`system_users_id`='" . $_SESSION['logged_user_id'] . "'"
	);

	if ( $logged_user_data['system_users_group_role_id'] == -1 ) {
		return 'admin';
	}

	$query = "SELECT `system_authorization_group_auth_id` FROM `system_authorization_group_role_join` WHERE `system_authorization_group_role_role_id`='" . $logged_user_data['system_users_group_role_id'] . "'";

	$result = mysql_query($query);
	if (!$result) {
		die("Invalid query (runQuery) ($query): " . mysql_error());
	}
	
	$system_authorization_roles = array();

	if (mysql_num_rows($result) > 0) {
		while($row = mysql_fetch_assoc($result)) 
		array_push($system_authorization_roles, $row['system_authorization_group_auth_id']);
	}

	return $system_authorization_roles;
}

function error_message($error_text, $error_code) { 

echo "<div id=\"centerbox-page-wrapper\" class=\"error\">";
echo "	<div id=\"centerbox-page-overlay\">";
echo "	</div>";
echo "";
echo "	<div id=\"centerbox-page-content\">";
echo "		<div class=\"error-top\">";
echo "			Error $error_code";
echo "		</div>";
echo "		<div class=\"error-bottom\">";
echo "			<p>($error_code) - $error_text</p>";
echo "			<p><a href=\"#\" class=\"goback\" onclick=\"history.go(-1);return false;\">Go back</a></p>";
echo "		</div>";
echo "	</div>";
echo "</div>";


}

function validate_section_subsection($section,$subsection) {

	$section_list = array("organization","system","asset","risk","security_services","compliance","operations","home","bcm");	

	$subsection_list = array("system_records_list","system_authorization_list","system_roles_list","system_records_edit","system_authorization_edit","system_roles_edit","bu_list","bu_edit","legal_list","legal_edit","tp_list","tp_edit","asset_classification_list","asset_classification_edit","asset_list","asset_edit","data_asset_list","data_asset_edit","risk_classification_list","risk_classification_edit","risk_management_list","risk_management_edit","risk_exception_list","risk_exception_edit","security_catalogue_list","security_catalogue_edit","security_services_audit_edit","service_contracts_list","service_contracts_edit","compliance_package_list","compliance_package_edit","compliance_package_item_edit","compliance_package_upload","compliance_management_list","compliance_management_step_two","compliance_management_edit","compliance_management","compliance_exception_list","compliance_exception_edit","project_improvements_list","security_incident_edit","security_incident_list","process_edit","dashboard","security_incident_classification_list","security_incident_classification_edit","policy_exceptions_list","policy_exceptions_edit","system_info","risk_tp_list","risk_tp_edit","project_improvements_edit","asset_label_list","asset_label_edit","risk_buss_list","risk_buss_edit","bcm_plans_list","bcm_plans_edit","bcm_plans_audit_edit","bcm_plans_audit_report","security_services_audit_report","bcm_plans_details_edit","project_improvements_expenses_edit","project_improvements_expenses_list","security_services_maintenance_edit","security_services_maintenance_list");


	#echo "$section and $subsection";

	if ($section) {
		if (in_array($section, $section_list)) {
			#echo "ok sec";
			return $section;
		} else {
			#echo "!ok sec";
			return NULL;
		}
	}
	
	if ($subsection) {
		if (in_array($subsection, $subsection_list)) {
			#echo "ok sub";
			return $subsection;
		} else {
			#echo "!ok sec";
			return NULL;
		}
	}
	
}

function download_export( $file_name ) {
	ignore_user_abort(true);

	$file = 'downloads/' . $file_name . '.csv';

	header('Content-Description: File Transfer');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename=' . basename( $file ));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize( $file ));
	ob_clean();
	flush();
	readfile( realpath( $file ) );

	unlink( $file );
	
	if (connection_aborted()) {
		unlink($f);
	}

	exit;
}

?>
