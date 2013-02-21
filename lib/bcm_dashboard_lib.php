<?
	
# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/bcm_plans_dashboard/bcm_plans_dashboard/ - SAMEPLE

include_once("mysql_lib.php");
include_once("bcm_plans_lib.php");
include_once("bcm_plans_audit_lib.php");

function bcm_plans_dashboard_data($force) {

	if (!$force) {
	# i need to make sure i add data ONLY if this current month has no data already
	# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
	$month = give_me_this_month();
	$bcm_plans_dashboard_list = list_bcm_plans_dashboard(" WHERE MONTH(dashboard_date) = $month");
	if (count($bcm_plans_dashboard_list)!=0) {
		#echo "no more updates for this month";
		return;
	}
	}

	# now i start getting hte data for a new update on the dashaboards
	$bcm_plans_dashboard_count=0;
	$bcm_plans_dashboard_failed_audits=0;

	$bcm_plans_list = list_bcm_plans(" WHERE bcm_plans_disabled = \"0\"");
	$bcm_plans_dashboard_count= count($bcm_plans_list);

	foreach($bcm_plans_list as $bcm_plans_item) {

		if (!check_bcm_plans_last_audit_result($bcm_plans_item[bcm_plans_id])) {
			$bcm_plans_dashboard_failed_audits++;
		}
	}	

	$date=give_me_date();
	
	$bcm_plans_update = array(
		'bcm_plans_dashboard_count' => $bcm_plans_dashboard_count,
		'bcm_plans_dashboard_failed_audits' => $bcm_plans_dashboard_failed_audits,
		'dashboard_date' => $date
	);	

	$bcm_plans_dashboard_id = add_bcm_plans_dashboard($bcm_plans_update);
}

function list_bcm_plans_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_bcm_plans_dashboard($bcm_plans_dashboard_data) {
	$sql = "INSERT INTO
		bcm_plans_dashboard_tbl
		VALUES (
		\"$bcm_plans_dashboard_data[bcm_plans_dashboard_id]\",
		\"$bcm_plans_dashboard_data[bcm_plans_dashboard_count]\",
		\"$bcm_plans_dashboard_data[bcm_plans_dashboard_failed_audits]\",
		\"$bcm_plans_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_bcm_plans_dashboard($bcm_plans_dashboard_data, $bcm_plans_dashboard_id) {
	$sql = "UPDATE bcm_plans_dashboard_tbl
		SET
		bcm_plans_dashboard_name=\"$bcm_plans_dashboard_data[bcm_plans_dashboard_name]\",
		bcm_plans_dashboard_description=\"$bcm_plans_dashboard_data[bcm_plans_dashboard_description]\"
		WHERE
		bcm_plans_dashboard_id=\"$bcm_plans_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_bcm_plans_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from bcm_plans_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_bcm_plans_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM bcm_plans_dashboard_tbl WHERE bcm_plans_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[bcm_plans_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_dashboard_id]\">$results_item[bcm_plans_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_dashboard_id]\">$results_item[bcm_plans_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[bcm_plans_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[bcm_plans_dashboard_id]\">$results_item[bcm_plans_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[bcm_plans_dashboard_id]\">$results_item[bcm_plans_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[bcm_plans_dashboard_id]\">$results_item[bcm_plans_dashboard_name]</option>\n"; 
		}
	}

}

function disable_bcm_plans_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE bcm_plans_dashboard_tbl SET bcm_plans_dashboard_disabled=\"1\" WHERE bcm_plans_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_bcm_plans_dashboard_csv() {

	# this will dump the table bcm_plans_dashboard_tbl on CSV format
	$sql = "SELECT * from bcm_plans_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/bcm_plans_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "bcm_plans_dashboard_id,bcm_plans_dashboard_name,bcm_plans_dashboard_description,bcm_plans_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[bcm_plans_dashboard_id],$line[bcm_plans_dashboard_name],$line[bcm_plans_dashboard_descripion],$line[bcm_plans_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
