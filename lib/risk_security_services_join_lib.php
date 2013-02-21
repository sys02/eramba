<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_security_services_join/category/ - SAMEPLE

include_once("mysql_lib.php");

function list_risk_security_services_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_security_services_join".$arguments;
	$results = runQuery($sql);
	return $results;
}

# this function deletes form the table risk_classification_join_id all asociated items with risk $risk_id
function delete_risk_security_services_join($risk_id) {

	if (!is_numeric($risk_id)) {
		return;
	}
	
	$sql = "DELETE
		from
		risk_security_services_join	
		WHERE
		risk_security_services_join_risk_id = \"$risk_id\"
		";
	
	$result = runUpdateQuery($sql);
	return $result;
}

# this function deletes form the table risk_classification_join_id all asociated items with risk $risk_id
# warning!
function delete_risk_security_services_join_service_delete($service_id) {

	if (!is_numeric($service_id)) {
		return;
	}
	
	$sql = "DELETE
		from
		risk_security_services_join	
		WHERE
		risk_security_services_join_security_services_id = \"$service_id\"
		";
	
	$result = runUpdateQuery($sql);
	return $result;
}

function add_risk_security_services_join($risk_id, $security_services_id) {
	$sql = "INSERT INTO
		risk_security_services_join
		VALUES (
		\"$risk_id\",
		\"$security_services_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_risk_security_services_join($category_data, $category_id) {
	$sql = "UPDATE risk_security_services_join
		SET
		\"$risk_security_services_join_data[risk_security_services_join_risk_id]\",
		\"$risk_security_services_join_data[risk_security_services_join_security_services_id]\"
		WHERE
		risk_security_services_join_id=\"$category_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_security_services_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_security_services_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_security_services_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_security_services_join WHERE category_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_security_services_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_security_services_join_id]\">$results_item[category_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_security_services_join_id]\">$results_item[category_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_security_services_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_security_services_join_id]\">$results_item[category_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_security_services_join_id]\">$results_item[category_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_security_services_join_id]\">$results_item[category_name]</option>\n"; 
		}
	}

}

function disable_risk_security_services_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_security_services_join SET category_disabled=\"1\" WHERE category_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_security_services_join_csv() {

	# this will dump the table risk_security_services_join on CSV format
	$sql = "SELECT * from risk_security_services_join";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_security_services_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_security_services_join_id,category_name,category_description,category_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[risk_security_services_join_id],$line[category_name],$line[category_descripion],$line[category_disabled]\n");
	}
	
	fclose($handler);

}

?>
