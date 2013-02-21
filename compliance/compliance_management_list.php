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
<?
echo "					<form name=\"asset_classification_edit\" method=\"GET\" action=\"$base_url_step_two\">";
?>
						<select id="applicable" name="tp_id" class="chzn-select">
<?
		$compliance_package_provider_name_list = list_compliance_package_unique();
		foreach($compliance_package_provider_name_list as $compliance_package_provider_name_item) {
			$provider_id = lookup_tp("tp_id",$compliance_package_provider_name_item[compliance_package_tp_id]);
			echo "<option value=\"$provider_id[tp_id]\">$provider_id[tp_name]</option>\n";
		}
?>
						</select>
	<br>
	<br>

		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="start_compliance_management">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_management_step_two">
			<a>
			    <INPUT type="submit" value="Submit" class="add-btn"> 
			</a>
			
					</form>
		</div>
		
		<br class="clear"/>
		
	</section>
</body>
</html>
