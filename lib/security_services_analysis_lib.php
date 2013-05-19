<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/security_services_analysis/security_services_analysis/ - SAMEPLE

include_once("mysql_lib.php");
include_once("security_services_classification_lib.php");
include_once("risk_security_services_join_lib.php");
include_once("data_asset_lib.php");
include_once("lib/data_asset_security_services_join_lib.php");
include_once("lib/compliance_item_security_service_join_lib.php");
include_once("lib/compliance_package_item_lib.php");
include_once("lib/compliance_package_lib.php");
include_once("lib/system_records_lib.php");

function build_security_services_analysis() {

	# first i need to delete the temporal table
	delete_security_services_analysis();
	
	# now i start populating it
	$control_list = list_security_services( " WHERE security_services_disabled = \"0\"");

	if (count($control_list)>0) {
	
		foreach($control_list as $control_item) {

			$security_services_analysis_control_id = $control_item[security_services_id];
			
			$list_of_audits = list_security_services_audit(" WHERE security_services_audit_security_service_id =\"$control_item[security_services_id]\" AND security_services_audit_result = \"3\" AND security_services_audit_disabled =\"0\""); 	
			$security_services_analysis_fa = count($list_of_audits);

			$security_services_analysis_resource = $control_item[security_services_cost_operational_resource];

			$security_services_analysis_opex= $control_item[security_services_cost_opex];

			$service_contracts = list_service_contracts_security_services(" WHERE security_services_id = \"$control_item[security_services_id]\""); 
			$security_services_analysis_contracts = 0;
			if (count($service_contracts)>0) {
				foreach($service_contracts as $service_contracts_item) {
					$tmp = lookup_service_contracts("service_contracts_id",$service_contracts_item[service_contracts_id]);
					$security_services_analysis_contracts = $security_services_analysis_contracts + $tmp[service_contracts_value];
				}
			}

			$security_services_analysis_capex = $control_item[security_services_cost_capex];

			$tmp = lookup_security_services_classification("security_services_classification_id",$control_item[security_services_classification_id]);
			$security_services_analysis_classification_name = $tmp[security_services_classification_name];

			$security_services_analysis_resource = $control_item[security_services_cost_operational_resource];
	
	#- Asset Risk (risk_title)
	$security_services_analysis_risk_asset=0;
	$security_services_analysis_risk_score=0;
	$risk_asset = list_risk_asset_join("");	
	$tmp_array = array();
	foreach ($risk_asset as $risk_asset_item) { 
		array_push($tmp_array, $risk_asset_item[risk_asset_join_risk_id]);
	} 

	$risk_asset_service  = list_risk_security_services_join("");	
	foreach($risk_asset_service as $risk_asset_service_list) {
	if ( $control_item[security_services_id] == $risk_asset_service_list[risk_security_services_join_security_services_id] ) { 
	if ( array_search($risk_asset_service_list[risk_security_services_join_risk_id], $tmp_array) ) {
		$security_services_analysis_risk_asset++;
		$tmp_risk = lookup_risk("risk_id",$risk_asset_service_list[risk_security_services_join_risk_id]);
		$security_services_analysis_risk_score = $security_services_analysis_risk_score + $tmp_risk[risk_classification_score];
	}
	}
	}

	#- Third Party Risk (risk_title)
	$security_services_analysis_tp_risk=0;
	$risk_tp = list_risk_tp_join("");
	$tmp_array = array();
	foreach ($risk_tp as $risk_tp_item) { 
		array_push($tmp_array, $risk_tp_item[risk_tp_join_risk_id]);
	} 

	$risk_tp_service  = list_risk_security_services_join("");	
	foreach($risk_tp_service as $risk_tp_service_list) {
	if ( $control_item[security_services_id] == $risk_tp_service_list[risk_security_services_join_security_services_id] ) { 
	if ( array_search($risk_tp_service_list[risk_security_services_join_risk_id], $tmp_array) ) {
		$security_services_analysis_tp_risk++;
		$tmp_risk = lookup_risk("risk_id",$risk_tp_service_list[risk_security_services_join_risk_id]);
		$security_services_analysis_risk_score = $security_services_analysis_risk_score + $tmp_risk[risk_classification_score];
	}
	}
	}

	#- Data Flows (Asset Name)
	$security_services_analysis_data_flows=0;
	$data_asset = list_data_asset(" WHERE data_asset_disabled = \"0\"");
	$tmp_array = array();
	foreach ($data_asset as $data_asset_item) { 
		array_push($tmp_array, $data_asset_item[data_asset_id]);
	} 

	$data_asset_service  = list_data_asset_security_services_join("");	
	foreach($data_asset_service as $data_asset_service_list) {
	if ( $control_item[security_services_id] == $data_asset_service_list[data_asset_security_services_join_security_services_id] ) { 

	if ( array_search($data_asset_service_list[data_asset_security_services_join_data_asset_id], $tmp_array) ) {
		$security_services_analysis_data_flows++;
	}
	}
	}
	
	#- Compliance (Compliance title)
	$security_services_analysis_compliance=0;
	$compliance = list_compliance_package_item(" WHERE compliance_package_item_disabled = \"0\"");	
	$tmp_array = array();
	foreach ($compliance as $compliance_item) { 
		array_push($tmp_array, $compliance_item[compliance_package_item_id]);
	} 

	$compliance_service  = list_compliance_item_security_services_join("");
	foreach($compliance_service as $compliance_service_list) {
	if ( $control_item[security_services_id] == $compliance_service_list[compliance_security_services_join_security_services_id] ) { 
	if ( array_search($compliance_service_list[compliance_security_services_join_compliance_id], $tmp_array) ) {
			$security_services_analysis_compliance++;
	}
	}
	}

	$security_services_analysis_control_name = $control_item[security_services_name]; 

	$security_services_analysis_mit_total = $security_services_analysis_risk_asset + $security_services_analysis_tp_risk + $security_services_analysis_data_flows +$security_services_analysis_compliance; 

	# now i should be able to insert on the table

		$analysis_data = array(
			'security_services_analysis_control_name' => $security_services_analysis_control_name,
			'security_services_analysis_control_id' => $security_services_analysis_control_id,
			'security_services_analysis_fa' => $security_services_analysis_fa,
			'security_services_analysis_resource' => $security_services_analysis_resource,
			'security_services_analysis_opex' => $security_services_analysis_opex,
			'security_services_analysis_contracts' => $security_services_analysis_contracts,
			'security_services_analysis_capex' => $security_services_analysis_capex,
			'security_services_analysis_classification_name' => $security_services_analysis_classification_name,
			'security_services_analysis_risk_score' => $security_services_analysis_risk_score,
			'security_services_analysis_risk_asset' => $security_services_analysis_risk_asset,
			'security_services_analysis_tp_risk' => $security_services_analysis_tp_risk,
			'security_services_analysis_data_flows' => $security_services_analysis_data_flows,
			'security_services_analysis_compliance' => $security_services_analysis_compliance,
			'security_services_analysis_mit_total' => $security_services_analysis_mit_total
		);	

		$legal_id = add_security_services_analysis($analysis_data);


	unset($security_services_analysis_tp_risk);
	
		}
	}

}

