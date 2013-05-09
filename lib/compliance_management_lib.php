<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/compliance_management/compliance_management/ - SAMEPLE

include_once("mysql_lib.php");
include_once("compliance_item_security_service_join_lib.php");

function compliance_rate_strategy_mitigate($third_party_id) {

	$counter=0;
	$missing_mitigation=0;
	$strategy_mitigate=0;
	$strategy_na=0;
	$strategy_ongoing=0;
	$strategy_compliant=0;
	$strategy_non_compliant=0;
	$strategy_non_applicable=0;
	
	# first i need to know which package this third party has
	$compliance_package_list = list_compliance_package(" where compliance_package_tp_id = \"$third_party_id\" and compliance_package_disabled = \"0\""); 

	if (count($compliance_package_list)>0) {

	# i might have more than one .. so for each compliance package , i count and search how many have controls, etc
	foreach($compliance_package_list as $compliance_package_item) {
	
		$compliance_package_item_list = list_compliance_package_item(" where compliance_package_id = \"$compliance_package_item[compliance_package_id]\" and compliance_package_item_disabled = \"0\"");

		# echo "puta deubg: $compliance_package_item[compliance_package_name] tiene:".count($compliance_package_item_list)."<br>";
		
		foreach ($compliance_package_item_list as $compliance_package_item_item) {

			$counter++;

			# echo "voy contando: $counter<br>";
			# i need to check if this control has some mitigantion on the compliance table
			$mitigation_strategy= lookup_compliance_management("compliance_management_item_id",$compliance_package_item_item[compliance_package_item_id]);

			# check the response type 
			if ($mitigation_strategy[compliance_management_response_id] == "1") {
				#i found one mitigation strategy without controls ... 
				$strategy_mitigate++;
			} elseif ($mitigation_strategy[compliance_management_response_id] == "2") {
				$strategy_na++;
			} 	

			# check the status
			if ($mitigation_strategy[compliance_management_status_id] == "1") {
				#i found one mitigation strategy without controls ... 
				$strategy_ongoing++;
			} elseif ($mitigation_strategy[compliance_management_status_id] == "2") {
				$strategy_compliant++;
			} elseif ($mitigation_strategy[compliance_management_status_id] == "3") {
				$strategy_non_compliant++;
			} elseif ($mitigation_strategy[compliance_management_status_id] == "4") {
				$strategy_non_applicable++;
			}
		}

	}

	}

	$stack = array();
	if ($counter>0) {
		$math = $missing_mitigation/$counter;
		array_push($stack, round($strategy_mitigate/$counter,2), round($strategy_na/$counter,2), round($strategy_ongoing/$counter,2), round($strategy_compliant/$counter,2), round($strategy_non_compliant/$counter,2), round($strategy_non_applicable/$counter,2)); 
	}

	return $stack;
	
}

function compliance_rate_failed_controls($third_party_id) {
	
	$counter=0;
	$compliance_dashboard_control_failed=0;
	
	# first i need to know which package this third party has
	$compliance_package_list = list_compliance_package(" where compliance_package_tp_id = \"$third_party_id\" and compliance_package_disabled = \"0\""); 

	if (count($compliance_package_list)>0) {

	# i might have more than one .. so for each compliance package , i count and search how many have controls, etc
	foreach($compliance_package_list as $compliance_package_item) {
	
		$compliance_package_item_list = list_compliance_package_item(" where compliance_package_id = \"$compliance_package_item[compliance_package_id]\" and compliance_package_item_disabled = \"0\"");

		# echo "puta deubg: $compliance_package_item[compliance_package_name] tiene:".count($compliance_package_item_list)."<br>";
		
		foreach ($compliance_package_item_list as $compliance_package_item_item) {

			$counter++;

			# echo "voy contando: $counter<br>";
			# i need to check if this control has some mitigantion on the compliance table
			$security_controls = lookup_compliance_item_security_services_join("compliance_security_services_join_compliance_id",$compliance_package_item_item[compliance_package_item_id]);

			
			# echo "checking control: $security_controls[compliance_security_services_join_security_services_id] <br>";

			if ($security_controls[compliance_security_services_join_security_services_id]) {

				$control_check = security_service_check($security_controls[compliance_security_services_join_security_services_id]);
	
				if ($control_check) {
					# echo "Control not ok ($control_check)<br>";
					$compliance_dashboard_control_failed++;	
				}

			}

		}
	}

	}

	if ($counter>0) {
	$math = $compliance_dashboard_control_failed/$counter;
	}

	return round($math,2);

}

function compliance_rate_missing_controls($third_party_id) {

	$counter=0;
	$missing_mitigation=0;
	
	# first i need to know which package this third party has
	$compliance_package_list = list_compliance_package(" where compliance_package_tp_id = \"$third_party_id\" and compliance_package_disabled = \"0\""); 

	if (count($compliance_package_list)>0) {

	# i might have more than one .. so for each compliance package , i count and search how many have controls, etc
	foreach($compliance_package_list as $compliance_package_item) {
	
		$compliance_package_item_list = list_compliance_package_item(" where compliance_package_id = \"$compliance_package_item[compliance_package_id]\" and compliance_package_item_disabled = \"0\"");

		# echo "puta deubg: $compliance_package_item[compliance_package_name] tiene:".count($compliance_package_item_list)."<br>";
		
		foreach ($compliance_package_item_list as $compliance_package_item_item) {

			$counter++;

			# echo "voy contando: $counter<br>";
			# i need to check if this control has some mitigantion on the compliance table
			$security_controls = lookup_compliance_item_security_services_join("compliance_security_services_join_compliance_id",$compliance_package_item_item[compliance_package_item_id]);
		
			if (!$security_controls) {
				#i found one mitigation strategy without controls ... 
				$missing_mitigation++;
			}		

		}

	}

	}
	if ($counter>0) {
	$math = $missing_mitigation/$counter;
	}

	return round($math,2);
	
}

