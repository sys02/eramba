<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/asset_label/asset_label/ - SAMEPLE

include_once("mysql_lib.php");

function list_asset_label($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM asset_label_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_asset_label($asset_label_data) {
	$sql = "INSERT INTO
		asset_label_tbl
		VALUES (
		\"$asset_label_data[asset_label_id]\",
		\"$asset_label_data[asset_label_name]\",
		\"$asset_label_data[asset_label_criteria]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_asset_label($asset_label_data, $asset_label_id) {
	$sql = "UPDATE asset_label_tbl
		SET
		asset_label_name=\"$asset_label_data[asset_label_name]\",
		asset_label_criteria=\"$asset_label_data[asset_label_criteria]\"
		WHERE
		asset_label_id=\"$asset_label_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_asset_label($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from asset_label_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_asset_label($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM asset_label_tbl WHERE asset_label_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[asset_label_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[asset_label_id]\">$results_item[asset_label_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_label_id]\">$results_item[asset_label_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[asset_label_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[asset_label_id]\">$results_item[asset_label_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_label_id]\">$results_item[asset_label_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[asset_label_id]\">$results_item[asset_label_name]</option>\n"; 
		}
	}

}

function disable_asset_label($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE asset_label_tbl SET asset_label_disabled=\"1\" WHERE asset_label_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_asset_label_csv() {

	# this will dump the table asset_label_tbl on CSV format
	$sql = "SELECT * from asset_label_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/asset_label_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "asset_label_id,asset_label_name,asset_label_criteria,asset_label_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[asset_label_id],$line[asset_label_name],$line[asset_label_criteria],$line[asset_label_disabled]\n");
	}
	
	fclose($handler);

}

?>
