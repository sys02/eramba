<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/asset_classification/asset_classification/ - SAMEPLE

include_once("mysql_lib.php");

function pre_selected_asset_classification_values($asset_classification_type, $asset_id) {

	# i need to know all classification id's with the "asset_classification_type" value
	# i need to know all classifications made with the asset $asset_id
	# i need to mix those two
	
	# i need to know all classification id's with the "asset_classification_type" value
	$sql = "SELECT
		asset_classification_id
		FROM
		asset_classification_tbl
		WHERE
		asset_classification_type = \"$asset_classification_type\"
		AND
		asset_classification_disabled = \"0\"
		";
	# echo "sql1: $sql<br>";
	$classification_id = runQuery($sql);

	# i need to know all classifications made with the asset $asset_id
	$sql = "SELECT
		asset_classification_join_asset_classification_id
		FROM
		asset_classification_join	
		WHERE
		asset_classification_join_asset_id = \"$asset_id\"
		";
	# echo "sql2: $sql<br>";
	$asset_classifications = runQuery($sql);

	# i need to mix those two
	foreach($classification_id as $classification_item) {
		# i need to know if any of this is used by the asset id
		foreach($asset_classifications as $asset_classification_item) {
			if ($classification_item[asset_classification_id] == $asset_classification_item[asset_classification_join_asset_classification_id]) {
				return $asset_classification_item[asset_classification_join_asset_classification_id];
			}
		}	
	}
}

# this function inserts classifications for assets
function lookup_asset_classification_join($asset_classification_join_asset_id) {
	if (!is_numeric($asset_classification_join_asset_id)) {
		return;
	}

	$sql = "SELECT
		*
		FROM
		asset_classification_join
		WHERE
		asset_classification_join_asset_id = \"$asset_classification_join_asset_id\"
		";
	$results = runQuery($sql);
	return $results;
}

# this function inserts classifications for assets
function add_asset_classification_join($asset_classification_join_asset_id, $asset_classification_join_asset_classification_id) {

	if (!is_numeric($asset_classification_join_asset_id)) {
		return;
	}
	
	$sql = "INSERT INTO
		asset_classification_join
		VALUES (
		\"$asset_classification_join_asset_id\",
		\"$asset_classification_join_asset_classification_id\"
		)
		";	

	$result = runUpdateQuery($sql);
	return $result;
}

# this function deletes form the table asset_classification_join_id all asociated items with asset $asset_id
function delete_asset_classification_join($asset_id) {

	if (!is_numeric($asset_id)) {
		return;
	}
	
	$sql = "DELETE
		from
		asset_classification_join
		WHERE
		asset_classification_join_asset_id = \"$asset_id\"
		";
	
	$result = runUpdateQuery($sql);
	return $result;
}

# This functions returns the number of classifications (maximum 5) to list assets in html
function list_asset_classification_distinct() {
	$sql = "SELECT
		DISTINCT
		asset_classification_type
		FROM
		asset_classification_tbl
		WHERE
		asset_classification_disabled = \"0\"
		LIMIT
		5
		"; 
	$results = runQuery($sql);
	return $results;
}

function list_asset_classification($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM asset_classification_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_asset_classification($asset_classification_data) {
	$sql = "INSERT INTO
		asset_classification_tbl
		VALUES (
		\"$asset_classification_data[asset_classification_id]\",
		\"$asset_classification_data[asset_classification_name]\",
		\"$asset_classification_data[asset_classification_criteria]\",
		\"$asset_classification_data[asset_classification_type]\",
		\"$asset_classification_data[asset_classification_value]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_asset_classification($asset_classification_data, $asset_classification_id) {
	$sql = "UPDATE asset_classification_tbl
		SET
		asset_classification_name=\"$asset_classification_data[asset_classification_name]\",
		asset_classification_criteria=\"$asset_classification_data[asset_classification_criteria]\",
		asset_classification_type=\"$asset_classification_data[asset_classification_type]\",
		asset_classification_value=\"$asset_classification_data[asset_classification_value]\"
		WHERE
		asset_classification_id=\"$asset_classification_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_asset_classification($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from asset_classification_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_asset_classification($pre_selected_items='', $order_clause='', $asset_classification_type) {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM asset_classification_tbl WHERE asset_classification_type = \"$asset_classification_type\" AND asset_classification_disabled = \"0\"".$order_clause;
	# echo "PUTA: $sql";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[asset_classification_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[asset_classification_id]\">$results_item[asset_classification_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_classification_id]\">$results_item[asset_classification_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[asset_classification_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[asset_classification_id]\">$results_item[asset_classification_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_classification_id]\">$results_item[asset_classification_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[asset_classification_id]\">$results_item[asset_classification_name]</option>\n"; 
		}
	}

}

function disable_asset_classification($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE asset_classification_tbl SET asset_classification_disabled=\"1\" WHERE asset_classification_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_asset_classification_csv() {

	# this will dump the table asset_classification_tbl on CSV format
	$sql = "SELECT * from asset_classification_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/asset_classification_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "asset_classification_id,asset_classification_name,asset_classification_description,asset_classification_type, asset_classification_value, asset_classification_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[asset_classification_id],$line[asset_classification_name],$line[asset_classification_criteria],$line[asset_classification_type], $line[asset_classification_value],$line[asset_classification_disabled]\n");
	}
	
	fclose($handler);

}

?>




