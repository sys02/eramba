<?
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/bcm_plans_lib.php");
	include_once("lib/bcm_plans_audit_lib.php");
	include_once("lib/security_services_audit_audit_result_lib.php");
	include_once("lib/security_services_audit_calendar_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"bcm_plans_list");
	$this_url = build_base_url($section,"bcm_plans_audit_report");
	$base_url_edit = build_base_url($section,"bcm_plans_audit_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$bcm_plans_id = $_GET["bcm_plans_id"];

	# local variables - YOU MUST ADJUST THIS! 
	$bcm_plans_audit_id = $_GET["bcm_plans_audit_id"];
	$bcm_plans_audit_status = $_GET["bcm_plans_audit_status"];
	$bcm_plans_audit_metric = $_GET["bcm_plans_audit_metric"];
	$bcm_plans_audit_criteria = $_GET["bcm_plans_audit_criteria"];
	$bcm_plans_audit_auditor = $_GET["bcm_plans_audit_auditor"];
	$bcm_plans_audit_start_audit_date = $_GET["bcm_plans_audit_start_audit_date"];
	$bcm_plans_audit_end_audit_date = $_GET["bcm_plans_audit_end_audit_date"];
	$bcm_plans_audit_result = $_GET["bcm_plans_audit_result"];
	$bcm_plans_audit_result_description = $_GET["bcm_plans_audit_result_description"];
	$bcm_plans_audit_disabled = $_GET["bcm_plans_audit_disabled"];

	if ($action == "update" && is_numeric($bcm_plans_audit_id) ) {

	# echo "ready to change status to: $bcm_plans_audit_status";
	$bcm_plans_audit_update = array(
		'bcm_plans_audit_status' => $bcm_plans_audit_status,
		'bcm_plans_audit_metric' => $bcm_plans_audit_metric,
		'bcm_plans_audit_criteria' => $bcm_plans_audit_criteria,
		'bcm_plans_audit_start_audit_date' => $bcm_plans_audit_start_audit_date,
		'bcm_plans_audit_end_audit_date' => $bcm_plans_audit_end_audit_date,
		'bcm_plans_audit_auditor' => $bcm_plans_audit_auditor,
		'bcm_plans_audit_result' => $bcm_plans_audit_result,
		'bcm_plans_audit_result_description' => $bcm_plans_audit_result_description
	);	

	update_bcm_plans_audit($bcm_plans_audit_update,$bcm_plans_audit_id);
	add_system_records("bcm_plans","bcm_plans_audit_edit","$bcm_plans_audit_id",$_SESSION['logged_user_id'],"Update","");

	}

	if ($action == "disable" && is_numeric($bcm_plans_audit_id) ) {
		disable_bcm_plans_audit($bcm_plans_audit_id);
		add_system_records("bcm_plans","bcm_plans_audit","$bcm_plans_audit_id",$_SESSION['logged_user_id'],"Disable","");
	}
	
	if ($action == "csv") {
		export_bcm_plans_audit_csv();
		add_system_records("bcm_plans","bcm_plans_audit","$bcm_plans_audit_id",$_SESSION['logged_user_id'],"Export","");
	}

?>

	<section id="content-wrapper">
		<h3>Security Services Audit Report</h3>
		<span class=description>This is a report of all the audits registed for this service</span>
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
echo "					<li><a href=\"downloads/bcm_plans_audit_export.csv\">Dowload</a></li>";
} else { 
echo "					<li><a href=\"$this_url&action=csv&bcm_plans_id=$bcm_plans_id\">Export All</a></li>";
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

	if ($bcm_plans_id) {
		$audit_list = list_bcm_plans_audit(" WHERE bcm_plans_audit_bcm_plans_id = \"$bcm_plans_id\" and bcm_plans_audit_disabled =\"0\""); 
	} else {
		echo "No audits found for this service";
		exit;
	}

	foreach($audit_list as $audit_item) {

	$service_details = lookup_bcm_plans("bcm_plans_id", $bcm_plans_id);
	$result = lookup_security_services_audit_result("security_services_audit_result_id",$audit_item[bcm_plans_audit_result]);
	$month_name = lookup_security_services_audit_calendar("security_services_audit_calendar_id",$audit_item[bcm_plans_audit_calendar_id]); 

echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">

					$service_details[bcm_plans_title]
<div class=\"cell-actions\">

<a href=\"$base_url_edit&bcm_plans_audit_id=$audit_item[bcm_plans_audit_id]\" class=\"edit-action\">audit!</a> 

<a href=\"$this_url&action=disable&bcm_plans_audit_id=$audit_item[bcm_plans_audit_id]&bcm_plans_id=$audit_item[bcm_plans_audit_bcm_plans_id]\" class=\"edit-action delete-action\">delete</a>

<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=bcm&system_records_lookup_subsection=bcm_plans_audit_edit&system_records_lookup_item_id=$audit_item[bcm_plans_audit_id]\" class=\"edit-action delete-action\">records</a>

<a href=\"?section=operations&subsection=project_improvements_edit&action=edit&project_improvements_lookup_section=bcm&project_improvements_lookup_subsection=bcm_plans_audit_edit&project_improvements_lookup_item_id=$audit_item[bcm_plans_audit_id]\" class=\"delete-action\">improve</a>

<div>

</td>";

echo "					<td>$month_name[security_services_audit_calendar_name] - $audit_item[bcm_plans_audit_planned_year]</td>";
echo "					<td>$audit_item[bcm_plans_audit_start_audit_date]</td>";
echo "					<td>$audit_item[bcm_plans_audit_end_audit_date]</td>";
echo "					<td>$result[security_services_audit_result_name]</td>";
echo "					<td>$audit_item[bcm_plans_audit_result_description]</td>";
echo "					<td>$audit_item[bcm_plans_audit_auditor]</td>";
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
