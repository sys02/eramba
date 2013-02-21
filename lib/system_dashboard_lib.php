<?
	

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/system_dashboard/system_dashboard/ - SAMEPLE

include_once("mysql_lib.php");
include_once("lib/system_records_lib.php");

function system_dashboard_data($force) {

	$month = give_me_this_month();

	if (!$force) {
	# i need to make sure i add data ONLY if this current month has no data already
	# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
	$system_dashboard_list = list_system_dashboard(" WHERE MONTH(dashboard_date) = $month");
	if (count($system_dashboard_list)!=0) {
		#echo "no more updates for this month";
		return;
	}
	}

	# now i start getting hte data for a new update on the dashaboards
	$login_ok=0;
	$login_not_ok=0;
	
	$system_login_ok = count(list_system_records(" WHERE system_records_action = \"Login\" AND MONTH(system_records_date) = $month"));
	$system_login_not_ok = count(list_system_records(" WHERE system_records_action = \"Wrong Login\" AND MONTH(system_records_date) = $month"));

	$date=give_me_date();
	
	$system_update = array(
		'system_dashboard_login_ok' => $system_login_ok,
		'system_dashboard_login_not_ok' => $system_login_not_ok,
		'dashboard_date' => $date,
	);	

	$system_dashboard_id = add_system_dashboard($system_update);
}

function list_system_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM system_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_system_dashboard($system_dashboard_data) {
	$sql = "INSERT INTO
		system_dashboard_tbl
		VALUES (
		\"$system_dashboard_data[system_dashboard_id]\",
		\"$system_dashboard_data[system_dashboard_login_ok]\",
		\"$system_dashboard_data[system_dashboard_login_not_ok]\",
		\"$system_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_system_dashboard($system_dashboard_data, $system_dashboard_id) {
	$sql = "UPDATE system_dashboard_tbl
		SET
		system_dashboard_name=\"$system_dashboard_data[system_dashboard_name]\",
		system_dashboard_description=\"$system_dashboard_data[system_dashboard_description]\"
		WHERE
		system_dashboard_id=\"$system_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_system_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from system_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_dashboard_tbl WHERE system_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_dashboard_id]\">$results_item[system_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_dashboard_id]\">$results_item[system_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_dashboard_id]\">$results_item[system_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_dashboard_id]\">$results_item[system_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_dashboard_id]\">$results_item[system_dashboard_name]</option>\n"; 
		}
	}

}

function disable_system_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE system_dashboard_tbl SET system_dashboard_disabled=\"1\" WHERE system_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_system_dashboard_csv() {

	# this will dump the table system_dashboard_tbl on CSV format
	$sql = "SELECT * from system_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/system_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "system_dashboard_id,system_dashboard_name,system_dashboard_description,system_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[system_dashboard_id],$line[system_dashboard_name],$line[system_dashboard_descripion],$line[system_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
