<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/project_improvements_expenses/project_improvements_expenses/ - SAMEPLE

include_once("mysql_lib.php");
include_once("project_improvements_lib.php");

function update_current_budget($project_id) {

	# get the list of expenditures for this project
	$list_expenditures = list_project_improvements_expenses(" WHERE project_improvements_expenses_project_id = \"$project_id\" and project_improvements_expenses_disabled = \"0\"");	
	if ($list_expenditures) {
		foreach($list_expenditures as $list_expenditures_item) {
			$expenditure = $expenditure + $list_expenditures_item[project_improvements_expenses_amount];
		}
	} else {
		$expenditure = 0;
	}
		
	update_project_improvements_current_budget($expenditure,$project_id);
	
}

function list_project_improvements_expenses($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM project_improvements_expenses_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_project_improvements_expenses($project_improvements_expenses_data) {
	$sql = "INSERT INTO
		project_improvements_expenses_tbl
		VALUES (
		\"\",
		\"$project_improvements_expenses_data[project_improvements_expenses_project_id]\",
		\"$project_improvements_expenses_data[project_improvements_expenses_description]\",
		\"$project_improvements_expenses_data[project_improvements_expenses_amount]\",
		\"$project_improvements_expenses_data[project_improvements_expenses_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_project_improvements_expenses($project_improvements_expenses_data, $project_improvements_expenses_id) {
	$sql = "UPDATE project_improvements_expenses_tbl
		SET
		project_improvements_expenses_description=\"$project_improvements_expenses_data[project_improvements_expenses_description]\",
		project_improvements_expenses_amount=\"$project_improvements_expenses_data[project_improvements_expenses_amount]\",
		project_improvements_expenses_date=\"$project_improvements_expenses_data[project_improvements_expenses_date]\"
		WHERE
		project_improvements_expenses_id=\"$project_improvements_expenses_id\"
		";	
	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_project_improvements_expenses($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from project_improvements_expenses_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_project_improvements_expenses($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM project_improvements_expenses_tbl WHERE project_improvements_expenses_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[project_improvements_expenses_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[project_improvements_expenses_id]\">$results_item[project_improvements_expenses_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[project_improvements_expenses_id]\">$results_item[project_improvements_expenses_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[project_improvements_expenses_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[project_improvements_expenses_id]\">$results_item[project_improvements_expenses_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[project_improvements_expenses_id]\">$results_item[project_improvements_expenses_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[project_improvements_expenses_id]\">$results_item[project_improvements_expenses_name]</option>\n"; 
		}
	}

}

function disable_all_project_improvements_expenses($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE project_improvements_expenses_tbl SET project_improvements_expenses_disabled=\"1\" WHERE project_improvements_expenses_project_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function disable_project_improvements_expenses($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE project_improvements_expenses_tbl SET project_improvements_expenses_disabled=\"1\" WHERE project_improvements_expenses_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_project_improvements_expenses_csv() {

	# this will dump the table project_improvements_expenses_tbl on CSV format
	$sql = "SELECT * from project_improvements_expenses_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/project_improvements_expenses_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "project_improvements_expenses_id,project_improvements_expenses_name,project_improvements_expenses_description,project_improvements_expenses_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[project_improvements_expenses_id],$line[project_improvements_expenses_name],$line[project_improvements_expenses_descripion],$line[project_improvements_expenses_disabled]\n");
	}
	
	fclose($handler);

}

?>
