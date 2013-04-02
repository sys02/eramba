<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/compliance_audit/compliance_audit/ - SAMEPLE

include_once("mysql_lib.php");

function list_compliance_audit($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM compliance_audit_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_compliance_audit($compliance_audit_data) {
	$sql = "INSERT INTO
		compliance_audit_tbl
		VALUES (
		\"$compliance_audit_data[compliance_audit_id]\",
		\"$compliance_audit_data[compliance_audit_title]\",
		\"$compliance_audit_data[compliance_audit_date]\",
		\"$compliance_audit_data[compliance_audit_package_id]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_compliance_audit($compliance_audit_data, $compliance_audit_id) {
	$sql = "UPDATE compliance_audit_tbl
		SET
		compliance_audit_title=\"$compliance_audit_data[compliance_audit_title]\",
		compliance_audit_date=\"$compliance_audit_data[compliance_audit_date]\",
		compliance_audit_package_id=\"$compliance_audit_data[compliance_audit_package_id]\"
		WHERE
		compliance_audit_id=\"$compliance_audit_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_compliance_audit($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from compliance_audit_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_compliance_audit($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM compliance_audit_tbl WHERE compliance_audit_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[compliance_audit_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[compliance_audit_id]\">$results_item[compliance_audit_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_audit_id]\">$results_item[compliance_audit_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[compliance_audit_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[compliance_audit_id]\">$results_item[compliance_audit_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_audit_id]\">$results_item[compliance_audit_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[compliance_audit_id]\">$results_item[compliance_audit_name]</option>\n"; 
		}
	}

}

function disable_compliance_audit($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE compliance_audit_tbl SET compliance_audit_disabled=\"1\" WHERE compliance_audit_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_compliance_audit_csv() {

	# this will dump the table compliance_audit_tbl on CSV format
	$sql = "SELECT * from compliance_audit_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/compliance_audit_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "compliance_audit_id,compliance_audit_name,compliance_audit_description,compliance_audit_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[compliance_audit_id],$line[compliance_audit_name],$line[compliance_audit_descripion],$line[compliance_audit_disabled]\n");
	}
	
	fclose($handler);

}

?>
