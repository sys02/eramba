<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/security_services/security_services/ - SAMEPLE

include_once("mysql_lib.php");
include_once("security_services_audit_lib.php");

function list_security_services($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM security_services_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_security_services($security_services_data) {
	$sql = "INSERT INTO
		security_services_tbl
		VALUES (
		\"$security_services_data[security_services_id]\",
		\"$security_services_data[security_services_name]\",
		\"$security_services_data[security_services_objective]\",
		\"$security_services_data[security_services_documentation_url]\",
		\"$security_services_data[security_services_status]\",
		\"$security_services_data[security_services_classification_id]\",
		\"$security_services_data[security_services_audit_metric]\",
		\"$security_services_data[security_services_audit_success_criteria]\",
		\"$security_services_data[security_services_regular_maintenance]\",
		\"$security_services_data[security_services_cost_opex]\",
		\"$security_services_data[security_services_cost_capex]\",
		\"$security_services_data[security_services_cost_operational_resource]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_security_services($security_services_data, $security_services_id) {
	$sql = "UPDATE security_services_tbl
		SET
		security_services_name = \"$security_services_data[security_services_name]\",
		security_services_objective = \"$security_services_data[security_services_objective]\",
		security_services_documentation_url = \"$security_services_data[security_services_documentation_url]\",
		security_services_status = \"$security_services_data[security_services_status]\",
		security_services_classification_id = \"$security_services_data[security_services_classification_id]\",
		security_services_audit_metric = \"$security_services_data[security_services_audit_metric]\",
		security_services_audit_success_criteria = \"$security_services_data[security_services_audit_success_criteria]\",
		security_services_regular_maintenance = \"$security_services_data[security_services_regular_maintenance]\",
		security_services_cost_opex = \"$security_services_data[security_services_cost_opex]\",
		security_services_cost_capex = \"$security_services_data[security_services_cost_capex]\",
		security_services_cost_operational_resource = \"$security_services_data[security_services_cost_operational_resource]\"
		WHERE
		security_services_id=\"$security_services_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_security_services($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from security_services_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# this function reviews if a security service is: 
# 1) if the control is not disabled, etc..
# 2) not in "Production" -security_services_status_id=4
function security_service_check($security_service_id) {


	$service_data = lookup_security_services("security_services_id", $security_service_id);	

	#  echo "puta: $service_data[security_services_disabled]<br>";
	if ($service_data[security_services_disabled] == "1") {
		#echo "puta: disabled issues, that's why this control is wrong<br>";
		return 1;
	}

	# echo "puta: $service_data[security_services_status]<br>";
	# if ($service_data[security_services_status] != "4") {
	#	# echo "puta: status issues, that's why this control is wrong<br>";
	#	return 1;
	# }
	
	if ( check_service_last_audit_result($service_data[security_services_id]) == NULL ) {
		#echo "puta: audit issues, that's why this control is wrong<br>";
		return 1;
	}

	return;

}

# this function checks if a security service is being used or not
# returns:
# NULL if all good
# 1 if not in use at any of this: risks, third party risks, compliance
function service_in_use($security_control_id) {

	# first i check on the risk table: risk_security_services_join
	$risk_security_services_join = lookup_risk_security_services_join("risk_security_services_join_security_services_id", $security_control_id);	
	
	# then i check on the compliance table: compliance_security_services_join
	$compliance_security_services_join = lookup_compliance_item_security_services_join("compliance_security_services_join_security_services_id", $security_control_id); 		
	# i need to check onthe data asset analysis...
	$data_asset_security_services_join = lookup_data_asset_security_services_join("data_asset_security_services_join_security_services_id", $security_control_id);

	#if any of these three has something, then this control is doing something ..
	if (!$risk_security_services_join && !$compliance_security_services_join && !$data_asset_security_services_join) {
		return 1;
	} else {
		return NULL;
	}
		
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_security_services($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM security_services_tbl WHERE security_services_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[security_services_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[security_services_id]\">$results_item[security_services_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_id]\">$results_item[security_services_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[security_services_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[security_services_id]\">$results_item[security_services_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_id]\">$results_item[security_services_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[security_services_id]\">$results_item[security_services_name]</option>\n"; 
		}
	}

}

function disable_security_services($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE security_services_tbl SET security_services_disabled=\"1\" WHERE security_services_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);

	# i need to remove all the asociated audit stuff
	# form tables: security_services_catalogue_audit_calendar_join & security_services_audit_tbl
	delete_security_services_catalogue_audit_calendar_join($item_id);
	$security_services_audit_list = list_security_services_audit(" WHERE security_services_audit_security_service_id = \"$item_id\"");
	foreach($security_services_audit_list as $security_services_audit_item) {
		disable_security_services_audit($security_services_audit_item[security_services_audit_id]);	
	}

	return;
}

function export_security_services_csv() {

	# this will dump the table security_services_tbl on CSV format
	$sql = "SELECT * from security_services_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/security_services_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "security_services_id,security_services_name,security_services_objective,security_services_documentation_url,security_services_status,security_services_audit_metric,security_services_audit_success_criteria,security_services_audit_periodicity,security_services_cost_opex,security_services_cost_capex,security_services_cost_operational_resource,security_services_disabled\n");

	foreach($result as $line) {

		$audit_months = array();
		$status_name = lookup_security_services_status("security_services_status_id", $line[security_services_status]);	
		$months_list = list_security_services_catalogue_audit_calendar_join(" WHERE security_service_catalogue_id = \"$line[security_services_id]\"");
		foreach($months_list as $months_item) {
			$month_name = lookup_security_services_audit_calendar("security_services_audit_calendar_id",$months_item[security_services_audit_calendar_id]);
			array_push($audit_months, $month_name[security_services_audit_calendar_name]);
		}
		$audit_months_string = implode("-",$audit_months);

		fwrite($handler,"$line[security_services_id],$line[security_services_name],$line[security_services_objective],$line[security_services_documentation_url],$status_name[security_services_status_name],$line[security_services_audit_metric],$line[security_services_audit_success_criteria],$audit_months_string,$line[security_services_cost_opex],$line[security_services_cost_capex],$line[security_services_cost_operational_resource],$line[security_services_disabled]\n");

		unset($audit_months_string);
		unset($audit_months);
	}
	
	fclose($handler);

}

?>
