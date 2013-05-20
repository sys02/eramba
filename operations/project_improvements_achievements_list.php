<?
	include_once("lib/legal_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/project_improvements_lib.php");
	include_once("lib/project_improvements_expenses_lib.php");
	include_once("lib/project_improvements_achievements_lib.php");
	include_once("lib/configuration.inc");

	global $services_conf; 

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];

	$project_improvements_id = $_GET["project_improvements_id"];

	if (is_numeric($project_improvements_id)) { 
		$achievements_list = list_project_improvements_achievements(" WHERE project_improvements_achievements_proj_id = \"$project_improvements_id\" AND project_improvements_achievements_disabled = \"0\"");
	}
	
	$base_url_list = build_base_url($section,"project_improvements_list");
	$base_url_list_achievements = build_base_url($section,"project_improvements_achievements_list");
	$base_url_edit  = build_base_url($section,"project_improvements_achievements_edit");
	
	if ($action == "csv") {
		export_project_improvements_achievements_csv();
		add_system_records("operations","project_improvements_achievements_edit","$",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>List of Project Updates</h3>
		<span class=description>This is the list of project updates</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&project_improvements_id=$project_improvements_id\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Project Update 
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
	echo '<li><a href="' . $base_url_list . '&download_export=project_improvements_achievements_export">Download</a></li>';
} else { 
echo "					<li><a href=\"$base_url_list_achievements&action=csv&project_improvements_id=$project_improvements_id\">Export All</a></li>";
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
echo "					<th>Project Name</th>";
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=project_improvements_achievements_text\">Update Owner</a></th>";
echo "					<th>Description</th>";
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=project_improvements_achievements_date\">Date</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------

	foreach($achievements_list as $achievements_item) {

		$project_information = lookup_project_improvements("project_improvements_id",$achievements_item[project_improvements_achievements_proj_id]);

echo "	<tr class=\"even\">";
echo "	<td class=\"action-cell\">";
echo "	<div class=\"cell-label\">";
echo "	$project_information[project_improvements_title]";
echo "	</div>";
echo "	<div class=\"cell-actions\">";
echo "	<a href=\"$base_url_edit&project_improvements_achievements_id=$achievements_item[project_improvements_achievements_id]&project_improvements_id=$achievements_item[project_improvements_achievements_proj_id]\" class=\"edit-action\">edit</a> ";
echo "	&nbsp;|&nbsp;";
echo "	<a href=\"$base_url_list&action=disable_achievements&project_improvements_achievements_id=$achievements_item[project_improvements_achievements_id]\" class=\"delete-action\">delete</a>";
echo "	&nbsp;|&nbsp;";
echo "	<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=operations&system_records_lookup_subsection=project_improvements_achievements_edit&system_records_lookup_item_id=$achievements_item[project_improvements_achievements_id]\" class=\"delete-action\">records</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$achievements_item[project_improvements_achievements_owner]</td>";
echo "					<td>".substr($achievements_item[project_improvements_achievements_text],0,20)."...</td>";
echo "					<td>$achievements_item[project_improvements_achievements_date]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
