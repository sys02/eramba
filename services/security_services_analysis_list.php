<?

	include_once("lib/site_lib.php");
	include_once("lib/security_services_analysis_lib.php");
	include_once("lib/configuration.inc");

	global $services_conf;

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];

	build_security_services_analysis();

?>

	<section id="content-wrapper">
		<h3>Security Services Reporting</h3>
		<span class="description">This aims to provide input information for analysing security controls</span>
		<div class="tab-wrapper"> 
		<br> 	


		<table class="main-table">
			<thead>
				<tr>
<?


# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th><a class=\"asc\">Control Name</th>";
echo "					<th># Failed Audits</th>";
echo "					<th>OPEX</th>";
echo "					<th>Support Contracts</th>";
echo "					<th>CAPEX</th>";
echo "					<th>Classification</th>";
echo "					<th># Asset Risk Mitigations</th>";
echo "					<th># TP Risk Mitigations</th>";
echo "					<th># Data Flows Mitigations</th>";
echo "					<th># Compliance Mitigations</th>";
?>
				</tr>
			</thead>
	

<?

echo "			<tbody>";

$data = list_security_services_analysis(" WHERE security_services_analysis_disabled = \"0\""); 
foreach($data as $data_item) {

echo "				<tr class=\"even\">";
echo "					<td>$data_item[security_services_analysis_control_name]</td>";
echo "					<td>$data_item[security_services_analysis_fa]</td>";
echo "					<td>$data_item[security_services_analysis_opex] $services_conf[system_currency]</td>";
echo "					<td>$data_item[security_services_analysis_contracts] $services_conf[system_currency]</td>";
echo "					<td>$data_item[security_services_analysis_capex] $services_conf[system_currency]</td>";
echo "					<td>$data_item[security_services_analysis_classification_name]</td>";
echo "					<td>$data_item[security_services_analysis_risk_asset]</td>";
echo "					<td>$data_item[security_services_analysis_tp_risk]</td>";
echo "					<td>$data_item[security_services_analysis_data_flows]</td>";
echo "					<td>$data_item[security_services_analysis_compliance]</td>";
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
