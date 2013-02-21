<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/tp_type/tp_type/ - SAMEPLE

include_once("mysql_lib.php");

function list_tp_type($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM tp_type_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_tp_type($tp_type_data) {
	$sql = "INSERT INTO
		tp_type_tbl
		VALUES (
		\"$tp_type_data[tp_type_id]\",
		\"$tp_type_data[tp_type_name]\",
		\"$tp_type_data[tp_type_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_tp_type($tp_type_data, $tp_type_id) {
	$sql = "UPDATE tp_type_tbl
		SET
		tp_type_name=\"$tp_type_data[tp_type_name]\",
		tp_type_description=\"$tp_type_data[tp_type_description]\"
		WHERE
		tp_type_id=\"$tp_type_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_tp_type($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from tp_type_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_tp_type($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM tp_type_tbl WHERE tp_type_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[tp_type_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[tp_type_id]\">$results_item[tp_type_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[tp_type_id]\">$results_item[tp_type_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[tp_type_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[tp_type_id]\">$results_item[tp_type_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[tp_type_id]\">$results_item[tp_type_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[tp_type_id]\">$results_item[tp_type_name]</option>\n"; 
		}
	}

}

function disable_tp_type($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE tp_type_tbl SET tp_type_disabled=\"1\" WHERE tp_type_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_tp_type_csv() {

	# this will dump the table tp_type_tbl on CSV format
	$sql = "SELECT * from tp_type_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/tp_type_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "tp_type_id,tp_type_name,tp_type_description,tp_type_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[tp_type_id],$line[tp_type_name],$line[tp_type_descripion],$line[tp_type_disabled]\n");
	}
	
	fclose($handler);

}

?>




