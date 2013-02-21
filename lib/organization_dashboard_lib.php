<?
	
# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/organization_dashboard/organization_dashboard/ - SAMEPLE

include_once("mysql_lib.php");
include_once("bu_lib.php");
include_once("process_lib.php");
include_once("legal_lib.php");
include_once("tp_lib.php");

function organization_dashboard_data($force) {

	if (!$force) {
	# i need to make sure i add data ONLY if this current month has no data already
	# otherwise i would collect too many samples for one month. I need to make sure i collect ONE SAMPLE PER MONTH!
	$month = give_me_this_month();
	$organization_dashboard_list = list_organization_dashboard(" WHERE MONTH(dashboard_date) = $month");
	if (count($organization_dashboard_list)!=0) {
		#echo "no more updates for this month";
		return;
	}
	}

	# now i start getting hte data for a new update on the dashaboards
	$organization_dashboard_count_bu = count(list_bu(" WHERE bu_disabled=\"0\""));
	$organization_dashboard_count_process=count(list_process(" WHERE process_disabled=\"0\""));
	$organization_dashboard_count_legal=count(list_legal(" WHERE legal_disabled=\"0\""));
	$organization_dashboard_count_tp=count(list_tp(" WHERE tp_disabled=\"0\""));
	
	$date=give_me_date();
	
	$organization_update = array(
		'organization_dashboard_count_bu' => $organization_dashboard_count_bu,
		'organization_dashboard_count_process' => $organization_dashboard_count_process,
		'organization_dashboard_count_legal' => $organization_dashboard_count_legal,
		'organization_dashboard_count_tp' => $organization_dashboard_count_tp,
		'dashboard_date' => $date
	);	

	$organization_dashboard_id = add_organization_dashboard($organization_update);
}

function list_organization_dashboard($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM organization_dashboard_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_organization_dashboard($organization_dashboard_data) {
	$sql = "INSERT INTO
		organization_dashboard_tbl
		VALUES (
		\"$organization_dashboard_data[organization_dashboard_id]\",
		\"$organization_dashboard_data[organization_dashboard_count_bu]\",
		\"$organization_dashboard_data[organization_dashboard_count_process]\",
		\"$organization_dashboard_data[organization_dashboard_count_legal]\",
		\"$organization_dashboard_data[organization_dashboard_count_tp]\",
		\"$organization_dashboard_data[dashboard_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_organization_dashboard($organization_dashboard_data, $organization_dashboard_id) {
	$sql = "UPDATE organization_dashboard_tbl
		SET
		organization_dashboard_name=\"$organization_dashboard_data[organization_dashboard_name]\",
		organization_dashboard_description=\"$organization_dashboard_data[organization_dashboard_description]\"
		WHERE
		organization_dashboard_id=\"$organization_dashboard_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_organization_dashboard($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from organization_dashboard_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_organization_dashboard($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM organization_dashboard_tbl WHERE organization_dashboard_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[organization_dashboard_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[organization_dashboard_id]\">$results_item[organization_dashboard_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[organization_dashboard_id]\">$results_item[organization_dashboard_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[organization_dashboard_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[organization_dashboard_id]\">$results_item[organization_dashboard_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[organization_dashboard_id]\">$results_item[organization_dashboard_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[organization_dashboard_id]\">$results_item[organization_dashboard_name]</option>\n"; 
		}
	}

}

function disable_organization_dashboard($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE organization_dashboard_tbl SET organization_dashboard_disabled=\"1\" WHERE organization_dashboard_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_organization_dashboard_csv() {

	# this will dump the table organization_dashboard_tbl on CSV format
	$sql = "SELECT * from organization_dashboard_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/organization_dashboard_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "organization_dashboard_id,organization_dashboard_name,organization_dashboard_description,organization_dashboard_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[organization_dashboard_id],$line[organization_dashboard_name],$line[organization_dashboard_descripion],$line[organization_dashboard_disabled]\n");
	}
	
	fclose($handler);

}

?>
