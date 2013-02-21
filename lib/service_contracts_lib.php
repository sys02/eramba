<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/service_contracts/service_contracts/ - SAMEPLE

include_once("mysql_lib.php");
include_once("tp_lib.php");
include_once("service_contracts_security_service_join_lib.php");

function list_service_contracts($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM service_contracts_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_service_contracts($service_contracts_data) {
	$sql = "INSERT INTO
		service_contracts_tbl
		VALUES (
		\"\",
		\"$service_contracts_data[service_contracts_name]\",
		\"$service_contracts_data[service_contracts_description]\",
		\"$service_contracts_data[service_contracts_value]\",
		\"$service_contracts_data[service_contracts_start]\",
		\"$service_contracts_data[service_contracts_end]\",
		\"$service_contracts_data[service_contracts_provider_id]\",
		\"0\"
		)
		";	
	
	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_service_contracts($service_contracts_data, $service_contracts_id) {
	$sql = "UPDATE service_contracts_tbl
		SET
		service_contracts_name=\"$service_contracts_data[service_contracts_name]\",
		service_contracts_description=\"$service_contracts_data[service_contracts_description]\",
		service_contracts_value=\"$service_contracts_data[service_contracts_value]\",
		service_contracts_start=\"$service_contracts_data[service_contracts_start]\",
		service_contracts_end=\"$service_contracts_data[service_contracts_end]\", 
		service_contracts_provider_id=\"$service_contracts_data[service_contracts_provider_id]\"
		WHERE
		service_contracts_id=\"$service_contracts_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_service_contracts($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from service_contracts_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_service_contracts($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM service_contracts_tbl WHERE service_contracts_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[service_contracts_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[service_contracts_id]\">$results_item[service_contracts_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[service_contracts_id]\">$results_item[service_contracts_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[service_contracts_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[service_contracts_id]\">$results_item[service_contracts_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[service_contracts_id]\">$results_item[service_contracts_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[service_contracts_id]\">$results_item[service_contracts_name]</option>\n"; 
		}
	}

}

function disable_service_contracts($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE service_contracts_tbl SET service_contracts_disabled=\"1\" WHERE service_contracts_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);

	# he is also taking out all the support contracts assigned to services
	$list = list_service_contracts_security_services(" WHERE service_contracts_id = \"$item_id\"");
	if ($list) {
		foreach($list as $item) {
			delete_service_contracts_security_services($item[security_services_id]);	
		}
	}	

	return;
}

function export_service_contracts_csv() {

	# this will dump the table service_contracts_tbl on CSV format
	$sql = "SELECT * from service_contracts_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/service_contracts_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "service_contracts_provider_name,service_contracts_id,service_contracts_name,service_contracts_description,service_contracts_value,service_contracts_start,service_contracts_end,service_contracts_disabled\n");

	foreach($result as $line) {

		$service_provider_name = lookup_tp("tp_id","$line[service_contracts_provider_id]");

		fwrite($handler,"$service_provider_name[tp_name],$line[service_contracts_id],$line[service_contracts_name],$line[service_contracts_description],$line[service_contracts_value],$line[service_contracts_start], $line[service_contracts_end],$line[service_contracts_disabled]\n");

	}
	
	fclose($handler);

}

?>
