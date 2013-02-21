<?
	include_once("lib/data_asset_lib.php");
	include_once("lib/data_asset_status_lib.php");
	include_once("lib/data_asset_security_services_join_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/security_services_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"data_asset_list");
	$base_url_edit = build_base_url($section,"data_asset_edit");
	
	$asset_identification_url = build_base_url("asset","asset_edit");
	$security_services_url = build_base_url("security_services","security_catalogue_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$data_asset_id = $_GET["data_asset_id"];
	$data_asset_asset_id = $_GET["asset_id"];
	$data_asset_status_id = $_GET["data_asset_status_id"];
	$data_asset_description = $_GET["data_asset_description"];
	$security_services_id = $_GET["security_services_id"];
	$data_asset_disabled = $_GET["data_asset_disabled"];
	
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update_data_asset" && is_numeric($data_asset_id)) {
		$data_asset_update = array(
			'data_asset_status_id' => $data_asset_status_id,
			'data_asset_description' => $data_asset_description
		);	
		update_data_asset($data_asset_update,$data_asset_id);
		add_system_records("asset","data_asset_edit","$data_asset_id",$_SESSION['logged_user_id'],"Update","");
		
		# delete all security services for this data_asset
		delete_data_asset_security_services_join($data_asset_id);
		# add all selected security services for this data_asset
		if (is_array($security_services_id)) {
			$count_security_services_id_item = count($security_services_id);
			for($count = 0 ; $count < $count_security_services_id_item ; $count++) {
				# now i insert this stuff
				add_data_asset_security_services_join($data_asset_id, $security_services_id[$count]);
			}
		}

	} elseif ($action == "update_data_asset") {
		$data_asset_update = array(
			'data_asset_asset_id' => $data_asset_asset_id,
			'data_asset_status_id' => $data_asset_status_id,
			'data_asset_description' => $data_asset_description
		);	
		$data_asset_id = add_data_asset($data_asset_update);
		add_system_records("asset","data_asset_edit","$data_asset_id",$_SESSION['logged_user_id'],"Insert","");
		
		# delete all security services for this data_asset
		delete_data_asset_security_services_join($data_asset_id);

		# add all selected security services for this data_asset
		if (is_array($security_services_id)) {
			$count_security_services_id_item = count($security_services_id);
			for($count = 0 ; $count < $count_security_services_id_item ; $count++) {
				# now i insert this stuff
				add_data_asset_security_services_join($data_asset_id, $security_services_id[$count]);
			}
		}
	 }

	if ($action == "disable_data_asset" & is_numeric($data_asset_id)) {
		disable_data_asset($data_asset_id);
		add_system_records("asset","data_asset_edit","$data_asset_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_data_asset_csv();
		add_system_records("asset","data_asset_edit","",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>


	<section id="content-wrapper">
		<h3>Data Asset Analysis</h3>
		<span class=description>For those sensitive data assets, describe the process on how they are created, used, transmited and disposed in order to ensure correct controls are in place for each one of those phases of the lifecycle of an asset.</span>
		<br>
		<br>
		
		<div class="controls-wrapper">
			
			<!--<a href="#" class="actions-btn">
				Actions
				<span class="select-icon"></span>
			</a>-->

			<div class="actions-wraper">
				<a href="#" class="actions-btn">
					Actions
					<span class="select-icon"></span>
				</a>
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
echo "					<li><a href=\"downloads/data_asset_export.csv\">Dowload</a></li>";
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>

		</div>
		
		<ul id="accordion">
			
<?
	$asset_list = list_asset(" WHERE asset_disabled=\"0\" AND asset_media_type_id = \"1\"");

	foreach($asset_list as $asset_item) {
	
	$data_asset_list = list_data_asset(" WHERE data_asset_asset_id = \"$asset_item[asset_id]\" AND data_asset_disabled = \"0\"");
	
	# check if the data assets analisys within this asset has failed controls or not
	foreach($data_asset_list as $data_asset_item) {

		$selected_services_list = list_data_asset_security_services_join(" WHERE data_asset_security_services_join_data_asset_id = \"$data_asset_item[data_asset_id]\"");

		if(count($selected_services_list) > 0) {
			foreach($selected_services_list as $selected_services_item) {
				if ( security_service_check($selected_services_item[data_asset_security_services_join_security_services_id]) ) {
					$warning_wrong_service = " - (Warning - Controls used here are faulty!) ";
				}
			}
		} else {
			$warning_missing_service = " - (Warning - Your data analisys might be missing some controls!) ";
		}

	}

echo "			<li>";
echo "				<div class=\"header\">";
echo "					Business Unit: $asset_item[asset_name] $warning_wrong_service $warning_missing_service";

			unset($warning_wrong_service);
			unset($warning_missing_service);
	
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$asset_identification_url&asset_id=$asset_item[asset_id]\">view this asset</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"edit\" href=\"$base_url_edit&asset_id=$asset_item[asset_id]&action=edit\">add new analysis</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "				<div class=\"content table\">";
echo "					<table>";
echo "						<tr>";
echo "							<th>Data State</th>";
echo "							<th>State Description</th>";
echo "							<th>Applicable Security Controls</th>";
echo "						</tr>";

	# $data_asset_list = list_data_asset(" WHERE data_asset_asset_id = \"$asset_item[asset_id]\" AND data_asset_disabled = \"0\"");

	foreach($data_asset_list as $data_asset_item) {
	

echo "						<tr>";
echo "							<td class=\"action-cell\">";
echo "								<div class=\"cell-label\">";
						$data_asset_status_name = lookup_data_asset_status("data_asset_status_id", $data_asset_item[data_asset_status_id]);
echo "					 When the data asset is: $data_asset_status_name[data_asset_status_name] ";
echo "								</div>";
echo "								<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&data_asset_id=$data_asset_item[data_asset_id]\" class=\"edit-action\">edit</a> ";
echo "							<a href=\"$base_url_list&action=disable_data_asset&data_asset_id=$data_asset_item[data_asset_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=asset&system_records_lookup_subsection=data_asset_edit&system_records_lookup_item_id=$data_asset_item[data_asset_id]\" class=\"delete-action\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=asset&ciso_pmo_lookup_subsection=asset_identification&ciso_pmo_lookup_item_id=$data_asset_item[data_asset_id]\">improve</a>";
echo "								</div>";
echo "							</td>";
echo "							<td>$data_asset_item[data_asset_description]</td>";
echo "							<td>\n\n\n";

	# echo "puta: ".count($selected_services_list)."";
	$selected_services_list = list_data_asset_security_services_join(" WHERE data_asset_security_services_join_data_asset_id = \"$data_asset_item[data_asset_id]\"");
	foreach($selected_services_list as $selected_services_item) {
		# echo "<a href=\"$security_services_url&security_service_id=$selected_services_item[data_asset_security_services_join_security_services_id]>service</a><br>";
		$service_name = lookup_security_services("security_services_id",$selected_services_item[data_asset_security_services_join_security_services_id]);

		if ( security_service_check($service_name[security_services_id]) ) {
			$warning = "(!)";
		}

		echo "<a href=\"$security_services_url&sort=$selected_services_item[data_asset_security_services_join_security_services_id]\">$service_name[security_services_name] $warning</a><br>\n";
	}
echo "							</td>\n\n\n";
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
