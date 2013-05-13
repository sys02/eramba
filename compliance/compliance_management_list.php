<?

	include_once("lib/site_lib.php");
	include_once("lib/compliance_package_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_step_two = build_base_url($section,"compliance_management_step_two");

?>


	<section id="content-wrapper">
		<h3>Compliance Management</h3>
		<span class="description">Select the third party who wish to work with</span>
		<div class="tab-wrapper"> 
		<br> 	


		<table class="main-table">
			<thead>
				<tr>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th><a class=\"asc\">Compliance Package</th>";
echo "					<th>% Mitigated</th>";
echo "					<th>% NA</th>";
echo "					<th>% Missing Controls</th>";
echo "					<th>% Failed Controls</th>";
echo "					<th>% Comp. On-Going</th>";
echo "					<th>% Compliant</th>";
echo "					<th>% Non-Compliant</th>";
echo "					<th>% Comp. N/A</th>";
echo "					<th># Incident</th>";
?>
				</tr>
			</thead>
	

<?

echo "			<tbody>";

$list_compliance_package = list_compliance_package_unique();

foreach($list_compliance_package as $list_compliance_package_item) { 


	$package_name = lookup_tp("tp_id", $list_compliance_package_item[compliance_package_tp_id]); 
	$no_controls = ( compliance_rate_missing_controls($list_compliance_package_item[compliance_package_tp_id]) * 100 );
	$failed_controls = ( compliance_rate_failed_controls($list_compliance_package_item[compliance_package_tp_id]) * 100 );
	$strategy_response = compliance_rate_strategy_mitigate($list_compliance_package_item[compliance_package_tp_id]);
	$incident = list_security_incident(" WHERE security_incident_disabled = \"0\" and security_incident_tp_id = \"$package_name[tp_id]\"");


echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$package_name[tp_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_step_two&action=start_compliance_management&tp_id=$package_name[tp_id]\">Analyse</a> ";
echo "						</div>";
echo "					</td>";
echo "					<td>".round($strategy_response[0]*100,2)." %</td>";
echo "					<td>".round($strategy_response[1]*100,2)." %</td>";
echo "					<td>$no_controls %</td>";
echo "					<td>$failed_controls %</td>";
echo "					<td>".round($strategy_response[2]*100,2)." %</td>";
echo "					<td>".round($strategy_response[3]*100,2)." %</td>";
echo "					<td>".round($strategy_response[4]*100,2)." %</td>";
echo "					<td>".round($strategy_response[5]*100,2)." %</td>";
echo "					<td>".count($incident)."</td>";
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
