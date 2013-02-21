<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/asset_bu_join/asset_bu_join/ - SAMEPLE

include_once("mysql_lib.php");

function list_asset_bu_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM asset_bu_join".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_asset_bu_join($asset_id, $bu_id) {
	$sql = "INSERT INTO
		asset_bu_join
		VALUES (
		\"$asset_id\",
		\"$bu_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function delete_asset_bu_join($asset_id) {
	$sql = "DELETE from asset_bu_join
		WHERE
		asset_bu_join_asset_id=\"$asset_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_asset_bu_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from asset_bu_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_asset_bu_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM asset_bu_join WHERE asset_bu_join_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[asset_bu_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[asset_bu_join_id]\">$results_item[asset_bu_join_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_bu_join_id]\">$results_item[asset_bu_join_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[asset_bu_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[asset_bu_join_id]\">$results_item[asset_bu_join_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_bu_join_id]\">$results_item[asset_bu_join_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[asset_bu_join_id]\">$results_item[asset_bu_join_name]</option>\n"; 
		}
	}

}

function disable_asset_bu_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE asset_bu_join SET asset_bu_join_disabled=\"1\" WHERE asset_bu_join_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_asset_bu_join_csv() {

	# this will dump the table asset_bu_join on CSV format
	$sql = "SELECT * from asset_bu_join";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/asset_bu_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "asset_bu_join_id,asset_bu_join_name,asset_bu_join_description,asset_bu_join_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[asset_bu_join_id],$line[asset_bu_join_name],$line[asset_bu_join_descripion],$line[asset_bu_join_disabled]\n");
	}
	
	fclose($handler);

}

?>
