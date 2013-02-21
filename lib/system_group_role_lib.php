<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/system_group_role/system_group_role/ - SAMEPLE

include_once("mysql_lib.php");

function list_system_group_role($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM system_group_role_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_system_group_role($system_group_role_data) {
	$sql = "INSERT INTO
		system_group_role_tbl
		VALUES (
		\"$system_group_role_data[system_group_role_id]\",
		\"$system_group_role_data[system_group_role_name]\",
		\"$system_group_role_data[system_group_role_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_system_group_role($system_group_role_data, $system_group_role_id) {
	$sql = "UPDATE system_group_role_tbl
		SET
		system_group_role_name=\"$system_group_role_data[system_group_role_name]\",
		system_group_role_description=\"$system_group_role_data[system_group_role_description]\"
		WHERE
		system_group_role_id=\"$system_group_role_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_system_group_role($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from system_group_role_tbl WHERE $search_parameter = \"$item_id\""; 
	
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_group_role($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_group_role_tbl WHERE system_group_role_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_group_role_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_group_role_id]\">$results_item[system_group_role_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_group_role_id]\">$results_item[system_group_role_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_group_role_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_group_role_id]\">$results_item[system_group_role_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_group_role_id]\">$results_item[system_group_role_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_group_role_id]\">$results_item[system_group_role_name]</option>\n"; 
		}
	}

}

function disable_system_group_role($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE system_group_role_tbl SET system_group_role_disabled=\"1\" WHERE system_group_role_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_system_group_role_csv() {

	# this will dump the table system_group_role_tbl on CSV format
	$sql = "SELECT * from system_group_role_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/system_group_role_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "system_group_role_id,system_group_role_name,system_group_role_description,system_group_role_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[system_group_role_id],$line[system_group_role_name],$line[system_group_role_descripion],$line[system_group_role_disabled]\n");
	}
	
	fclose($handler);

}

?>




