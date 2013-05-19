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

	$base_url_list = build_base_url($section,"security_services_analysis_list");
	$base_url_services = build_base_url("security_services","security_catalogue_list");

	build_security_services_analysis();

	if ($action == "csv") {
		export_security_services_analysis_csv();
		add_system_records("security_services","security_services_analysis_list","",$_SESSION['logged_user_id'],"Export","");
	}
?>

	<section id="content-wrapper">
		<h3>Security Services Reporting</h3>
		<span class="description">This aims to provide input information for analysing security controls</span>
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
echo '<li><a href="' . $base_url_list . '&download_export=security_services_analysis_export">Download</a></li>';
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
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_control_name\"><a class=\"asc\">Control Name</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_fa\"># Failed Audits</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_resource\">Hs/Month Resources</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_opex\">OPEX</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_contracts\">Support Contracts</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_capex\">CAPEX</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_classification_name\">Classification</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_risk_asset\"># Asset Risk Mitigations</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_tp_risk\"># TP Risk Mitigations</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_risk_score\"># Risk Score</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_data_flows\"># Data Flows Mitigations</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_compliance\"># Compliance Mitigations</th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_analysis_mit_total\"># Total Mitigations</th>";
?>
				</tr>
			</thead>
	

<?

echo "			<tbody>";
		
		if ($sort == "security_services_analysis_control_name" OR $sort == "security_services_analysis_fa" OR $sort == "security_services_analysis_opex" OR $sort == "security_services_analysis_contracts" OR $sort == "security_services_analysis_capex" OR $sort == "security_services_analysis_classification_name" OR $sort == "security_services_analysis_risk_asset" OR $sort == "security_services_analysis_tp_risk" OR $sort == "security_services_analysis_data_flows" OR $sort == "security_services_analysis_compliance" OR $sort == "security_services_analysis_mit_total" OR $sort = "security_services_analysis_risk_score" OR $sort="security_services_analysis_resource") {

			$data = list_security_services_analysis(" WHERE security_services_analysis_disabled = 0 ORDER by $sort");
		} else {
			$data = list_security_services_analysis(" WHERE security_services_analysis_disabled = 0 ORDER by security_services_analysis_control_name");
		}

foreach($data as $data_item) {

echo "				<tr class=\"even\">";
echo "					<td><a href=\"$base_url_services&sort=$data_item[security_services_analysis_control_id]\">$data_item[security_services_analysis_control_name]</a></td>";
echo "					<td>$data_item[security_services_analysis_fa]</td>";
echo "					<td>$data_item[security_services_analysis_resource] FTE</td>";
echo "					<td>$data_item[security_services_analysis_opex] $services_conf[system_currency]</td>";
echo "					<td>$data_item[security_services_analysis_contracts] $services_conf[system_currency]</td>";
echo "					<td>$data_item[security_services_analysis_capex] $services_conf[system_currency]</td>";
echo "					<td>$data_item[security_services_analysis_classification_name]</td>";
echo "					<td>$data_item[security_services_analysis_risk_asset]</td>";
echo "					<td>$data_item[security_services_analysis_tp_risk]</td>";
echo "					<td>$data_item[security_services_analysis_risk_score]</td>";
echo "					<td>$data_item[security_services_analysis_data_flows]</td>";
echo "					<td>$data_item[security_services_analysis_compliance]</td>";
echo "					<td>$data_item[security_services_analysis_mit_total]</td>";
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
