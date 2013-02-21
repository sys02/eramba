<?
	# this holds the basic information
	include_once("risk_lib.php");
	
	# include_once("risk_asset_join_lib.php");
	include_once("risk_tp_join_lib.php");
	include_once("risk_buss_process_join_lib.php");

	#exceptions
	include_once("risk_risk_exception_join_lib.php");
	include_once("risk_security_services_join_lib.php");
	include_once("risk_exception_lib.php");
	
# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_dashboard/risk_dashboard/ - SAMEPLE

include_once("mysql_lib.php");

function risk_dashboard_data($force) {

	if (!$force) {
	# i need to make sure i add data ONLY if this current month has no data already
	# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
	$month = give_me_this_month();
	$risk_dashboard_list = list_risk_dashboard(" WHERE MONTH(dashboard_date) = $month");
	if (count($risk_dashboard_list)!=0) {
		#echo "no more updates for this month";
		return;
	}
	}

	# now i start getting hte data for a new update on the dashaboards
	$risk_dashboard_count_asset_risks=0;
	$risk_dashboard_count_tp_risks=0;
	$risk_dashboard_count_buss_risks=0;
	$risk_dashboard_percentage_expired_risks=0;
	$risk_dashboard_percentage_expired_exceptions=0;
	$risk_dashboard_percentage_fail_controls=0;
	$risk_dashboard_percentage_missing_controls=0;
	$risk_dashboard_count_risk_index=0;
	$risk_dashboard_count_risk_residual_index=0;

	$risk_control_error =0;
	
	$risk_asset_list = list_distinct_risk_asset_join("");
	$risk_dashboard_count_asset_risks = count($risk_asset_list);
	
	$risk_tp_list = list_risk_tp_join("");
	$risk_dashboard_count_tp_risks = count($risk_tp_list);
	
	$risk_buss_list = list_risk_buss_process_join("");
	$risk_dashboard_count_buss_risks = count($risk_buss_list);

	$risk_list = list_risk(" WHERE risk_disabled=\"0\"");

	foreach($risk_list as $risk_item) {

		$risk_total_count++;

		# i'm now checking the expcetions asociated for expiration date
		$risk_exception_for_this_risk_list = list_risk_risk_exception_join(" WHERE risk_risk_exception_join_risk_id = \"$risk_item[risk_id]\""); 
		foreach($risk_exception_for_this_risk_list as $risk_exception_for_this_risk_item) {
			if (check_risk_exception($risk_exception_for_this_risk_item[risk_risk_exception_join_risk_exception_id])) {
				$error=1;
			}
		}

		if ($error) {
			$risks_faulty_exceptions++;
			# echo "puta: un riesgo mas con faulty exceptins: $risks_faulty_exceptions<br>";
		}
		unset($error);
	
		# i'm checking if the risk expiration review is ok or not 
		if (check_expired_risk_review($risk_item[risk_id])) {
			$error=1;
		}
		
		if ($error) {
			$risks_expired_reviews++;
			# echo "puta: un riesgo mas con expired risk reviews: $risks_expired_reviews<br>";
		}
		unset($error);


		# finished with the checking of risks

		$risk_score=$risk_score+$risk_item[risk_classification_score];
		$risk_residual=$risk_residual+$risk_item[risk_residual_score];

		# now looking at controls used for each risk
		$risk_mitigation_control = list_risk_security_services_join(" WHERE risk_security_services_join_risk_id = \"$risk_item[risk_id]\"");  

		# see which one has a mitigatino control and check if that control is failed		
		if (!empty($risk_mitigation_control)) {
			
			$risk_dashboard_use_controls++;

			foreach($risk_mitigation_control as $risk_mitigation_control_item) {
				if (security_service_check($risk_mitigation_control_item[risk_security_services_join_security_services_id])) {
					$risk_dashboard_fail_controls_error=1;	
				} 	
			}

		}

		if ($risk_dashboard_fail_controls_error) {
			$risk_control_error++;
		}

		unset($risk_dashboard_fail_controls_error);

	}	
		
		if (empty($risk_control_error)) {
			$risk_dashboard_percentage_fail_controls = 0;
		} else {
			$risk_dashboard_percentage_fail_controls = ($risk_control_error/($risk_dashboard_count_asset_risks + $risk_dashboard_count_tp_risks))*100;
		}

		if (empty($risks_expired_reviews)) {
		$percentage_risks_expired_reviews=0;
		} else {
		$percentage_risks_expired_reviews=($risks_expired_reviews/$risk_total_count)*100;
		}
	
		# echo "puta percentage_risks_expired_reviews: $percentage_risks_expired_reviews=($risks_expired_reviews/$risk_total_count)<br>";

		if (empty($risks_faulty_exceptions)) {
		$percentage_risks_faulty_exceptions=0;
		} else {
		$percentage_risks_faulty_exceptions=($risks_faulty_exceptions/$risk_total_count)*100;
		}
		# echo "puta percentage_risks_faulty_exceptions: $percentage_risks_faulty_exceptions=($risks_faulty_exceptions/$risk_total_count)<br>";

	$date=give_me_date();
	
	$risk_update = array(
		'risk_dashboard_count_asset_risks' => $risk_dashboard_count_asset_risks,
		'risk_dashboard_count_tp_risks' => $risk_dashboard_count_tp_risks,
		'risk_dashboard_count_buss_risks' => $risk_dashboard_count_buss_risks,
		'risk_dashboard_percentage_fail_controls' => $risk_dashboard_percentage_fail_controls,
		'risk_dashboard_count_risk_index' => $risk_score,
		'risk_dashboard_count_risk_residual_index' => $risk_residual,
		'risk_dashboard_percentage_expired_risks' => $percentage_risks_expired_reviews,
		'risk_dashboard_percentage_expired_exceptions' => $percentage_risks_faulty_exceptions,
		'dashboard_date' => $date
	);	

	$risk_dashboard_id = add_risk_dashboard($risk_update);
}

