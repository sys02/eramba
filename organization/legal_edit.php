<?

	include_once("lib/legal_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$legal_id = $_GET["legal_id"];
	
	$base_url_list = build_base_url($section,"legal_list");
	$base_url_edit  = build_base_url($section,"legal_edit");

	if (is_numeric($legal_id)) {
		$legal_item = lookup_legal("legal_id",$legal_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Legal Constrain</h3>
		<span class="description">It's critical to understand the business potential liabilities and regulations to which is subject. In particular this is important at the time of managing a Business Continuity Management (BCM) program and Risk Management.</span>
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
echo "					<form name=\"legal_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name</label>
						<span class="description">Give a name to the legal constrain. Examples: Data Privacy Regulations, Customer Contractual Agreements, Etc. </span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"legal_name\" id=\"legal_name\" value=\"$legal_item[legal_name]\"/>";?>
						
						<label for="description">Description</label>
						<span class="description">Describe what this legal constrain is about so everyone understands.</span>
<? echo "						<textarea class=\"filter-text\" name=\"legal_description\">$legal_item[legal_description]</textarea>";?>
				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="organization">
				    <INPUT type="hidden" name="subsection" value="legal_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"legal_id\" value=\"$legal_item[legal_id]\">"; ?>

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
