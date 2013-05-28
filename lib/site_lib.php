<?

date_default_timezone_set('Europe/Bratislava');

include_once("lib/risk_lib.php");
include_once("lib/risk_tp_join_lib.php");
include_once("lib/risk_buss_process_join_lib.php");
include_once("lib/risk_exception_lib.php");
include_once("lib/attachments_lib.php");

include_once("lib/compliance_audit_lib.php");
include_once("lib/compliance_finding_lib.php");
include_once("lib/compliance_exception_lib.php");

include_once("lib/project_improvements_lib.php");
include_once("lib/security_incident_lib.php");
include_once("lib/policy_exceptions_lib.php");

include_once("lib/security_services_lib.php");
include_once("lib/service_contracts_lib.php");

include_once("lib/security_services_catalogue_audit_calendar_join_lib.php");
include_once("lib/security_services_catalogue_maintenance_calendar_join_lib.php");

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

	$section_list = array("organization","system","asset","risk","security_services","compliance","operations","calendar","bcm","attachments");	

	$subsection_list = array("system_records_list","system_authorization_list","system_roles_list","system_records_edit","system_authorization_edit","system_roles_edit","bu_list","bu_edit","legal_list","legal_edit","tp_list","tp_edit","asset_classification_list","asset_classification_edit","asset_list","asset_edit","data_asset_list","data_asset_edit","risk_classification_list","risk_classification_edit","risk_management_list","risk_management_edit","risk_exception_list","risk_exception_edit","security_catalogue_list","security_catalogue_edit","security_services_audit_edit","service_contracts_list","service_contracts_edit","compliance_package_list","compliance_package_edit","compliance_package_item_edit","compliance_package_upload","compliance_management_list","compliance_management_step_two","compliance_management_edit","compliance_management","compliance_exception_list","compliance_exception_edit","project_improvements_list","security_incident_edit","security_incident_list","process_edit","dashboard","security_incident_classification_list","security_incident_classification_edit","policy_exceptions_list","policy_exceptions_edit","system_info","risk_tp_list","risk_tp_edit","project_improvements_edit","asset_label_list","asset_label_edit","risk_buss_list","risk_buss_edit","bcm_plans_list","bcm_plans_edit","bcm_plans_audit_edit","bcm_plans_audit_report","security_services_audit_report","bcm_plans_details_edit","project_improvements_expenses_edit","project_improvements_expenses_list","security_services_maintenance_edit","security_services_maintenance_list","compliance_audit_list","compliance_audit_edit","compliance_finding_list","compliance_finding_edit","attachments_edit","attachments_list","security_services_classification_list", "security_services_classification_edit","security_services_analysis_list","project_improvements_achievements_edit","project_improvements_achievements_list");


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

function download_attachment( $file_name ) {

	# i need to search the original name of the file
	$attachment_info = lookup_attachments("attachments_unique_name", $file_name);
	if (empty($attachment_info[attachments_original_name])) {
		exit;
	}

	ignore_user_abort(true);

	$file = 'downloads/uploads/'.$file_name.'';

	header('Content-Description: File Transfer');
	header('Content-Type: text/csv');
	header('Content-Disposition: attachment; filename=' . basename( $attachment_info[attachments_original_name]));
	header('Content-Transfer-Encoding: binary');
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: ' . filesize( $file ));
	ob_clean();
	flush();
	readfile( realpath( $file ) );

	#unlink( $file );
	
	if (connection_aborted()) {
		unlink($f);
	}

	exit;
}

