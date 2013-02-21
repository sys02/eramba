<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/bcm_plans_catalogue_audit_calendar_join/category/ - SAMEPLE

include_once("mysql_lib.php");

function list_bcm_plans_catalogue_audit_calendar_join($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_catalogue_audit_calendar_join".$arguments;
	$results = runQuery($sql);
	return $results;
}

function delete_bcm_plans_catalogue_audit_calendar_join($service_catalogue_id) {

	if (!is_numeric($service_catalogue_id)) {
		return;
	}
	
	$sql = "DELETE
		from
		bcm_plans_catalogue_audit_calendar_join	
		WHERE
		bcm_plans_catalogue_id = \"$service_catalogue_id\"
		";
	
	$result = runUpdateQuery($sql);
	return $result;
}

function add_bcm_plans_catalogue_audit_calendar_join($service_catalogue_id, $bcm_plans_audit_calendar_id) {
	$sql = "INSERT INTO
		bcm_plans_catalogue_audit_calendar_join
		VALUES (
		\"$service_catalogue_id\",
		\"$bcm_plans_audit_calendar_id\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function lookup_bcm_plans_catalogue_audit_calendar_join($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from bcm_plans_catalogue_audit_calendar_join WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_bcm_plans_catalogue_audit_calendar_join($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_catalogue_audit_calendar_join WHERE category_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[bcm_plans_catalogue_audit_calendar_join_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_catalogue_audit_calendar_join_id]\">$results_item[category_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_catalogue_audit_calendar_join_id]\">$results_item[category_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[bcm_plans_catalogue_audit_calendar_join_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_catalogue_audit_calendar_join_id]\">$results_item[category_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_catalogue_audit_calendar_join_id]\">$results_item[category_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[bcm_plans_catalogue_audit_calendar_join_id]\">$results_item[category_name]</option>\n"; 
		}
	}

}

function disable_bcm_plans_catalogue_audit_calendar_join($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE bcm_plans_catalogue_audit_calendar_join SET category_disabled=\"1\" WHERE category_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_bcm_plans_catalogue_audit_calendar_join_csv() {

	# this will dump the table bcm_plans_catalogue_audit_calendar_join on CSV format
	$sql = "SELECT * from bcm_plans_catalogue_audit_calendar_join";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/bcm_plans_catalogue_audit_calendar_join_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "bcm_plans_catalogue_audit_calendar_join_id,category_name,category_description,category_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[bcm_plans_catalogue_audit_calendar_join_id],$line[category_name],$line[category_descripion],$line[category_disabled]\n");
	}
	
	fclose($handler);

}

?>
