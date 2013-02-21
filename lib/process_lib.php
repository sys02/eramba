<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/process/process/ - SAMEPLE

include_once("mysql_lib.php");
include_once("bu_lib.php");

function list_process($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM process_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_process($process_data) {
	$sql = "INSERT INTO
		process_tbl
		VALUES (
		\"$process_data[process_id]\",
		\"$process_data[process_name]\",
		\"$process_data[bu_id]\",
		\"$process_data[process_description]\",
		\"$process_data[process_mto]\",
		\"$process_data[process_revenue]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_process($process_data, $process_id) {
	$sql = "UPDATE process_tbl
		SET
		process_name=\"$process_data[process_name]\",
		bu_id=\"$process_data[bu_id]\",
		process_description=\"$process_data[process_description]\",
		process_mto=\"$process_data[process_mto]\",
		process_revenue=\"$process_data[process_revenue]\"
		WHERE
		process_id=\"$process_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_process($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from process_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_process($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM process_tbl".$order_clause;
	$results = runQuery($sql);

	foreach($results as $process_item) {

		# get the name of the BU
		$bu_data = lookup_bu("bu_id",$process_item[bu_id]);

		if ($pre_selected_items) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($process_item[process_id] == $preselected) {
					echo "<option selected=\"selected\">($bu_data[bu_name]) - $process_item[process_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option>($bu_data[bu_name]) - $process_item[process_name]</option>\n";
			}

		} else {
			# MUST EDIT
			echo "<option>($bu_data[bu_name]) - $process_item[process_name]</option>\n";
		}
	}
}

function disable_process($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE process_tbl SET process_disabled=\"1\" WHERE process_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_process_csv() {

	# this will dump the table process_tbl on CSV format
	$sql = "SELECT * from process_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/process_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "bu_name,process_id,process_name,process_description,process_mto,process_revenue,process_disabled\n");
	foreach($result as $line) {

		$bu_name = lookup_bu("bu_id",$line[bu_id]);

		fwrite($handler,"$bu_name[bu_name],$line[process_id],$line[process_name],$line[process_description],$line[process_mto],$line[process_revenue],$line[process_disabled]\n");
	}
	
	fclose($handler);

}

?>
