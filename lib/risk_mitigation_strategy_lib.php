<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_mitigation_strategy/risk_mitigation_strategy/ - SAMEPLE

include_once("mysql_lib.php");

function list_risk_mitigation_strategy($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_mitigation_strategy_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_risk_mitigation_strategy($risk_mitigation_strategy_data) {
	$sql = "INSERT INTO
		risk_mitigation_strategy_tbl
		VALUES (
		\"$risk_mitigation_strategy_data[risk_mitigation_strategy_id]\",
		\"$risk_mitigation_strategy_data[risk_mitigation_strategy_name]\",
		\"$risk_mitigation_strategy_data[risk_mitigation_strategy_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_risk_mitigation_strategy($risk_mitigation_strategy_data, $risk_mitigation_strategy_id) {
	$sql = "UPDATE risk_mitigation_strategy_tbl
		SET
		risk_mitigation_strategy_name=\"$risk_mitigation_strategy_data[risk_mitigation_strategy_name]\",
		risk_mitigation_strategy_description=\"$risk_mitigation_strategy_data[risk_mitigation_strategy_description]\"
		WHERE
		risk_mitigation_strategy_id=\"$risk_mitigation_strategy_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_mitigation_strategy($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_mitigation_strategy_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_mitigation_strategy($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_mitigation_strategy_tbl WHERE risk_mitigation_strategy_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_mitigation_strategy_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_mitigation_strategy_id]\">$results_item[risk_mitigation_strategy_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_mitigation_strategy_id]\">$results_item[risk_mitigation_strategy_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_mitigation_strategy_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_mitigation_strategy_id]\">$results_item[risk_mitigation_strategy_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_mitigation_strategy_id]\">$results_item[risk_mitigation_strategy_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_mitigation_strategy_id]\">$results_item[risk_mitigation_strategy_name]</option>\n"; 
		}
	}

}

function disable_risk_mitigation_strategy($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_mitigation_strategy_tbl SET risk_mitigation_strategy_disabled=\"1\" WHERE risk_mitigation_strategy_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_mitigation_strategy_csv() {

	# this will dump the table risk_mitigation_strategy_tbl on CSV format
	$sql = "SELECT * from risk_mitigation_strategy_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_mitigation_strategy_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_mitigation_strategy_id,risk_mitigation_strategy_name,risk_mitigation_strategy_description,risk_mitigation_strategy_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[risk_mitigation_strategy_id],$line[risk_mitigation_strategy_name],$line[risk_mitigation_strategy_descripion],$line[risk_mitigation_strategy_disabled]\n");
	}
	
	fclose($handler);

}

?>




