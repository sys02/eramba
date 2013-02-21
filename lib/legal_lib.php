<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/legal/legal/ - SAMEPLE

include_once("mysql_lib.php");

function list_legal($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM legal_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_legal($legal_data) {
	$sql = "INSERT INTO
		legal_tbl
		VALUES (
		\"$legal_data[legal_id]\",
		\"$legal_data[legal_name]\",
		\"$legal_data[legal_description]\",
		\"$legal_data[legal_disabled]\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_legal($legal_data, $legal_id) {
	$sql = "UPDATE legal_tbl
		SET
		legal_name=\"$legal_data[legal_name]\",
		legal_description=\"$legal_data[legal_description]\"
		WHERE
		legal_id=\"$legal_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_legal($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	$sql = "SELECT * from legal_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_legal($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM legal_tbl WHERE legal_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[legal_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[legal_id]\">$results_item[legal_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[legal_id]\">$results_item[legal_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[legal_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[legal_id]\">$results_item[legal_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[legal_id]\">$results_item[legal_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[legal_id]\">$results_item[legal_name]</option>\n"; 
		}
	}

}

function disable_legal($item) {
	if (!is_numeric($item)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE legal_tbl SET legal_disabled=\"1\" WHERE legal_id = \"$item\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_legal_csv() {

	# this will dump the table legal_tbl on CSV format
	$sql = "SELECT * from legal_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/legal_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "legal_id,legal_name,legal_description,legal_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[legal_id],$line[legal_name],$line[legal_description],$line[legal_disabled]\n");
	}
	
	fclose($handler);

}

?>
