<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_summary/risk_summary/ - SAMEPLE

include_once("mysql_lib.php");

function list_risk_summary($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_summary_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function delete_risk_summary() {
	$sql = "DELETE from risk_summary_tbl WHERE 1=1";
	$result = runUpdateQuery($sql);
	return $result;
}

function add_risk_summary($risk_summary_data) {
	$sql = "INSERT INTO
		risk_summary_tbl
		VALUES (
		\"$risk_summary_data[risk_summary_id]\",
		\"$risk_summary_data[risk_summary_type]\",
		\"$risk_summary_data[risk_summary_name]\",
		\"$risk_summary_data[risk_summary_risk_counter]\",
		\"$risk_summary_data[risk_summary_opex]\",
		\"$risk_summary_data[risk_summary_capex]\",
		\"$risk_summary_data[risk_summary_resources]\",
		\"$risk_summary_data[risk_summary_score]\",
		\"$risk_summary_data[risk_summary_residual]\",
		\"$risk_summary_data[risk_summary_incident_counter]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_risk_summary($risk_summary_data, $risk_summary_id) {
	$sql = "UPDATE risk_summary_tbl
		SET
		risk_summary_name=\"$risk_summary_data[risk_summary_name]\",
		risk_summary_description=\"$risk_summary_data[risk_summary_description]\"
		WHERE
		risk_summary_id=\"$risk_summary_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_summary($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_summary_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_summary($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_summary_tbl WHERE risk_summary_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_summary_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_summary_id]\">$results_item[risk_summary_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_summary_id]\">$results_item[risk_summary_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_summary_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_summary_id]\">$results_item[risk_summary_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_summary_id]\">$results_item[risk_summary_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_summary_id]\">$results_item[risk_summary_name]</option>\n"; 
		}
	}

}

function disable_risk_summary($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_summary_tbl SET risk_summary_disabled=\"1\" WHERE risk_summary_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_summary_csv() {

	# this will dump the table risk_summary_tbl on CSV format
	$sql = "SELECT * from risk_summary_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_summary_list.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_summary_id,risk_summary_type,risk_summary_name,risk_summary_risk_counter,risk_summary_opex,risk_summary_capex,risk_summary_resources,risk_summary_score,risk_summary_residual,risk_summary_incident_counter,risk_summary_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[risk_summary_id],$line[risk_summary_type],$line[risk_summary_name],$line[risk_summary_risk_counter],$line[risk_summary_opex],$line[risk_summary_capex],$line[risk_summary_resources],$line[risk_summary_score],$line[risk_summary_residual],$line[risk_summary_incident_counter],$line[risk_summary_disabled]\n");
	}
	
	fclose($handler);

}

?>
