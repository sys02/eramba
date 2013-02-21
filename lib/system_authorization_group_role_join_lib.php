<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/system_authorization_group_role_join/system_authorization_group_role_join/ - SAMEPLE

include_once("mysql_lib.php");

function list_system_authorization_group_role_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM system_authorization_group_role_join".$arguments;
	# echo "$sql<br>";
	$results = runQuery($sql);
	return $results;
}

function delete_system_authorization_group_role_join($role_id) {
	$sql = "DELETE from system_authorization_group_role_join where system_authorization_group_role_role_id = \"$role_id\"";
	$result = runUpdateQuery($sql);
	return $result;
}

function add_system_authorization_group_role_join($role_id, $auth_id) {
	$sql = "INSERT INTO
		system_authorization_group_role_join	
		VALUES (
		\"$role_id\",
		\"$auth_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_system_authorization_group_role_join($system_authorization_group_role_join_data, $system_authorization_group_role_join_id) {
	$sql = "UPDATE system_authorization_group_role_join_tbl
		SET
		system_authorization_group_role_join_name=\"$system_authorization_group_role_join_data[system_authorization_group_role_join_name]\",
		system_authorization_group_role_join_description=\"$system_authorization_group_role_join_data[system_authorization_group_role_join_description]\"
		WHERE
		system_authorization_group_role_join_id=\"$system_authorization_group_role_join_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_system_authorization_group_role_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from system_authorization_group_role_join_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_authorization_group_role_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_authorization_group_role_join_tbl WHERE system_authorization_group_role_join_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_authorization_group_role_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_authorization_group_role_join_id]\">$results_item[system_authorization_group_role_join_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_authorization_group_role_join_id]\">$results_item[system_authorization_group_role_join_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_authorization_group_role_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_authorization_group_role_join_id]\">$results_item[system_authorization_group_role_join_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_authorization_group_role_join_id]\">$results_item[system_authorization_group_role_join_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_authorization_group_role_join_id]\">$results_item[system_authorization_group_role_join_name]</option>\n"; 
		}
	}

}

function disable_system_authorization_group_role_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE system_authorization_group_role_join_tbl SET system_authorization_group_role_join_disabled=\"1\" WHERE system_authorization_group_role_join_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_system_authorization_group_role_join_csv() {

	# this will dump the table system_authorization_group_role_join_tbl on CSV format
	$sql = "SELECT * from system_authorization_group_role_join_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/system_authorization_group_role_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "system_authorization_group_role_join_id,system_authorization_group_role_join_name,system_authorization_group_role_join_description,system_authorization_group_role_join_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[system_authorization_group_role_join_id],$line[system_authorization_group_role_join_name],$line[system_authorization_group_role_join_descripion],$line[system_authorization_group_role_join_disabled]\n");
	}
	
	fclose($handler);

}

?>




