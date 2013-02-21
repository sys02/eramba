<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/bcm_plans/bcm_plans/ - SAMEPLE

include_once("mysql_lib.php");
include_once("security_services_status_lib.php");
include_once("bcm_plans_catalogue_audit_calendar_join_lib.php");

function list_bcm_plans($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_bcm_plans($bcm_plans_data) {
	$sql = "INSERT INTO
		bcm_plans_tbl
		VALUES (
		\"$bcm_plans_data[bcm_plans_id]\",
		\"$bcm_plans_data[bcm_plans_title]\",
		\"$bcm_plans_data[bcm_plans_objective]\",
		\"$bcm_plans_data[bcm_plans_lunch_criteria]\",
		\"$bcm_plans_data[bcm_plans_sponsor_name]\",
		\"$bcm_plans_data[bcm_plans_who_declares]\",
		\"$bcm_plans_data[bcm_plans_status]\",
		\"$bcm_plans_data[bcm_plans_metric]\",
		\"$bcm_plans_data[bcm_plans_success_criteria]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_bcm_plans($bcm_plans_data, $bcm_plans_id) {
	$sql = "UPDATE bcm_plans_tbl
		SET
		bcm_plans_title=\"$bcm_plans_data[bcm_plans_title]\",
		bcm_plans_objective=\"$bcm_plans_data[bcm_plans_objective]\",
		bcm_plans_lunch_criteria=\"$bcm_plans_data[bcm_plans_lunch_criteria]\",
		bcm_plans_sponsor_name=\"$bcm_plans_data[bcm_plans_sponsor_name]\",
		bcm_plans_who_declares=\"$bcm_plans_data[bcm_plans_who_declares]\",
		bcm_plans_status=\"$bcm_plans_data[bcm_plans_status]\",
		bcm_plans_success_criteria=\"$bcm_plans_data[bcm_plans_success_criteria]\",
		bcm_plans_metric=\"$bcm_plans_data[bcm_plans_metric]\"
		WHERE
		bcm_plans_id=\"$bcm_plans_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_bcm_plans($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from bcm_plans_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_bcm_plans($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_tbl WHERE bcm_plans_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[bcm_plans_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_id]\">$results_item[bcm_plans_title]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_id]\">$results_item[bcm_plans_title]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[bcm_plans_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_id]\">$results_item[bcm_plans_title]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_id]\">$results_item[bcm_plans_title]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[bcm_plans_id]\">$results_item[bcm_plans_title]</option>\n"; 
		}
	}

}

function disable_bcm_plans($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE bcm_plans_tbl SET bcm_plans_disabled=\"1\" WHERE bcm_plans_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_bcm_plans_csv() {

	# this will dump the table bcm_plans_tbl on CSV format
	$sql = "SELECT * from bcm_plans_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/bcm_plans_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "bcm_plans_id,bcm_plans_title,bcm_plans_objectives,bcm_plans_lunch_criteria,bcm_plans_sponsor_name,bcm_plans_who_declarers,bcm_plans_status,bcm_plans_metric,bcm_plans_success_criteria,bcm_plans_audit_months,bcm_plans_audit_check,bcm_plans_disabled\n");

	foreach($result as $line) {

		# this checks the bcm plan audit status
		$status_name = lookup_security_services_status("security_services_status_id", $line[bcm_plans_status]);

		# this checks on which months i've got to audit
		$months_list = list_bcm_plans_catalogue_audit_calendar_join(" WHERE bcm_plans_catalogue_id = \"$line[bcm_plans_id]\"");	
		$tmp = array();
		foreach($months_list as $months_item) {
			$month_name = lookup_security_services_audit_calendar("security_services_audit_calendar_id",$months_item[bcm_plans_audit_calendar_id]);
			array_push($tmp, $month_name[security_services_audit_calendar_name]);
		}
		$months_string = implode("-",$tmp);

		# audit check
		if ( check_bcm_plans_last_audit_result($line[bcm_plans_id]) ) {
			$last_check = "ok";
		} else {
			$last_check = "not ok";
		}

		fwrite($handler,"$line[bcm_plans_id],$line[bcm_plans_title],$line[bcm_plans_objective],$line[bcm_plans_lunch_criteria],$line[bcm_plans_sponsor_name],$line[bcm_plans_who_declares],$status_name[security_services_status_name],$line[bcm_plans_metric],$line[bcm_plans_success_criteria],$months_string,$last_check,$line[bcm_plans_disabled]\n\n");

	

		# if i dont have tasks .. i should go to the point .. otherwise , print the bloody plans!
		$bcm_plans_details = list_bcm_plans_details(" WHERE bcm_plans_details_bcm_plan_id = \"$line[bcm_plans_id]\" AND bcm_plans_details_disabled = \"0\"  ORDER by bcm_plans_details_step ASC");
	
		if (!count($bcm_plans_details)) {
			fwrite($handler,"There are no available detailed plans for this continuity plan\n\n");	
		} else {
			fwrite($handler,"bcm_plans_details_id,bcm_plans_details_bcm_plan_id,bcm_plans_details_step,bcm_plans_details_when,bcm_plans_details_who,bcm_plans_details_what,bcm_plans_details_where,bcm_plans_details_how,bcm_plans_details_disabled\n");	

			foreach($bcm_plans_details as $bcm_plans_item) {
				fwrite($handler,"$bcm_plans_item[bcm_plans_details_id],$bcm_plans_item[bcm_plans_details_bcm_plan_id],$bcm_plans_item[bcm_plans_details_step],$bcm_plans_item[bcm_plans_details_when],$bcm_plans_item[bcm_plans_details_who],$bcm_plans_item[bcm_plans_details_what],$bcm_plans_item[bcm_plans_details_where],$bcm_plans_item[bcm_plans_details_how],$bcm_plans_item[bcm_plans_details_disabled]\n");
			}

			fwrite($handler,"\n\n");
		}

	}
	
	fclose($handler);

}

?>
