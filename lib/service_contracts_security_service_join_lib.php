<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/service_contracts_security_services/service_contracts_security_services/ - SAMEPLE

include_once("mysql_lib.php");

function list_service_contracts_security_services($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM service_contracts_security_services_join".$arguments;
	$results = runQuery($sql);
	return $results;
}

function delete_service_contracts_security_services($security_services_id) {
	$sql = "DELETE FROM 
		service_contracts_security_services_join
		WHERE
		security_services_id = \"$security_services_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function add_service_contracts_security_services($service_contracts_id, $security_services_id) {
	$sql = "INSERT INTO
		service_contracts_security_services_join
		VALUES (
		\"$security_services_id\",
		\"$service_contracts_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_service_contracts_security_services($service_contracts_security_services_data, $service_contracts_security_services_id) {
	$sql = "UPDATE service_contracts_security_services_join
		SET
		service_contracts_security_services_name=\"$service_contracts_security_services_data[service_contracts_security_services_name]\",
		service_contracts_security_services_description=\"$service_contracts_security_services_data[service_contracts_security_services_description]\"
		WHERE
		service_contracts_security_services_id=\"$service_contracts_security_services_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_service_contracts_security_services($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from service_contracts_security_services_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_service_contracts_security_services($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM service_contracts_security_services_join WHERE service_contracts_security_services_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[service_contracts_security_services_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[service_contracts_security_services_id]\">$results_item[service_contracts_security_services_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[service_contracts_security_services_id]\">$results_item[service_contracts_security_services_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[service_contracts_security_services_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[service_contracts_security_services_id]\">$results_item[service_contracts_security_services_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[service_contracts_security_services_id]\">$results_item[service_contracts_security_services_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[service_contracts_security_services_id]\">$results_item[service_contracts_security_services_name]</option>\n"; 
		}
	}

}

function disable_service_contracts_security_services($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE service_contracts_security_services_join SET service_contracts_security_services_disabled=\"1\" WHERE service_contracts_security_services_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_service_contracts_security_services_csv() {

	# this will dump the table service_contracts_security_services_join on CSV format
	$sql = "SELECT * from service_contracts_security_services_join";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/service_contracts_security_services_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "service_contracts_security_services_id,service_contracts_security_services_name,service_contracts_security_services_description,service_contracts_security_services_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[service_contracts_security_services_id],$line[service_contracts_security_services_name],$line[service_contracts_security_services_descripion],$line[service_contracts_security_services_disabled]\n");
	}
	
	fclose($handler);

}

?>
