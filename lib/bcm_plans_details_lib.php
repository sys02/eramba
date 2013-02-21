<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/bcm_plans_details/bcm_plans_details/ - SAMEPLE

include_once("mysql_lib.php");

function list_bcm_plans_details($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_details_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_bcm_plans_details($bcm_plans_details_data) {
	$sql = "INSERT INTO
		bcm_plans_details_tbl
		VALUES (
		\"$bcm_plans_details_data[bcm_plans_details_id]\",
		\"$bcm_plans_details_data[bcm_plans_details_bcm_plan_id]\",
		\"$bcm_plans_details_data[bcm_plans_details_step]\",
		\"$bcm_plans_details_data[bcm_plans_details_when]\",
		\"$bcm_plans_details_data[bcm_plans_details_who]\",
		\"$bcm_plans_details_data[bcm_plans_details_what]\",
		\"$bcm_plans_details_data[bcm_plans_details_where]\",
		\"$bcm_plans_details_data[bcm_plans_details_how]\",
		\"$bcm_plans_details_data[bcm_plans_details_disabled]\"
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_bcm_plans_details($bcm_plans_details_data, $bcm_plans_details_id) {
	$sql = "UPDATE bcm_plans_details_tbl
		SET
		bcm_plans_details_bcm_plan_id=\"$bcm_plans_details_data[bcm_plans_details_bcm_plan_id]\",
		bcm_plans_details_step=\"$bcm_plans_details_data[bcm_plans_details_step]\",
		bcm_plans_details_when=\"$bcm_plans_details_data[bcm_plans_details_when]\",
		bcm_plans_details_who=\"$bcm_plans_details_data[bcm_plans_details_who]\",
		bcm_plans_details_what=\"$bcm_plans_details_data[bcm_plans_details_what]\",
		bcm_plans_details_where=\"$bcm_plans_details_data[bcm_plans_details_where]\",
		bcm_plans_details_how=\"$bcm_plans_details_data[bcm_plans_details_how]\"
		WHERE
		bcm_plans_details_id=\"$bcm_plans_details_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_bcm_plans_details($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from bcm_plans_details_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_bcm_plans_details($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_details_tbl WHERE bcm_plans_details_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[bcm_plans_details_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_details_id]\">$results_item[bcm_plans_details_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_details_id]\">$results_item[bcm_plans_details_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[bcm_plans_details_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_details_id]\">$results_item[bcm_plans_details_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_details_id]\">$results_item[bcm_plans_details_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[bcm_plans_details_id]\">$results_item[bcm_plans_details_name]</option>\n"; 
		}
	}

}

function disable_bcm_plans_details($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE bcm_plans_details_tbl SET bcm_plans_details_disabled=\"1\" WHERE bcm_plans_details_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_bcm_plans_details_csv() {

	# this will dump the table bcm_plans_details_tbl on CSV format
	$sql = "SELECT * from bcm_plans_details_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/bcm_plans_details_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "bcm_plans_details_id,bcm_plans_details_name,bcm_plans_details_description,bcm_plans_details_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[bcm_plans_details_id],$line[bcm_plans_details_name],$line[bcm_plans_details_descripion],$line[bcm_plans_details_disabled]\n");
	}
	
	fclose($handler);

}

?>
