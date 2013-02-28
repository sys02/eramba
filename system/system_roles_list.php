<?
	include_once("lib/system_group_role_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/system_authorization_group_role_join_lib.php");
	include_once("lib/system_authorization_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"system_roles_list");
	$base_url_edit = build_base_url($section,"system_roles_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$system_group_role_id = $_GET["system_group_role_id"];
	$system_group_role_name = $_GET["system_group_role_name"];
	$system_group_role_description = $_GET["system_group_role_description"];
	$system_group_role_disabled = $_GET["system_group_role_disabled"];
	$system_group_role_read_access = $_GET["system_group_role_read_access"];
	$system_group_role_write_access = $_GET["system_group_role_write_access"];

	# cant do naything without name or roels
	if ($action == "update" && empty($system_group_role_name)) {
		$action = NULL;
	}
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($system_group_role_id)) {
		$system_group_role_update = array(
			'system_group_role_name' => $system_group_role_name,
			'system_group_role_description' => $system_group_role_description
		);	
		update_system_group_role($system_group_role_update,$system_group_role_id);
		add_system_records("system","system_roles_edit","$system_group_role_id",$_SESSION['logged_user_id'],"Update","");

		# i need to delete all asociations between the group and the permisions
		delete_system_authorization_group_role_join($system_group_role_id);
		# i need to add all asociations i received between the group and the permisions
		foreach($system_group_role_read_access as $item) { 
			if ($item> 0) {
			add_system_authorization_group_role_join($system_group_role_id,$item);
			}
		}
		foreach($system_group_role_write_access as $item) { 
			if ($item> 0) {
			add_system_authorization_group_role_join($system_group_role_id,$item);
			}
		}

	} elseif ($action == "update") {
		$system_group_role_update = array(
			'system_group_role_name' => $system_group_role_name,
			'system_group_role_description' => $system_group_role_description
		);	
		$system_group_role_id = add_system_group_role($system_group_role_update);
		add_system_records("system","system_roles_edit","$system_group_role_id",$_SESSION['logged_user_id'],"Insert","");
		foreach($system_group_role_write_access as $item) { 
			if ($item> 0) {
			add_system_authorization_group_role_join($system_group_role_id,$item);
			}
		}
		
		# i need to delete all asociations between the group and the permisions
		delete_system_authorization_group_role_join($system_group_role_id);
		# i need to add all asociations i received between the group and the permisions
		foreach($system_group_role_read_access as $item) { 
			if ($item> 0) {
			add_system_authorization_group_role_join($system_group_role_id,$item);
			}
		}
	}

	if ($action == "disable") {
		disable_system_group_role($system_group_role_id);
		add_system_records("system","system_roles_edit","$system_group_role_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_system_group_role_csv();
		add_system_records("system","system_roles_edit","$system_group_role_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>System Roles</h3>
		<span class=description>Manage Group Roles byu defining the roles assigned to a given role. You can assign them later to your system users</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add a new Group Role 
			</a>
			
			<div class="actions-wraper">
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
	echo '<li><a href="' . $base_url_list . '&download_export=system_group_role_export">Download</a></li>';
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=system_group_role_name\">Role Group Name</a></th>";
?>
<?
echo "					<th>Description</th>";
echo "					<th>Is allowed to...</th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$system_group_role_list = list_system_group_role(" WHERE system_group_role_disabled = 0 AND system_group_role_id = $show_id");
	} else {
		if ($sort == "system_group_role_description" OR $sort == "system_group_role_name") {
			$system_group_role_list = list_system_group_role(" WHERE system_group_role_disabled = 0 ORDER by $sort");
		} else {
			$system_group_role_list = list_system_group_role(" WHERE system_group_role_disabled = 0 ORDER by system_group_role_name");
		}
	}

	foreach($system_group_role_list as $system_group_role_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$system_group_role_item[system_group_role_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&system_group_role_id=$system_group_role_item[system_group_role_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"$base_url_list&action=disable&system_group_role_id=$system_group_role_item[system_group_role_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=system&system_records_lookup_subsection=system_roles_edit&system_records_lookup_item_id=$system_group_role_item[system_group_role_id]\" class=\"delete-action\">records</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$system_group_role_item[system_group_role_description]</td>";

	# read allowed permisssions
	$pre_selected_system_group_role_read_access = list_system_authorization_group_role_join(" WHERE system_authorization_group_role_role_id= \"$system_group_role_item[system_group_role_id]\"");	
	$pre_selected_items = array();

echo "					<td>";
	foreach($pre_selected_system_group_role_read_access as $pre_selected_auth_item) {
		$auth_name = lookup_system_authorization("system_authorization_id",$pre_selected_auth_item[system_authorization_group_auth_id]);
		echo "- $auth_name[system_authorization_section_cute_name] / $auth_name[system_authorization_subsection_cute_name] - ($auth_name[system_authorization_action_type])<br>";
	}
echo "					</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
