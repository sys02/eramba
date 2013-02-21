<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/policy_exceptions_status/policy_exceptions_status/ - SAMEPLE

include_once("mysql_lib.php");

function list_policy_exceptions_status($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM policy_exceptions_status_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_policy_exceptions_status($policy_exceptions_status_data) {
	$sql = "INSERT INTO
		policy_exceptions_status_tbl
		VALUES (
		\"$policy_exceptions_status_data[policy_exceptions_status_id]\",
		\"$policy_exceptions_status_data[policy_exceptions_status_name]\",
		\"$policy_exceptions_status_data[policy_exceptions_status_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_policy_exceptions_status($policy_exceptions_status_data, $policy_exceptions_status_id) {
	$sql = "UPDATE policy_exceptions_status_tbl
		SET
		policy_exceptions_status_name=\"$policy_exceptions_status_data[policy_exceptions_status_name]\",
		policy_exceptions_status_description=\"$policy_exceptions_status_data[policy_exceptions_status_description]\"
		WHERE
		policy_exceptions_status_id=\"$policy_exceptions_status_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_policy_exceptions_status($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from policy_exceptions_status_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_policy_exceptions_status($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM policy_exceptions_status_tbl WHERE policy_exceptions_status_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[policy_exceptions_status_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[policy_exceptions_status_id]\">$results_item[policy_exceptions_status_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[policy_exceptions_status_id]\">$results_item[policy_exceptions_status_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[policy_exceptions_status_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[policy_exceptions_status_id]\">$results_item[policy_exceptions_status_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[policy_exceptions_status_id]\">$results_item[policy_exceptions_status_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[policy_exceptions_status_id]\">$results_item[policy_exceptions_status_name]</option>\n"; 
		}
	}

}

function disable_policy_exceptions_status($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE policy_exceptions_status_tbl SET policy_exceptions_status_disabled=\"1\" WHERE policy_exceptions_status_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_policy_exceptions_status_csv() {

	# this will dump the table policy_exceptions_status_tbl on CSV format
	$sql = "SELECT * from policy_exceptions_status_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/policy_exceptions_status_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "policy_exceptions_status_id,policy_exceptions_status_name,policy_exceptions_status_description,policy_exceptions_status_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[policy_exceptions_status_id],$line[policy_exceptions_status_name],$line[policy_exceptions_status_descripion],$line[policy_exceptions_status_disabled]\n");
	}
	
	fclose($handler);

}

?>
