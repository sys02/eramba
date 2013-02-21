<?
	
# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/asset_dashboard/asset_dashboard/ - SAMEPLE

include_once("mysql_lib.php");
include_once("asset_lib.php");
include_once("data_asset_lib.php");
include_once("data_asset_security_services_join_lib.php");

function asset_dashboard_data($force) {

	if (!$force) {
	# i need to make sure i add data ONLY if this current month has no data already
	# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
	$month = give_me_this_month();
	$asset_dashboard_list = list_asset_dashboard(" WHERE MONTH(dashboard_date) = $month");
	if (count($asset_dashboard_list)!=0) {
		#echo "no more updates for this month";
		return;
	}
	}

	# now i start getting hte data for a new update on the dashaboards
	$asset_dashboard_type_data_asset=0;
	$asset_dashboard_type_human_asset=0;
	$asset_dashboard_type_information=0;

	# how many analyssis on data assets i have
	$list_of_data_assets_analysis = list_data_asset(" WHERE data_asset_disabled = \"0\"");
	$count_list_of_data_assets_analysis = count($list_of_data_assets_analysis);
	
	# how many assets i have
	$asset_list = list_asset(" WHERE asset_disabled=\"0\"");
	$total_numer_of_assets = count($asset_list);

	# i'm checking how many assets from each type i have
	foreach($asset_list as $asset_item) {

		if ($asset_item[asset_media_type_id] == "1") {
			$count_assets_type_one++;
		} elseif ($asset_item[asset_media_type_id] == "2") {
			$count_assets_type_two++;
		} elseif ($asset_item[asset_media_type_id] == "3") {
			$count_assets_type_three++;
		} elseif ($asset_item[asset_media_type_id] == "4") {
			$count_assets_type_four++;
		} elseif ($asset_item[asset_media_type_id] == "5") {
			$count_assets_type_five++;
		}
	}	

	# i want to know how many data assets i was supposed to analyse and i didnt
	$assets_supposed_tobe_analysed = list_distinct_data_asset();
	
	if (empty($assets_supposed_tobe_analysed)) {
	$percentage_of_missing_analysed=0;
	} else {
	$percentage_of_missing_analysed = (count($assets_supposed_tobe_analysed) / $count_assets_type_one)*100;
	}

	# i want to know how many analysis i have in total , and the percentage which have no controls asociated
	$no_control=0;
	foreach($list_of_data_assets_analysis as $list_of_data_assets_analysis_item) {
		$selected_services_list = list_data_asset_security_services_join(" WHERE data_asset_security_services_join_data_asset_id = \"$list_of_data_assets_analysis_item[data_asset_id]\"");
		if (count($selected_services_list) == "0") {
			$no_control++;
		}
	}

	if (empty($no_control)) {
	$percentage_of_missing_controls=0;
	} else {
	$percentage_of_missing_controls = ($no_control / count($list_of_data_assets_analysis)) * 100; 
	}

	# i want to know how many analysis i have in total , and the percentage which have WRONG controls asociated
	$wrong_control=0;
	foreach($list_of_data_assets_analysis as $list_of_data_assets_analysis_item) {
		$selected_services_list = list_data_asset_security_services_join(" WHERE data_asset_security_services_join_data_asset_id = \"$list_of_data_assets_analysis_item[data_asset_id]\"");
		foreach($selected_services_list as $selected_services_item) {
		if (security_service_check($selected_services_item[data_asset_security_services_join_security_services_id])) {
			$wrong_control++;
		}
		}
	}
	if (empty($wrong_control)) {
	$percentage_of_wrong_controls=0;
	} else { 
	$percentage_of_wrong_controls = ($wrong_control / $count_list_of_data_assets_analysis)* 100; 
	}

	$date=give_me_date();
	
	$asset_update = array(
		'count_assets_total' => $total_numer_of_assets,
		'count_assets_type_one' => $count_assets_type_one,
		'count_assets_type_two' => $count_assets_type_two,
		'count_assets_type_three' => $count_assets_type_three,
		'count_assets_type_four' => $count_assets_type_four,
		'count_assets_type_five' => $count_assets_type_five,
		'percentage_of_missing_controls' => $percentage_of_missing_controls,
		'percentage_of_wrong_controls' => $percentage_of_wrong_controls,
		'dashboard_date' => $date
	);	

	$asset_dashboard_id = add_asset_dashboard($asset_update);
}

function list_asset_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM asset_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_asset_dashboard($asset_dashboard_data) {
	$sql = "INSERT INTO
		asset_dashboard_tbl
		VALUES (
		\"$asset_dashboard_data[asset_dashboard_id]\",
		\"$asset_dashboard_data[count_assets_total]\",
		\"$asset_dashboard_data[count_assets_type_one]\",
		\"$asset_dashboard_data[count_assets_type_two]\",
		\"$asset_dashboard_data[count_assets_type_three]\",
		\"$asset_dashboard_data[count_assets_type_four]\",
		\"$asset_dashboard_data[count_assets_type_five]\",
		\"$asset_dashboard_data[percentage_of_missing_controls]\",
		\"$asset_dashboard_data[percentage_of_wrong_controls]\",
		\"$asset_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_asset_dashboard($asset_dashboard_data, $asset_dashboard_id) {
	$sql = "UPDATE asset_dashboard_tbl
		SET
		asset_dashboard_name=\"$asset_dashboard_data[asset_dashboard_name]\",
		asset_dashboard_description=\"$asset_dashboard_data[asset_dashboard_description]\"
		WHERE
		asset_dashboard_id=\"$asset_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_asset_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from asset_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_asset_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM asset_dashboard_tbl WHERE asset_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[asset_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[asset_dashboard_id]\">$results_item[asset_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_dashboard_id]\">$results_item[asset_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[asset_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[asset_dashboard_id]\">$results_item[asset_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[asset_dashboard_id]\">$results_item[asset_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[asset_dashboard_id]\">$results_item[asset_dashboard_name]</option>\n"; 
		}
	}

}

function disable_asset_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE asset_dashboard_tbl SET asset_dashboard_disabled=\"1\" WHERE asset_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_asset_dashboard_csv() {

	# this will dump the table asset_dashboard_tbl on CSV format
	$sql = "SELECT * from asset_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/asset_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "asset_dashboard_id,asset_dashboard_name,asset_dashboard_description,asset_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[asset_dashboard_id],$line[asset_dashboard_name],$line[asset_dashboard_descripion],$line[asset_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
