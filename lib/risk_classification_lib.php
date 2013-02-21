<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/risk_classification/risk_classification/ - SAMEPLE

include_once("mysql_lib.php");

function pre_selected_risk_classification_values($risk_classification_type, $risk_id) {

	# i need to know all classification id's with the "risk_classification_type" value
	# i need to know all classifications made with the risk $risk_id
	# i need to mix those two
	
	# i need to know all classification id's with the "risk_classification_type" value
	$sql = "SELECT
		risk_classification_id
		FROM
		risk_classification_tbl
		WHERE
		risk_classification_type = \"$risk_classification_type\"
		AND
		risk_classification_disabled = \"0\"
		";
	# echo "sql1: $sql<br>";
	$classification_id = runQuery($sql);

	# i need to know all classifications made with the risk $risk_id
	$sql = "SELECT
		risk_classification_join_risk_classification_id
		FROM
		risk_classification_join	
		WHERE
		risk_classification_join_risk_id = \"$risk_id\"
		";
	# echo "sql2: $sql<br>";
	$risk_classifications = runQuery($sql);

	# i need to mix those two
	foreach($classification_id as $classification_item) {
		# i need to know if any of this is used by the risk id
		foreach($risk_classifications as $risk_classification_item) {
			if ($classification_item[risk_classification_id] == $risk_classification_item[risk_classification_join_risk_classification_id]) {
				return $risk_classification_item[risk_classification_join_risk_classification_id];
			}
		}	
	}
}

# this function inserts classifications for risks
function lookup_risk_classification_join($risk_classification_join_risk_id) {
	if (!is_numeric($risk_classification_join_risk_id)) {
		return;
	}

	$sql = "SELECT
		*
		FROM
		risk_classification_join
		WHERE
		risk_classification_join_risk_id = \"$risk_classification_join_risk_id\"
		";
	$results = runQuery($sql);
	return $results;
}

# this function inserts classifications for risks
function add_risk_classification_join($risk_classification_join_risk_id, $risk_classification_join_risk_classification_id) {

	if (!is_numeric($risk_classification_join_risk_id)) {
		return;
	}
	
	$sql = "INSERT INTO
		risk_classification_join
		VALUES (
		\"$risk_classification_join_risk_id\",
		\"$risk_classification_join_risk_classification_id\"
		)
		";	

	$result = runUpdateQuery($sql);
	return $result;
}

# this function deletes form the table risk_classification_join_id all asociated items with risk $risk_id
function delete_risk_classification_join($risk_id) {

	if (!is_numeric($risk_id)) {
		return;
	}
	
	$sql = "DELETE
		from
		risk_classification_join
		WHERE
		risk_classification_join_risk_id = \"$risk_id\"
		";
	
	$result = runUpdateQuery($sql);
	return $result;
}

# This functions returns the number of classifications (maximum 5) to list risks in html
function list_risk_classification_distinct() {
	$sql = "SELECT
		DISTINCT
		risk_classification_type
		FROM
		risk_classification_tbl
		WHERE
		risk_classification_disabled = \"0\"
		LIMIT
		5
		"; 
	$results = runQuery($sql);
	return $results;
}

function list_risk_classification($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM risk_classification_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_risk_classification($risk_classification_data) {
	$sql = "INSERT INTO
		risk_classification_tbl
		VALUES (
		\"$risk_classification_data[risk_classification_id]\",
		\"$risk_classification_data[risk_classification_name]\",
		\"$risk_classification_data[risk_classification_criteria]\",
		\"$risk_classification_data[risk_classification_type]\",
		\"$risk_classification_data[risk_classification_value]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_risk_classification($risk_classification_data, $risk_classification_id) {
	$sql = "UPDATE risk_classification_tbl
		SET
		risk_classification_name=\"$risk_classification_data[risk_classification_name]\",
		risk_classification_criteria=\"$risk_classification_data[risk_classification_criteria]\",
		risk_classification_type=\"$risk_classification_data[risk_classification_type]\",
		risk_classification_value=\"$risk_classification_data[risk_classification_value]\"
		WHERE
		risk_classification_id=\"$risk_classification_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_risk_classification($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from risk_classification_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_risk_classification($pre_selected_items='', $order_clause='', $risk_classification_type) {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM risk_classification_tbl WHERE risk_classification_disabled = \"0\" AND risk_classification_type = \"$risk_classification_type\"".$order_clause;
	# echo "PUTA: $sql";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[risk_classification_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[risk_classification_id]\">$results_item[risk_classification_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_classification_id]\">$results_item[risk_classification_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[risk_classification_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[risk_classification_id]\">$results_item[risk_classification_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[risk_classification_id]\">$results_item[risk_classification_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[risk_classification_id]\">$results_item[risk_classification_name]</option>\n"; 
		}
	}

}

function disable_risk_classification($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE risk_classification_tbl SET risk_classification_disabled=\"1\" WHERE risk_classification_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_risk_classification_csv() {

	# this will dump the table risk_classification_tbl on CSV format
	$sql = "SELECT * from risk_classification_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/risk_classification_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "risk_classification_id,risk_classification_name,risk_classification_description,risk_classification_type, risk_classification_value, risk_classification_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[risk_classification_id],$line[risk_classification_name],$line[risk_classification_criteria],$line[risk_classification_type], $line[risk_classification_value],$line[risk_classification_disabled]\n");
	}
	
	fclose($handler);

}

?>
