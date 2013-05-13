<?

	include_once("lib/security_incident_lib.php");
	include_once("lib/security_incident_classification_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/security_incident_service_lib.php");
	include_once("lib/general_classification_lib.php");
	include_once("lib/security_incident_status_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/tp_lib.php");
	include_once("lib/asset_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$security_incident_id = $_GET["security_incident_id"];
	
	$base_url_list = build_base_url($section,"security_incident_list");

	if (is_numeric($security_incident_id)) {
		$security_incident_item = lookup_security_incident("security_incident_id",$security_incident_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Security Incidents</h3>
		<span class="description">Use this form to create or edit Security Incidents</span>
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
echo "					<form name=\"edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Security Incident Title</label>
						<span class="description">Give the Securty Incident a title, name or code so it's easily identified on the list list menu</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"security_incident_title\" id=\"security_incident_title\" value=\"$security_incident_item[security_incident_title]\"/>";?>
						
	<label for="description">Incident Description</label>
	<span class="description">Describe the Security Incident in detail (when, what, where, why, whom, how).</span>
<? echo "<textarea name=\"security_incident_description\" class=\"filter-text\">$security_incident_item[security_incident_description]</textarea>";?>
	
	<label for="legalType">Third Parties Affected</label>
	<span class="description"></span>
	<select name="security_incident_tp_id" id="" class="chzn-select">
	<option value="-1">Select the affected Third Party (If any)</option>
<?
	list_drop_menu_tp($security_incident_item[security_incident_tp_id],"tp_name");	
?>
	</select>
	
	<label for="legalType">Incident Classification</label>
	<span class="description"></span>
	<select name="security_incident_classification_id" id="" class="chzn-select">
	<option value="-1">Select the Incident Classification</option>
<?
	list_drop_menu_security_incident_classification($security_incident_item[security_incident_classification_id],"security_incident_classification_id");	
?>
	</select>
	
	<label for="legalType">Compromised Asset</label>
	<span class="description">Describe an asset from the list of registered asset that best represents the assets being affected by this incident</span>
	<select name="security_incident_compromised_asset_id" id="" class="chzn-select">
	<option value="-1">Select an Asset</option>
<?
	list_drop_menu_asset($security_incident_item[security_incident_compromised_asset_id],"asset_id");	
?>
	</select>


	<label for="legalType">Compensating Controls</label>
	<span class="description">Select those controls involved on this incident</span>
	<select name="security_incident_service[]" id="" class="chzn-select" multiple="multiple">
	<option value="-1">Select one or more Controls...</option>
<?
	$pre_selected_security_services_list = list_security_incident_service_join(" WHERE security_incident_service_incident_id = \"$security_incident_item[security_incident_id]\"");	
	$pre_selected_items = array();
	foreach($pre_selected_security_services_list as $pre_selected_security_services_item) {
		array_push($pre_selected_items,$pre_selected_security_services_item[security_incident_service_service_id]);
	}
	list_drop_menu_security_services($pre_selected_items,"security_services_name");	
?>
	</select>
	
						
	<label for="description">Security Incident Owner</label>
	<span class="description">Describe who is assigned on this incident and is responsible for it's treatment</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"security_incident_owner_id\" id=\"security_incident_owner\" value=\"$security_incident_item[security_incident_owner_id]\"/>";?>
						
	<label for="description">Security Incident Open Date</label>
	<span class="description">Describe the time when the Incident has been reported</span>
<? echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"security_incident_open_date\" id=\"security_incident_open_date\" value=\"$security_incident_item[security_incident_open_date]\"/>";?>
	
	<label for="description">Security Incident Closure Date</label>
	<span class="description">Describe the time when the Incident has been closed</span>
<? echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"security_incident_closure_date\" id=\"security_incident_closure_date\" value=\"$security_incident_item[security_incident_closure_date]\"/>";?>
						
	<label for="legalType">Incident Status</label>
	<span class="description"></span>
	<select name="security_incident_status_id" id="" class="chzn-select">
	<option value="-1">Select the Incident Status</option>
<?
	list_drop_menu_security_incident_status($security_incident_item[security_incident_status_id],"security_incident_status_id");	
?>
	</select>

			</div>
			<div class="tab" id="tab2">
				advanced tab
			</div>
		</div>
	</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="edit">
				    <INPUT type="hidden" name="section" value="operations">
				    <INPUT type="hidden" name="subsection" value="security_incident_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"security_incident_id\" value=\"$security_incident_item[security_incident_id]\">"; ?>
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
