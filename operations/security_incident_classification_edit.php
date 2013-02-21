<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/security_incident_classification_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$security_incident_classification_id = $_GET["security_incident_classification_id"];
	
	$base_url_list = build_base_url($section,"security_incident_classification_list");

	if (is_numeric($security_incident_classification_id)) {
		$security_incident_classification_item = lookup_security_incident_classification("security_incident_classification_id",$security_incident_classification_id);
	}

?>

	<section id="content-wrapper">
		<h3>Edit or Create an Security Incident Classification</h3>
		<span class="description">Define your Security Incident Classification</span>
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
echo "					<form name=\"security_incident_classification_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name</label>
						<span class="description">You will need to create a name for your classification. Examples could be "High", "Low", etc.</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"security_incident_classification_name\" id=\"security_incident_classification_name\" value=\"$security_incident_classification_item[security_incident_classification_name]\"/>";?>
						
						<label for="description">Classification Criteria</label>
						<span class="description">Very important. It's crucial when classifying to be <i>consistent</i> with the criteria you use to say a given risk is one or another type. Ideally your criteria should be simple and practical. Dont get too creative here. Examples: "The risk worth is higher than a 40k EUR", "The disclosure of this risk could mean legal actions against the company", Etc.</span>
<? echo "						<textarea name=\"security_incident_classification_criteria\" class=\"filter-text\">$security_incident_classification_item[security_incident_classification_criteria]</textarea>";?>
						

				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="operations">
				    <INPUT type="hidden" name="subsection" value="security_incident_classification_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"security_incident_classification_id\" value=\"$security_incident_classification_item[security_incident_classification_id]\">"; ?>

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
