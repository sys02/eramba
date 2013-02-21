<?

# WARNING! This is a TEMPLATE
# IF YOU WANT TO USE, YOU MUST RENAME FUNCTIONS!! :s/security_services_audit/security_services_audit/ - SAMEPLE

include_once("mysql_lib.php");
#include_once("security_services_lib.php");
#include_once("security_services_audit_calendar_lib.php");
#include_once("security_services_catalogue_maintenance_calendar_join_lib.php");
#include_once("security_services_audit_results_lib.php");
#include_once("site_lib.php");

function new_year_maintenance_updates() {

	$this_year = give_me_this_year();

	# i need to search if there's any audit for this year...
	$current_maintenance_list = list_security_services_audit(" WHERE security_services_maintenance_planned_year = \"$this_year\"");	

	# if there's NO audit for this year, that is strange since audits are created automaticaly for the same calendar year
	# when the control audit was created
	if (empty($current_maintenance_list)) { 
		# echo "puta: i shouuld create audits for this calendar year, i might be in a new year<br>";	
		$security_services = list_security_services(" WHERE security_services_disabled = \"0\"");
		if ($security_services) {
			foreach($security_services as $security_services_item) {
				$audit_id = real_add_security_services_audit($security_services_item[security_services_id]);
				#echo "puta: i will now add audits for the sec. serv id $security_services_item[security_services_id]<br>";
				add_system_records("security_services","security_services_maintenance_edit",$audit_id,"SYSTEM","Insert","");
			}
		}
	}

}

function list_security_services_maintenance($arguments) {
	# MUST EDIT
	$sql = "SELECT * FROM security_services_maintenance_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function list_security_services_maintenance_unique($arguments) {
	# MUST EDIT
	$sql = "SELECT DISTINCT security_services_maintenance_security_service_id  FROM security_services_maintenance_tbl".$arguments;
	$results = runQuery($sql);
	return $results;
}

function check_service_last_maintenance_result($security_services_id) {


	# let's keep this a bit more simple
	# last audits are checked based on the inputs in security_services_maintenance_tbl .. 
	# i look which month and year is today and everythig in the past should be reviewed
	# that's as much check we do

	$audit_list = list_security_services_maintenance(" WHERE security_services_maintenance_disabled = \"0\" AND security_services_maintenance_security_service_id = \"$security_services_id\"");
	$this_year = give_me_this_year();
	$this_month = give_me_this_month();

	# echo "puta: $security_services_id<br>";

	foreach($audit_list as $audit_item) {
		# i just care for what it didnt pass
		if($audit_item[security_services_maintenance_result] != "2") {
			# here i should have a non audit pass... 
			# is it previous to this current date?
			if ($audit_item[security_services_maintenance_planned_year] < $this_year) {
				# this is for sure a non-compliance from previous years
				return;
			} elseif ($audit_item[security_services_maintenance_planned_year] == $this_year && $audit_item[security_services_maintenance_calendar_id] < $this_month) {
				# this is for sure a non-compliance from this month
				return;
			}
		}
	}

	# if i managed to get here i should be ok
	return 1;

}

