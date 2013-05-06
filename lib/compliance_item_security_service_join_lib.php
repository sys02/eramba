<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/compliance_item_security_services_join/compliance_item_security_services_join/ - SAMEPLE

include_once("mysql_lib.php");

function list_compliance_item_security_services_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM compliance_security_services_join".$arguments;
	# echo "$sql<br>";
	$results = runQuery($sql);
	return $results;
}

function delete_compliance_item_security_services_join($compliance_security_services_join_compliance_id) {
	$sql = "DELETE from compliance_security_services_join where compliance_security_services_join_compliance_id = \"$compliance_security_services_join_compliance_id\"";
	$result = runUpdateQuery($sql);
	return $result;
}

function delete_compliance_item_security_services_join_service_id($service_id) {
	$sql = "DELETE from compliance_security_services_join where compliance_security_services_join_security_services_id = \"$service_id\"";
	$result = runUpdateQuery($sql);
	return $result;
}

function add_compliance_item_security_services_join($compliance_management_item_id, $security_service_id) {
	$sql = "INSERT INTO
		compliance_security_services_join	
		VALUES (
		\"$compliance_management_item_id\",
		\"$security_service_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_compliance_item_security_services_join($compliance_item_security_services_join_data, $compliance_item_security_services_join_id) {
	$sql = "UPDATE compliance_item_security_services_join_tbl
		SET
		compliance_item_security_services_join_name=\"$compliance_item_security_services_join_data[compliance_item_security_services_join_name]\",
		compliance_item_security_services_join_description=\"$compliance_item_security_services_join_data[compliance_item_security_services_join_description]\"
		WHERE
		compliance_item_security_services_join_id=\"$compliance_item_security_services_join_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_compliance_item_security_services_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	#$sql = "SELECT * from compliance_item_security_services_join WHERE $search_parameter = \"$item_id\""; 
	$sql = "SELECT * from compliance_security_services_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_compliance_item_security_services_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM compliance_item_security_services_join_tbl WHERE compliance_item_security_services_join_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[compliance_item_security_services_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[compliance_item_security_services_join_id]\">$results_item[compliance_item_security_services_join_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_item_security_services_join_id]\">$results_item[compliance_item_security_services_join_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[compliance_item_security_services_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[compliance_item_security_services_join_id]\">$results_item[compliance_item_security_services_join_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_item_security_services_join_id]\">$results_item[compliance_item_security_services_join_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[compliance_item_security_services_join_id]\">$results_item[compliance_item_security_services_join_name]</option>\n"; 
		}
	}

}

function disable_compliance_item_security_services_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE compliance_item_security_services_join_tbl SET compliance_item_security_services_join_disabled=\"1\" WHERE compliance_item_security_services_join_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_compliance_item_security_services_join_csv() {

	# this will dump the table compliance_item_security_services_join_tbl on CSV format
	$sql = "SELECT * from compliance_item_security_services_join_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/compliance_item_security_services_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "compliance_item_security_services_join_id,compliance_item_security_services_join_name,compliance_item_security_services_join_description,compliance_item_security_services_join_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[compliance_item_security_services_join_id],$line[compliance_item_security_services_join_name],$line[compliance_item_security_services_join_descripion],$line[compliance_item_security_services_join_disabled]\n");
	}
	
	fclose($handler);

}

?>
