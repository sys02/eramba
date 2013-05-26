	
<?
	include_once("lib/security_services_status_lib.php");
	## include_once("lib/security_services_maintenance_calendar_lib.php");
	include_once("lib/security_services_audit_calendar_lib.php");
	include_once("lib/security_services_catalogue_audit_calendar_join_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/general_classification_lib.php");
	include_once("lib/bu_lib.php");
	include_once("lib/asset_type_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/legal_lib.php");
	include_once("lib/asset_classification_lib.php");
	include_once("lib/security_services_classification_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/service_contracts_lib.php");
	include_once("lib/service_contracts_security_service_join_lib.php");
	include_once("lib/security_services_catalogue_maintenance_calendar_join_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$security_services_id= isset( $_GET["security_services_id"] ) ? $_GET["security_services_id"] : $_GET["security_catalogue_id"];
	
	$base_url_list = build_base_url($section,"security_catalogue_list");
	$base_url_edit = build_base_url($section,"security_catalogue_edit");

	if (is_numeric($security_services_id)) {
		$security_services_item = lookup_security_services("security_services_id",$security_services_id);
	}

?>

	<section id="content-wrapper">
		<h3>Edit or Create a Security Service</h3>
		<span class="description">Pretty much the same way a restaurant has a menu, a security program has a menu of services and even sometimes products. It's very important to know what security services your program has, since it's the core of it's delivery and must be well understood and managed.</span>
				
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
<?
#echo "					<a href=\"$base_url&action=edit&security_services_id=$security_services_item[security_services_id]\">General</a>";
?>
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">
<?
echo "					<form name=\"security_services_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name of the Service</label>
						<span class="description">Give a name to the service your program is intended to deliver. Examples: Internet Gateways, Encryption, Physical Lockers, Etc.</span>
<?
echo "						<input type=\"text\" class=\"\" name=\"security_services_name\" id=\"\" value=\"$security_services_item[security_services_name]\"/>";
?>
						
						<label for="description">Service Objective</label>
						<span class="description">Give a brief description on what this services does. It's sometimes usefull to answer, what happens if the service wouldnt be available?</span>
<?
echo "						<textarea id=\"\" name=\"security_services_objective\" class=\"\">$security_services_item[security_services_objective]</textarea>";
?>
						
						<label for="legalType">Service Status</label>
						<span class="description">The objective is to understand on what status this service is: Proposed (Just a good idea that needs to be validated and drafted), Design (there's budget and a business case, so it's time to design), Transition (the design is moving towards an implementation), Production (the service is working, metrics are being taken, etc), Retired (the service is no longer used)</span>
						<select name="security_services_status" id="" class="chzn-select">
						<option value="-1">Select the Service Status</option>
<?
						list_drop_menu_security_services_status($security_services_item[security_services_status],"security_services_status_id");	
?>
						</select>
						
						<label for="legalType">Service Classification</label>
						<span class="description">Use a pre-defined classification criteria as a priotization tool</span>
						<select name="security_services_classification_id" id="" class="chzn-select">
						<option value="-1">Select the Service Classification</option>
<?
						list_drop_menu_security_services_classification($security_services_item[security_services_classification_id],"security_services_classification_id");	
?>
						</select>
						
						<label for="description">Service Documentation</label>
						<span class="description">Document the URLs or links where to find the documentation for each lifecycle phase: Proposed (business case, emails, etc), Design (design documents, budgets, costs, etc), Transition (operational manuals, etc).</span>
<?
echo "						<textarea class=\"\" id=\"\" name=\"security_services_documentation_url\">$security_services_item[security_services_documentation_url]</textarea>";
?>
						
						<label for="legalType">Audit Metrics</label>
						<span class="description">What needs to be measured in order to determine if the service is doing what it should</span>
<?
				if (empty($security_services_item[security_services_audit_metric])) { 
echo "				<textarea class=\"\" id=\"\" name=\"security_services_audit_metric\">Describe the metric</textarea>";
				} else {
echo "				<textarea class=\"\" id=\"\" name=\"security_services_audit_metric\">$security_services_item[security_services_audit_metric]</textarea>";
				}

?>
						<label for="legalType">Sucess Criteria</label>
						<span class="description">What should be the outcome of the metric in order to consider it acceptable?</span>

<?

				if (empty($security_services_item[security_services_audit_metric])) { 
echo "				<textarea class=\"\" id=\"\" name=\"security_services_audit_success_criteria\">Describe the metric success criteria</textarea>";
				} else {
echo "				<textarea class=\"\" id=\"\" name=\"security_services_audit_success_criteria\">$security_services_item[security_services_audit_success_criteria]</textarea>";
				}
?>
				<label for="name">Metric Regular Review (Audit)</label>
				<span class="description">Trust but control, that's my mother in law piece of advice was for my wife... At regular intervals, it's a very good idea to audit (internaly or by third parties) the security services by the use of their metrics. Choose one or many months on which you'll each year review this service.</span>
						<select name="security_services_audit_calendar[]" id="" class="" multiple="multiple">
<?
	$pre_selected_list = list_security_services_catalogue_audit_calendar_join(" WHERE security_service_catalogue_id = \"$security_services_item[security_services_id]\""); 
	$pre_selected_items = array();
	foreach($pre_selected_list as $pre_selected_audits) {
			array_push($pre_selected_items,$pre_selected_audits[security_services_audit_calendar_id]);
	}
	list_drop_menu_security_services_audit_calendar($pre_selected_items, "");	
?>
						</select>

						<label for="legalType">Service Maintenance</label>
						<span class="description">Some human managed controls require regular maintenance tasks .. some examples are User Reviews, Analysis of Logs, etc. This helps to set how regular those controls are so no-one forgets</span>
<?
echo "				<textarea class=\"\" id=\"\" name=\"security_services_regular_maintenance\">$security_services_item[security_services_regular_maintenance]</textarea>";

?>
				<label for="name">Maintenance Peridiocity</label>
				<span class="description">Define how often this maintenance should be done</span>
						<select name="security_services_maintenance_calendar[]" id="" class="" multiple="multiple">
<?
	$pre_selected_list = list_security_services_catalogue_maintenance_calendar_join(" WHERE security_service_catalogue_id = \"$security_services_item[security_services_id]\""); 
	$pre_selected_items = array();
	foreach($pre_selected_list as $pre_selected_maintenances) {
			array_push($pre_selected_items,$pre_selected_maintenances[security_services_maintenance_calendar_id]);
	}
	list_drop_menu_security_services_audit_calendar($pre_selected_items, "");	
?>
						</select>

		<label for="name">Service Cost (OPEX)</label>
		<span class="description">For those of you who must keep budgets tidy, it's important to keep as clear as possible how much effort is required to operate the service in financial (OPEX).</span>

<?
				if (empty($security_services_item[security_services_cost_opex])) { 
echo "				<input type=\"text\" class=\"\" name=\"security_services_cost_opex\" value=\"\"/>";
				} else {
echo "				<input type=\"text\" class=\"\" name=\"security_services_cost_opex\" value=\"$security_services_item[security_services_cost_opex]\"/>";
				}

echo "		<label for=\"name\">Service Cost (CAPEX)</label>";
echo "		<span class=\"description\">For those of you who must keep budgets tidy, it's important to keep as clear as possible how much effort is required to operate the service in financial (CAPEX)</span>";

				if (empty($security_services_item[security_services_cost_capex])) { 
echo "				<input type=\"text\" class=\"\" name=\"security_services_cost_capex\" value=\"\"/>";
				} else {
echo "				<textarea class=\"\" id=\"\" name=\"security_services_cost_capex\">$security_services_item[security_services_cost_capex]</textarea>";
				}

echo "		<label for=\"name\">Service Cost (Resource Utilization)</label>";
echo "		<span class=\"description\">How many days of your resources this control consumes over a year? Think on defining, communicating, fixing, auditing, operating and reviewing the controls.</span>";



				if (empty($security_services_item[security_services_cost_operational_resource])) { 
echo "				<input type=\"text\" class=\"\" name=\"security_services_cost_operational_resource\" value=\"\"/>";
				} else {
echo "				<input type=\"text\" class=\"\" name=\"security_services_cost_operational_resource\" value=\"$security_services_item[security_services_cost_operational_resource]\"/>";
				}
?>
		
		<label for="name">Service Contracts</label>
		<span class="description">You are able to choose service contracts that are related to this security service.</span>
		<select name="service_contracts_id[]" id="" class="" multiple="multiple">

<?

	$pre_selected_list = list_service_contracts_security_services(" WHERE security_services_id = \"$security_services_item[security_services_id]\""); 
	$pre_selected_items = array();
	foreach($pre_selected_list as $pre_selected_service_contracts) {
			array_push($pre_selected_items,$pre_selected_service_contracts[service_contracts_id]);
	}
	#print_r($pre_selected_items);
	list_drop_menu_service_contracts($pre_selected_items, "");	
?>
						</select>
	


				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">
				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="security_services">
				    <INPUT type="hidden" name="subsection" value="security_catalogue_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"security_services_id\" value=\"$security_services_item[security_services_id]\">"; ?>
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
