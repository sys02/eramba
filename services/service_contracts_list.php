<?
	include_once("lib/service_contracts_lib.php");
	include_once("lib/tp_lib.php");
	include_once("lib/tp_type_lib.php");
	include_once("lib/process_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/service_contracts_security_service_join_lib.php");
	include_once("lib/configuration.inc");

	# currency
	global $services_conf;

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list  = build_base_url($section,"service_contracts_list");
	$base_url_edit  = build_base_url($section,"service_contracts_edit");
	$tp_url = build_base_url("organization","tp_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$service_contracts_id = $_GET["service_contracts_id"];
	$service_contracts_name = $_GET["service_contracts_name"];
	$service_contracts_description = $_GET["service_contracts_description"];
	$service_contracts_value = $_GET["service_contracts_value"];
	$service_contracts_start = $_GET["service_contracts_start"];
	$service_contracts_end = $_GET["service_contracts_end"];
	$service_contracts_provider_id = $_GET["service_contracts_provider_id"];
	$service_contracts_disabled = $_GET["service_contracts_disabled"];
	
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update_service_contracts" && is_numeric($service_contracts_id)) {
		$service_contracts_update = array(
			'service_contracts_name' => $service_contracts_name,
			'service_contracts_description' => $service_contracts_description,
			'service_contracts_value' => $service_contracts_value,
			'service_contracts_end' => $service_contracts_end,
			'service_contracts_start' => $service_contracts_start,
			'service_contracts_provider_id' => $service_contracts_provider_id
		);	
		update_service_contracts($service_contracts_update,$service_contracts_id);
		add_system_records("security_services","service_contracts_edit","$service_contracts_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update_service_contracts") {
		$service_contracts_update = array(
			'service_contracts_name' => $service_contracts_name,
			'service_contracts_description' => $service_contracts_description,
			'service_contracts_value' => $service_contracts_value,
			'service_contracts_end' => $service_contracts_end,
			'service_contracts_start' => $service_contracts_start,
			'service_contracts_provider_id' => $service_contracts_provider_id
		);	
		# print_r($service_contracts_update);
		$service_contracts_id = add_service_contracts($service_contracts_update);
		add_system_records("security_services","service_contracts_edit","$service_contracts_id",$_SESSION['logged_user_id'],"Insert","");
	 }
	
	if ($action == "disable" && is_numeric($service_contracts_id)) {
		disable_service_contracts($service_contracts_id);
		add_system_records("security_services","service_contracts_edit","$service_contracts_id",$_SESSION['logged_user_id'],"Disable","");

		# remove all contracts from the security controls if apploable
		$control_list = list_service_contracts_security_services(" WHERE service_contracts_id = \"$service_contracts_id\""); 
		if ($control_list) { 
			foreach($control_list as $control_item) {
				delete_service_contracts_security_services($control_item[security_services_id]);	
			}
		}
	}

	if ($action == "csv") {
		export_service_contracts_csv();
		add_system_records("security_services","service_contracts_edit","",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>


	<section id="content-wrapper">
		<h3>Service Contracts</h3>
		<span class=description>Of particular importance for those Security Organizations with many controls and providers, keeping an inventory of support contracts is vital at the times of budget planning! </span>
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
echo "					<li><a href=\"downloads/service_contracts_export.csv\">Dowload</a></li>";
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>

		</div>
		
		<ul id="accordion">
			
<?
	$tp_list = list_tp(" WHERE tp_disabled = \"0\" AND tp_type_id = \"2\"");

	if (count($tp_list) == "0") {
		echo "<br>";
		echo "You first need to define Suppliers using the Third Party section";
		exit;
	}

	foreach($tp_list as $tp_item) {
echo "			<li>";
echo "				<div class=\"header\">";
echo "					Provider: $tp_item[tp_name]";
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$tp_url&sort=$tp_item[tp_id]\">view this third party</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"edit\" href=\"$base_url_edit&service_contracts_provider_id=$tp_item[tp_id]&action=edit_service_contracts\">add a new service contract to this provider</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "				<div class=\"content table\">";
echo "					<table>";
echo "						<tr>";
echo "							<th><center><input type=\"checkbox\" name=\"check-all\" class=\"checkAll\" /></th>";
echo "							<th>Contract Name</th>";
echo "							<th>Description</th>";
echo "							<th><center>Value</th>";
echo "							<th><center>Start Date</th>";
echo "							<th><center>End Date</th>";
echo "						</tr>";

	$service_contracts_list = list_service_contracts(" WHERE service_contracts_disabled = \"0\" AND service_contracts_provider_id = $tp_item[tp_id]");
	foreach($service_contracts_list as $service_contracts_item) {
echo "						<tr>";
echo "							<td><center><input type=\"checkbox\" name=\"action\" class=\"check-elem\"/></td>";
echo "							<td class=\"action-cell\">";
echo "								<div class=\"cell-label\">";
echo "								 	$service_contracts_item[service_contracts_name]";
echo "								</div>";
echo "								<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit_service_contracts&service_contracts_provider_id=$service_contracts_item[service_contracts_provider_id]&service_contracts_id=$service_contracts_item[service_contracts_id]\" class=\"edit-action\">edit</a> ";
echo "							<a href=\"$base_url_list&action=disable&service_contracts_id=$service_contracts_item[service_contracts_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=security_services&system_records_lookup_subsection=service_contracts_edit&system_records_lookup_item_id=$service_contracts_item[service_contracts_id]\" class=\"delete-action\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=operations&subsection=project_improvements_edit&operations_pmo_lookup_section=security_services&operations_pmo_lookup_subsection=service_contracts_edit&operations_pmo_lookup_item_id=$service_contracts_item[service_contracts_id]\">improve</a>";
echo "								</div>";
echo "							</td>";
echo "							<td>$service_contracts_item[service_contracts_description]</td>";
echo "							<td><center>$service_contracts_item[service_contracts_value] $services_conf[system_currency]</td>";
echo "							<td><center>$service_contracts_item[service_contracts_start]</td>";
echo "							<td><center>$service_contracts_item[service_contracts_end]</td>";
echo "						</tr>";
	}

echo "					</table>";
echo "				</div>";
echo "			</li>";
	}
?>
		</ul>
		
		<br class="clear"/>
		
	</section>
