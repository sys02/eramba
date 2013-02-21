<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/system_users/system_users/ - SAMEPLE

include_once("mysql_lib.php");

function list_system_users($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM system_users_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_system_users($system_users_data) {
	$sql = "INSERT INTO
		system_users_tbl
		VALUES (
		\"\",
		\"$system_users_data[system_users_name]\",
		\"$system_users_data[system_users_surname]\",
		\"$system_users_data[system_users_group_role_id]\",
		\"$system_users_data[system_users_login]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_system_users($system_users_data, $system_users_id) {
	$sql = "UPDATE system_users_tbl
		SET
		system_users_name=\"$system_users_data[system_users_name]\",
		system_users_surname=\"$system_users_data[system_users_surname]\",
		system_users_login=\"$system_users_data[system_users_login]\",
		system_users_group_role_id=\"$system_users_data[system_users_group_role_id]\"
		WHERE
		system_users_id=\"$system_users_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_system_users($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from system_users_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_users($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_users_tbl WHERE system_users_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_users_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_users_id]\">$results_item[system_users_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_users_id]\">$results_item[system_users_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_users_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_users_id]\">$results_item[system_users_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_users_id]\">$results_item[system_users_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_users_id]\">$results_item[system_users_name]</option>\n"; 
		}
	}

}

function disable_system_users($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "SELECT system_users_group_role_id FROM system_users_tbl WHERE system_users_id = \"$item_id\"";
	$result = runSmallQuery($sql);
	if ($result['system_users_group_role_id'] != -1) {
		$sql = "UPDATE system_users_tbl SET system_users_disabled=\"1\" WHERE system_users_id = \"$item_id\"";
		$result = runUpdateQuery($sql);
	}	
	return;
}

function export_system_users_csv() {

	# this will dump the table system_users_tbl on CSV format
	$sql = "SELECT * from system_users_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/system_users_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "system_users_id,system_users_name,system_users_description,system_users_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[system_users_id],$line[system_users_name],$line[system_users_descripion],$line[system_users_disabled]\n");
	}
	
	fclose($handler);

}

?>
