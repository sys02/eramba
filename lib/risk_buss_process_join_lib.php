<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_buss_process_join/risk_buss_process_join/ - SAMEPLE

include_once("mysql_lib.php");

function list_risk_buss_process_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_buss_process_join".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_risk_buss_process_join($risk_id, $bu_id) {
	$sql = "INSERT INTO
		risk_buss_process_join
		VALUES (
		\"$risk_id\",
		\"$bu_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function delete_risk_buss_process_join($risk_id) {
	$sql = "DELETE from risk_buss_process_join
		WHERE	
		risk_buss_process_join_risk_id = \"$risk_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_buss_process_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_buss_process_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_buss_process_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_buss_process_join WHERE risk_buss_process_join_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_buss_process_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_buss_process_join_id]\">$results_item[risk_buss_process_join_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_buss_process_join_id]\">$results_item[risk_buss_process_join_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_buss_process_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_buss_process_join_id]\">$results_item[risk_buss_process_join_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_buss_process_join_id]\">$results_item[risk_buss_process_join_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_buss_process_join_id]\">$results_item[risk_buss_process_join_name]</option>\n"; 
		}
	}

}

function disable_risk_buss_process_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_buss_process_join SET risk_buss_process_join_disabled=\"1\" WHERE risk_buss_process_join_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_buss_process_join_csv() {

	# this will dump the table risk_buss_process_join on CSV format
	$sql = "SELECT * from risk_buss_process_join";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_buss_process_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_buss_process_join_id,risk_buss_process_join_name,risk_buss_process_join_description,risk_buss_process_join_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[risk_buss_process_join_id],$line[risk_buss_process_join_name],$line[risk_buss_process_join_descripion],$line[risk_buss_process_join_disabled]\n");
	}
	
	fclose($handler);

}

?>
