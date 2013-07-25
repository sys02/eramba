<?

	include_once("lib/site_lib.php");
	include_once("lib/security_services_analysis_lib.php");
	include_once("lib/configuration.inc");
	include_once("lib/system_records_lib.php");

	global $services_conf;

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$sort = $_GET["sort"];

	$base_url_list = build_base_url($section,"risk_summary_list");

	# build_risk_summary();

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
echo "					<th><a href=\"$base_url_list&sort=risk_summary_name\"><a class=\"asc\">Project Name</th>";
echo "					<th><a href=\"$base_url_list&sort=risk_summary_type\">Completion</th>";
echo "					<th><a href=\"$base_url_list&sort=risk_summary_risk_counter\">Velocity</th>";
echo "					<th><a href=\"$base_url_list&sort=risk_summary_score\">Planned End</th>";
echo "					<th><a href=\"$base_url_list&sort=risk_summary_residual\">Current Expenditure</th>";
echo "					<th><a href=\"$base_url_list&sort=risk_summary_opex\">Budget</th>";
echo "					<th><a href=\"$base_url_list&sort=risk_summary_incident_counter\">Owner</th>";
?>
				</tr>
			</thead>
	

<?

echo "			<tbody>";
		
		if ($sort == "risk_summary_type" OR $sort == "risk_summary_name" OR $sort == "risk_summary_risk_counter" OR $sort == "risk_summary_opex" OR $sort == "risk_summary_capex" OR $sort == "risk_summary_resources" OR $sort == "risk_summary_score" OR $sort == "risk_summary_residual" OR $sort == "risk_summary_incident_counter") {

			$data = list_risk_summary(" WHERE risk_summary_disabled = 0 ORDER by $sort DESC");
		} else {
			$data = list_risk_summary(" WHERE risk_summary_disabled = 0 ORDER by risk_summary_type");
		}

foreach($data as $data_item) {

echo "				<tr class=\"even\">";
echo "					<td>$data_item[risk_summary_name]</td>";
echo "					<td>$data_item[risk_summary_type]</td>";
echo "					<td>$data_item[risk_summary_risk_counter]</td>";
echo "					<td>$data_item[risk_summary_score]</td>";
echo "					<td>$data_item[risk_summary_residual]</td>";
echo "					<td>$data_item[risk_summary_opex] $services_conf[system_currency]</td>";
echo "					<td>$data_item[risk_summary_capex] $services_conf[system_currency]</td>";
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
