<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/bu/bu/ - SAMEPLE

include_once("mysql_lib.php");
include_once("asset_bu_join_lib.php");
include_once("risk_buss_process_join_lib.php");
include_once("asset_lib.php");
include_once("risk_lib.php");

function list_bu($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM bu_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_bu($bu_data) {
	$sql = "INSERT INTO
		bu_tbl
		VALUES (
		\"$bu_data[bu_id]\",
		\"$bu_data[bu_name]\",
		\"$bu_data[bu_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_bu($bu_data, $bu_id) {
	$sql = "UPDATE bu_tbl
		SET
		bu_name=\"$bu_data[bu_name]\",
		bu_description=\"$bu_data[bu_description]\"
		WHERE
		bu_id=\"$bu_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_bu($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from bu_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_bu($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM bu_tbl WHERE bu_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $bu_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($bu_item[bu_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$bu_item[bu_id]\">$bu_item[bu_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$bu_item[bu_id]\">$bu_item[bu_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($bu_item[bu_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$bu_item[bu_id]\">$bu_item[bu_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$bu_item[bu_id]\">$bu_item[bu_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$bu_item[bu_id]\">$bu_item[bu_name]</option>\n"; 
		}
	}
}

function disable_bu($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}

	# MUST EDIT
	$sql = "UPDATE bu_tbl SET bu_disabled=\"1\" WHERE bu_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	
	# I must also remove all asociated processes
	$process_list = list_process(" WHERE bu_id = \"$item_id\"");
	foreach($process_list as $process_item) {
		disable_process($process_item[process_id]);	
	}

	# i must also remove all associated assets
	$asset_list = list_asset_bu_join(" WHERE asset_bu_join_bu_id = \"$item_id\""); 
	if ($asset_list) {
		foreach($asset_list as $asset_item) {
			delete_asset_bu_join($asset_item[asset_bu_join_asset_id]);
			# now i also need to remove the	assets 
			disable_asset($asset_item[asset_bu_join_asset_id]);
		}
	}

	# i also must remove all risks associated with this bu
	$risk_list = list_risk_buss_process_join(" WHERE risk_buss_process_join_bu_id = \"$item_id\"");	
	if ($risk_list) {
		foreach($risk_list as $risk_item) {
			delete_risk_buss_process_join($risk_item[risk_buss_process_join_risk_id]);	
			#now i need to remove all risks
			disable_risk($risk_item[risk_buss_process_join_risk_id]);
		}
	}

	return;
}

function export_bu_csv() {

	# this will dump the table bu_tbl on CSV format
	$sql = "SELECT * from bu_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/bu_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "bu_id,bu_name,bu_description,bu_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[bu_id],$line[bu_name],$line[bu_description],$line[bu_disabled]\n");
	}
	
	fclose($handler);

}

?>