# the objective is to ensure that there's an audit record for future times starting today.
# so if i get called, i need to make sure that there will be an audit in the future for this service, when? well, the planned started date + periodicity.
# if the planned start date is after today, then i do nothing! i wait until the planned start date is in the PAST and then i will eventually create one
function add_security_services_maintenance_v2($security_services_id) {
	
	# first i need to know if this service is valid
	$service_information = lookup_security_services("security_services_id", $security_services_id); 
	if (empty($service_information[security_services_id])) {
		# echo "DEBUG: Not a valid service<br>";
		return 1;
	}

	# then i need to check which audits i have PLANNED for this service (this will give me the list of months ids) for EVERY YEAR 
	$service_planned_audits_list = list_security_services_catalogue_maintenance_calendar_join( " WHERE security_service_catalogue_id = \"$service_information[security_services_id]\""); 
	if (!count($service_planned_audits_list)) {
		# echo "DEBUG: no tiene audits planned ($service_information[security_services_id]) <br>";
		return 1;
	}
	
	# then i need to check which audits i have CREATED for this service THIS YEAR
	# then i need to make sure all what was planned is created
	$this_year = give_me_this_year();

	$service_created_maintenance_list = list_security_services_maintenance(" WHERE security_services_maintenance_security_service_id = \"$service_information[security_services_id]\" and security_services_maintenance_disabled = \"0\" and security_services_maintenance_planned_year = \"$this_year\""); 

	if (!count($service_created_maintenance_list)) {
		# echo "DEBUG: tenes que crear audits papa<br>";
		foreach($service_planned_audits_list as $planned_audit) {
			$audit_id = real_add_security_services_maintenance($service_information[security_services_id], $planned_audit[security_services_maintenance_calendar_id], $this_year, $service_information[security_services_regular_maintenance]);
			add_system_records("security_services","security_services_maintenance_edit",$audit_id,"SYSTEM","Insert","");
		}
		return;
	}
	
	foreach($service_planned_audits_list as $planned_month_audit) {

		# echo "DEBUG: stargin to compare what audits PLANNED against CREATED<br>";
		
		# here i search if i have an audit planned with that ID
		foreach($service_created_maintenance_list as $created_audit) {

			# echo "DEBUG: Comparing .. $planned_month_audit[security_services_maintenance_calendar_id] == $created_audit[security_services_maintenance_calendar_id] <br>";
	
			if ($planned_month_audit[security_services_maintenance_calendar_id] == $created_audit[security_services_maintenance_calendar_id]) {
				# echo "DEBUG: Matched<br>";
				$find = 1;
			}	
		}

		if (empty($find)) {
			# echo "DEBUG: I need to create a new audit, for $this_year and calendarid = $planned_month_audit[security_services_maintenance_calendar_id]<br>";
			$audit_id = real_add_security_services_maintenance($service_information[security_services_id], $planned_month_audit[security_services_maintenance_calendar_id], $this_year, $service_information[security_services_regular_maintenance]);
			add_system_records("security_services","security_services_maintenance_edit",$audit_id,"SYSTEM","Insert","");
		}

		unset($find);

	}

}


function real_add_security_services_maintenance($security_services_id, $plan_date, $year, $metric) {
	 $sql = "INSERT INTO
	security_services_maintenance_tbl
	VALUES (
	\"\",
	\"$security_services_id\",
		\"1\",
		\"$plan_date\",
		\"$year\",
		\"$metric\",
		\"\",
		\"\",
		\"\",
		\"\",
		\"\",
		\"0\"
		)
		";	

	# echo "$sql<br>";
	$result = runUpdateQuery($sql);
	return $result;
}

function update_security_services_maintenance($security_services_maintenance_data, $security_services_maintenance_id) {

	$sql = "UPDATE security_services_maintenance_tbl

		SET

		security_services_maintenance_status=\"$security_services_maintenance_data[security_services_maintenance_status]\",
		security_services_maintenance_task=\"$security_services_maintenance_data[security_services_maintenance_task]\",
		security_services_maintenance_start_maintenance_date=\"$security_services_maintenance_data[security_services_maintenance_start_maintenance_date]\",
		security_services_maintenance_end_maintenance_date=\"$security_services_maintenance_data[security_services_maintenance_end_maintenance_date]\",
		security_services_maintenance_engineer=\"$security_services_maintenance_data[security_services_maintenance_engineer]\",
		security_services_maintenance_result=\"$security_services_maintenance_data[security_services_maintenance_result]\",
		security_services_maintenance_result_description=\"$security_services_maintenance_data[security_services_maintenance_result_description]\"

		WHERE
		security_services_maintenance_id=\"$security_services_maintenance_id\"
		";	

	$result = runUpdateQuery($sql);
	return $result;
}

