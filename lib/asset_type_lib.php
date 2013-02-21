<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/asset_media_type/asset_media_type/ - SAMEPLE

include_once("mysql_lib.php");

function list_asset_media_type($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM asset_media_type_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_asset_media_type($asset_media_type_data) {
	$sql = "INSERT INTO
		asset_media_type_tbl
		VALUES (
		\"$asset_media_type_data[asset_media_type_id]\",
		\"$asset_media_type_data[asset_media_type_name]\",
		\"$asset_media_type_data[asset_media_type_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_asset_media_type($asset_media_type_data, $asset_media_type_id) {
	$sql = "UPDATE asset_media_type_tbl
		SET
		asset_media_type_name=\"$asset_media_type_data[asset_media_type_name]\",
		asset_media_type_description=\"$asset_media_type_data[asset_media_type_description]\"
		WHERE
		asset_media_type_id=\"$asset_media_type_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_asset_media_type($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from asset_media_type_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_asset_media_type($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM asset_media_type_tbl WHERE asset_media_type_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[asset_media_type_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[asset_media_type_id]\">$results_item[asset_media_type_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_media_type_id]\">$results_item[asset_media_type_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[asset_media_type_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[asset_media_type_id]\">$results_item[asset_media_type_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_media_type_id]\">$results_item[asset_media_type_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[asset_media_type_id]\">$results_item[asset_media_type_name]</option>\n"; 
		}
	}


}

function disable_asset_media_type($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE asset_media_type_tbl SET asset_media_type_disabled=\"1\" WHERE asset_media_type_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_asset_media_type_csv() {

	# this will dump the table asset_media_type_tbl on CSV format
	$sql = "SELECT * from asset_media_type_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/asset_media_type_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "asset_media_type_id,asset_media_type_name,asset_media_type_description,asset_media_type_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[asset_media_type_id],$line[asset_media_type_name],$line[asset_media_type_descripion],$line[asset_media_type_disabled]\n");
	}
	
	fclose($handler);

}

?>




