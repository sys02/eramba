<?
	include_once("lib/configuration.inc");
	include_once("lib/bu_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/security_incident_service_lib.php");
	include_once("lib/compliance_item_security_service_join_lib.php");
	include_once("lib/compliance_package_item_lib.php");
	include_once("lib/compliance_package_lib.php");
	include_once("lib/risk_security_services_join_lib.php");
	include_once("lib/data_asset_security_services_join_lib.php");
	include_once("lib/asset_classification_lib.php");
	include_once("lib/asset_type_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/tp_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/service_contracts_lib.php");
	include_once("lib/security_services_status_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/security_services_audit_calendar_lib.php");
	include_once("lib/security_services_catalogue_audit_calendar_join_lib.php");
	include_once("lib/service_contracts_security_service_join_lib.php");
	include_once("lib/security_services_catalogue_maintenance_calendar_join_lib.php");
	include_once("lib/security_services_maintenance_lib.php");
	include_once("lib/security_services_classification_lib.php");

	global $services_conf;

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_security_incident = build_base_url("operations","security_incident_edit");
	$base_url_list = build_base_url($section,"security_catalogue_list");
	$base_url_compliance = build_base_url("compliance","compliance_package_item_edit");
	$base_url_risk = build_base_url("risk","risk_management_edit");
	$base_url_risk_tp = build_base_url("risk","risk_tp_edit");
	$base_url_audit_report_list = build_base_url($section,"security_services_audit_report");
	$base_url_edit = build_base_url($section,"security_catalogue_edit");
	$base_url_maintenance_report_list = build_base_url($section,"security_services_maintenance_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$security_services_id = $_GET["security_services_id"];
	$security_services_name = $_GET["security_services_name"];
	$security_services_regular_maintenance = $_GET["security_services_regular_maintenance"];
	$security_services_maintenance_calendar= $_GET["security_services_maintenance_calendar"];
	$security_services_objective = $_GET["security_services_objective"];
	$security_services_documentation_url = $_GET["security_services_documentation_url"];
	$security_services_status = $_GET["security_services_status"];
	$security_services_classification_id = $_GET["security_services_classification_id"];

	if (!is_numeric($security_services_status)) {
		$security_services_status="1";
	}

	$security_services_audit_metric = $_GET["security_services_audit_metric"];
	$security_services_audit_success_criteria = $_GET["security_services_audit_success_criteria"];
	$security_services_audit_calendar = $_GET["security_services_audit_calendar"];
	$service_contracts_id = $_GET["service_contracts_id"];
		

	$security_services_cost_capex = $_GET["security_services_cost_capex"];
	$security_services_cost_opex = $_GET["security_services_cost_opex"];
	$security_services_cost_operational_resource = $_GET["security_services_cost_operational_resource"];
	$security_services_disabled = $_GET["security_services_disabled"];
	
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" && is_numeric($security_services_id)) {
		$security_services_update = array(
			'security_services_name' => $security_services_name,
			'security_services_objective' => $security_services_objective,
			'security_services_documentation_url' => $security_services_documentation_url,
			'security_services_status' => $security_services_status,
			'security_services_classification_id' => $security_services_classification_id,
			'security_services_audit_metric' => $security_services_audit_metric,
			'security_services_audit_success_criteria' => $security_services_audit_success_criteria,
			'security_services_regular_maintenance' => $security_services_regular_maintenance,
			'security_services_cost_opex' => $security_services_cost_opex,
			'security_services_cost_capex' => $security_services_cost_capex,
			'security_services_cost_operational_resource' => $security_services_cost_operational_resource,
			'security_services_cost_disabled' => $security_services_cost_disabled
		);	
		update_security_services($security_services_update,$security_services_id);
		add_system_records("security_services","security_catalogue_edit","$security_services_id",$_SESSION['logged_user_id'],"Update","");
	
		# delete all audit reviews for this service 
		delete_security_services_catalogue_audit_calendar_join($security_services_id);

		# add all selected PLANNED audits for this service
		if (is_array($security_services_audit_calendar)) {
			$count_security_services_audit_calendar = count($security_services_audit_calendar);
			for($count = 0 ; $count < $count_security_services_audit_calendar; $count++) {
				# now i insert this stuff
				add_security_services_catalogue_audit_calendar_join($security_services_id, $security_services_audit_calendar[$count]);
			}
		}

		# now i add the audits if they didnt exist before 
		add_security_services_audit_v2($security_services_id);

		# now i do something similar to what i did up for the maintenance
		delete_security_services_catalogue_maintenance_calendar_join($security_services_id);

		#add all selected PLANNED maintenance for this service
		if (is_array($security_services_maintenance_calendar)) {
			#$count_security_services_maintenance_calendar = count($security_services_maintenance_calendar);
			#for($count = 0 ; $count < $count_security_services_maintenance_calendar ; $count++) {
			foreach($security_services_maintenance_calendar as $security_services_maintenance_calendar_item) {
				# now i insert this stuff
				add_security_services_catalogue_maintenance_calendar_join($security_services_id, $security_services_maintenance_calendar_item);
			}
		}
		
		# now i add the audits if they didnt exist before 
		add_security_services_maintenance_v2($security_services_id);
		
		# delete all the service contracts
		delete_service_contracts_security_services($security_services_id);	

		# add all service contracts
		if ($service_contracts_id) {
			foreach($service_contracts_id as $service_contracts_item) {
				add_service_contracts_security_services($service_contracts_item, $security_services_id);
			}
		}

	} elseif ($action == "update") {
		$security_services_update = array(
			'security_services_name' => $security_services_name,
			'security_services_objective' => $security_services_objective,
			'security_services_documentation_url' => $security_services_documentation_url,
			'security_services_status' => $security_services_status,
			'security_services_classification_id' => $security_services_classification_id,
			'security_services_audit_metric' => $security_services_audit_metric,
			'security_services_audit_success_criteria' => $security_services_audit_success_criteria,
			'security_services_regular_maintenance' => $security_services_regular_maintenance,
			'security_services_cost_opex' => $security_services_cost_opex,
			'security_services_cost_capex' => $security_services_cost_capex,
			'security_services_cost_operational_resource' => $security_services_cost_operational_resource,
			'security_services_cost_disabled' => $security_services_cost_disabled
		);	
		$security_services_id = add_security_services($security_services_update);
		# when inserting security catalogues i need to look at the asociated reviews (audit)
		# add_security_services_audit_v2($security_service_id);	

		add_system_records("security_services","security_catalogue_edit","$security_services_id",$_SESSION['logged_user_id'],"Insert","");
		
		# delete all audit reviews for this service 
		delete_security_services_catalogue_audit_calendar_join($security_services_id);

		# add all selected PLANNED audits for this service
		if (is_array($security_services_audit_calendar)) {
			$count_security_services_audit_calendar = count($security_services_audit_calendar);
			for($count = 0 ; $count < $count_security_services_audit_calendar; $count++) {
				# now i insert this stuff
				add_security_services_catalogue_audit_calendar_join($security_services_id, $security_services_audit_calendar[$count]);
			}
		}
	
		# now i add the audits if they didnt exist before 
		add_security_services_audit_v2($security_services_id);
		
		# now i do something similar to what i did up for the maintenance
		delete_security_services_catalogue_maintenance_calendar_join($security_services_id);

		#add all selected PLANNED maintenance for this service
		if (is_array($security_services_maintenance_calendar)) {
			#$count_security_services_maintenance_calendar = count($security_services_maintenance_calendar);
			#for($count = 0 ; $count < $count_security_services_maintenance_calendar ; $count++) {
			foreach($security_services_maintenance_calendar as $security_services_maintenance_calendar_item) {
				# now i insert this stuff
				add_security_services_catalogue_maintenance_calendar_join($security_services_id, $security_services_maintenance_calendar_item);
			}
		}
		
		# now i add the audits if they didnt exist before 
		add_security_services_maintenance_v2($security_services_id);
		
		# add all service contracts
		if ($service_contracts_id) {
			foreach($service_contracts_id as $service_contracts_item) {
				add_service_contracts_security_services($service_contracts_item, $security_services_id);
			}
		}
	 }

	if ($action == "disable" && is_numeric($security_services_id)) {
		disable_security_services($security_services_id);

		# i need to disable this in the risk stuff
		delete_risk_security_services_join_service_delete($security_services_id);

		# i need to delete from the asset data flows stuff
		delete_data_asset_security_services_join_delete_service($security_services_id);

		# i need to delete this from the compliance part
		delete_compliance_item_security_services_join_service_id($security_services_id);	

		# i need to delete this from the audit reviews
		delete_security_services_catalogue_audit_calendar_join($security_services_id);

		# i need to delete this form all the security incidents
		delete_security_incident_service_join_service_id($security_services_id);

		# i need to delete this fmor all contracts
		delete_service_contracts_security_services($security_services_id);	

		add_system_records("security_services","security_catalogue_edit","$security_services_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_security_services_csv();
		add_system_records("security_services","security_catalogue_edit","$security_services_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>


	<section id="content-wrapper">
		<h3>Security Services Catalogue</h3>
		<span class=description>If Security Controls are one of the main deliverables of a Security Organization, it's highgly recommended to keep them well identified.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Service 
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
	echo '<li><a href="' . $base_url_list . '&download_export=security_services_export">Download</a></li>';
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>

		</div>
			
		
		<ul id="accordion">
			
<?
	if ($show_id) {
		$security_services_list = list_security_services(" WHERE security_services_disabled = 0 AND security_services_id = $show_id");
	} else {
		if ($sort) {
			$security_services_list = list_security_services(" WHERE security_services_disabled=\"0\" AND security_services_id =\"$sort\"");
		} else {
			$security_services_list = list_security_services(" WHERE security_services_disabled=\"0\"");
		}
	}

	foreach($security_services_list as $security_services_item) {
	
	# i use this to check if the control has audit failures and put it as a warning
	if ( check_service_last_audit_result($security_services_item[security_services_id]) ) {
		$warning_audit = "";
	} else {
		$warning_audit = " - (Warning: Audit Issues)";
	}

	# i need to check if the service is actually being used or not
	if ( service_in_use($security_services_item[security_services_id]) ) {
		$warning_not_in_use= " - (Warning: Control not in use!)";
	} else {
		$warning_not_in_use= "";
	} 

	$status_name = lookup_security_services_status("security_services_status_id", $security_services_item[security_services_status]);	
	$classification_name = lookup_security_services_classification("security_services_classification_id", $security_services_item[security_services_classification_id]);	

echo "			<li>";
echo "				<div class=\"header\">";
echo "					Service Name: $security_services_item[security_services_name] $warning_audit $warning_not_in_use";
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$base_url_edit&action=edit&security_services_id=$security_services_item[security_services_id]\">edit</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"$base_url_list&action=disable&security_services_id=$security_services_item[security_services_id]\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=system&subsection=system_records_list&system_records_lookup_section=security_services&system_records_lookup_subsection=security_catalogue_edit&system_records_lookup_item_id=$security_services_item[security_services_id]\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?action=edit&section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=security_services&ciso_pmo_lookup_subsection=security_catalogue_edit&ciso_pmo_lookup_item_id=$security_services_item[security_services_id]\">improve</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "				<div class=\"content table\">";
echo "					<table>";
echo "						<tr>";
echo "							<th>Objective</th>";
echo "							<th>Documentation</th>";
echo "							<th><center>Status</center></th>";
echo "							<th><center>Classification</center></th>";
echo "						</tr>";

echo "						<tr>";
echo "							<td class=\"action-cell\">";
echo "								<div class=\"cell-label\">";
echo "								 	$security_services_item[security_services_objective]";
echo "								</div>";
echo "							</td>";
echo "							<td class=\"center\">$security_services_item[security_services_documentation_url]</td>";
echo "							<td class=\"center\">$status_name[security_services_status_name]</td>";
echo "							<td class=\"center\">$classification_name[security_services_classification_name]</td>";
echo "						</tr>";
	#}

echo "					</table>";
echo "<br>";
echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo "								<th><center>Last Records</th>";
echo "								<th><center>What</th>";
echo "								<th><center>By Whom</th>";
echo "								<th><center>Notes</th>";
echo "							</tr>";
	
$system_records_list = list_system_records(" WHERE system_records_section = \"security_services\" AND system_records_subsection = \"security_catalogue_edit\" AND system_records_item_id =\"$security_services_item[security_services_id]\" ORDER by system_records_date LIMIT 5");

if ( count($system_records_list) ) {

foreach($system_records_list as $system_records_item) {
echo "							<tr>";
echo "								<td class=\"center\">$system_records_item[system_records_date]</td>";
echo "								<td class=\"center\">$system_records_item[system_records_action]</td>";
		$username = lookup_system_users("system_users_id",$system_records_item['system_records_author']);
		if (empty($username['system_users_login'])) {
			$username['system_users_login'] = "System";
		}
echo "								<td class=\"center\">$username[system_users_login]</td>";
echo "								<td class=\"center\">$system_records_item[system_records_notes]</td>";
echo "							</tr>";
}

echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";
echo "<br>";

} else {

echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";
echo "<br>";

}
echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo "								<th><center>Audit Metric</th>";
echo "								<th><center>Metric Criteria</th>";
echo "								<th><center>Audit Periodicity</th>";
echo "								<th><center>Last Audit Result</th>";
echo "							</tr>";
echo "							<tr>";
echo "								<td class=\"left\">$security_services_item[security_services_audit_metric]</td>";
echo "								<td class=\"left\">$security_services_item[security_services_audit_success_criteria]</td>";

	$months_list = list_security_services_catalogue_audit_calendar_join(" WHERE security_service_catalogue_id = \"$security_services_item[security_services_id]\"");	

echo "								<td class=\"center\">";
	foreach($months_list as $months) {
		$month_name = lookup_security_services_audit_calendar("security_services_audit_calendar_id",$months[security_services_audit_calendar_id]); 
		echo "$month_name[security_services_audit_calendar_name] "; 
	}

echo "</td>";
	#if ( check_service_last_maintenance_result($security_services_item[security_services_id]) ) {
	if ( check_service_last_audit_result($security_services_item[security_services_id]) ) {
		$audit_result = "<a href=\"$base_url_audit_report_list&service_id=$security_services_item[security_services_id]\">Ok</a>";
	} else {
		$audit_result = "<a href=\"$base_url_audit_report_list&service_id=$security_services_item[security_services_id]\">Not Ok</a>";
	}
	echo "<td class=\"center\">$audit_result</td>";
echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";



echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo "								<th><center>Maintenance</th>";
echo "								<th><center>Periodicity</th>";
echo "								<th><center>Last Result</th>";
echo "							</tr>";

# display this section if i have maintenance items ... otherwise not!
$maintenance_months_list = list_security_services_catalogue_maintenance_calendar_join(" WHERE security_service_catalogue_id = \"$security_services_item[security_services_id]\"");	
if ( count($maintenance_months_list) ) { 

echo "							<tr>";
echo "								<td class=\"center\">";

		echo "".substr($security_services_item[security_services_regular_maintenance],0,100)."...";

echo "</td>";

echo "								<td class=\"center\">";


foreach($maintenance_months_list as $maintenance_months_item) {
	$month_name = lookup_security_services_audit_calendar("security_services_audit_calendar_id",$maintenance_months_item[security_services_maintenance_calendar_id]); 
	echo "$month_name[security_services_audit_calendar_name] "; 
}

echo "</td>";

		if ( check_service_last_maintenance_result($security_services_item[security_services_id]) ) {
			$audit_result = "<a href=\"$base_url_maintenance_report_list&service_id=$security_services_item[security_services_id]\">Ok</a>";
		} else {
			$audit_result = "<a href=\"$base_url_maintenance_report_list&service_id=$security_services_item[security_services_id]\">Not Ok</a>";
		}

	echo "<td class=\"center\">$audit_result</td>";

echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";
echo "<br>";

} else {

echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";
echo "<br>";

}

echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo "								<th><center>OPEX Cost</th>";
echo "								<th><center>CAPEX Cost</th>";
echo "								<th><center>Resource Utilization</th>";
echo "							</tr>";
echo "							<tr>";
echo "								<td class=\"center\">$security_services_item[security_services_cost_opex] $services_conf[system_currency]</td>";
echo "								<td class=\"center\">$security_services_item[security_services_cost_capex] $services_conf[system_currency]</td>";
echo "								<td class=\"center\">$security_services_item[security_services_cost_operational_resource]</td>";
echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";

echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo "								<th><center>Provider</th>";
echo "								<th><center>Contract Name</th>";
echo "								<th><center>Value</th>";
echo "								<th><center>Start</th>";
echo "								<th><center>End</th>";
echo "							</tr>";

$service_contracts_security_services_join_list = list_service_contracts_security_services(" WHERE security_services_id =\"$security_services_item[security_services_id]\"");
foreach ($service_contracts_security_services_join_list as $service_contracts_security_services_join_item) {

$service_contracts_item = lookup_service_contracts("service_contracts_id","$service_contracts_security_services_join_item[service_contracts_id]");
$service_provider_name = lookup_tp("tp_id", $service_contracts_item[service_contracts_provider_id]); 

echo "							<tr>";
echo "								<td class=\"center\">$service_provider_name[tp_name]</td>";
echo "								<td class=\"center\">$service_contracts_item[service_contracts_name]</td>";
echo "								<td class=\"center\">$service_contracts_item[service_contracts_value]</td>";
echo "								<td class=\"center\">$service_contracts_item[service_contracts_start]</td>";
echo "								<td class=\"center\">$service_contracts_item[service_contracts_end]</td>";
echo "							</tr>";

}

echo "						</table>";
echo "					</div>";
echo "<br>";

echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo "								<th><center>Mitigation Type</th>";
echo "								<th><center>Description</th>";
echo "							</tr>";

	#- Asset Risk (risk_title)
	$risk_asset = list_risk_asset_join("");	
	$tmp_array = array();
	foreach ($risk_asset as $risk_asset_item) { 
		array_push($tmp_array, $risk_asset_item[risk_asset_join_risk_id]);
	} 

	$risk_asset_service  = list_risk_security_services_join("");	
	foreach($risk_asset_service as $risk_asset_service_list) {
	if ( $security_services_item[security_services_id] == $risk_asset_service_list[risk_security_services_join_security_services_id] ) { 
	if ( array_search($risk_asset_service_list[risk_security_services_join_risk_id], $tmp_array) ) {

			$risk_info = lookup_risk("risk_id",$risk_asset_service_list[risk_security_services_join_risk_id]);
echo "			<tr>";
echo "			<td class=\"center\">Asset based Risk</td>";
echo "			<td class=\"center\"><a href=\"$base_url_risk&risk_id=$risk_asset_service_list[risk_security_services_join_risk_id]\">$risk_info[risk_title]</a></td>";
echo "			</tr>";
	}
	}
	}

	#- Incidents
	$security_incident = list_security_incident(" WHERE security_incident_disabled = \"0\"");	
	$tmp_array = array();

	foreach ($security_incident as $security_incident_item) { 
		array_push($tmp_array, $security_incident_item[security_incident_id]);
	} 

	$security_incident_service  = list_security_incident_service_join("");	
	foreach($security_incident_service as $security_incident_service_list) {
	if ( $security_services_item[security_services_id] == $security_incident_service_list[security_incident_service_service_id] ) { 
	if ( array_search($security_incident_service_list[security_incident_service_incident_id], $tmp_array) ) {

			$security_incident_info = lookup_security_incident("security_incident_id",$security_incident_service_list[security_incident_service_incident_id]);
echo "			<tr>";
echo "			<td class=\"center\">Security Incident</td>";
echo "			<td class=\"center\"><a href=\"$base_url_security_incident&security_incident_id=$security_incident_service_list[security_incident_service_incident_id]\">$security_incident_info[security_incident_title]</a></td>";
echo "			</tr>";
	}
	}
	}
	
	
	#- Third Party Risk (risk_title)
	$risk_tp = list_risk_tp_join("");
	$tmp_array = array();
	foreach ($risk_tp as $risk_tp_item) { 
		array_push($tmp_array, $risk_tp_item[risk_tp_join_risk_id]);
	} 

	$risk_tp_service  = list_risk_security_services_join("");	
	foreach($risk_tp_service as $risk_tp_service_list) {
	if ( $security_services_item[security_services_id] == $risk_tp_service_list[risk_security_services_join_security_services_id] ) { 
	if ( array_search($risk_tp_service_list[risk_security_services_join_risk_id], $tmp_array) ) {

			$risk_info = lookup_risk("risk_id",$risk_tp_service_list[risk_security_services_join_risk_id]);
echo "			<tr>";
echo "			<td class=\"center\">Third Party based Risk</td>";
echo "			<td class=\"center\"><a href=\"$base_url_risk_tp&risk_id=$risk_asset_service_list[risk_security_services_join_risk_id]\">$risk_info[risk_title]</a></td>";
echo "			</tr>";
	}
	}
	}

	#- Data Flows (Asset Name)
	$data_asset = list_data_asset(" WHERE data_asset_disabled = \"0\"");
	$tmp_array = array();
	foreach ($data_asset as $data_asset_item) { 
		array_push($tmp_array, $data_asset_item[data_asset_id]);
	} 

	$data_asset_service  = list_data_asset_security_services_join("");	
	foreach($data_asset_service as $data_asset_service_list) {
	if ( $security_services_item[security_services_id] == $data_asset_service_list[data_asset_security_services_join_security_services_id] ) { 

	if ( array_search($data_asset_service_list[data_asset_security_services_join_data_asset_id], $tmp_array) ) {

			$data_info = lookup_data_asset("data_asset_id",$data_asset_service_list[data_asset_security_services_join_data_asset_id]);
			$asset_info = lookup_asset("asset_id",$data_info[data_asset_asset_id]);
echo "			<tr>";
echo "			<td class=\"center\">Data Flow Analysis</td>";
echo "			<td class=\"center\"><a href=\"$base_url_data_asset&risk_id=$risk_asset_service_list[risk_security_services_join_risk_id]\">$asset_info[asset_name]</a></td>";
echo "			</tr>";
	}
	}
	}
	


	#- Compliance (Compliance title)
	$compliance = list_compliance_package_item(" WHERE compliance_package_item_disabled = \"0\"");	
	$tmp_array = array();
	foreach ($compliance as $compliance_item) { 
		array_push($tmp_array, $compliance_item[compliance_package_item_id]);
	} 

	$compliance_service  = list_compliance_item_security_services_join("");

	foreach($compliance_service as $compliance_service_list) {

	if ( $security_services_item[security_services_id] == $compliance_service_list[compliance_security_services_join_security_services_id] ) { 

	if ( array_search($compliance_service_list[compliance_security_services_join_compliance_id], $tmp_array) ) {

			$compliance_package_item_info = lookup_compliance_package_item("compliance_package_item_id",$compliance_service_list[compliance_security_services_join_compliance_id]);
			$compliance_package_info = lookup_compliance_package("compliance_package_id",$compliance_package_item_info[compliance_package_id]);

			$tp_info = lookup_tp("tp_id",$compliance_package_info[compliance_package_tp_id]);	

echo "			<tr>";
echo "			<td class=\"center\">Compliance</td>";
echo "			<td class=\"center\"><a href=\"$base_url_compliance&compliance_package_id=$compliance_package_item_info[compliance_package_id]&compliance_package_item_id=$compliance_package_item_info[compliance_package_item_id]\"> ($tp_info[tp_name]) - $compliance_package_item_info[compliance_package_item_name]</a></td>";
echo "			</tr>";
	}
	}
	}
	



echo "						</table>";
echo "					</div>";
echo "<br>";


	}





?>
</div>
</li>
		</ul>
		
		<br class="clear"/>
		
	</section>