function sql_lookup_security_services_maintenance($query) {

	# MUST EDIT
	$sql = "SELECT * from security_services_maintenance_tbl $query"; 
	$result = runSmallQuery($sql);
	return $result;
}

function lookup_security_services_maintenance($search_parameter, $item_id) {
	if (!$item_id or !$search_parameter) {
		return;
	}

	# MUST EDIT
	$sql = "SELECT * from security_services_maintenance_tbl WHERE $search_parameter = \"$item_id\""; 
	$result = runSmallQuery($sql);
	return $result;
}

# he needs to return a whole html ready to drop a menu
# he receives an array with an item of pre-selected items that must be pre-selected
# he receives a second argument which is the order by lookup
function list_drop_menu_security_services_maintenance($pre_selected_items='', $order_clause='') {

	if ($order_clause) {
		$order_clause = " ORDER BY ".$order_clause."";
	}

	# MUST EDIT
	$sql = "SELECT * FROM security_services_maintenance_tbl WHERE security_services_maintenance_disabled = \"0\"".$order_clause."";
	$results = runQuery($sql);

	foreach($results as $results_item) {
		if (is_array($pre_selected_items)) { 
			$match = NULL;
			foreach($pre_selected_items as $preselected) {
				# MUST EDIT
				if ($results_item[security_services_maintenance_id] == $preselected) {
					echo "<option selected=\"selected\" value=\"$results_item[security_services_maintenance_id]\">$results_item[security_services_maintenance_name]</option>\n";
					$match = 1;
				} 
			}

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_maintenance_id]\">$results_item[security_services_maintenance_name]</option>\n"; 
			}

		} elseif ($pre_selected_items) {
			$match = NULL;
			# MUST EDIT
			if ($results_item[security_services_maintenance_id] == $pre_selected_items) {
				echo "<option selected=\"selected\" value=\"$results_item[security_services_maintenance_id]\">$results_item[security_services_maintenance_name]</option>\n";
				$match = 1;
			} 

			# MUST EDIT
			if (!$match) { 
				echo "<option value=\"$results_item[security_services_maintenance_id]\">$results_item[security_services_maintenance_name]</option>\n"; 
			}
		} else {
			# MUST EDIT
			echo "<option value=\"$results_item[security_services_maintenance_id]\">$results_item[security_services_maintenance_name]</option>\n"; 
		}
	}

}

function disable_security_services_maintenance($item_id) {
	if (!is_numeric($item_id)) {
		return;
	}
	# MUST EDIT
	$sql = "UPDATE security_services_maintenance_tbl SET security_services_maintenance_disabled=\"1\" WHERE security_services_maintenance_id = \"$item_id\""; 
	$result = runUpdateQuery($sql);
	return;
}

function export_security_services_maintenance_csv() {

# this will dump the table security_services_maintenance_tbl on CSV format
$sql = "SELECT * from security_services_maintenance_tbl";
$result = runQuery($sql);

# open file
$export_file = "downloads/security_services_maintenance_export.csv";

$handler = fopen($export_file, 'w');
	
fwrite($handler, "security_services_maintenance_id,security_service_name,planned_execution,security_services_maintenance_metric,security_services_maintenance_criteria,security_services_maintenance_start_maintenance_date,security_services_maintenance_end_maintenance_date,security_services_maintenance_auditor,security_services_maintenance_result,security_services_maintenance_result_description,security_services_maintenance_disabled\n");

foreach($result as $line) {
	
	$result_name = lookup_security_services_maintenance_result("security_services_maintenance_result_id",$line[security_services_maintenance_result]);	
	$service_name = lookup_security_services("security_services_id",$line[security_services_maintenance_security_service_id]);	
	$planned_execution = lookup_security_services_maintenance_calendar("security_services_maintenance_calendar_id", $line[security_services_maintenance_calendar_id]); 
			
	fwrite($handler,"$line[security_services_maintenance_id],$service_name[security_services_name],$planned_execution[security_services_maintenance_calendar_name],$line[security_services_maintenance_metric],$line[security_services_maintenance_criteria], $line[security_services_maintenance_start_maintenance_date],$line[security_services_maintenance_end_maintenance_date],$line[security_services_maintenance_auditor],$result_name[security_services_maintenance_result_name],$line[security_services_maintenance_result_description],$line[security_services_maintenance_disabled]\n");

	}
	
fclose($handler);

}

