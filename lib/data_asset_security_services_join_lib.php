<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/data_asset_security_services_join/data_asset_security_services_join/ - SAMEPLE

include_once("mysql_lib.php");

function list_data_asset_security_services_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM data_asset_security_services_join".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_data_asset_security_services_join($data_asset_id, $security_services_id) {
	$sql = "INSERT INTO
		data_asset_security_services_join
		VALUES (
		\"$data_asset_id\",
		\"$security_services_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}



function update_data_asset_security_services_join($data_asset_security_services_join_data, $data_asset_security_services_join_id) {
	$sql = "UPDATE data_asset_security_services_join
		SET
		data_asset_security_services_join_name=\"$data_asset_security_services_join_data[data_asset_security_services_join_name]\",
		data_asset_security_services_join_description=\"$data_asset_security_services_join_data[data_asset_security_services_join_description]\"
		WHERE
		data_asset_security_services_join_id=\"$data_asset_security_services_join_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_data_asset_security_services_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from data_asset_security_services_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_data_asset_security_services_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM data_asset_security_services_join WHERE data_asset_security_services_join_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[data_asset_security_services_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[data_asset_security_services_join_id]\">$results_item[data_asset_security_services_join_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[data_asset_security_services_join_id]\">$results_item[data_asset_security_services_join_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[data_asset_security_services_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[data_asset_security_services_join_id]\">$results_item[data_asset_security_services_join_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[data_asset_security_services_join_id]\">$results_item[data_asset_security_services_join_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[data_asset_security_services_join_id]\">$results_item[data_asset_security_services_join_name]</option>\n"; 
		}
	}

}

function disable_data_asset_security_services_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE data_asset_security_services_join SET data_asset_security_services_join_disabled=\"1\" WHERE data_asset_security_services_join_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_data_asset_security_services_join_csv() {

	# this will dump the table data_asset_security_services_join on CSV format
	$sql = "SELECT * from data_asset_security_services_join";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/data_asset_security_services_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "data_asset_security_services_join_id,data_asset_security_services_join_name,data_asset_security_services_join_description,data_asset_security_services_join_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[data_asset_security_services_join_id],$line[data_asset_security_services_join_name],$line[data_asset_security_services_join_descripion],$line[data_asset_security_services_join_disabled]\n");
	}
	
	fclose($handler);

}

# this function deletes form the table data_asset_classification_join_id all asociated items with data_asset $data_asset_id
function delete_data_asset_security_services_join($data_asset_id) {

	if (!is_numeric($data_asset_id)) {
		return;
	}
	
	$sql = "DELETE
		from
		data_asset_security_services_join	
		WHERE
		data_asset_security_services_join_data_asset_id = \"$data_asset_id\"
		";
	
	$result = runUpdateQuery($sql);
	return $result;
}

# this function deletes form the table data_asset_classification_join_id all asociated items with data_asset $data_asset_id
function delete_data_asset_security_services_join_delete_service($service_id) {

	if (!is_numeric($service_id)) {
		return;
	}
	
	$sql = "DELETE
		from
		data_asset_security_services_join	
		WHERE
		data_asset_security_services_join_security_services_id = \"$service_id\"
		";
	
	$result = runUpdateQuery($sql);
	return $result;
}

?>
