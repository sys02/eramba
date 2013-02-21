<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_exception/risk_exception/ - SAMEPLE

include_once("mysql_lib.php");


function check_risk_exception($id) {

	$risk_data = lookup_risk_exception("risk_exception_id",$id);	

	if ($risk_data[risk_exception_expiration] == "0000-00-00") {
		return 1;
	}
	
	$today = strtotime(date("Y-m-d"));
	$expiration_date = strtotime($risk_data[risk_exception_expiration]);	

	# echo "putA: $risk_id $today vs. $expiration_date<br>";

	if ($expiration_date > $today) {
		return;
	} else {
		return 1;	
	}


}

function list_risk_exception($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_exception_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_risk_exception($risk_exception_data) {
	$sql = "INSERT INTO
		risk_exception_tbl
		VALUES (
		\"$risk_exception_data[risk_exception_id]\",
		\"$risk_exception_data[risk_exception_title]\",
		\"$risk_exception_data[risk_exception_description]\",
		\"$risk_exception_data[risk_exception_author]\",
		\"$risk_exception_data[risk_exception_expiration]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_risk_exception($risk_exception_data, $risk_exception_id) {
	$sql = "UPDATE risk_exception_tbl
		SET
		risk_exception_title=\"$risk_exception_data[risk_exception_title]\",
		risk_exception_description=\"$risk_exception_data[risk_exception_description]\",
		risk_exception_author=\"$risk_exception_data[risk_exception_author]\",
		risk_exception_expiration=\"$risk_exception_data[risk_exception_expiration]\"
		WHERE
		risk_exception_id=\"$risk_exception_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_exception($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_exception_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_exception($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_exception_tbl WHERE risk_exception_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_exception_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_exception_id]\">$results_item[risk_exception_title]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_exception_id]\">$results_item[risk_exception_title]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_exception_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_exception_id]\">$results_item[risk_exception_title]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_exception_id]\">$results_item[risk_exception_title]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_exception_id]\">$results_item[risk_exception_title]</option>\n"; 
		}
	}

}

function disable_risk_exception($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_exception_tbl SET risk_exception_disabled=\"1\" WHERE risk_exception_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_exception_csv() {

	# this will dump the table risk_exception_tbl on CSV format
	$sql = "SELECT * from risk_exception_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_exception_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_exception_id,risk_exception_title,risk_exception_description,risk_exception_author, risk_exception_disabled\n");

	foreach($result as $line) {
		
		# $risk_exception_status = lookup_risk_exception("risk_exception_id", $line[risk_exception_status]); 

		fwrite($handler,"$line[risk_exception_id],$line[risk_exception_title],$line[risk_exception_description],$line[risk_exception_author],$line[risk_exception_disabled]\n");

	}
	
	fclose($handler);

}

?>