function list_risk_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_risk_dashboard($risk_dashboard_data) {
	$sql = "INSERT INTO
		risk_dashboard_tbl
		VALUES (
		\"$risk_dashboard_data[risk_dashboard_id]\",
		\"$risk_dashboard_data[risk_dashboard_count_asset_risks]\",
		\"$risk_dashboard_data[risk_dashboard_count_tp_risks]\",
		\"$risk_dashboard_data[risk_dashboard_count_buss_risks]\",
		\"$risk_dashboard_data[risk_dashboard_percentage_expired_risks]\",
		\"$risk_dashboard_data[risk_dashboard_percentage_expired_exceptions]\",
		\"$risk_dashboard_data[risk_dashboard_percentage_fail_controls]\",
		\"$risk_dashboard_data[risk_dashboard_count_risk_index]\",
		\"$risk_dashboard_data[risk_dashboard_count_risk_residual_index]\",
		\"$risk_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_risk_dashboard($risk_dashboard_data, $risk_dashboard_id) {
	$sql = "UPDATE risk_dashboard_tbl
		SET
		risk_dashboard_name=\"$risk_dashboard_data[risk_dashboard_name]\",
		risk_dashboard_description=\"$risk_dashboard_data[risk_dashboard_description]\"
		WHERE
		risk_dashboard_id=\"$risk_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_dashboard_tbl WHERE risk_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_dashboard_id]\">$results_item[risk_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_dashboard_id]\">$results_item[risk_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_dashboard_id]\">$results_item[risk_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_dashboard_id]\">$results_item[risk_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_dashboard_id]\">$results_item[risk_dashboard_name]</option>\n"; 
		}
	}

}

function disable_risk_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_dashboard_tbl SET risk_dashboard_disabled=\"1\" WHERE risk_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_dashboard_csv() {

	# this will dump the table risk_dashboard_tbl on CSV format
	$sql = "SELECT * from risk_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_dashboard_id,risk_dashboard_name,risk_dashboard_description,risk_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[risk_dashboard_id],$line[risk_dashboard_name],$line[risk_dashboard_descripion],$line[risk_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
