<?
	
# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/security_operations_dashboard/security_operations_dashboard/ - SAMEPLE

include_once("mysql_lib.php");
include_once("project_improvements_lib.php");
include_once("security_incident_lib.php");

function security_operations_dashboard_data($force) {

	if (!$force) {
	# i need to make sure i add data ONLY if this current month has no data already
	# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
	$month = give_me_this_month();
	$security_operations_dashboard_list = list_security_operations_dashboard(" WHERE MONTH(dashboard_date) = $month");
	if (count($security_operations_dashboard_list)!=0) {
		#echo "no more updates for this month";
		return;
	}
	}

	# now i start getting hte data for a new update on the dashaboards
	$security_operations_dashboard_project_count=0;
	$security_operations_dashboard_project_idea=0;
	$security_operations_dashboard_project_initiated=0;
	$security_operations_dashboard_project_complet=0;
	$security_operations_dashboard_incident_count=0;
	$security_operations_dashboard_incident_reported=0;
	$security_operations_dashboard_incident_open=0;
	$security_operations_dashboard_incident_closed=0;

	$security_operations_dashboard_plan_budget_plan=0;
	$security_operations_dashboard_plan_budget_on=0;
	$security_operations_dashboard_plan_budget_com=0;

	$security_operations_dashboard_current_budget_plan=0;
	$security_operations_dashboard_current_budget_on=0;
	$security_operations_dashboard_current_budget_com=0;
	
	$project_improvements_list = list_project_improvements(" WHERE project_improvements_disabled=\"0\"");

	foreach($project_improvements_list as $project_improvements_item) {

		if ($project_improvements_item[project_improvements_status_id] == "1") {
		$security_operations_dashboard_project_idea++;
		$security_operations_dashboard_plan_budget_plan=$security_operations_dashboard_plan_budget_plan+$project_improvements_item[project_improvements_plan_budget];
		$security_operations_dashboard_current_budget_plan=$security_operations_dashboard_current_budget_plan+$project_improvements_item[project_improvements_current_budget];

		} elseif ($project_improvements_item[project_improvements_status_id] == "2") {
		$security_operations_dashboard_project_initiated++;
		$security_operations_dashboard_plan_budget_on=$security_operations_dashboard_plan_budget_on+$project_improvements_item[project_improvements_plan_budget];
		$security_operations_dashboard_current_budget_on=$security_operations_dashboard_current_budget_on+$project_improvements_item[project_improvements_current_budget];

		} elseif ($project_improvements_item[project_improvements_status_id] == "3") {
		$security_operations_dashboard_project_complet++;
		$security_operations_dashboard_plan_budget_com=$security_operations_dashboard_plan_budget_com+$project_improvements_item[project_improvements_plan_budget];
		$security_operations_dashboard_current_budget_com=$security_operations_dashboard_current_budget_com+$project_improvements_item[project_improvements_current_budget];
		}
		
		$security_operations_dashboard_project_count++;
		
	}	

	$security_incident_list = list_security_incident(" WHERE security_incident_disabled = \"0\"");
	foreach($security_incident_list as $security_incident_item) {
		
		if ($security_incident_item[security_incident_status_id] == "1") {
			$security_operations_dashboard_incident_reported++;
		} elseif ($security_incident_item[security_incident_status_id] == "2") {
			$security_operations_dashboard_incident_open++;
		} elseif ($security_incident_item[security_incident_status_id] == "3") {
			$security_operations_dashboard_incident_closed++;
		}
		
		$security_operations_dashboard_incident_count++;

	}	

	$date=give_me_date();
	
	$security_operations_update = array(
		'security_operations_dashboard_project_count' => $security_operations_dashboard_project_count,
		'security_operations_dashboard_project_idea' => $security_operations_dashboard_project_idea,
		'security_operations_dashboard_project_initiated' => $security_operations_dashboard_project_initiated,
		'security_operations_dashboard_project_complet' => $security_operations_dashboard_project_complet,
		'security_operations_dashboard_incident_count' => $security_operations_dashboard_incident_count,
		'security_operations_dashboard_incident_reported' => $security_operations_dashboard_incident_reported,
		'security_operations_dashboard_incident_open' => $security_operations_dashboard_incident_open,
		'security_operations_dashboard_incident_closed' => $security_operations_dashboard_incident_closed,
		'security_operations_dashboard_plan_budget_plan' => $security_operations_dashboard_plan_budget_plan,
		'security_operations_dashboard_plan_budget_on' => $security_operations_dashboard_plan_budget_on,
		'security_operations_dashboard_plan_budget_com' => $security_operations_dashboard_plan_budget_com,
		'security_operations_dashboard_current_budget_plan' => $security_operations_dashboard_current_budget_plan,
		'security_operations_dashboard_current_budget_on' => $security_operations_dashboard_current_budget_on,
		'security_operations_dashboard_current_budget_com' => $security_operations_dashboard_current_budget_com,
		'dashboard_date' => $date
	);	

	$security_operations_dashboard_id = add_security_operations_dashboard($security_operations_update);
}

function list_security_operations_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM security_operations_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_security_operations_dashboard($security_operations_dashboard_data) {
	$sql = "INSERT INTO
		security_operations_dashboard_tbl
		VALUES (
		\"$security_operations_dashboard_data[security_operations_dashboard_id]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_project_count]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_project_idea]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_project_initiated]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_project_complet]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_incident_count]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_incident_reported]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_incident_open]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_incident_closed]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_plan_budget_plan]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_plan_budget_on]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_plan_budget_com]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_current_budget_plan]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_current_budget_on]\",
		\"$security_operations_dashboard_data[security_operations_dashboard_current_budget_com]\",
		\"$security_operations_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_security_operations_dashboard($security_operations_dashboard_data, $security_operations_dashboard_id) {
	$sql = "UPDATE security_operations_dashboard_tbl
		SET
		security_operations_dashboard_name=\"$security_operations_dashboard_data[security_operations_dashboard_name]\",
		security_operations_dashboard_description=\"$security_operations_dashboard_data[security_operations_dashboard_description]\"
		WHERE
		security_operations_dashboard_id=\"$security_operations_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_security_operations_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from security_operations_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_security_operations_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM security_operations_dashboard_tbl WHERE security_operations_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[security_operations_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[security_operations_dashboard_id]\">$results_item[security_operations_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_operations_dashboard_id]\">$results_item[security_operations_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[security_operations_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[security_operations_dashboard_id]\">$results_item[security_operations_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_operations_dashboard_id]\">$results_item[security_operations_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[security_operations_dashboard_id]\">$results_item[security_operations_dashboard_name]</option>\n"; 
		}
	}

}

function disable_security_operations_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE security_operations_dashboard_tbl SET security_operations_dashboard_disabled=\"1\" WHERE security_operations_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_security_operations_dashboard_csv() {

	# this will dump the table security_operations_dashboard_tbl on CSV format
	$sql = "SELECT * from security_operations_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/security_operations_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "security_operations_dashboard_id,security_operations_dashboard_name,security_operations_dashboard_description,security_operations_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[security_operations_dashboard_id],$line[security_operations_dashboard_name],$line[security_operations_dashboard_descripion],$line[security_operations_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
