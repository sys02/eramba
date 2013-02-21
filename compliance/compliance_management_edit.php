<?

	include_once("lib/security_services_lib.php");
	include_once("lib/compliance_item_security_service_join_lib.php");
	include_once("lib/compliance_management_lib.php");
	include_once("lib/compliance_exception_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/compliance_response_strategy_lib.php");
	include_once("lib/compliance_status_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$tp_id = $_GET["tp_id"];
	$compliance_package_item= $_GET["compliance_package_item"];
	
	$base_url_list = build_base_url($section,"compliance_management_step_two");

	if (is_numeric($compliance_package_item)) {
		$compliance_management_item = lookup_compliance_management("compliance_management_item_id",$compliance_package_item);
	}

?>

	<section id="content-wrapper">
		<h3>Mitigate a Compliance Item</h3>
		<span class="description">Select which mitigation strategy (response) you'll provide to this compliance package item and what's the regulator feedback on this particular item (status)</span>
				
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">
<?
echo "					<form name=\"risk_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="legalType">Compliance Response Strategy</label>
						<span class="description">What's your mitigation strategy for this compliance item</span>
						<select name="compliance_management_response_id" id="" class="chzn-select">
						<option value="-1">Select a Strategy...</option>
<?
						list_drop_menu_compliance_response_strategy($compliance_management_item[compliance_management_response_id],"compliance_response_strategy_name");	
?>
						</select>

						<label for="legalType">Compensating Controls</label>
						<span class="description">Choose the most suitable available compensating controls (you can select multiple)</span>
	                                        <select name="compliance_security_services_join_security_services_id[]" id="" class="chzn-select" multiple="multiple">

						<option value="-1">Select a Compensating Control...</option>
<?
	$pre_selected_security_services_list = list_compliance_item_security_services_join(" WHERE compliance_security_services_join_compliance_id = \"$compliance_management_item[compliance_management_item_id]\"");	
	$pre_selected_items = array();

	foreach($pre_selected_security_services_list as $pre_selected_security_services_item) {
		array_push($pre_selected_items,$pre_selected_security_services_item[compliance_security_services_join_security_services_id]);
	}

	list_drop_menu_security_services($pre_selected_items,"security_services_name");	
?>
						</select>
						
						<label for="legalType">Compliance Exception</label>
						<span class="description">When no compensating control has been identified for this requirement, it's recomended to asociate a compliance exception</span>
						<select name="compliance_management_exception_id" id="" class="">
						<option value="-1">Select a Compensating Control...</option>
<?

			list_drop_menu_compliance_exception($compliance_management_item[compliance_management_exception_id],"compliance_exception_id");	
?>
						</select>
						
						<label for="legalType">Compliance Status</label>
						<span class="description">What's the agreed (with the regulator) status of this compliance item?</span>
						<select name="compliance_management_status_id" id="" class="chzn-select">
						<option value="-1">Select Status</option>
<?
			list_drop_menu_compliance_status($compliance_management_item[compliance_management_status_id],"compliance_status_id");	
?>
						</select>

				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">
				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_management_step_two">
<? echo "			    <INPUT type=\"hidden\" name=\"compliance_management_id\" value=\"$compliance_management_item[compliance_management_id]\">"; ?>
<? echo "			    <INPUT type=\"hidden\" name=\"compliance_management_item_id\" value=\"$compliance_package_item\">"; ?>
<? echo "			    <INPUT type=\"hidden\" name=\"tp_id\" value=\"$tp_id\">"; ?>

			<a>
			    <INPUT type="submit" value="Submit" class="add-btn"> 
			</a>
			
<?
echo "			<a href=\"$base_url_list\" class=\"cancel-btn\">";
?>
				Cancel
				<span class="select-icon"></span>
			</a>
</form>
		</div>
		
		<br class="clear"/>
		
	</section>
</body>
</html>
