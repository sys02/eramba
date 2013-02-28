<?
	include_once("lib/bu_lib.php");
	include_once("lib/configuration.inc");
	include_once("lib/process_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	global $services_conf;

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"bu_list");
	$base_url_edit_process= build_base_url($section,"process_edit");
	$base_url_edit = build_base_url($section,"bu_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$bu_id = $_GET["bu_id"];
	$bu_name = $_GET["bu_name"];
	$bu_description = $_GET["bu_description"];
	$bu_disabled = $_GET["bu_disabled"];
	
	$process_id = $_GET["process_id"];
	$process_name = $_GET["process_name"];
	$process_description = $_GET["process_description"];
	$process_mto = $_GET["process_mto"];
	$process_revenue = $_GET["process_revenue"];
	if (!is_numeric($process_mto)) {
		$process_mto = 360;
	}
	$process_disabled = $_GET["process_disabled"];

	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update_bu" & is_numeric($bu_id)) {
		$bu_update = array(
			'bu_name' => $bu_name,
			'bu_description' => $bu_description
		);	
		update_bu($bu_update,$bu_id);
		add_system_records("organization","bu_edit","$bu_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update_bu") {
		$bu_update = array(
			'bu_name' => $bu_name,
			'bu_description' => $bu_description
		);	
		$bu_id = add_bu($bu_update);
		add_system_records("organization","bu_edit","$bu_id",$_SESSION['logged_user_id'],"Insert","");
	 }

	if ($action == "update_process" & is_numeric($process_id)) {
		$process_update = array(
			'process_name' => $process_name,
			'bu_id' => $bu_id,
			'process_description' => $process_description,
			'process_mto' => $process_mto,
			'process_revenue' => $process_revenue
		);	
		update_process($process_update,$process_id);
		add_system_records("organization","process_edit","$process_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update_process") {
		$process_update = array(
			'process_name' => $process_name,
			'bu_id' => $bu_id,
			'process_description' => $process_description,
			'process_mto' => $process_mto,
			'process_revenue' => $process_revenue
		);	
		$process_id = add_process($process_update);
		add_system_records("organization","process_edit","$process_id",$_SESSION['logged_user_id'],"Insert","");
	}


	if ($action == "disable_bu" & is_numeric($bu_id)) {
		disable_bu($bu_id);
		add_system_records("organization","bu_edit","$bu_id",$_SESSION['logged_user_id'],"Disable","");
	}
	if ($action == "disable_process" & is_numeric($process_id)) {
		disable_process($process_id);
		add_system_records("organization","process_edit","$process_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_bu_csv();
		add_system_records("organization","bu_edit","",$_SESSION['logged_user_id'],"Export","");
	}
	
	if ($action == "csv_process") {
		export_process_csv();
		add_system_records("organization","process_edit","",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>


	<section id="content-wrapper">
		<h3>Business Units</h3>
		<span class=description>Describing the organiational units and their main processes is a basic component on any Security Program. After all it might be a good idea to know what is that you are protecting!</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit_bu\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Business Unit 
			</a>
			
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
	echo '<li><a href="' . $base_url_list . '&download_export=bu_export">Download</a></li>';
} elseif ($action == "csv_process") { 
	echo '<li><a href="' . $base_url_list . '&download_export=process_export">Download</a></li>';
} else {
echo "					<li><a href=\"$base_url_list&action=csv\">Export All BU</a></li>";
echo "					<li><a href=\"$base_url_list&action=csv_process\">Export All Process</a></li>";
}
?>
				</ul>
			</div>

		</div>
		
		<ul id="accordion">
			
<?
	if ($show_id) {
		$bu_list = list_bu(" WHERE bu_disabled = 0 AND bu_id = $show_id");
	} else {
		$bu_list = list_bu(" WHERE bu_disabled=\"0\"");
	}
	foreach($bu_list as $bu_item) {
echo "			<li>";
echo "				<div class=\"header\">";
echo "					Business Unit: $bu_item[bu_name]";
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$base_url_edit&action=edit&bu_id=$bu_item[bu_id]\">edit</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"$base_url_list&action=disable_bu&bu_id=$bu_item[bu_id]\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"$base_url_edit_process&action=edit_process&bu_id=$bu_item[bu_id]\">add new business process here</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=system&subsection=system_records_list&system_records_lookup_section=organization&system_records_lookup_subsection=bu_edit&system_records_lookup_item_id=$bu_item[bu_id]\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=organization&ciso_pmo_lookup_subsection=process_edit&ciso_pmo_lookup_item_id=$bu_item[bu_id]\">improve</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "				<div class=\"content table\">";
echo "					<table>";
echo "						<tr>";
echo "							<th>Process Name</th>";
echo "							<th>Description</th>";
echo "							<th><center>MTO</th>";
echo "							<th><center>Revenue/Day</th>";
echo "						</tr>";

	$process_list = list_process(" WHERE bu_id = $bu_item[bu_id] AND process_disabled = \"0\"");
	foreach($process_list as $process_item) {
echo "						<tr>";
echo "							<td class=\"action-cell\">";
echo "								<div class=\"cell-label\">";
echo "								 	$process_item[process_name]";
echo "								</div>";
echo "								<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit_process&action=edit_process&process_id=$process_item[process_id]&bu_id=$bu_item[bu_id]\" class=\"edit-action\">edit</a> ";
echo "							<a href=\"$base_url_list&action=disable_process&process_id=$process_item[process_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=organization&system_records_lookup_subsection=process_edit&system_records_lookup_item_id=$process_item[process_id]\" class=\"delete-action\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=organization&ciso_pmo_lookup_subsection=process_edit&ciso_pmo_lookup_item_id=$process_item[process_id]\">improve</a>";
echo "								</div>";
echo "							</td>";
echo "							<td>".substr($process_item[process_description],0,100)."...</td>";
echo "							<td><center>$process_item[process_mto] Days</td>";
echo "							<td><center>$process_item[process_revenue] $services_conf[system_currency]</td>";
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