function display_html_maintenance_items($service_id) {

	$base_url_list = build_base_url("security_services","security_services_maintenance_list");
	$base_url_edit  = build_base_url("security_services","security_services_maintenance_edit");
	
	# here i need to start listing all the audits for this particular service_id
	$audit_list = list_security_services_audit(" WHERE security_services_maintenance_security_service_id = \"$service_id\" 
			AND
			security_services_maintenance_disabled = \"0\"
			");
	foreach($audit_list as $audit_item) {

	$status_name = lookup_security_services_maintenance_status("security_services_maintenance_status_id",$audit_item[security_services_maintenance_status]); 	

echo "						<tr>";
echo "							<td class=\"action-cell\">";
echo "										$status_name[security_services_maintenance_status_name]";
echo "								<div class=\"cell-label\">";
echo "								 	$process_item[process_name]";
echo "								</div>";
echo "								<div class=\"cell-actions\">";

if ($audit_item[security_services_maintenance_status] == "1") {
	echo "<a href=\"$base_url_list&action=change_status&security_services_maintenance_status=2&security_services_maintenance_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action\">start review</a> ";
} elseif ($audit_item[security_services_maintenance_status] == "2") {
	echo "<a href=\"$base_url_edit&action=edit_security_services_audit&security_services_maintenance_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action\">add evidence</a> ";
	echo "<a href=\"$base_url_list&action=change_status&security_services_maintenance_status=3&security_services_maintenance_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action\">finish review</a> ";
} elseif ($audit_item[security_services_maintenance_status] == "3") {
	echo "<a href=\"$base_url_edit&action=view_evidence&security_services_maintenance_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action\">view evidence</a> ";
}

echo "							<a href=\"$base_url_list&action=disable_security_services_audit&security_services_maintenance_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action delete-action\">delete</a>";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=security_services&system_records_lookup_subsection=security_services_maintenance_edit&system_records_lookup_item_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action delete-action\">records</a>";

if ($audit_item[security_services_maintenance_status] != "3") {
	# i have added this to be able to edit audits if i need to 
	echo "<a href=\"$base_url_edit&action=edit_audit&security_services_maintenance_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action delete-action\"> edit audit</a> ";
}

echo "							<a href=\"?section=operations&subsection=project_improvements&action=edit&project_improvements_lookup_section=security_services&project_improvements_lookup_subsection=security_services_maintenance_edit&project_improvements_lookup_item_id=$audit_item[security_services_maintenance_id]\" class=\"delete-action\">improve</a>";

echo "								</div>";
echo "							</td>";
echo "							<td>$audit_item[security_services_maintenance_metric]</td>";
echo "							<td><center>$audit_item[security_services_maintenance_criteria]</td>";

				$month_name = lookup_security_services_maintenance_calendar("security_services_maintenance_calendar_id",$audit_item[security_services_maintenance_calendar_id]); 
	
echo "							<td><center>$month_name[security_services_maintenance_calendar_name]-$audit_item[security_services_maintenance_planned_year]</td>";

	

echo "							<td><center>$audit_item[security_services_maintenance_start_maintenance_date]</td>";
echo "							<td><center>$audit_item[security_services_maintenance_end_maintenance_date]</td>";
				$result_name = lookup_security_services_maintenance_result("security_services_maintenance_result_id",$audit_item[security_services_maintenance_result]);	

echo "							<td><center>$result_name[security_services_maintenance_result_name]</td>";
echo "						</tr>";
	}

}

?>
