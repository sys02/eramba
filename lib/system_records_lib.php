<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/system_records/system_records/ - SAMEPLE

include_once("mysql_lib.php");
include_once("site_lib.php");
include_once("system_users_lib.php");


function list_system_records($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM system_records_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function add_system_records($system_records_section, $system_records_subsection, $system_records_item_id, $system_records_author, $system_records_action, $system_records_notes) {

	$system_records_time = give_me_date_time();
		
	$sql = "INSERT INTO
		system_records_tbl
		VALUES (
		\"NULL\",
		\"$system_records_section\",
		\"$system_records_subsection\",
		\"$system_records_item_id\",
		\"$system_records_author\",
		\"$system_records_action\",
		\"$system_records_notes\",
		\"$system_records_time\"
		)
		";	

	$result = runUpdateQuery($sql);
	return $result;
	
}

function lookup_system_records($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from system_records_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_system_records($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM system_records_tbl WHERE system_records_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[system_records_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[system_records_id]\">$results_item[system_records_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_records_id]\">$results_item[system_records_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[system_records_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[system_records_id]\">$results_item[system_records_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[system_records_id]\">$results_item[system_records_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[system_records_id]\">$results_item[system_records_name]</option>\n"; 
		}
	}

}

function disable_system_records($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE system_records_tbl SET system_records_disabled=\"1\" WHERE system_records_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_system_records_csv() {

	# this will dump the table system_records_tbl on CSV format
	$sql = "SELECT * from system_records_tbl";
	$result = runQuery($sql);
	
	# open file
	$export_file = "downloads/system_records_export.csv";
	$handler = fopen($export_file, 'w');
	
	fwrite($handler, "system_records_id,system_records_section,system_records_subsection,system_records_item_id,system_records_author,system_records_action,system_records_notes,system_records_date\n");

	foreach($result as $line) {
		
		$username = lookup_system_users("system_users_id",$line[system_records_author]);

		fwrite($handler,"$line[system_records_id],$line[system_records_section],$line[system_records_subsection],$line[system_records_item_id],$username[system_users_login],$line[system_records_action],$line[system_records_notes],$line[system_records_date]\n");

	}
	
	fclose($handler);

}

function get_record_url($section, $subsection, $id) {
	//$sql = "SELECT `system_authorization_target_url` FROM `system_authorization_tbl` WHERE `system_authorization_section_name` = '$section' AND `system_authorization_subsection_name` = '" . $subsection . "_list'"; 
	//$result = runSmallQuery($sql);
	$not_link = array('bu-process', 'asset_identification', 'data_asset', 'risk_management', 'compliance_management');
	if ( in_array($subsection, $not_link) )
		return "#";

	$link = "?section=" . $section . "&subsection=" . $subsection . "_list&show_id=" . $id;
	return $link;
}

$correct_system_tables = array(
	'asset_identification' => 'asset'
);

function get_system_edit_entry_url( $tbl, $id ) {
	$correct_system_tables = array(
		'asset_identification' => 'asset'
	);
	
	if ( array_key_exists( $tbl, $correct_system_tables ) ) {
		$tbl = $correct_system_tables[ $tbl ];
	}
	$id_col = $tbl;

	$edit_tbl_name = $tbl . '_edit';
	$sql = "SELECT * FROM `system_authorization_tbl` WHERE `system_authorization_subsection_name` = '$edit_tbl_name'";
	$query = runSmallQuery( $sql );
	$url = 'index.php?section=' . $query['system_authorization_section_name'] . '&subsection=' . $query['system_authorization_subsection_name'] . '&action=edit&' . $id_col . '_id=' . $id;
	return $url;
}

function get_system_record_cute_name( $subsection ) {

#	$correct_system_tables = array(
#		'asset_identification' => 'asset'
#	);
#
#	if (  array_key_exists( $subsection, $correct_system_tables ) ) {
#		$subsection = $correct_system_tables[ $subsection ];
#	}
#	
#	$subsection = $subsection . '_list';
	
#	$sql = "SELECT `system_authorization_section_cute_name`, `system_authorization_subsection_cute_name` FROM `system_authorization_tbl` WHERE `system_authorization_subsection_name` = '$subsection'";
	return;
}

?>
