<?
	include_once("lib/site_lib.php");
	include_once("lib/security_services_status_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/system_users_lib.php");
	include_once("lib/bcm_plans_lib.php");
	include_once("lib/bcm_plans_audit_lib.php");
	include_once("lib/bcm_plans_catalogue_audit_calendar_join_lib.php");
	include_once("lib/security_services_audit_calendar_lib.php");
	include_once("lib/bcm_plans_details_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];

	$bcm_plans_id = $_GET["bcm_plans_id"];
	$bcm_plans_title = $_GET["bcm_plans_title"];
	$bcm_plans_objective = $_GET["bcm_plans_objective"];
	$bcm_plans_status = $_GET["bcm_plans_status"];
	$bcm_plans_lunch_criteria = $_GET["bcm_plans_lunch_criteria"];
	$bcm_plans_sponsor_name = $_GET["bcm_plans_sponsor_name"];
	$bcm_plans_who_declares = $_GET["bcm_plans_who_declares"];
	$bcm_plans_success_criteria = $_GET["bcm_plans_success_criteria"];
	$bcm_plans_metric = $_GET["bcm_plans_metric"];

	$bcm_plans_details_bcm_plan_id = $_GET["bcm_plans_details_bcm_plan_id"];
	$bcm_plans_details_step = $_GET["bcm_plans_details_step"];
	$bcm_plans_details_who = $_GET["bcm_plans_details_who"];
	$bcm_plans_details_what = $_GET["bcm_plans_details_what"];
	$bcm_plans_details_where = $_GET["bcm_plans_details_where"];
	$bcm_plans_details_when = $_GET["bcm_plans_details_when"];
	$bcm_plans_details_how = $_GET["bcm_plans_details_how"];
	$bcm_plans_details_id = $_GET["bcm_plans_details_id"];
		
	$base_url_list = build_base_url($section,"bcm_plans_list");
	$base_url_edit = build_base_url($section,"bcm_plans_edit");
	$base_url_details_list = build_base_url($section,"bcm_plans_details_edit");
	$base_url_details_edit = build_base_url($section,"bcm_plans_details_edit");
	$base_url_audit_report_list = build_base_url($section,"bcm_plans_audit_report");	

	$bcm_plans_audit_calendar = $_GET["bcm_plans_audit_calendar"];

	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "edit" && is_numeric($bcm_plans_id)) {
		$bcm_plans_update = array(
			'bcm_plans_title' => $bcm_plans_title,
			'bcm_plans_objective' => $bcm_plans_objective,
			'bcm_plans_status' => $bcm_plans_status,
			'bcm_plans_lunch_criteria' => $bcm_plans_lunch_criteria,
			'bcm_plans_sponsor_name' => $bcm_plans_sponsor_name,
			'bcm_plans_who_declares' => $bcm_plans_who_declares,
			'bcm_plans_metric' => $bcm_plans_metric,
			'bcm_plans_success_criteria' => $bcm_plans_success_criteria
		);	

		update_bcm_plans($bcm_plans_update,$bcm_plans_id);
		add_system_records("bcm","bcm_plans_edit","$bcm_plans_id",$_SESSION['logged_user_id'],"Update","");

		# delete all audit reviews for this service 
		delete_bcm_plans_catalogue_audit_calendar_join($bcm_plans_id);

		# add all selected PLANNED audits for this service
		if (is_array($bcm_plans_audit_calendar)) {
			$count_bcm_plans_audit_calendar = count($bcm_plans_audit_calendar);
			for($count = 0 ; $count < $count_bcm_plans_audit_calendar; $count++) {
				# now i insert this stuff
				add_bcm_plans_catalogue_audit_calendar_join($bcm_plans_id, $bcm_plans_audit_calendar[$count]);
			}
		}
		
		# now i add the audits if they didnt exist before 
		add_bcm_plans_audit_v2($bcm_plans_id);

		# this is wrong! i need to update the bcm_plans_audit_tbl with the new information!

	} elseif ($action == "edit" && !is_numeric($bcm_plans_id)) {

		$bcm_plans_update = array(
			'bcm_plans_id' => $bcm_plans_id,
			'bcm_plans_title' => $bcm_plans_title,
			'bcm_plans_objective' => $bcm_plans_objective,
			'bcm_plans_status' => $bcm_plans_status,
			'bcm_plans_lunch_criteria' => $bcm_plans_lunch_criteria,
			'bcm_plans_sponsor_name' => $bcm_plans_sponsor_name,
			'bcm_plans_who_declares' => $bcm_plans_who_declares,
			'bcm_plans_success_criteria' => $bcm_plans_success_criteria,
			'bcm_plans_metric' => $bcm_plans_metric
		);	
		
		$bcm_plans_id = add_bcm_plans($bcm_plans_update);
		add_system_records("bcm","bcm_plans_edit",$bcm_plans_id,$_SESSION['logged_user_id'],"Insert","");
		
		# delete all audit reviews for this service 
		delete_bcm_plans_catalogue_audit_calendar_join($bcm_plans_id);

		# add all selected PLANNED audits for this service
		if (is_array($bcm_plans_audit_calendar)) {
			$count_bcm_plans_audit_calendar = count($bcm_plans_audit_calendar);
			for($count = 0 ; $count < $count_bcm_plans_audit_calendar; $count++) {
				# now i insert this stuff
				add_bcm_plans_catalogue_audit_calendar_join($bcm_plans_id, $bcm_plans_audit_calendar[$count]);
			}
		}
		
		# now i add the audits if they didnt exist before 
		add_bcm_plans_audit_v2($bcm_plans_id);
		
	 }

	if ($action == "edit_details" && is_numeric($bcm_plans_details_id)) {

		$bcm_plans_update = array(
			'bcm_plans_details_step' => $bcm_plans_details_step,
			'bcm_plans_details_bcm_plan_id' => $bcm_plans_details_bcm_plan_id,
			'bcm_plans_details_who' => $bcm_plans_details_who,
			'bcm_plans_details_what' => $bcm_plans_details_what,
			'bcm_plans_details_when' => $bcm_plans_details_when,
			'bcm_plans_details_where' => $bcm_plans_details_where,
			'bcm_plans_details_how' => $bcm_plans_details_how
		);	
		
		update_bcm_plans_details($bcm_plans_update,$bcm_plans_details_id);
		add_system_records("bcm","bcm_plans_details_edit","$bcm_plans_details_id",$_SESSION['logged_user_id'],"Update","");

	} elseif ($action == "edit_details" && !is_numeric($bcm_plans_details_id)) { 
		
			
		$bcm_plans_update = array(
			'bcm_plans_details_id' => $bcm_plans_details_id,
			'bcm_plans_details_step' => $bcm_plans_details_step,
			'bcm_plans_details_bcm_plan_id' => $bcm_plans_details_bcm_plan_id,
			'bcm_plans_details_who' => $bcm_plans_details_who,
			'bcm_plans_details_what' => $bcm_plans_details_what,
			'bcm_plans_details_when' => $bcm_plans_details_when,
			'bcm_plans_details_where' => $bcm_plans_details_where,
			'bcm_plans_details_how' => $bcm_plans_details_how
		);
		
		$id = add_bcm_plans_details($bcm_plans_update);
		add_system_records("bcm","bcm_plans_details_edit","$id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable" && is_numeric($bcm_plans_id)) {
		disable_bcm_plans($bcm_plans_id);
		add_system_records("bcm","bcm_plans_edit","$bcm_plans_id",$_SESSION['logged_user_id'],"Disable","");
	}
	
	if ($action == "disable_details" && is_numeric($bcm_plans_details_id)) {
		disable_bcm_plans_details($bcm_plans_details_id);
		add_system_records("bcm","bcm_plans_details_edit","$bcm_plans_details_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_bcm_plans_csv();
		add_system_records("bcm","bcm_plans_edit","$bcm_plans_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>


	<section id="content-wrapper">
		<h3>Continuity Plans Catalogue</h3>
		<span class=description>Manage your continuity plans catalogue.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add a new Plan 
			</a>
			
			<div class="actions-wraper">
				<a href="#" class="actions-btn">
					Actions
					<span class="select-icon"></span>
				</a>
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
echo "					<li><a href=\"downloads/bcm_plans_export.csv\">Dowload</a></li>";
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>

		</div>
			
		
		<ul id="accordion">

<?
	$plan_list = list_bcm_plans(" WHERE bcm_plans_disabled=\"0\"");
	

	foreach($plan_list as $plan_item) {
	
	if ( check_bcm_plans_last_audit_result($plan_item[bcm_plans_id]) ) {
		$warning_audit = "";
	} else {
		$warning_audit = " - (Warning: Audit Issues)";
	}

echo "			<li>";
echo "				<div class=\"header\">";
echo "					$plan_item[bcm_plans_title] $warning_audit";
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$base_url_edit&action=edit&bcm_plans_id=$plan_item[bcm_plans_id]\">edit</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=system&subsection=system_records_list&system_records_lookup_section=bcm&system_records_lookup_subsection=bcm_plans_edit&system_records_lookup_item_id=$plan_item[bcm_plans_id]\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"edit\" href=\"$base_url_list&action=disable&bcm_plans_id=$plan_item[bcm_plans_id]\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"edit\" href=\"$base_url_details_edit&bcm_plans_details_bcm_plan_id=$plan_item[bcm_plans_id]\">add new task on plan</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "				<div class=\"content table\">";
echo "					<table>";
echo "						<tr>";
echo "							<th class=\"center\">Objective</th>";
echo "							<th class=\"center\">Status</th>";
echo "							<th class=\"center\">Lunch Criteria</th>";
echo "							<th class=\"center\">Sponsor</th>";
echo "							<th class=\"center\">Who can Declare</th>";
echo "							<th class=\"center\">Audit Frequency</th>";
echo "							<th class=\"center\">Last Audit Result</th>";
echo "						</tr>";

echo "						<tr>";

	$status_name = lookup_security_services_status("security_services_status_id", $plan_item[bcm_plans_status]);	

echo "							<td><left>".substr($plan_item[bcm_plans_objective],0,100)."...</td>";
echo "							<td><center>$status_name[security_services_status_name]</td>";
echo "							<td><left>".substr($plan_item[bcm_plans_lunch_criteria],0,100)."...</td>";
echo "							<td><center>$plan_item[bcm_plans_sponsor_name]</td>";
echo "							<td><center>$plan_item[bcm_plans_who_declares]</td>";
	
$months_list = list_bcm_plans_catalogue_audit_calendar_join(" WHERE bcm_plans_catalogue_id = \"$plan_item[bcm_plans_id]\"");	
$tmp = array();
foreach($months_list as $months_item) {
	$month_name = lookup_security_services_audit_calendar("security_services_audit_calendar_id",$months_item[bcm_plans_audit_calendar_id]);
	array_push($tmp, $month_name[security_services_audit_calendar_name]);
}
$months_string = implode(",",$tmp);

echo "							<td><center>$months_string</td>";

	if ( check_bcm_plans_last_audit_result($plan_item[bcm_plans_id]) ) {
		$audit_result = "<a href=\"$base_url_audit_report_list&bcm_plans_id=$plan_item[bcm_plans_id]\">Ok</a>";
	} else {
		$audit_result = "<a href=\"$base_url_audit_report_list&bcm_plans_id=$plan_item[bcm_plans_id]\">Not Ok</a>";
	}
	echo "<td class=\"center\">$audit_result</td>";



echo "						</tr>";
	#}
echo "					</table>";
echo "<br>";

echo "<div class=\"rounded\">";
echo "<table class=\"sub-table\">";
echo "<tr>";
echo "<th class=\"center\">Plan Audit Metric</th>";
echo "<th class=\"center\">Success Criteria</th>";
echo "</tr>";
echo "<tr>";
echo "<td class=\"left\">".substr($plan_item[bcm_plans_metric],0,200)."...</td>";
echo "<td class=\"left\">".substr($plan_item[bcm_plans_success_criteria],0,200)."...</td>";
echo "</tr>";
echo "</table>";
echo "</div>";

echo "<br>";


echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo " 					<th align=\"center\">Step</th>";
echo " 					<th>When</th>";
echo " 					<th>Who</th>";
echo " 					<th>Doess What</th>";
echo " 					<th>Where</th>";
echo " 					<th>How</th>";
echo "							</tr>";

	$bcm_plans_details = list_bcm_plans_details(" WHERE bcm_plans_details_bcm_plan_id = \"$plan_item[bcm_plans_id]\" AND bcm_plans_details_disabled = \"0\"  ORDER by bcm_plans_details_step ASC");

	foreach($bcm_plans_details as $bcm_plans_item) {

echo "	<tr>";
echo " 	<td class='action-cell'>$bcm_plans_item[bcm_plans_details_step]</a>";
echo "		<div class='cell-actions'>";
echo "			<a href=\"$base_url_details_edit&bcm_plans_details_id=$bcm_plans_item[bcm_plans_details_id]\" class='edit-action'>Edit</a>";
echo "			<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=bcm&system_records_lookup_subsection=bcm_plans_details_edit&system_records_lookup_item_id=$bcm_plans_item[bcm_plans_details_id]\" class='edit-action delete-action'>Records</a>";
echo "			<a href=\"$base_url_list&action=disable_details&bcm_plans_details_id=$bcm_plans_item[bcm_plans_details_id]\" class='delete-action'>Disable</a>";
echo "		</div>";
echo "  </td>";
echo " 	<td>$bcm_plans_item[bcm_plans_details_when]</td>";
echo " 	<td>$bcm_plans_item[bcm_plans_details_who]</td>";
echo " 	<td>$bcm_plans_item[bcm_plans_details_what]</td>";
echo " 	<td>$bcm_plans_item[bcm_plans_details_where]</td>";
echo " 	<td>$bcm_plans_item[bcm_plans_details_how]</td>";
echo "	</tr>";
	}
echo "	</tr>";
	
echo "						</table>";
echo "					</div>";
echo "<br>";
### INJERTO ENDS
echo "				</div>";
echo "			</li>";
	}
?>
		</ul>
		
		<br class="clear"/>
		
	</section>
