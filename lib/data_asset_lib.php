<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/data_asset/data_asset/ - SAMEPLE

include_once("mysql_lib.php");

function list_data_asset($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM data_asset_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function list_distinct_data_asset() {
	# MUST EDIT
	$sql = "select distinct(data_asset_asset_id) from data_asset_tbl WHERE data_asset_disabled = \"0\"";
	$results = runQuery($sql);
	return $results;
}

function add_data_asset($data_asset_data) {
	$sql = "INSERT INTO
		data_asset_tbl
		VALUES (
		\"\",
		\"$data_asset_data[data_asset_asset_id]\",
		\"$data_asset_data[data_asset_status_id]\",
		\"$data_asset_data[data_asset_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_data_asset($data_asset_data, $data_asset_id) {
	$sql = "UPDATE data_asset_tbl
		SET
		data_asset_status_id=\"$data_asset_data[data_asset_status_id]\",
		data_asset_description=\"$data_asset_data[data_asset_description]\"
		WHERE
		data_asset_id=\"$data_asset_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_data_asset($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from data_asset_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_data_asset($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM data_asset_tbl WHERE data_asset_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[data_asset_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[data_asset_id]\">$results_item[data_asset_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[data_asset_id]\">$results_item[data_asset_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[data_asset_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[data_asset_id]\">$results_item[data_asset_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[data_asset_id]\">$results_item[data_asset_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[data_asset_id]\">$results_item[data_asset_name]</option>\n"; 
		}
	}

}

function disable_data_asset($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE data_asset_tbl SET data_asset_disabled=\"1\" WHERE data_asset_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_data_asset_csv() {

	# this will dump the table data_asset_tbl on CSV format
	$sql = "SELECT * from data_asset_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/data_asset_export.csv";
	$handler = fopen($export_file, 'w');
	
	
	fwrite($handler, "data_asset_id,data_asset_name,data_asset_status,data_asset_status_description,security_controls,data_asset_disabled\n");
	$service_name_list = array();

	foreach($result as $line) {

	$service_name = lookup_security_services("security_services_id",$line[security_services_audit_security_service_id]);	
	$asset_name = lookup_asset("asset_id",$line[data_asset_asset_id]); 
	$data_asset_status_name = lookup_data_asset_status("data_asset_status_id", $line[data_asset_status_id]);
	
	$selected_services_list = list_data_asset_security_services_join(" WHERE data_asset_security_services_join_data_asset_id = \"$line[data_asset_id]\"");
	foreach($selected_services_list as $selected_services_item) {
	$service_name = lookup_security_services("security_services_id",$selected_services_item[data_asset_security_services_join_security_services_id]);
		array_push($service_name_list, $service_name[security_services_name]);
	}
	
	$lista = implode(";",$service_name_list);

	fwrite($handler,"$line[data_asset_id],$asset_name[asset_name],$data_asset_status_name[data_asset_status_name],$line[data_asset_description],$lista,$line[data_asset_disabled]\n");

	}
	
	fclose($handler);

}

?>
