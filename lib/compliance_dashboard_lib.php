<?
	
# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/compliance_dashboard/compliance_dashboard/ - SAMEPLE

include_once("mysql_lib.php");
include_once("compliance_package_item_lib.php");
include_once("compliance_management_lib.php");
include_once("security_services_lib.php");
include_once("compliance_item_security_service_join_lib.php");

function compliance_dashboard_data($force) {

	if (!$force) {
	# i need to make sure i add data ONLY if this current month has no data already
	# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
	$month = give_me_this_month();
	$compliance_dashboard_list = list_compliance_dashboard(" WHERE MONTH(dashboard_date) = $month");
	if (count($compliance_dashboard_list)!=0) {
		#echo "no more updates for this month";
		return;
	}
	}

	# now i start getting hte data for a new update on the dashaboards
	$compliance_dashboard_comp_items=0;
	$compliance_dashboard_strategy_mitigate=0;
	$compliance_dashboard_strategy_na=0;
	$compliance_dashboard_status_ongoing=0;
	$compliance_dashboard_status_compliant=0;
	$compliance_dashboard_status_noncomp=0;
	$compliance_dashboard_status_na=0;
	$compliance_dashboard_without_mitigation=0;
	$compliance_dashboard_control_failed=0;


	$compliance_package_items = list_compliance_package_item(" WHERE compliance_package_item_disabled = \"0\"");

	foreach($compliance_package_items as $compliance_package_items_items) {

		$compliance_dashboard_comp_items++;

		# how many compliance packages do not have a control or exception assigned?
		$compliance_item_mitigation_control = list_compliance_item_security_services_join(" WHERE compliance_security_services_join_compliance_id = \"$compliance_package_items_items[compliance_package_item_id]\""); 

		#echo "puta: checking if compliance item id $compliance_package_items_items[compliance_package_item_id] has controls".count($compliance_item_mitigation_control)."<br>";

		# i will get an array out of compliance_item_mitigation_control ... 
		if (empty($compliance_item_mitigation_control)) {
			$compliance_dashboard_without_mitigation++;		
			# echo "puta: NO tiene control<br>";
		} else {
			# echo "puta: tiene control<br>";
		# how many have a control assgined by it's last audit went bad?
			foreach($compliance_item_mitigation_control as $compliance_item_mitigation_control_item) {
			if (security_service_check($compliance_item_mitigation_control_item[compliance_security_services_join_security_services_id])) {
				$compliance_dashboard_control_failed++;	
				# echo "puta: tiene control pero dio con fallas<br>";
			} 	
			}
		}
	}

	
	$compliance_management_list = list_compliance_management(" WHERE compliance_management_disabled = \"0\"");

	foreach($compliance_management_list as $compliance_management_item) {
		if ($compliance_management_item[compliance_management_response_id] == "1") {
			$compliance_dashboard_strategy_mitigate++;
		} elseif ($compliance_management_item[compliance_management_response_id] == "2") {
			$compliance_dashboard_strategy_na++;
		}
	}	
	
	foreach($compliance_management_list as $compliance_management_item) {
		if ($compliance_management_item[compliance_management_status_id] == "1") {
			$compliance_dashboard_status_ongoing++;	
		} elseif($compliance_management_item[compliance_management_status_id] == "2") {
			$compliance_dashboard_status_compliant++;	
		} elseif($compliance_management_item[compliance_management_status_id] == "3") {
			$compliance_dashboard_status_noncomp++;
		} elseif($compliance_management_item[compliance_management_status_id] == "4") {
			$compliance_dashboard_status_na++;
		}	
	}

	$date=give_me_date();
	
	$dashboard_update = array(
		'compliance_dashboard_comp_items' => $compliance_dashboard_comp_items,
		'compliance_dashboard_strategy_mitigate' => $compliance_dashboard_strategy_mitigate,
		'compliance_dashboard_strategy_na' => $compliance_dashboard_strategy_na,
		'compliance_dashboard_status_ongoing' => $compliance_dashboard_status_ongoing,
		'compliance_dashboard_status_compliant' => $compliance_dashboard_status_compliant,
		'compliance_dashboard_status_noncomp' => $compliance_dashboard_status_noncomp,
		'compliance_dashboard_status_na' => $compliance_dashboard_status_na,
		'compliance_dashboard_without_mitigation' => $compliance_dashboard_without_mitigation,
		'compliance_dashboard_control_failed' => $compliance_dashboard_control_failed,
		'dashboard_date' => $date
	);	

	$compliance_management_dashboard_id = add_compliance_dashboard($dashboard_update);
}

function list_compliance_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM compliance_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_compliance_dashboard($compliance_dashboard_data) {
	$sql = "INSERT INTO
		compliance_dashboard_tbl	
		VALUES (
		\"$compliance_dashboard_data[compliance_dashboard_id]\",
		\"$compliance_dashboard_data[compliance_dashboard_comp_items]\",
		\"$compliance_dashboard_data[compliance_dashboard_strategy_mitigate]\",
		\"$compliance_dashboard_data[compliance_dashboard_strategy_na]\",
		\"$compliance_dashboard_data[compliance_dashboard_status_ongoing]\",
		\"$compliance_dashboard_data[compliance_dashboard_status_compliant]\",
		\"$compliance_dashboard_data[compliance_dashboard_status_noncomp]\",
		\"$compliance_dashboard_data[compliance_dashboard_status_na]\",
		\"$compliance_dashboard_data[compliance_dashboard_without_mitigation]\",
		\"$compliance_dashboard_data[compliance_dashboard_control_failed]\",
		\"$compliance_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_compliance_dashboard($compliance_dashboard_data, $compliance_dashboard_id) {
	$sql = "UPDATE compliance_dashboard_tbl 
		SET
		compliance_dashboard_name=\"$compliance_dashboard_data[compliance_dashboard_name]\",
		compliance_dashboard_description=\"$compliance_dashboard_data[compliance_dashboard_description]\"
		WHERE
		compliance_dashboard_id=\"$compliance_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_compliance_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from compliance_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_compliance_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM compliance_dashboard_tbl WHERE compliance_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[compliance_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[compliance_dashboard_id]\">$results_item[compliance_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_dashboard_id]\">$results_item[compliance_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[compliance_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[compliance_dashboard_id]\">$results_item[compliance_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_dashboard_id]\">$results_item[compliance_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[compliance_dashboard_id]\">$results_item[compliance_dashboard_name]</option>\n"; 
		}
	}

}

function disable_compliance_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE compliance_dashboard_tbl SET compliance_dashboard_disabled=\"1\" WHERE compliance_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_compliance_dashboard_csv() {

	# this will dump the table compliance_dashboard_tbl on CSV format
	$sql = "SELECT * from compliance_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/compliance_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "compliance_dashboard_id,compliance_dashboard_name,compliance_dashboard_description,compliance_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[compliance_dashboard_id],$line[compliance_dashboard_name],$line[compliance_dashboard_descripion],$line[compliance_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
