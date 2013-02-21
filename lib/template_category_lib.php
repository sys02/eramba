<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/category/category/ - SAMEPLE

include_once("mysql_lib.php");

function list_category($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM category_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_category($category_data) {
	$sql = "INSERT INTO
		category_tbl
		VALUES (
		\"$category_data[category_id]\",
		\"$category_data[category_name]\",
		\"$category_data[category_description]\",
		\"0\"
		)
		";	
	$result = runUpdateQuery($sql);
	return $result;
	
}

function update_category($category_data, $category_id) {
	$sql = "UPDATE category_tbl
		SET
		category_name=\"$category_data[category_name]\",
		category_description=\"$category_data[category_description]\"
		WHERE
		category_id=\"$category_id\"
		";	
	$result = runUpdateQuery($sql);
	return $result;
}

function lookup_category($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from category_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_category($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM category_tbl WHERE category_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[category_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[category_id]\">$results_item[category_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[category_id]\">$results_item[category_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[category_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[category_id]\">$results_item[category_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[category_id]\">$results_item[category_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[category_id]\">$results_item[category_name]</option>\n"; 
		}
	}

}

function disable_category($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE category_tbl SET category_disabled=\"1\" WHERE category_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_category_csv() {

	# this will dump the table category_tbl on CSV format
	$sql = "SELECT * from category_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/category_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "category_id,category_name,category_description,category_disabled\n");
	foreach($result as $line) {
		fwrite($handler,"$line[category_id],$line[category_name],$line[category_descripion],$line[category_disabled]\n");
	}
	
	fclose($handler);

}

?>
