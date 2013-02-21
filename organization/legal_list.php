<?
	include_once("lib/legal_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"legal_list");
	$base_url_edit  = build_base_url($section,"legal_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$legal_id = filter_input(INPUT_GET,"legal_id",FILTER_SANITIZE_NUMBER_INT);
	$legal_name = filter_input(INPUT_GET,"legal_name",FILTER_SANITIZE_STRING);
	$legal_description = filter_input(INPUT_GET,"legal_description",FILTER_SANITIZE_STRING);
	$legal_disabled = filter_input(INPUT_GET,"legal_disabled",FILTER_SANITIZE_NUMBER_INT);
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($legal_id)) {
		$legal_update = array(
			'legal_name' => $legal_name,
			'legal_description' => $legal_description
		);	
		update_legal($legal_update,$legal_id);
		add_system_records("organization","legal_edit","$legal_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$legal_update = array(
			'legal_name' => $legal_name,
			'legal_description' => $legal_description
		);	
		$legal_id = add_legal($legal_update);
		add_system_records("organization","legal_edit","$legal_id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_legal($legal_id);
		add_system_records("organization","legal_edit","$legal_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_legal_csv();
		add_system_records("organization","legal_edit","$legal_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Legal Constrains</h3>
		<span class=description>Most businesses deal with Legal requirement, either from customers, providers, regulators, etc. Compliance to this requirements is a good idea.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Legal
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
echo "					<li><a href=\"downloads/legal_export.csv\">Dowload</a></li>";
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=legal_name\">Legal name</a></th>";
?>
<?
echo "					<th><a href=\"$base_url_list&sort=legal_description\">Description</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------

	if ($show_id) {
		$legal_list = list_legal(" WHERE legal_disabled = 0 AND legal_id = $show_id");
	} else {
		if ($sort == "legal_description" OR $sort == "legal_name") {
			$legal_list = list_legal(" WHERE legal_disabled = 0 ORDER by $sort");
		} else {
			$legal_list = list_legal(" WHERE legal_disabled = 0 ORDER by legal_name");
		}
	}

	foreach($legal_list as $legal_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$legal_item[legal_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&legal_id=$legal_item[legal_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"$base_url_list&action=disable&legal_id=$legal_item[legal_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=organization&system_records_lookup_subsection=legal_edit&system_records_lookup_item_id=$legal_item[legal_id]\" class=\"delete-action\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=operations&subsection=project_improvements_edit&system_records_lookup_section=organization&system_records_lookup_subsection=legal_edit&system_records_lookup_item_id=$legal_item[legal_id]\" class=\"delete-action\">improve</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$legal_item[legal_description]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
