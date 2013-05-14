<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/security_services_classification_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$security_services_classification_id = $_GET["security_services_classification_id"];
	
	$base_url_list = build_base_url($section,"security_services_classification_list");

	if (is_numeric($security_services_classification_id)) {
		$security_services_classification_item = lookup_security_services_classification("security_services_classification_id",$security_services_classification_id);
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
echo "					<form name=\"security_services_classification_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name</label>
						<span class="description">You will need to create a name for your classification. Examples could be "High", "Low", etc.</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"security_services_classification_name\" id=\"security_services_classification_name\" value=\"$security_services_classification_item[security_services_classification_name]\"/>";?>
						
						<label for="description">Classification Criteria</label>
						<span class="description">Provide a descriptive and clear classification criteria</span>
<? echo "						<textarea name=\"security_services_classification_criteria\" class=\"filter-text\">$security_services_classification_item[security_services_classification_criteria]</textarea>";?>
						

				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="security_services">
				    <INPUT type="hidden" name="subsection" value="security_services_classification_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"security_services_classification_id\" value=\"$security_services_classification_item[security_services_classification_id]\">"; ?>

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