function create_Calendar($month,$year) {

date_default_timezone_set('America/Los_Angeles');

		$this_year = give_me_this_year();
		
		# RED are risk stuff
		# - Risk Review Periodicity
	$risk_asset_review = array();
	$risk_asset_list = list_distinct_risk_asset_join("");
	foreach($risk_asset_list as $risk_asset_item) {
		$risk_asset_data = lookup_risk("risk_id",$risk_asset_item[risk_asset_join_risk_id]);
		array_push($risk_asset_review, $risk_asset_data);
	}
	
	$risk_tp_review = array();
	$risk_tp_list = list_risk_tp_join("");
	foreach($risk_tp_list as $risk_tp_item) {
		$risk_tp_data = lookup_risk("risk_id",$risk_tp_item[risk_tp_join_risk_id]);
		array_push($risk_tp_review, $risk_tp_data);
	}
	
	$risk_buss_review = array();
	$risk_buss_list = list_risk_buss_process_join("");
	foreach($risk_buss_list as $risk_buss_item) {
		$risk_buss_data = lookup_risk("risk_id",$risk_buss_item[risk_buss_process_join_risk_id]);
		array_push($risk_buss_review, $risk_buss_data);
	}

		# - Risk Exception Expiration
	$risk_exception = list_risk_exception(" WHERE YEAR(risk_exception_expiration) = $this_year AND risk_exception_disabled = \"0\" "); 
		
		# GREEN are service stuff
		# - Regular Review (is a month, not an exact date)  
	$control_audit = list_security_services_catalogue_audit_calendar_join("");

	$control_audit_updated = array();
	foreach($control_audit as $control_audit_item) {
		$control_audit_random_time = rand( strtotime("1-$control_audit_item[security_services_audit_calendar_id]-$this_year"), strtotime("28-$control_audit_item[security_services_audit_calendar_id]-$this_year"));	
		$control_audit_random_day_string = date("Y-m-d", $control_audit_random_time);
		# debug
		# echo "New Random Day: $control_audit_random_day_string vs $control_audit_item[security_services_audit_calendar_id]<br>";
		$tmp_array = array(control_id => $control_audit_item[security_service_catalogue_id], day => $control_audit_random_day_string);
		array_push($control_audit_updated,$tmp_array);
		unset($tmp_array);
	}


	# - Regular Mantainance (is a month, not an exact date)  
	$control_maintenance  = list_security_services_catalogue_maintenance_calendar_join("");
	# since what i get is a month, i need to add one more element on the array with a random day (from 1st to 28th to include any month)
	$control_maintenance_updated = array();
	foreach($control_maintenance as $control_maintenance_item) {
		$control_maintenance_random_time = rand( strtotime("1-$control_maintenance_item[security_services_maintenance_calendar_id]-$this_year"), strtotime("28-$control_maintenance_item[security_services_maintenance_calendar_id]-$this_year"));	
		$control_maintenance_random_day_string = date("Y-m-d", $control_maintenance_random_time);
		# debug
		# echo "New Random Day: $control_maintenance_random_day_string vs $control_maintenance_item[security_services_maintenance_calendar_id]<br>";
		$tmp_array = array(control_id => $control_maintenance_item[security_service_catalogue_id], day => $control_maintenance_random_day_string);
		array_push($control_maintenance_updated,$tmp_array);
		unset($tmp_array);
	}

		# - Service Contract End Date
	$service_contracts = list_service_contracts(" WHERE YEAR(service_contracts_end) = $this_year AND service_contracts_disabled = \"0\" ");

		# BLUE is for compliance stuff
		# - Compliance Exception Expiration
	$compliance_exception = list_compliance_exception(" WHERE YEAR(compliance_exception_expiration) = $this_year AND compliance_exception_disabled = \"0\" ");
		# - Audit Dates
	$compliance_audit = list_compliance_audit(" WHERE YEAR(compliance_audit_date) = $this_year AND compliance_audit_disabled = \"0\" ");
		# - Audit Finding Dates
	$compliance_finding = list_compliance_finding(" WHERE YEAR(compliance_finding_deadline) = $this_year AND compliance_finding_disabled = \"0\" ");

		# YELLOW is Operations stuff
		# - Project Deadline
	$project_improvements = list_project_improvements(" WHERE YEAR(project_improvements_deadline) = $this_year AND project_improvements_disabled = \"0\" ");
		# - Policy Exceptions Deadline 
	$policy_exceptions = list_policy_exceptions(" WHERE YEAR(policy_exceptions_expiration_date) = $this_year AND policy_exceptions_disabled = \"0\" ");

		# GREAY is for Incidents
		# - Incident Date Start 
	$security_incident = list_security_incident(" WHERE YEAR(security_incident_open_date) = $this_year AND security_incident_disabled = \"0\" ");

	//array containing days of week.
	$WeeksDays = array('Su','Mo','Tu','We','Th','Fr','Sa'); 
	// define first day of the month.
	$firstDayOfMonth = mktime(0,0,0,$month,1,$year);
	// no of days in month.   
	$numberDays = date('t',$firstDayOfMonth); 
	//get first day of month
	$dateComponents = getdate($firstDayOfMonth); 
	// What is the name of the month in question?
	$NameofMonth = $dateComponents['month'];
	// What is the index value (0-6) of the first day of the
	// month in question.
	$dayOfWeek = $dateComponents['wday'];

	// Create the table tag opener and day headers
	$Calendar = "<table class='Calendar'>";
	
		$Calendar .= "<caption>$NameofMonth $year</caption>";
 		$Calendar .= "<tr>";
	
	
		// Create the Calendar headers
		foreach($WeeksDays as $day) {
			$Calendar .= "<th class='header calendar'>$day</th>";
		}

	// Create the rest of the Calendar
	$currentDay = 1;
	$Calendar .= "</tr><tr>";
	
	if ($dayOfWeek > 0) {
		$Calendar .= "<td colspan='$dayOfWeek'>&nbsp;</td>";
	}

	$month = str_pad($month, 2, "0", STR_PAD_LEFT);
	while ($currentDay <= $numberDays) {
		//  when cloumn position is 7 means Saturday then starts a new row.
		if ($dayOfWeek == 7) {
			$dayOfWeek = 0;
			$Calendar .= "</tr><tr>";
	}

	$currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
	$date = "$year-$month-$currentDayRel";
	$events = array();


	foreach($risk_exception as $risk_exception_item) {
		if (array_search($date, $risk_exception_item)) {
			$base_url_edit = build_base_url("risk","risk_exception_edit");
			$events['warning_risk_exception']="<a href=\"$base_url_edit&action=edit&risk_exception_id=$risk_exception_item[risk_exception_id]\">(RE)</a>";

		}
	}
	
	foreach($risk_asset_review as $risk_asset_review_item) {
		if (array_search($date, $risk_asset_review_item)) {
			$base_url_edit = build_base_url("risk","risk_management_edit");
			$events['warning_risk_asset_review']="<a href=\"$base_url_edit&action=edit&risk_id=$risk_asset_review_item[risk_id]\">(RR)</a>";
		}
	}
	
	foreach($risk_tp_review as $risk_tp_review_item) {
		if (array_search($date, $risk_tp_review_item)) {
			$base_url_edit = build_base_url("risk","risk_tp_edit");
			$events['warning_risk_tp_review']="<a href=\"$base_url_edit&action=edit&risk_id=$risk_tp_review_item[risk_id]\">(RR)</a>";
		}
	}
	
	foreach($risk_buss_review as $risk_buss_review_item) {
		if (array_search($date, $risk_buss_review_item)) {
			$base_url_edit = build_base_url("risk","risk_buss_edit");
			$events['warning_risk_buss_review']="<a href=\"$base_url_edit&action=edit&risk_id=$risk_buss_review_item[risk_id]\">(RR)</a>";
		}
	}

	foreach($compliance_exception as $compliance_exception_item) {
		if (array_search($date, $compliance_exception_item)) {
			$base_url_edit = build_base_url("compliance","compliance_exception_edit");
			$events['warning_compliance_exception']="<a href=\"$base_url_edit&action=edit&compliance_exception_id=$compliance_exception_item[compliance_exception_id]\">(CE)</a>";
		}
	}
	
	foreach($compliance_finding as $compliance_finding_item) {
		if (array_search($date, $compliance_finding_item)) {
			$base_url_edit = build_base_url("compliance","compliance_finding_edit");
			$events['warning_compliance_finding']="<a href=\"$base_url_edit&action=edit&compliance_finding_id=$compliance_finding_item[compliance_finding_id]\">(CF)</a>";
		}
	}
	
	foreach($compliance_audit as $compliance_audit_item) {
		if (array_search($date, $compliance_audit_item)) {
			$base_url_edit = build_base_url("compliance","compliance_audit_edit");
			$events['warning_compliance_audit']="<a href=\"$base_url_edit&action=edit&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\">(CA)</a>";
		}
	}
	
	foreach($policy_exceptions as $policy_exceptions_item) {
		if (array_search($date, $policy_exceptions_item)) {
			$base_url_edit = build_base_url("operations","policy_exceptions_edit");
			$events['warning_policy_exceptions']="<a href=\"$base_url_edit&action=edit&policy_exceptions_id=$policy_exceptions_item[policy_exceptions_id]\">(PE)</a>";
		}
	}
	
	foreach($project_improvements as $project_improvements_item) {
		if (array_search($date, $project_improvements_item)) {
			$base_url_edit = build_base_url("operations","project_improvements_edit");
			$events['warning_project_improvements']="<a href=\"$base_url_edit&action=edit&project_improvements_id=$project_improvements_item[project_improvements_id]\">(PI)</a>";
		}
	}
	
	foreach($security_incident as $security_incident_item) {
		if (array_search($date, $security_incident_item)) {
			$base_url_edit = build_base_url("operations","security_incident_edit");
			$events['warning_security_incident']="<a href=\"$base_url_edit&action=edit&security_incident_id=$security_incident_item[security_incident_id]\">(SI)</a>";
		}
	}
	
	foreach($service_contracts as $service_contracts_item) {
		if (array_search($date, $service_contracts_item)) {
			$base_url_edit = build_base_url("security_services","service_contracts_edit");
			$events['warning_service_contracts']="<a href=\"$base_url_edit&action=edit&service_contracts_id=$service_contracts_item[service_contracts_id]\">(SC)</a>";
		}
	}
	
	foreach($control_audit_updated as $control_audit_updated_item) {
		if (array_search($date, $control_audit_updated_item)) {
			$base_url_edit = build_base_url("security_services","security_catalogue_edit");
			$events['warning_service_audit']="<a href=\"$base_url_edit&action=edit&security_services_id=$control_audit_updated_item[control_id]\">(SA)</a>";
		}
	}
	
	foreach($control_maintenance_updated as $control_maintenance_updated_item) {
		if (array_search($date, $control_maintenance_updated_item)) {
			$base_url_edit = build_base_url("security_services","security_catalogue_edit");
			$events['warning_service_maintenance']="<a href=\"$base_url_edit&action=edit&security_services_id=$control_maintenance_updated_item[control_id]\">(SM)</a>";
		}
	}
	$hasEvents = count($events);
	$eventContainer = ($hasEvents)? "<ul class='eventContainer'><li>".join('</li><li>', $events)."</li></ul>" : "";
	$Calendar .= "<td class='day ".(($hasEvents) ? 'hasEvents' : '')."' rel='$date'>$currentDay $eventContainer</td>";
	
	unset($events,$hasEvents);
	unset($warning_risk_exception, $warning_risk_asset_review, $warning_risk_tp_review, $warning_risk_buss_review, $warning_compliance_exception, $warning_compliance_audit, $warning_compliance_finding, $warning_policy_exceptions, $warning_project_improvements, $warning_security_incident, $warning_service_contracts, $warning_service_maintenance, $warning_service_audit);

	$currentDay++;
	$dayOfWeek++;

	}

	// Complete the row of the last week in month, if necessary
	if ($dayOfWeek != 7) {
		$remainingDays = 7 - $dayOfWeek;
		$Calendar .= "<td colspan='$remainingDays'>&nbsp;</td>";
	}
	$Calendar .= "</tr>";
	$Calendar .= "</table>";

	return $Calendar;

	}


?>
