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
					echo '<li><a href="?section='.$row['system_authorization_section_name'].'&subsection=dashboard" ' . (is_this_menu_active($_GET["section"], $row['system_authorization_section_name'])) . '>'.$row['system_authorization_section_cute_name'].'</a></li>';
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
				echo "<li><a href=\"$base_url?section=" . $section . "&subsection=" . $row['system_authorization_subsection_name'] . "\">" . $row['system_authorization_subsection_cute_name'] . "</a></li>";
			}
		}
	}

	//var_dump($sub_menu);
	/*
	if ($section == "organization") {
		echo "<li><a href=\"$base_url?section=organization&subsection=bu\">Bussiness Units</a></li>";
		echo "<li><a href=\"$base_url?section=organization&subsection=legal\">Legal</a></li>";
		echo "<li><a href=\"$base_url?section=organization&subsection=tp\">Third Parties</a></li>";
	}
	
	if ($section == "asset") {
		echo "<li><a href=\"$base_url?section=asset&subsection=asset_classification\">Classification Scheme</a></li>";
		echo "<li><a href=\"$base_url?section=asset&subsection=asset_identification\">Asset Identification</a></li>";
		echo "<li><a href=\"$base_url?section=asset&subsection=data_asset\">Data Asset Analysis</a></li>";
	}
	
	if ($section == "risk") {
		echo "<li><a href=\"$base_url?section=risk&subsection=risk_classification\">Risk Classification Scheme</a></li>";
		echo "<li><a href=\"$base_url?section=risk&subsection=risk_management\">Risk Management</a></li>";
		echo "<li><a href=\"$base_url?section=risk&subsection=risk_exception\">Risk Exception</a></li>";
	}

	if ($section == "security_services") {
		echo "<li><a href=\"$base_url?section=security_services&subsection=security_catalogue\">Security Catalogue</a></li>";
		echo "<li><a href=\"$base_url?section=security_services&subsection=security_services_audit\">Audits & Reviews</a></li>";
		echo "<li><a href=\"$base_url?section=security_services&subsection=service_contracts\">Support Contracts</a></li>";
	}
	
	if ($section == "compliance") {
		echo "<li><a href=\"$base_url?section=compliance&subsection=compliance_package\">Compliance Packages DB</a></li>";
		echo "<li><a href=\"$base_url?section=compliance&subsection=compliance_management\">Compliance Management</a></li>";
		echo "<li><a href=\"$base_url?section=compliance&subsection=compliance_exception\">Compliance Exception</a></li>";
	}

	if ($section == "operations") {
		echo "<li><a href=\"$base_url?section=operations&subsection=project_improvements\">Improvement Projects</a></li>";
	}

	if ($section == "system") {
		echo "<li><a href=\"$base_url?section=system&subsection=system_records\">System Records</a></li>";
		echo "<li><a href=\"$base_url?section=system&subsection=system_authorization\">Authorization</a></li>";
		echo "<li><a href=\"$base_url?section=system&subsection=system_roles\">Roles</a></li>";
	}
	*/
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

?>
