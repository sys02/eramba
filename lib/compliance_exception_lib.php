<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/compliance_exception/compliance_exception/ - SAMEPLE

include_once("mysql_lib.php");

function list_compliance_exception($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM compliance_exception_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_compliance_exception($compliance_exception_data) {
	$sql = "INSERT INTO
		compliance_exception_tbl
		VALUES (
		\"$compliance_exception_data[compliance_exception_id]\",
		\"$compliance_exception_data[compliance_exception_title]\",
		\"$compliance_exception_data[compliance_exception_description]\",
		\"$compliance_exception_data[compliance_exception_author]\",
		\"$compliance_exception_data[compliance_exception_expiration]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_compliance_exception($compliance_exception_data, $compliance_exception_id) {
	$sql = "UPDATE compliance_exception_tbl
		SET
		compliance_exception_title=\"$compliance_exception_data[compliance_exception_title]\",
		compliance_exception_description=\"$compliance_exception_data[compliance_exception_description]\",
		compliance_exception_author=\"$compliance_exception_data[compliance_exception_author]\",
		compliance_exception_expiration=\"$compliance_exception_data[compliance_exception_expiration]\"
		WHERE
		compliance_exception_id=\"$compliance_exception_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_compliance_exception($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from compliance_exception_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_compliance_exception($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM compliance_exception_tbl WHERE compliance_exception_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[compliance_exception_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[compliance_exception_id]\">$results_item[compliance_exception_title]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_exception_id]\">$results_item[compliance_exception_title]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[compliance_exception_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[compliance_exception_id]\">$results_item[compliance_exception_title]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_exception_id]\">$results_item[compliance_exception_title]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[compliance_exception_id]\">$results_item[compliance_exception_title]</option>\n"; 
		}
	}

}

function disable_compliance_exception($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE compliance_exception_tbl SET compliance_exception_disabled=\"1\" WHERE compliance_exception_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_compliance_exception_csv() {

	# this will dump the table compliance_exception_tbl on CSV format
	$sql = "SELECT * from compliance_exception_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/compliance_exception_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "compliance_exception_id,compliance_exception_title,compliance_exception_description,compliance_exception_author, compliance_exception_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[compliance_exception_id],$line[compliance_exception_title],$line[compliance_exception_description],$line[compliance_exception_author],$line[compliance_exception_disabled]\n");
	}
	
	fclose($handler);

}

?>
