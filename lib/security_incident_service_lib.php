<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/security_incident_service/security_incident_service/ - SAMEPLE

include_once("mysql_lib.php");

function list_security_incident_service_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM security_incident_service_join".$arguments;
	$results = runQuery($sql);
	return $results;
}

function delete_security_incident_service_join($incident_id) {
	$sql = "DELETE from
		security_incident_service_join
		WHERE security_incident_service_incident_id = \"$incident_id\"";	
	$result = runUpdateQuery($sql);
	return $result;
}

function delete_security_incident_service_join_service_id($service_id) {
	$sql = "DELETE from
		security_incident_service_join
		WHERE security_incident_service_service_id = \"$service_id\"";	
	$result = runUpdateQuery($sql);
	return $result;
}

function add_security_incident_service_join($incident_id, $security_service_id) {
	$sql = "INSERT INTO
		security_incident_service_join
		VALUES (
		\"$incident_id\",
		\"$security_service_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_security_incident_service_join($security_incident_service_data, $security_incident_service_id) {
	$sql = "UPDATE security_incident_service_join
		SET
		security_incident_service_name=\"$security_incident_service_data[security_incident_service_name]\",
		security_incident_service_description=\"$security_incident_service_data[security_incident_service_description]\"
		WHERE
		security_incident_service_id=\"$security_incident_service_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_security_incident_service_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from security_incident_service_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_security_incident_service_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM security_incident_service_join WHERE security_incident_service_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[security_incident_service_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[security_incident_service_id]\">$results_item[security_incident_service_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_incident_service_id]\">$results_item[security_incident_service_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[security_incident_service_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[security_incident_service_id]\">$results_item[security_incident_service_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_incident_service_id]\">$results_item[security_incident_service_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[security_incident_service_id]\">$results_item[security_incident_service_name]</option>\n"; 
		}
	}

}

function disable_security_incident_service_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE security_incident_service_join SET security_incident_service_disabled=\"1\" WHERE security_incident_service_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_security_incident_service_join_csv() {

	# this will dump the table security_incident_service_join on CSV format
	$sql = "SELECT * from security_incident_service_join";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/security_incident_service_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "security_incident_service_id,security_incident_service_name,security_incident_service_description,security_incident_service_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[security_incident_service_id],$line[security_incident_service_name],$line[security_incident_service_descripion],$line[security_incident_service_disabled]\n");
	}
	
	fclose($handler);

}

?>
