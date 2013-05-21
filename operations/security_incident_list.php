<?
	include_once("lib/security_incident_lib.php");
	include_once("lib/security_incident_classification_lib.php");
	include_once("lib/security_incident_service_lib.php");
	include_once("lib/security_incident_status_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"security_incident_list");
	$base_url_edit  = build_base_url($section,"security_incident_edit");
	$service_url = build_base_url("security_services","security_catalogue_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$security_incident_id = $_GET["security_incident_id"];
	$security_incident_owner_id = $_GET["security_incident_owner_id"];
	$security_incident_tp_id = $_GET["security_incident_tp_id"];
	$security_incident_title = $_GET["security_incident_title"];
	$security_incident_open_date = $_GET["security_incident_open_date"];
	$security_incident_description = $_GET["security_incident_description"];
	$security_incident_compromised_asset_id = $_GET["security_incident_compromised_asset_id"];
	$security_incident_closure_date = $_GET["security_incident_closure_date"];
	$security_incident_classification_id = $_GET["security_incident_classification_id"];
	$security_incident_status_id = $_GET["security_incident_status_id"];
	$security_incident_disabled = $_GET["security_incident_disabled"];
	$security_incident_service = $_GET["security_incident_service"];
	$security_incident_reporter_id = $_GET["security_incident_reporter_id"];
	$security_incident_victim_id = $_GET["security_incident_victim_id"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "edit" && is_numeric($security_incident_id)) {
		$security_incident_update = array(
			'security_incident_owner_id' => $security_incident_owner_id,
			'security_incident_tp_id' => $security_incident_tp_id,
			'security_incident_reporter_id' => $security_incident_reporter_id,
			'security_incident_victim_id' => $security_incident_victim_id,
			'security_incident_title' => $security_incident_title,
			'security_incident_open_date' => $security_incident_open_date,
			'security_incident_description' => $security_incident_description,
			'security_incident_compromised_asset_id' => $security_incident_compromised_asset_id,
			'security_incident_closure_date' => $security_incident_closure_date,
			'security_incident_classification_id' => $security_incident_classification_id,
			'security_incident_status_id' => $security_incident_status_id
		);	
		update_security_incident($security_incident_update,$security_incident_id);
		add_system_records("operations","security_incident_edit","$security_incident_id",$_SESSION['logged_user_id'],"Update","");
		
		# delete all controlss for this incident
		if ($security_incident_id) {
		delete_security_incident_service_join($security_incident_id);
		}

		# add all selected controlss for this incident
		if (is_array($security_incident_service)) {
			foreach($security_incident_service as $controls_item) {
				# now i insert this stuff
				add_security_incident_service_join($security_incident_id, $controls_item);
			}
		}

	} elseif ($action == "edit" && !is_numeric($security_incident_id)) {
		$security_incident_update = array(
			'security_incident_owner_id' => $security_incident_owner_id,
			'security_incident_tp_id' => $security_incident_tp_id,
			'security_incident_reporter_id' => $security_incident_reporter_id,
			'security_incident_victim_id' => $security_incident_victim_id,
			'security_incident_title' => $security_incident_title,
			'security_incident_open_date' => $security_incident_open_date,
			'security_incident_description' => $security_incident_description,
			'security_incident_compromised_asset_id' => $security_incident_compromised_asset_id,
			'security_incident_closure_date' => $security_incident_closure_date,
			'security_incident_classification_id' => $security_incident_classification_id,
			'security_incident_status_id' => $security_incident_status_id
		);	
		$security_incident_id = add_security_incident($security_incident_update);
		add_system_records("operations","security_incident_edit","$security_incident_id",$_SESSION['logged_user_id'],"Insert","");
		
		# delete all controlss for this incident
		if ($security_incident_id) {
		delete_security_incident_service_join($security_incident_id);
		}

		# add all selected controlss for this incident
		if (is_array($security_incident_service)) {
			foreach($security_incident_service as $controls_item) {
				# now i insert this stuff
				add_security_incident_service_join($security_incident_id, $controls_item);
			}
		}
	}

	if ($action == "disable") {
		disable_security_incident($security_incident_id);
		add_system_records("operations","security_incident_edit","$security_incident_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_security_incident_csv();
		add_system_records("operations","security_incident_edit","$security_incident_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Security Incidents</h3>
		<span class=description>Records for all reported Security Incidents</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Incident 
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
	echo '<li><a href="' . $base_url_list . '&download_export=security_incident_export">Download</a></li>';
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>
		</div>
		<br class="clear"/>
		
		<table class="main-table">
			<thead>
				<tr>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=security_incident_name\">Incident Title</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_tp_id\">Third Party</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_reporter_id\">Reporter</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_victim_id\">Affected</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_owner_id\">Owner</a></th>";
echo "					<th>Security Controls</th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_classification_id\">Classification</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_status_id\">Status</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_open_date\">Open Date</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_closure_date\">Closure Date</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_incident_compromised_asset_id\">Asset</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$security_incident_list = list_security_incident(" WHERE security_incident_disabled = 0 AND security_incident_id = $show_id");
	} else {
		if ($sort == "security_incident_name" OR $sort == "security_incident_tp_id" OR $sort == "security_incident_victim_id" OR $sort == "security_incident_victim_id" OR $sort == "security_incident_classification_id" OR $sort == "security_incident_status_id" OR $sort == "security_incident_open_date" OR $sort == "security_incident_closure_date" OR $sort == "security_incident_owner_id" OR $sort == "security_incident_compromised_asset_id") {
			$security_incident_list = list_security_incident(" WHERE security_incident_disabled = 0 ORDER by $sort");
		} else {
			$security_incident_list = list_security_incident(" WHERE security_incident_disabled = 0 ORDER by security_incident_open_date");
		}
	}

	foreach($security_incident_list as $security_incident_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$security_incident_item[security_incident_title]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&security_incident_id=$security_incident_item[security_incident_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"$base_url_list&action=disable&security_incident_id=$security_incident_item[security_incident_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=operations&system_records_lookup_subsection=security_incident_edit&system_records_lookup_item_id=$security_incident_item[security_incident_id]\" class=\"delete-action\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?action=edit&section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=operations&ciso_pmo_lookup_subsection=security_incident_edit&ciso_pmo_lookup_item_id=$security_incident_item[security_incident_id]\">improve</a>";
echo "						</div>";
echo "					</td>";
	$classification_name = lookup_security_incident_classification("security_incident_classification_id",$security_incident_item[security_incident_classification_id]);
	$tp_name = lookup_tp("tp_id",$security_incident_item[security_incident_tp_id]);

echo "					<td>$tp_name[tp_name]</td>";

echo "					<td>$security_incident_item[security_incident_reporter_id]</td>";
echo "					<td>$security_incident_item[security_incident_victim_id]</td>";
echo "					<td>$security_incident_item[security_incident_owner_id]</td>";


echo "<td>";
$controls_list = list_security_incident_service_join(" WHERE security_incident_service_incident_id = \"$security_incident_item[security_incident_id]\"");
foreach ($controls_list as $controls_item) {
	$control_name = lookup_security_services("security_services_id",$controls_item[security_incident_service_service_id]);
		
	if ( security_service_check($control_name[security_services_id]) ) {
		$warning = "(!)";
	}

	echo "<ul><a href=\"$service_url&sort=$control_name[security_services_id]\">$control_name[security_services_name] $warning <a/></ul>";

	unset($warning);
}
echo "</td>";
echo "					<td>$classification_name[security_incident_classification_name]</td>";
	$status_name = lookup_security_incident_status("security_incident_status_id",$security_incident_item[security_incident_status_id]);
echo "					<td>$status_name[security_incident_status_name]</td>";
echo "					<td>$security_incident_item[security_incident_open_date]</td>";
echo "					<td>$security_incident_item[security_incident_closure_date]</td>";
	$asset_name = lookup_asset("asset_id",$security_incident_item[security_incident_compromised_asset_id]);
echo "					<td>$asset_name[asset_name]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
