<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/system_conf_pwd/system_conf_pwd/ - SAMEPLE

include_once("mysql_lib.php");

function list_system_conf_pwd($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM system_conf_pwd_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_system_conf_pwd($system_conf_pwd_data) {
	$sql = "INSERT INTO
		system_conf_pwd_tbl
		VALUES (
		\"\",
		\"$system_conf_pwd_data[system_conf_timestamp]\",
		\"$system_conf_pwd_data[system_conf_login_id]\",
		SHA1(\"$system_conf_pwd_data[system_conf_pwd]\")
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function lookup_system_conf_pwd($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from system_conf_pwd_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_conf_pwd($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_conf_pwd_tbl WHERE system_conf_pwd_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_conf_pwd_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_conf_pwd_id]\">$results_item[system_conf_pwd_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_conf_pwd_id]\">$results_item[system_conf_pwd_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_conf_pwd_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_conf_pwd_id]\">$results_item[system_conf_pwd_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_conf_pwd_id]\">$results_item[system_conf_pwd_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_conf_pwd_id]\">$results_item[system_conf_pwd_name]</option>\n"; 
		}
	}

}

function disable_system_conf_pwd($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE system_conf_pwd_tbl SET system_conf_pwd_disabled=\"1\" WHERE system_conf_pwd_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_system_conf_pwd_csv() {

	# this will dump the table system_conf_pwd_tbl on CSV format
	$sql = "SELECT * from system_conf_pwd_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/system_conf_pwd_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "system_conf_pwd_id,system_conf_pwd_name,system_conf_pwd_description,system_conf_pwd_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[system_conf_pwd_id],$line[system_conf_pwd_name],$line[system_conf_pwd_descripion],$line[system_conf_pwd_disabled]\n");
	}
	
	fclose($handler);

}

?>
