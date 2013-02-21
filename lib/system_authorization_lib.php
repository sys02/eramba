<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/system_authorization/system_authorization/ - SAMEPLE

include_once("mysql_lib.php");

function list_system_authorization($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM system_authorization_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_system_authorization($system_authorization_data) {
	$sql = "INSERT INTO
		system_authorization_tbl
		VALUES (
		\"$system_authorization_data[system_authorization_id]\",
		\"$system_authorization_data[system_authorization_name]\",
		\"$system_authorization_data[system_authorization_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_system_authorization($system_authorization_data, $system_authorization_id) {
	$sql = "UPDATE system_authorization_tbl
		SET
		system_authorization_name=\"$system_authorization_data[system_authorization_name]\",
		system_authorization_description=\"$system_authorization_data[system_authorization_description]\"
		WHERE
		system_authorization_id=\"$system_authorization_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_system_authorization($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from system_authorization_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}
# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_authorization_write($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_authorization_tbl WHERE system_authorization_disabled = \"0\" AND system_authorization_action_type = \"w\"";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_authorization_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_authorization_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n"; 
		}
	}

}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_authorization_read($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_authorization_tbl WHERE system_authorization_disabled = \"0\" AND system_authorization_action_type = \"r\"";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_authorization_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_authorization_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_authorization_id]\">$results_item[system_authorization_section_cute_name] / $results_item[system_authorization_subsection_cute_name]</option>\n"; 
		}
	}

}

function disable_system_authorization($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "DELETE FROM system_authorization_tbl WHERE system_authorization_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_system_authorization_csv() {

	# this will dump the table system_authorization_tbl on CSV format
	$sql = "SELECT * from system_authorization_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/system_authorization_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "system_authorization_id,system_authorization_name,system_authorization_description,system_authorization_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[system_authorization_id],$line[system_authorization_name],$line[system_authorization_descripion],$line[system_authorization_disabled]\n");
	}
	
	fclose($handler);

}

?>




