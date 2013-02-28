<?
	include_once("lib/policy_exceptions_lib.php");
	include_once("lib/policy_exceptions_status_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/site_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"policy_exceptions_list");
	$base_url_edit  = build_base_url($section,"policy_exceptions_edit");

	# change the status of the expired exceptions
	set_exceptions_to_expire();
	
	# local variables - YOU MUST ADJUST THIS! 
	$policy_exceptions_id = $_GET["policy_exceptions_id"];
	$policy_exceptions_title = $_GET["policy_exceptions_title"];
	$policy_exceptions_description = $_GET["policy_exceptions_description"];
	$policy_exceptions_status = $_GET["policy_exceptions_status"];
	$policy_exceptions_owner = $_GET["policy_exceptions_owner"];
	$policy_exceptions_expiration_date = $_GET["policy_exceptions_expiration_date"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "edit" && is_numeric($policy_exceptions_id)) {
		$policy_exceptions_update = array(
			'policy_exceptions_title' => $policy_exceptions_title,
			'policy_exceptions_description' => $policy_exceptions_description,
			'policy_exceptions_status' => $policy_exceptions_status,
			'policy_exceptions_owner' => $policy_exceptions_owner,
			'policy_exceptions_expiration_date' => $policy_exceptions_expiration_date
		);	
		update_policy_exceptions($policy_exceptions_update,$policy_exceptions_id);
		add_system_records("operations","policy_exceptions_edit","$policy_exceptions_id",$_SESSION['logged_user_id'],"Update","");
		
	} elseif ($action == "edit" && !is_numeric($policy_exceptions_id)) {
		$policy_exceptions_update = array(
			'policy_exceptions_title' => $policy_exceptions_title,
			'policy_exceptions_description' => $policy_exceptions_description,
			'policy_exceptions_status' => $policy_exceptions_status,
			'policy_exceptions_owner' => $policy_exceptions_owner,
			'policy_exceptions_expiration_date' => $policy_exceptions_expiration_date
		);	
		$policy_exceptions_id = add_policy_exceptions($policy_exceptions_update);
		add_system_records("operations","policy_exceptions_edit","$policy_exceptions_id",$_SESSION['logged_user_id'],"Insert","");
		
	}

	if ($action == "disable") {
		disable_policy_exceptions($policy_exceptions_id);
		add_system_records("operations","policy_exceptions_edit","$policy_exceptions_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_policy_exceptions_csv();
		add_system_records("operations","policy_exceptions_edit","$policy_exceptions_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Policy Exceptions</h3>
		<span class=description>Records for all reported Policy Exceptions</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Policy Exception 
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
	echo '<li><a href="' . $base_url_list . '&download_export=policy_exceptions_export">Download</a></li>';
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=policy_exceptions_title\">Exception Title</a></th>";
echo "					<th><a href=\"$base_url_list&sort=policy_exceptions_description\">Description</a></th>";
echo "					<th><a href=\"$base_url_list&sort=policy_exceptions_status\">Status</a></th>";
echo "					<th><a href=\"$base_url_list&sort=policy_exceptions_owner\">Owner</a></th>";
echo "					<th><a href=\"$base_url_list&sort=policy_exceptions_expiration_date\">Expiration</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$policy_exceptions_list = list_policy_exceptions(" WHERE policy_exceptions_disabled = 0 AND policy_exceptions_id = $show_id");
	} else {
		if ($sort == "policy_exceptions_description" OR $sort == "policy_exceptions_name") {
			$policy_exceptions_list = list_policy_exceptions(" WHERE policy_exceptions_disabled = 0 ORDER by $sort");
		} else {
			$policy_exceptions_list = list_policy_exceptions(" WHERE policy_exceptions_disabled = 0 ORDER by policy_exceptions_expiration_date");
		}
	}

	foreach($policy_exceptions_list as $policy_exceptions_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$policy_exceptions_item[policy_exceptions_title]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&policy_exceptions_id=$policy_exceptions_item[policy_exceptions_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"$base_url_list&action=disable&policy_exceptions_id=$policy_exceptions_item[policy_exceptions_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=operations&system_records_lookup_subsection=policy_exceptions_edit&system_records_lookup_item_id=$policy_exceptions_item[policy_exceptions_id]\" class=\"delete-action\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=operations&subsection=project_improvements_edit&system_records_lookup_section=operations&system_records_lookup_subsection=policy_exceptions_edit&system_records_lookup_item_id=$policy_exceptions_item[policy_exceptions_id]\" class=\"delete-action\">improve</a>";
echo "						</div>";
echo "					</td>";
echo "					<td><a href=\"$base_url_edit&action=edit&policy_exceptions_id=$policy_exceptions_item[policy_exceptions_id]\">".substr($policy_exceptions_item[policy_exceptions_description],0,50)."...</a></td>";

	$status_name = lookup_policy_exceptions_status("policy_exceptions_status_id",$policy_exceptions_item[policy_exceptions_status]);

echo "					<td>$status_name[policy_exceptions_status_name]</td>";
echo "					<td>$policy_exceptions_item[policy_exceptions_owner]</td>";
echo "					<td>$policy_exceptions_item[policy_exceptions_expiration_date]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
