<?
	include_once("lib/tp_lib.php");
	include_once("lib/tp_type_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/service_contracts_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"tp_list");
	$base_url_edit = build_base_url($section,"tp_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$tp_id = $_GET["tp_id"];
	$tp_name = $_GET["tp_name"];
	$tp_description = $_GET["tp_description"];
	$tp_type_id = $_GET["tp_type_id"];
	$tp_disabled = $_GET["tp_disabled"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($tp_id)) {
		$tp_update = array(
			'tp_name' => $tp_name,
			'tp_description' => $tp_description,
			'tp_type_id' => $tp_type_id
		);	
		update_tp($tp_update,$tp_id);
		add_system_records("organization","tp_edit","$tp_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$tp_update = array(
			'tp_name' => $tp_name,
			'tp_description' => $tp_description,
			'tp_type_id' => $tp_type_id
		);	
		$tp_id = add_tp($tp_update);
		add_system_records("organization","tp_edit","$tp_id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_tp($tp_id);
		add_system_records("organization","tp_edit","$tp_id",$_SESSION['logged_user_id'],"Disable","");

		# now  i need to disable all related sub-contracts
		$list_of_contracts = list_service_contracts(" WHERE service_contracts_disabled = \"0\" AND service_contracts_provider_id = \"$tp_id\"");	
		if ($list_of_contracts) {
			foreach($list_of_contracts as $list_of_contracts_item) {
				disable_service_contracts($list_of_contracts_item[service_contracts_id]);	
				add_system_records("security_services","service_contracts_edit",$list_of_contracts_item[service_contracts_id],$_SESSION['logged_user_id'],"Disable","");
			}
		}

		# now i need to delete this contracts from the asociated services ... this could be in disable_service_contracts ...!!

	}

	if ($action == "csv") {
		export_tp_csv();
		add_system_records("organization","tp_edit","$tp_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Third Parties</h3>
		<span class=description>Most organization partners and executes busineses with many other parties. Understanding this links is necesary in order to develop a full picture of hte scope of your security program.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Third Party 
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
echo "					<li><a href=\"downloads/tp_export.csv\">Dowload</a></li>";
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=tp_name\">Third Party name</a></th>";
?>
<?
echo "					<th><a href=\"$base_url_list&sort=tp_type_id\">Type</a></th>";
echo "					<th><a href=\"$base_url_list&sort=tp_description\">Description</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$tp_list = list_tp(" WHERE tp_disabled = 0 AND tp_id = $show_id");
	} else {
		if (is_numeric($sort)) {
			$tp_list = list_tp(" WHERE tp_disabled = 0 AND tp_id = \"$sort\"");
		} elseif ($sort == "tp_description" OR $sort == "tp_name" OR $sort == "tp_tp_id") {
			$tp_list = list_tp(" WHERE tp_disabled = 0 ORDER by $sort");
		} else {
			$tp_list = list_tp(" WHERE tp_disabled = 0 ORDER by tp_name");
		}
	}

	foreach($tp_list as $tp_item) {

	$tp_type_name = lookup_tp_type("tp_type_id",$tp_item[tp_type_id]);

echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$tp_item[tp_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&tp_id=$tp_item[tp_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"$base_url_list&action=disable&tp_id=$tp_item[tp_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=organization&system_records_lookup_subsection=tp_edit&system_records_lookup_item_id=$tp_item[tp_id]\" class=\"delete-action\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=operations&subsection=project_improvements_list&system_records_lookup_section=organization&system_records_lookup_subsection=tp_edit&system_records_lookup_item_id=$tp_item[tp_id]\" class=\"delete-action\">improve</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$tp_type_name[tp_type_name]</td>";
echo "					<td>$tp_item[tp_description]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
