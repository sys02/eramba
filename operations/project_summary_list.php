<?

	include_once("lib/site_lib.php");
	include_once("lib/project_improvements_summary_lib.php");
	include_once("lib/configuration.inc");
	include_once("lib/system_records_lib.php");

	global $services_conf;

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$sort = $_GET["sort"];

	$base_url_list = build_base_url($section,"risk_summary_list");

	build_project_improvements_summary();

	if ($action == "csv") {
		export_risk_summary_csv();
		add_system_records("security_services","security_services_analysis_list","",$_SESSION['logged_user_id'],"Export","");
	}
?>

	<section id="content-wrapper">
		<h3>Project Summary</h3>
		<span class="description">Get a summary overview of the current projects</span>
		<div class="tab-wrapper"> 
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
echo '<li><a href="' . $base_url_list . '&download_export=risk_summary_list">Download</a></li>';
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
echo "					<th><a href=\"$base_url_list&sort=project_improvements_name\"><a class=\"asc\">Project Name</th>";
echo "					<th><a href=\"$base_url_list&sort=project_improvements_completion\">Completion</th>";
echo "					<th><a href=\"$base_url_list&sort=project_improvements_velocity\">Velocity</th>";
echo "					<th><a href=\"$base_url_list&sort=project_improvements_planned_end\">Planned End</th>";
echo "					<th><a href=\"$base_url_list&sort=project_improvements_planned_bud\">Budget</th>";
echo "					<th><a href=\"$base_url_list&sort=project_improvements_current_bud\">Actual Expenditure</th>";
echo "					<th><a href=\"$base_url_list&sort=project_improvements_owner\">Owner</th>";
?>
				</tr>
			</thead>
	

<?

echo "			<tbody>";
		
		if ($sort == "project_improvements_name" OR $sort == "project_improvements_completion" OR $sort == "project_improvements_velocity" OR $sort == "project_improvements_planned_end" OR $sort == "project_improvements_current_bud" OR $sort == "project_improvements_planned_bud" OR $sort == "project_improvements_owner") {

			$data = list_project_improvements_summary(" WHERE project_improvements_disabled = 0 ORDER by $sort DESC");
		} else {
			$data = list_project_improvements_summary(" WHERE project_improvements_disabled = 0 ORDER by project_improvements_name");
		}

foreach($data as $data_item) {

echo "				<tr class=\"even\">";
echo "					<td>$data_item[project_improvements_name]</td>";
echo "					<td>$data_item[project_improvements_completion]%</td>";
echo "					<td>$data_item[project_improvements_velocity]</td>";
echo "					<td>$data_item[project_improvements_planned_end]</td>";
echo "					<td>$data_item[project_improvements_planned_bud] $services_conf[system_currency]</td>";
echo "					<td>$data_item[project_improvements_current_bud] $services_conf[system_currency]</td>";
echo "					<td>$data_item[project_improvements_owner]</td>";
echo "				</tr>";

}

?>
			</tbody>
		</table>
		
		<br class="clear"/>


		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="start_compliance_management">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_management_step_two">
		</div>
		
		<br class="clear"/>
		
	</section>
</body>
</html>
