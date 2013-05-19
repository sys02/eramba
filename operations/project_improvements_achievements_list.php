<?
	include_once("lib/legal_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/project_improvements_lib.php");
	include_once("lib/project_improvements_expenses_lib.php");
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
		$expense_list = list_project_improvements_expenses(" WHERE project_improvements_expenses_project_id = \"$project_improvements_id\" AND project_improvements_expenses_disabled = \"0\"");
	}
	
	$base_url_list = build_base_url($section,"project_improvements_list");
	$base_url_edit  = build_base_url($section,"project_improvements_expenses_edit");
	
	if ($action == "csv") {
		export_legal_csv();
		add_system_records("operations","project_improvements_expenses_edit","$legal_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>List of Expenses</h3>
		<span class=description>This is the list of expenses for a given project</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&project_improvements_id=$project_improvements_id\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Expense
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
	echo '<li><a href="' . $base_url_list . '&download_export=legal_export">Download</a></li>';
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=legal_name\">Project Name</a></th>";
echo "					<th>Expense Amount</th>";
echo "					<th>Expense Date</th>";
echo "					<th>Expense Description</th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------

	foreach($expense_list as $expense_item) {

		$project_information = lookup_project_improvements("project_improvements_id",$expense_item[project_improvements_expenses_project_id]);

echo "	<tr class=\"even\">";
echo "	<td class=\"action-cell\">";
echo "	<div class=\"cell-label\">";
echo "	$project_information[project_improvements_title]";
echo "	</div>";
echo "	<div class=\"cell-actions\">";
echo "	<a href=\"$base_url_edit&project_improvements_expense_id=$expense_item[project_improvements_expenses_id]&project_improvements_id=$expense_item[project_improvements_expenses_project_id]\" class=\"edit-action\">edit</a> ";
echo "	&nbsp;|&nbsp;";
echo "	<a href=\"$base_url_list&action=disable_expenses&project_improvements_expenses_id=$expense_item[project_improvements_expenses_id]\" class=\"delete-action\">delete</a>";
echo "	&nbsp;|&nbsp;";
echo "	<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=operations&system_records_lookup_subsection=project_improvements_expenses_edit&system_records_lookup_item_id=$expense_item[project_improvements_expenses_id]\" class=\"delete-action\">records</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$expense_item[project_improvements_expenses_amount] $services_conf[system_currency]</td>";
echo "					<td>$expense_item[project_improvements_expenses_date]</td>";
echo "					<td>$expense_item[project_improvements_expenses_description]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
