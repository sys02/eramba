<?
	
	include_once("lib/security_services_lib.php");
	include_once("lib/service_contracts_lib.php");
	include_once("lib/security_services_status_lib.php");
	include_once("lib/security_services_catalogue_audit_calendar_join_lib.php");
	include_once("lib/service_contracts_security_service_join_lib.php");

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/security_services_dashboard/security_services_dashboard/ - SAMEPLE

include_once("mysql_lib.php");

function security_services_dashboard_data($force) {

	if (!$force) {
		# i need to make sure i add data ONLY if this current month has no data already
		# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
		$month = give_me_this_month();
		$security_services_dashboard_list = list_security_services_dashboard(" WHERE MONTH(dashboard_date) = $month");
	
		if (count($security_services_dashboard_list)!=0) {
			#echo "no more updates for this month";
			return;
		}
	}

	# now i start getting hte data for a new update on the dashaboards
	$opex_prop=0;
	$opex_des=0;
	$opex_tran=0;
	$opex_prod=0;

	$capex_prop=0;
	$capex_des=0;
	$capex_tran=0;
	$capex_prod=0;

	$resource=0;
	
	$proposed=0;
	$design=0;
	$transition=0;
	$production=0;
	$retired=0;

	$service_audit_error=0;

	$security_services_list = list_security_services(" WHERE security_services_disabled=\"0\"");

	foreach($security_services_list as $security_services_item) {

		$opex=$opex+$security_services_item[security_services_cost_opex];
		$capex=$capex+$security_services_item[security_services_cost_capex];
		$resource=$resource+$security_services_item[security_services_cost_operational_resource];

		if (!check_service_last_audit_result($security_services_item[security_services_id])) {
			$service_audit_errors++;
		}
	
		if ($security_services_item[security_services_status] == "1") {
			$proposed++;
			$opex_prop=$opex_prop+$security_services_item[security_services_cost_opex];
			$capex_prop=$capex_prop+$security_services_item[security_services_cost_capex];
		} elseif ($security_services_item[security_services_status] == "2") {
			$design++;
			$opex_des=$opex_des+$security_services_item[security_services_cost_opex];
			$capex_des=$capex_des+$security_services_item[security_services_cost_capex];
		} elseif ($security_services_item[security_services_status] == "3") {
			$transition++;
			$opex_tran=$opex_tran+$security_services_item[security_services_cost_opex];
			$capex_tran=$capex_tran+$security_services_item[security_services_cost_capex];
		} elseif ($security_services_item[security_services_status] == "4") {
			$production++;
			$opex_prod=$opex_prod+$security_services_item[security_services_cost_opex];
			$capex_prod=$capex_prod+$security_services_item[security_services_cost_capex];
		} elseif ($security_services_item[security_services_status] == "5") {
			$retired++;
		}	
	}	

	$date=give_me_date();
	$total = $proposed + $design + $transition + $production;

	if (empty($service_audit_errors)) {
		$percentage = 0;
	} else {
		$percentage = ($service_audit_errors/$total)*100;
	}
	
	$security_services_update = array(
		'security_services_dashboard_op_prop' => $opex_prop,
		'security_services_dashboard_op_des' => $opex_des,
		'security_services_dashboard_op_tran' => $opex_tran,
		'security_services_dashboard_op_prod' => $opex_prod,
		'security_services_dashboard_cap_prop' => $capex_prop,
		'security_services_dashboard_cap_des' => $capex_des,
		'security_services_dashboard_cap_tran' => $capex_tran,
		'security_services_dashboard_cap_prod' => $capex_prod,
		'security_services_dashboard_resource' => $resource,
		'security_services_dashboard_proposed' => $proposed,
		'security_services_dashboard_design' => $design,
		'security_services_dashboard_transition' => $transition,
		'security_services_dashboard_production' => $production,
		'security_services_dashboard_retired' => $retired,
		'security_services_dashboard_total' => $total,
		'service_audit_errors' => $percentage,
		'dashboard_date' => $date,
	);	

	$security_service_dashboard_id = add_security_services_dashboard($security_services_update);
}

function list_security_services_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM security_services_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_security_services_dashboard($security_services_dashboard_data) {
	$sql = "INSERT INTO
		security_services_dashboard_tbl
		VALUES (
		\"$security_services_dashboard_data[security_services_dashboard_id]\",
		\"$security_services_dashboard_data[security_services_dashboard_op_prop]\",
		\"$security_services_dashboard_data[security_services_dashboard_op_des]\",
		\"$security_services_dashboard_data[security_services_dashboard_op_tran]\",
		\"$security_services_dashboard_data[security_services_dashboard_op_prod]\",
		\"$security_services_dashboard_data[security_services_dashboard_cap_prop]\",
		\"$security_services_dashboard_data[security_services_dashboard_cap_des]\",
		\"$security_services_dashboard_data[security_services_dashboard_cap_tran]\",
		\"$security_services_dashboard_data[security_services_dashboard_cap_prod]\",
		\"$security_services_dashboard_data[security_services_dashboard_resource]\",
		\"$security_services_dashboard_data[security_services_dashboard_proposed]\",
		\"$security_services_dashboard_data[security_services_dashboard_design]\",
		\"$security_services_dashboard_data[security_services_dashboard_transition]\",
		\"$security_services_dashboard_data[security_services_dashboard_production]\",
		\"$security_services_dashboard_data[security_services_dashboard_retired]\",
		\"$security_services_dashboard_data[security_services_dashboard_total]\",
		\"$security_services_dashboard_data[service_audit_errors]\",
		\"$security_services_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_security_services_dashboard($security_services_dashboard_data, $security_services_dashboard_id) {
	$sql = "UPDATE security_services_dashboard_tbl
		SET
		security_services_dashboard_name=\"$security_services_dashboard_data[security_services_dashboard_name]\",
		security_services_dashboard_description=\"$security_services_dashboard_data[security_services_dashboard_description]\"
		WHERE
		security_services_dashboard_id=\"$security_services_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_security_services_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from security_services_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_security_services_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM security_services_dashboard_tbl WHERE security_services_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[security_services_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[security_services_dashboard_id]\">$results_item[security_services_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_dashboard_id]\">$results_item[security_services_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[security_services_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[security_services_dashboard_id]\">$results_item[security_services_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_dashboard_id]\">$results_item[security_services_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[security_services_dashboard_id]\">$results_item[security_services_dashboard_name]</option>\n"; 
		}
	}

}

function disable_security_services_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE security_services_dashboard_tbl SET security_services_dashboard_disabled=\"1\" WHERE security_services_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_security_services_dashboard_csv() {

	# this will dump the table security_services_dashboard_tbl on CSV format
	$sql = "SELECT * from security_services_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/security_services_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "security_services_dashboard_id,security_services_dashboard_name,security_services_dashboard_description,security_services_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[security_services_dashboard_id],$line[security_services_dashboard_name],$line[security_services_dashboard_descripion],$line[security_services_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
