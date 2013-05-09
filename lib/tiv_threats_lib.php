<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/tiv_threats/tiv_threats/ - SAMEPLE

include_once("mysql_lib.php");

function list_tiv_threats($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM tiv_threats_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_tiv_threats($tiv_threats_data) {
	$sql = "INSERT INTO
		tiv_threats_tbl
		VALUES (
		\"$tiv_threats_data[tiv_threats_id]\",
		\"$tiv_threats_data[tiv_threats_name]\",
		\"$tiv_threats_data[tiv_threats_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_tiv_threats($tiv_threats_data, $tiv_threats_id) {
	$sql = "UPDATE tiv_threats_tbl
		SET
		tiv_threats_name=\"$tiv_threats_data[tiv_threats_name]\",
		tiv_threats_description=\"$tiv_threats_data[tiv_threats_description]\"
		WHERE
		tiv_threats_id=\"$tiv_threats_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_tiv_threats($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from tiv_threats_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_tiv_threats($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM tiv_threats_tbl WHERE tiv_threats_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[tiv_threats_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[tiv_threats_id]\">$results_item[tiv_threats_category] - $results_item[tiv_threats_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[tiv_threats_id]\">$results_item[tiv_threats_category] - $results_item[tiv_threats_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[tiv_threats_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[tiv_threats_id]\">$results_item[tiv_threats_category] - $results_item[tiv_threats_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[tiv_threats_id]\">$results_item[tiv_threats_category] - $results_item[tiv_threats_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[tiv_threats_id]\">$results_item[tiv_threats_category] - $results_item[tiv_threats_name]</option>\n"; 
		}
	}

}

function disable_tiv_threats($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE tiv_threats_tbl SET tiv_threats_disabled=\"1\" WHERE tiv_threats_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_tiv_threats_csv() {

	# this will dump the table tiv_threats_tbl on CSV format
	$sql = "SELECT * from tiv_threats_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/tiv_threats_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "tiv_threats_id,tiv_threats_name,tiv_threats_description,tiv_threats_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[tiv_threats_id],$line[tiv_threats_name],$line[tiv_threats_descripion],$line[tiv_threats_disabled]\n");
	}
	
	fclose($handler);

}

?>
