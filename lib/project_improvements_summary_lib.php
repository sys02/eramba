<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/project_improvements_summary/project_improvements_summary/ - SAMEPLE

include_once("mysql_lib.php");
include_once("project_improvements_achievements_lib.php");

function build_project_improvements_summary() {

	delete_project_improvements_summary();

	$project_list = list_project_improvements(" WHERE project_improvements_disabled = \"0\" ");

	foreach($project_list as $project_item) {

		$project_updates = list_project_improvements_achievements(" WHERE project_improvements_achievements_disabled = \"0\" AND project_improvements_achievements_date < \"$project_item[project_improvements_deadline]\" and project_improvements_achievements_date > \"$project_item[project_improvements_start]\" and project_improvements_achievements_proj_id = \"$project_item[project_improvements_id]\"");

		$updates = count($project_updates);
		$weeks = floor(( strtotime($project_item[project_improvements_deadline],0) - strtotime($project_item[project_improvements_start],0) ) / 604800); 

		if ($updates>0) {

			$velocity = $weeks / $updates;
	
			# a good follow up is an update every week
			# a medium follow up is an update every two weeks
			# a poor follow up is an update every three weeks
	
		}
		
		$project_improvements_summary = array(
			'project_improvements_name' => $project_item[project_improvements_title],
			'project_improvements_completion' => $project_item[project_improvements_completion],
			'project_improvements_owner' => $project_item[project_improvements_owner_id], 
			'project_improvements_planned_end' => $project_item[project_improvements_deadline],
			'project_improvements_current_bud' => $project_item[project_improvements_current_budget],
			'project_improvements_planned_bud' => $project_item[project_improvements_plan_budget],
			'project_improvements_velocity' => "0"
		);	

		add_project_improvements_summary($project_improvements_summary);

	}

}

function list_project_improvements_summary($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM project_improvements_summary_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function delete_project_improvements_summary() {
	$sql = "DELETE from project_improvements_summary_tbl WHERE 1=1";
	$result = runUpdateQuery($sql);
	return $result;
}

function add_project_improvements_summary($project_improvements_summary_data) {
	$sql = "INSERT INTO
		project_improvements_summary_tbl
		VALUES (
		\"$project_improvements_summary_data[project_improvements_summary_id]\",
		\"$project_improvements_summary_data[project_improvements_name]\",
		\"$project_improvements_summary_data[project_improvements_completion]\",
		\"$project_improvements_summary_data[project_improvements_owner]\",
		\"$project_improvements_summary_data[project_improvements_planned_end]\",
		\"$project_improvements_summary_data[project_improvements_current_bud]\",
		\"$project_improvements_summary_data[project_improvements_planned_bud]\",
		\"$project_improvements_summary_data[project_improvements_velocity]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_project_improvements_summary($project_improvements_summary_data, $project_improvements_summary_id) {
	$sql = "UPDATE project_improvements_summary_tbl
		SET
		project_improvements_summary_name=\"$project_improvements_summary_data[project_improvements_summary_name]\",
		project_improvements_summary_description=\"$project_improvements_summary_data[project_improvements_summary_description]\"
		WHERE
		project_improvements_summary_id=\"$project_improvements_summary_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_project_improvements_summary($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from project_improvements_summary_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_project_improvements_summary($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM project_improvements_summary_tbl WHERE project_improvements_summary_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[project_improvements_summary_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[project_improvements_summary_id]\">$results_item[project_improvements_summary_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[project_improvements_summary_id]\">$results_item[project_improvements_summary_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[project_improvements_summary_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[project_improvements_summary_id]\">$results_item[project_improvements_summary_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[project_improvements_summary_id]\">$results_item[project_improvements_summary_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[project_improvements_summary_id]\">$results_item[project_improvements_summary_name]</option>\n"; 
		}
	}

}

function disable_project_improvements_summary($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE project_improvements_summary_tbl SET project_improvements_summary_disabled=\"1\" WHERE project_improvements_summary_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_project_improvements_summary_csv() {

	# this will dump the table project_improvements_summary_tbl on CSV format
	$sql = "SELECT * from project_improvements_summary_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/project_improvements_summary_list.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "project_improvements_summary_id,project_improvements_summary_type,project_improvements_summary_name,project_improvements_summary_project_improvements_counter,project_improvements_summary_opex,project_improvements_summary_capex,project_improvements_summary_resources,project_improvements_summary_score,project_improvements_summary_residual,project_improvements_summary_incident_counter,project_improvements_summary_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[project_improvements_summary_id],$line[project_improvements_summary_type],$line[project_improvements_summary_name],$line[project_improvements_summary_project_improvements_counter],$line[project_improvements_summary_opex],$line[project_improvements_summary_capex],$line[project_improvements_summary_resources],$line[project_improvements_summary_score],$line[project_improvements_summary_residual],$line[project_improvements_summary_incident_counter],$line[project_improvements_summary_disabled]\n");
	}
	
	fclose($handler);

}

?>
