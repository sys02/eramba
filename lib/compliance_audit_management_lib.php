<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/compliance_audit_management/compliance_audit_management/ - SAMEPLE

include_once("mysql_lib.php");

function compliance_items_on_tp($third_party_id,$audit_id) {

	$counter=0;
	$audited_item_counter=0;
	
	# first i need to know which package this third party has
	$compliance_package_list = list_compliance_package(" where compliance_package_tp_id = \"$third_party_id\" and compliance_package_disabled = \"0\""); 
	if (count($compliance_package_list)>0) {
	# i might have more than one .. so for each compliance package , i count and search how many have controls, etc
	foreach($compliance_package_list as $compliance_package_item) {
		$compliance_package_item_list = list_compliance_package_item(" where compliance_package_id = \"$compliance_package_item[compliance_package_id]\" and compliance_package_item_disabled = \"0\"");

		foreach ($compliance_package_item_list as $compliance_package_item_item) {
			# do i have this item on my copmliance_audit_management_tbl ?
			$tmp = lookup_compliance_audit_management_for_specific_audit($audit_id, $compliance_package_item_item[compliance_package_item_id]);
			# echo "$tmp";
			if (!empty($tmp[compliance_audit_management_comp_item_id])) {
				$audited_item_counter++;
			}
	
			$counter++;
		}
	}
	}
	return array ($counter, $audited_item_counter);
}

function list_compliance_audit_management($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM compliance_audit_management_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_compliance_audit_management($compliance_audit_management_data) {
	$sql = "INSERT INTO
		compliance_audit_management_tbl
		VALUES (
		\"$compliance_audit_management_data[compliance_audit_management_id]\",
		\"$compliance_audit_management_data[compliance_audit_management_audit_id]\",
		\"$compliance_audit_management_data[compliance_audit_management_comp_item_id]\",
		\"$compliance_audit_management_data[compliance_audit_management_audit_name]\",
		\"$compliance_audit_management_data[compliance_audit_management_feedback]\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function delete_compliance_audit_management($id,$audit_id) {
	$sql = "DELETE FROM compliance_audit_management_tbl
		WHERE	
		compliance_audit_management_comp_item_id = \"$id\"
		AND
		compliance_audit_management_audit_id = \"$audit_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function update_compliance_audit_management_for_specific_audit($compliance_audit_management_data, $compliance_audit_management_id,$audit_id) {
	$sql = "UPDATE compliance_audit_management_tbl
		SET
		compliance_audit_management_audit_name=\"$compliance_audit_management_data[compliance_audit_management_audit_name]\",
		compliance_audit_management_feedback=\"$compliance_audit_management_data[compliance_audit_management_feedback]\"
		WHERE
		compliance_audit_management_comp_item_id=\"$compliance_audit_management_id\"
		AND
		compliance_audit_management_audit_id = \"$audit_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function update_compliance_audit_management($compliance_audit_management_data, $compliance_audit_management_id) {
	$sql = "UPDATE compliance_audit_management_tbl
		SET
		compliance_audit_management_audit_name=\"$compliance_audit_management_data[compliance_audit_management_audit_name]\",
		compliance_audit_management_feedback=\"$compliance_audit_management_data[compliance_audit_management_feedback]\"
		WHERE
		compliance_audit_management_comp_item_id=\"$compliance_audit_management_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_compliance_audit_management_for_specific_audit($audit_id, $package_item_id) {


	# MUST EDIT
	$sql = "SELECT * from compliance_audit_management_tbl WHERE compliance_audit_management_audit_id = \"$audit_id\" AND compliance_audit_management_comp_item_id = \"$package_item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

function lookup_compliance_audit_management($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from compliance_audit_management_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_compliance_audit_management($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM compliance_audit_management_tbl WHERE compliance_audit_management_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[compliance_audit_management_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[compliance_audit_management_id]\">$results_item[compliance_audit_management_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_audit_management_id]\">$results_item[compliance_audit_management_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[compliance_audit_management_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[compliance_audit_management_id]\">$results_item[compliance_audit_management_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_audit_management_id]\">$results_item[compliance_audit_management_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[compliance_audit_management_id]\">$results_item[compliance_audit_management_name]</option>\n"; 
		}
	}

}

function disable_compliance_audit_management($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE compliance_audit_management_tbl SET compliance_audit_management_disabled=\"1\" WHERE compliance_audit_management_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_compliance_audit_management_csv() {

	# this will dump the table compliance_audit_management_tbl on CSV format
	$sql = "SELECT * from compliance_audit_management_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/compliance_audit_management_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "compliance_audit_management_id,compliance_audit_management_name,compliance_audit_management_description,compliance_audit_management_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[compliance_audit_management_id],$line[compliance_audit_management_name],$line[compliance_audit_management_descripion],$line[compliance_audit_management_disabled]\n");
	}
	
	fclose($handler);

}

?>