function list_compliance_management($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM compliance_management_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_compliance_management($compliance_management_data) {
	$sql = "INSERT INTO
		compliance_management_tbl
		VALUES (
		\"\",
		\"$compliance_management_data[compliance_management_item_id]\",
		\"$compliance_management_data[compliance_management_response_id]\",
		\"$compliance_management_data[compliance_management_status_id]\",
		\"$compliance_management_data[compliance_management_exception_id]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_compliance_management($compliance_management_data, $compliance_management_id) {
	$sql = "UPDATE compliance_management_tbl
		SET
		compliance_management_response_id=\"$compliance_management_data[compliance_management_response_id]\",
		compliance_management_status_id=\"$compliance_management_data[compliance_management_status_id]\",
		compliance_management_exception_id=\"$compliance_management_data[compliance_management_exception_id]\"
		WHERE
		compliance_management_id=\"$compliance_management_id\"
		";	
	# echo "$sql";
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_compliance_management($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from compliance_management_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_compliance_management($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM compliance_management_tbl WHERE compliance_management_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[compliance_management_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[compliance_management_id]\">$results_item[compliance_management_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_management_id]\">$results_item[compliance_management_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[compliance_management_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[compliance_management_id]\">$results_item[compliance_management_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[compliance_management_id]\">$results_item[compliance_management_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[compliance_management_id]\">$results_item[compliance_management_name]</option>\n"; 
		}
	}

}

function disable_compliance_management($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE compliance_management_tbl SET compliance_management_disabled=\"1\" WHERE compliance_management_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_compliance_management_csv($tp_id) {

	# this will dump the table compliance_management_tbl on CSV format
	$sql = "SELECT * from compliance_management_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/compliance_management_export.csv";
	$handler = fopen($export_file, 'w');

	fwrite($handler, "compliance_package_original_id,compliance_package_name,compliance_package_description,compliance_package_item_original_id,compliance_package_item_name,compliance_package_item_description,compliance_management_response_id,mitigation_controls_name,control_status,compliance_exception_name,compliance_management_status_id\n");
	
	$compliance_package_list = list_compliance_package(" WHERE compliance_package_tp_id = \"$tp_id\" AND compliance_package_disabled = \"0\"");

	foreach($compliance_package_list as $compliance_package_item) {

		# fwrite($handler,"$compliance_package_item[compliance_package_original_id],$compliance_package_item[compliance_package_name], $compliance_package_item[compliance_package_description]\n");
		
	
		$compliance_package_item_list = list_compliance_package_item(" WHERE compliance_package_id = \"$compliance_package_item[compliance_package_id]\" AND compliance_package_item_disabled = \"0\""); 
	
		if ( count($compliance_package_item_list) != 0 ) {
		
			foreach($compliance_package_item_list as $compliance_package_item_item) {
			
			fwrite($handler,"$compliance_package_item[compliance_package_original_id],$compliance_package_item[compliance_package_name], $compliance_package_item[compliance_package_description],");

			# load the ocmpliance_management_item data
			$compliance_management_item = lookup_compliance_management("compliance_management_item_id", $compliance_package_item_item[compliance_package_item_id]);
			$exception_item = lookup_compliance_exception("compliance_exception_id",$compliance_management_item[compliance_management_exception_id]);
			$lookup_response_id = lookup_compliance_response_strategy("compliance_response_strategy_id",$compliance_management_item[compliance_management_response_id]);
			$lookup_status_id = lookup_compliance_status("compliance_status_id",$compliance_management_item[compliance_management_status_id]);
			$applicable_security_services = array();
			$applicable_security_services = list_compliance_item_security_services_join(" WHERE compliance_security_services_join_compliance_id = \"$compliance_package_item_item[compliance_package_item_id]\"");	

			fwrite($handler,"$compliance_package_item_item[compliance_package_item_original_id], $compliance_package_item_item[compliance_package_item_name], $compliance_package_item_item[compliance_package_item_description], $lookup_response_id[compliance_response_strategy_name],");

			# this sucks!!! i need to use implode or something a bit simpler!
			foreach($applicable_security_services as $service_item) {
				$security_services_details = lookup_security_services("security_services_id",$service_item[compliance_security_services_join_security_services_id]);
				fwrite($handler,"$security_services_details[security_services_name] - ");
			}
			# this is necesry to finish the column hwere the sec controls are listed	
			fwrite($handler,",");
			
			# this sucks!!! i need to use implode or something a bit simpler!
			foreach($applicable_security_services as $service_item) {
				if (security_service_check($service_item[compliance_security_services_join_security_services_id])) {
					$error=1;
				}
			}

			# print error msg
			if ($error) {	
				fwrite($handler,"Security Controls with Issues");
			} else { 
				fwrite($handler,"Security Controls without Issues");
			}
	
			unset($error);	
			
			# this is necesry to finish the column hwere the sec controls are listed	
			fwrite($handler,",");

			fwrite($handler, "$exception_item[compliance_exception_title],$lookup_status_id[compliance_status_name]\n");
			}
		
		}

	}
	
	fclose($handler);

}

?>
