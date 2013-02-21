	
<?

	include_once("lib/service_contracts_lib.php");
	include_once("lib/general_classification_lib.php");
	include_once("lib/bu_lib.php");
	include_once("lib/asset_type_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/legal_lib.php");
	include_once("lib/asset_classification_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$service_contracts_id= $_GET["service_contracts_id"];
	$service_contracts_provider_id = $_GET["service_contracts_provider_id"];
	
	$base_url_list = build_base_url($section,"service_contracts_list");

	if (is_numeric($service_contracts_id)) {
		$service_contracts_item = lookup_service_contracts("service_contracts_id",$service_contracts_id);
	}

?>

	<section id="content-wrapper">
		<h3>Edit or Create a Service Contract</h3>
		<span class="description">Describe the support contracts you have with this providers. You can at a later stage, asociate this support contracts with security services as well.</span>
				
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
<?
#echo "					<a href=\"$base_url&action=edit&service_contracts_id=$service_contracts_item[service_contracts_id]\">General</a>";
?>
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">
<?
echo "					<form name=\"service_contracts_edit\" method=\"GET\" action=\"$base_url_list\">";
?>

						<label for="name">Service Contract Name</label>
						<span class="description">Give a name to the contract you have in between this provider and your organization. Examples: Firewall Hardware Support, Firewall Consulting Time, Etc.</span>
<?
echo "						<input class=\"filter-text\" type=\"text\" name=\"service_contracts_name\" id=\"\" value=\"$service_contracts_item[service_contracts_name]\"/>";
?>
						
						<label for="description">Description</label>
						<span class="description">Provide a description of the service contract scope, Etc.</span>
<?
echo "						<textarea class=\"filter-text\" id=\"\" name=\"service_contracts_description\">$service_contracts_item[service_contracts_description]</textarea>";
?>
						
						<label for="description">Service Value</label>
						<span class="description">Record the service contract value, how much money you are paying for this?</span>
<?
echo "						<input class=\"filter-text\" type=\"text\" name=\"service_contracts_value\" id=\"\" value=\"$service_contracts_item[service_contracts_value]\"/>";
?>
						
				<label for="name">Service Contract Start Date</label>
				<span class="description">Service contracts usually have a start and end dates. This will help you to keep track of renovations (altough service providers are quite good at reminding that to us ... right?) ... the date format is YYYY-MM-DD</span>
<?
echo "						<input class=\"filter-date datepicker\" type=\"text\" name=\"service_contracts_start\" value=\"$service_contracts_item[service_contracts_start]\"/>";
?>

				<label for="name">Service Contract Start Date</label>
				<span class="description">Service contracts usually have a start and end dates. This will help you to keep track of renovations (altough service providers are quite good at reminding that to us ... right?) ... the date format is YYYY-MM-DD</span>
<?
echo "						<input class=\"filter-date datepicker\" type=\"text\" name=\"service_contracts_end\" value=\"$service_contracts_item[service_contracts_end]\"/>";
?>

				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">
				    <INPUT type="hidden" name="action" value="update_service_contracts">
				    <INPUT type="hidden" name="section" value="security_services">
				    <INPUT type="hidden" name="subsection" value="service_contracts_list">
<?
 echo " 			    <INPUT type=\"hidden\" name=\"service_contracts_id\" value=\"$service_contracts_item[service_contracts_id]\">"; 
 echo " 			    <INPUT type=\"hidden\" name=\"service_contracts_provider_id\" value=\"$service_contracts_provider_id\">"; 
?>
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
