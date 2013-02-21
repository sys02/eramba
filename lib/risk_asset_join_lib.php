<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_asset_join/risk_asset_join/ - SAMEPLE

include_once("mysql_lib.php");

function list_risk_asset_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_asset_join_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_risk_asset_join($risk_id, $asset_id) {
	$sql = "INSERT INTO
		risk_asset_join_tbl
		VALUES (
		\"$risk_id\",
		\"$asset_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_risk_asset_join($risk_asset_join_data, $risk_asset_join_id) {
	$sql = "UPDATE risk_asset_join_tbl
		SET
		risk_asset_join_name=\"$risk_asset_join_data[risk_asset_join_name]\",
		risk_asset_join_description=\"$risk_asset_join_data[risk_asset_join_description]\"
		WHERE
		risk_asset_join_id=\"$risk_asset_join_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_asset_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_asset_join_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_asset_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_asset_join_tbl WHERE risk_asset_join_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_asset_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_asset_join_id]\">$results_item[risk_asset_join_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_asset_join_id]\">$results_item[risk_asset_join_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_asset_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_asset_join_id]\">$results_item[risk_asset_join_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_asset_join_id]\">$results_item[risk_asset_join_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_asset_join_id]\">$results_item[risk_asset_join_name]</option>\n"; 
		}
	}

}

function delete_risk_asset_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "DELETE risk_asset_join_tbl WHERE risk_asset_join_risk_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function disable_risk_asset_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_asset_join_tbl SET risk_asset_join_disabled=\"1\" WHERE risk_asset_join_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_asset_join_csv() {

	# this will dump the table risk_asset_join_tbl on CSV format
	$sql = "SELECT * from risk_asset_join_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_asset_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_asset_join_id,risk_asset_join_name,risk_asset_join_description,risk_asset_join_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[risk_asset_join_id],$line[risk_asset_join_name],$line[risk_asset_join_descripion],$line[risk_asset_join_disabled]\n");
	}
	
	fclose($handler);

}

?>




