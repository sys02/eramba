<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/tp/tp/ - SAMEPLE

include_once("mysql_lib.php");

function list_tp($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM tp_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_tp($tp_data) {
	$sql = "INSERT INTO
		tp_tbl
		VALUES (
		\"$tp_data[tp_id]\",
		\"$tp_data[tp_name]\",
		\"$tp_data[tp_description]\",
		\"$tp_data[tp_type_id]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_tp($tp_data, $tp_id) {
	$sql = "UPDATE tp_tbl
		SET
		tp_name=\"$tp_data[tp_name]\",
		tp_description=\"$tp_data[tp_description]\",
		tp_type_id=\"$tp_data[tp_type_id]\"
		WHERE
		tp_id=\"$tp_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_tp($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from tp_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_tp($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
	$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM tp_tbl WHERE tp_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[tp_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[tp_id]\">$results_item[tp_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[tp_id]\">$results_item[tp_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[tp_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[tp_id]\">$results_item[tp_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[tp_id]\">$results_item[tp_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[tp_id]\">$results_item[tp_name]</option>\n"; 
		}
	}

}

function disable_tp($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE tp_tbl SET tp_disabled=\"1\" WHERE tp_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_tp_csv() {

	# this will dump the table tp_tbl on CSV format
	$sql = "SELECT * from tp_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/tp_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "tp_id,tp_name,tp_type,tp_description,tp_disabled\n");
	foreach($result as $line) {
		$tp_type_name = lookup_tp_type("tp_type_id",$line[tp_type_id]);
		fwrite($handler,"$line[tp_id],$line[tp_name],$tp_type_name[tp_type_name],$line[tp_description],$line[tp_disabled]\n");
	}
	
	fclose($handler);

}

?>