function delete_security_services_analysis() {
	$sql = "DELETE from security_services_analysis_tbl WHERE 1=1"; 
	$result = runUpdateQuery($sql);
	return $result;
}

function list_security_services_analysis($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM security_services_analysis_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_security_services_analysis($security_services_analysis_data) {
	$sql = "INSERT INTO
		security_services_analysis_tbl
		VALUES (
		\"$security_services_analysis_data[security_services_analysis_id]\",
		\"$security_services_analysis_data[security_services_analysis_control_name]\",
		\"$security_services_analysis_data[security_services_analysis_control_id]\",
		\"$security_services_analysis_data[security_services_analysis_fa]\",
		\"$security_services_analysis_data[security_services_analysis_resource]\",
		\"$security_services_analysis_data[security_services_analysis_opex]\",
		\"$security_services_analysis_data[security_services_analysis_contracts]\",
		\"$security_services_analysis_data[security_services_analysis_capex]\",
		\"$security_services_analysis_data[security_services_analysis_classification_name]\",
		\"$security_services_analysis_data[security_services_analysis_risk_score]\",
		\"$security_services_analysis_data[security_services_analysis_risk_asset]\",
		\"$security_services_analysis_data[security_services_analysis_tp_risk]\",
		\"$security_services_analysis_data[security_services_analysis_data_flows]\",
		\"$security_services_analysis_data[security_services_analysis_compliance]\",
		\"$security_services_analysis_data[security_services_analysis_mit_total]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_security_services_analysis($security_services_analysis_data, $security_services_analysis_id) {
	$sql = "UPDATE security_services_analysis_tbl
		SET
		security_services_analysis_name=\"$security_services_analysis_data[security_services_analysis_name]\",
		security_services_analysis_description=\"$security_services_analysis_data[security_services_analysis_description]\"
		WHERE
		security_services_analysis_id=\"$security_services_analysis_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_security_services_analysis($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from security_services_analysis_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_security_services_analysis($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM security_services_analysis_tbl WHERE security_services_analysis_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[security_services_analysis_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[security_services_analysis_id]\">$results_item[security_services_analysis_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_analysis_id]\">$results_item[security_services_analysis_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[security_services_analysis_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[security_services_analysis_id]\">$results_item[security_services_analysis_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_analysis_id]\">$results_item[security_services_analysis_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[security_services_analysis_id]\">$results_item[security_services_analysis_name]</option>\n"; 
		}
	}

}

function disable_security_services_analysis($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE security_services_analysis_tbl SET security_services_analysis_disabled=\"1\" WHERE security_services_analysis_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_security_services_analysis_csv() {

	# this will dump the table security_services_analysis_tbl on CSV format
	$sql = "SELECT * from security_services_analysis_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/security_services_analysis_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "security_services_analysis_id,security_services_analysis_control_name,security_services_analysis_control_id,security_services_analysis_fa,security_services_analysis_opex,security_services_analysis_contracts,security_services_analysis_capex,security_services_analysis_classification_name,security_services_analysis_risk_score,security_services_analysis_risk_asset,security_services_analysis_tp_risk,security_services_analysis_data_flows,security_services_analysis_compliance,security_services_analysis_mit_total,security_services_analysis_resource\n");
	foreach($result as $line) {
		fwrite($handler,"$line[security_services_analysis_id],$line[security_services_analysis_control_name],$line[security_services_analysis_control_id],$line[security_services_analysis_fa],$line[security_services_analysis_opex],$line[security_services_analysis_contracts],$line[security_services_analysis_capex],$line[security_services_analysis_classification_name],$line[security_services_analysis_risk_score],$line[security_services_analysis_risk_asset],$line[security_services_analysis_tp_risk],$line[security_services_analysis_data_flows],$line[security_services_analysis_compliance],$line[security_services_analysis_mit_total],$line[security_services_analysis_resource]\n");
	}
	
	fclose($handler);

}

?>
