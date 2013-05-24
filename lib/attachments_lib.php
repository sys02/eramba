<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/attachments_tbl/attachments_tbl/ - SAMEPLE

include_once("mysql_lib.php");

function list_attachments($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM attachments_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_attachments($attachments_tbl_data) {
	$sql = "INSERT INTO
		attachments_tbl
		VALUES (
		\"$attachments_tbl_data[attachments_tbl_id]\",
		\"$attachments_tbl_data[attachments_original_name]\",
		\"$attachments_tbl_data[attachments_unique_name]\",
		\"$attachments_tbl_data[attachments_ref_section]\",
		\"$attachments_tbl_data[attachments_ref_subsection]\",
		\"$attachments_tbl_data[attachments_ref_id]\",
		\"$attachments_tbl_data[attachments_upload_date]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_attachments($attachments_tbl_data, $attachments_tbl_id) {
	$sql = "UPDATE attachments_tbl
		SET
		attachments_tbl_name=\"$attachments_tbl_data[attachments_tbl_name]\",
		attachments_tbl_description=\"$attachments_tbl_data[attachments_tbl_description]\"
		WHERE
		attachments_tbl_id=\"$attachments_tbl_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_attachments($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from attachments_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_attachments_tbl($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM attachments_tbl WHERE attachments_tbl_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[attachments_tbl_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[attachments_tbl_id]\">$results_item[attachments_tbl_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[attachments_tbl_id]\">$results_item[attachments_tbl_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[attachments_tbl_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[attachments_tbl_id]\">$results_item[attachments_tbl_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[attachments_tbl_id]\">$results_item[attachments_tbl_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[attachments_tbl_id]\">$results_item[attachments_tbl_name]</option>\n"; 
		}
	}

}

function disable_attachments($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE attachments_tbl SET attachments_disabled=\"1\" WHERE attachments_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);

	$data_info = lookup_attachments("attachments_id", $item_id);

	# i should delete the file as well
	unlink("downloads/uploads/$data_info[attachments_unique_name]");

	return;
}

function export_attachments_tbl_csv() {

	# this will dump the table attachments_tbl on CSV format
	$sql = "SELECT * from attachments_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/attachments_tbl_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "attachments_tbl_id,attachments_tbl_name,attachments_tbl_description,attachments_tbl_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[attachments_tbl_id],$line[attachments_tbl_name],$line[attachments_tbl_descripion],$line[attachments_tbl_disabled]\n");
	}
	
	fclose($handler);

}

?>
