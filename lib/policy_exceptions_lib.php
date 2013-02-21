<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/policy_exceptions/policy_exceptions/ - SAMEPLE

include_once("mysql_lib.php");

function set_exceptions_to_expire() {

	$policy_exceptions_list = list_policy_exceptions(" WHERE policy_exceptions_disabled = \"0\" AND policy_exceptions_expiration_date < CURDATE()");

	foreach($policy_exceptions_list as $policy_exceptions_item) {

		$policy_exceptions_update = array(
			'policy_exceptions_title' => $policy_exceptions_item[policy_exceptions_title],
			'policy_exceptions_description' => $policy_exceptions_item[policy_exceptions_description],
			'policy_exceptions_status' => "3",
			'policy_exceptions_owner' => $policy_exceptions_item[policy_exceptions_owner],
			'policy_exceptions_expiration_date' => $policy_exceptions_item[policy_exceptions_expiration_date]
		);	

		update_policy_exceptions($policy_exceptions_update,$policy_exceptions_item[policy_exceptions_id]);
	}

}

function list_policy_exceptions($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM policy_exceptions_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_policy_exceptions($policy_exceptions_data) {
	$sql = "INSERT INTO
		policy_exceptions_tbl
		VALUES (
		\"\",
		\"$policy_exceptions_data[policy_exceptions_title]\",
		\"$policy_exceptions_data[policy_exceptions_description]\",
		\"$policy_exceptions_data[policy_exceptions_status]\",
		\"$policy_exceptions_data[policy_exceptions_owner]\",
		\"$policy_exceptions_data[policy_exceptions_expiration_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_policy_exceptions($policy_exceptions_data, $policy_exceptions_id) {
	$sql = "UPDATE policy_exceptions_tbl
		SET
		policy_exceptions_title=\"$policy_exceptions_data[policy_exceptions_title]\",
		policy_exceptions_description=\"$policy_exceptions_data[policy_exceptions_description]\",
		policy_exceptions_status=\"$policy_exceptions_data[policy_exceptions_status]\",
		policy_exceptions_owner=\"$policy_exceptions_data[policy_exceptions_owner]\",
		policy_exceptions_expiration_date=\"$policy_exceptions_data[policy_exceptions_expiration_date]\"
		WHERE
		policy_exceptions_id=\"$policy_exceptions_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_policy_exceptions($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from policy_exceptions_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_policy_exceptions($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM policy_exceptions_tbl WHERE policy_exceptions_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[policy_exceptions_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[policy_exceptions_id]\">$results_item[policy_exceptions_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[policy_exceptions_id]\">$results_item[policy_exceptions_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[policy_exceptions_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[policy_exceptions_id]\">$results_item[policy_exceptions_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[policy_exceptions_id]\">$results_item[policy_exceptions_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[policy_exceptions_id]\">$results_item[policy_exceptions_name]</option>\n"; 
		}
	}

}

function disable_policy_exceptions($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE policy_exceptions_tbl SET policy_exceptions_disabled=\"1\" WHERE policy_exceptions_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_policy_exceptions_csv() {

	# this will dump the table policy_exceptions_tbl on CSV format
	$sql = "SELECT * from policy_exceptions_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/policy_exceptions_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "policy_exceptions_id,policy_exceptions_title,policy_exceptions_description,policy_exceptions_status,policy_exceptions_owner,policy_exceptions_expiration_date,policy_exceptions_disabled\n");

	foreach($result as $line) {
		$status = lookup_policy_exceptions_status("policy_exceptions_status_id",$line[policy_exceptions_status]);
		fwrite($handler,"$line[policy_exceptions_id],$line[policy_exceptions_title],$line[policy_exceptions_description],$status[policy_exceptions_status_name],$line[policy_exceptions_owner],$line[policy_exceptions_expiration_date],$line[policy_exceptions_disabled]\n");

	}
	
	fclose($handler);

}

?>
