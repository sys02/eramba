<?
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/security_services_maintenance_lib.php");
	include_once("lib/security_services_audit_audit_result_lib.php");
	include_once("lib/security_services_audit_calendar_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"security_catalogue_list");
	$this_url = build_base_url($section,"security_services_maintenance_list");
	$base_url_edit = build_base_url($section,"security_services_maintenance_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$service_id = $_GET["service_id"];

	# local variables - YOU MUST ADJUST THIS! 
	$security_services_maintenance_id = $_GET["security_services_maintenance_id"];
	$security_services_maintenance_status = $_GET["security_services_maintenance_status"];
	$security_services_maintenance_task = $_GET["security_services_maintenance_task"];
	$security_services_maintenance_engineer = $_GET["security_services_maintenance_engineer"];
	$security_services_maintenance_start_maintenance_date = $_GET["security_services_maintenance_start_maintenance_date"];
	$security_services_maintenance_end_maintenance_date = $_GET["security_services_maintenance_end_maintenance_date"];
	$security_services_maintenance_result = $_GET["security_services_maintenance_result"];
	$security_services_maintenance_result_description = $_GET["security_services_maintenance_result_description"];
	$security_services_maintenance_disabled = $_GET["security_services_maintenance_disabled"];

	if ($action == "update" && is_numeric($security_services_maintenance_id) ) {

	# echo "ready to change status to: $security_services_maintenance_status";
	$security_services_maintenance_update = array(
		'security_services_maintenance_status' => $security_services_maintenance_status,
		'security_services_maintenance_task' => $security_services_maintenance_task,
		'security_services_maintenance_start_maintenance_date' => $security_services_maintenance_start_maintenance_date,
		'security_services_maintenance_end_maintenance_date' => $security_services_maintenance_end_maintenance_date,
		'security_services_maintenance_engineer' => $security_services_maintenance_engineer,
		'security_services_maintenance_result' => $security_services_maintenance_result,
		'security_services_maintenance_result_description' => $security_services_maintenance_result_description
	);	

	update_security_services_maintenance($security_services_maintenance_update,$security_services_maintenance_id);
	add_system_records("security_services","security_services_maintenance_edit","$security_services_maintenance_id",$_SESSION['logged_user_id'],"Update","");

	}

	if ($action == "disable" && is_numeric($security_services_maintenance_id) ) {
		disable_security_services_maintenance($security_services_maintenance_id);
		add_system_records("security_services","security_services_maintenance_edit","$security_services_maintenance_id",$_SESSION['logged_user_id'],"Disable","");
	}
	
	if ($action == "csv") {
		export_security_services_maintenance_csv();
		add_system_records("security_services","security_services_maintenance_edit","$security_services_maintenance_id",$_SESSION['logged_user_id'],"Export","");
	}

?>

	<section id="content-wrapper">
		<h3>Security Services Maintenance Report</h3>
		<span class=description>This is a report of all maintenance records for this service</span>
		<br>
		<br>
	<div class="controls-wrapper">
		
			<div class="actions-wraper">
				<a href="#" class="actions-btn">
					Actions
					<span class="select-icon"></span>
				</a>
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
	echo '<li><a href="' . $base_url_list . '&download_export=security_services_maintenance_export">Download</a></li>';
} else { 
echo "					<li><a href=\"$this_url&action=csv&service_id=$service_id\">Export All</a></li>";
}
?>
				</ul>
			</div>
			</div>
<br>
<br>
		
		<table class="main-table">
			<thead>
				<tr>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th><a class=\"asc\">Control Name</a></th>";
?>
<?
echo "	<th>Planned Start</th>";
echo "	<th>Actual Start</th>";
echo "	<th>Actual End</th>";
echo "	<th>Result</th>";
echo "	<th>Conclusion</th>";
echo "	<th>Owner</th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------

	if ($service_id) {
		$audit_list = list_security_services_maintenance(" WHERE security_services_maintenance_security_service_id = \"$service_id\" and security_services_maintenance_disabled =\"0\""); 
	} else {
		echo "No maintenance records found for this service";
		exit;
	}

	foreach($audit_list as $audit_item) {

	$service_details = lookup_security_services("security_services_id", $service_id);
	$result = lookup_security_services_audit_result("security_services_audit_result_id",$audit_item[security_services_maintenance_result]);
	$month_name = lookup_security_services_audit_calendar("security_services_audit_calendar_id",$audit_item[security_services_maintenance_calendar_id]); 

echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">

					$service_details[security_services_name]
<div class=\"cell-actions\">

<a href=\"$base_url_edit&security_services_maintenance_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action\">audit!</a> 

<a href=\"$this_url&action=disable&security_services_maintenance_id=$audit_item[security_services_maintenance_id]&service_id=$audit_item[security_services_maintenance_security_service_id]\" class=\"edit-action delete-action\">delete</a>

<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=security_services&system_records_lookup_subsection=security_services_maintenance_edit&system_records_lookup_item_id=$audit_item[security_services_maintenance_id]\" class=\"edit-action delete-action\">records</a>

<a href=\"?section=operations&subsection=project_improvements_edit&action=edit&project_improvements_lookup_section=security_services&project_improvements_lookup_subsection=security_services_maintenance_edit&project_improvements_lookup_item_id=$audit_item[security_services_maintenance_id]\" class=\"delete-action\">improve</a>

<div>

</td>";

echo "					<td>$month_name[security_services_audit_calendar_name] - $audit_item[security_services_maintenance_planned_year]</td>";
echo "					<td>$audit_item[security_services_maintenance_start_maintenance_date]</td>";
echo "					<td>$audit_item[security_services_maintenance_end_maintenance_date]</td>";
echo "					<td>$result[security_services_audit_result_name]</td>";
echo "					<td>$audit_item[security_services_maintenance_result_description]</td>";
echo "					<td>$audit_item[security_services_maintenance_engineer]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
<?
echo "			<a href=\"$base_url_list\" class=\"cancel-btn\">";
?>
			Back	
				<span class="select-icon"></span>
			</a>
		
		<br class="clear"/>
		
	</section>
