<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/risk_classification_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$risk_classification_id = $_GET["risk_classification_id"];
	
	$base_url_list = build_base_url($section,"risk_classification_list");

	if (is_numeric($risk_classification_id)) {
		$risk_classification_item = lookup_risk_classification("risk_classification_id",$risk_classification_id);
	}

	echo "	<script type=\"text/javascript\" src=\"js/disable_elements.js\"></script>";

?>


	<section id="content-wrapper">
		<h3>Edit or Create an Asset Classification</h3>
		<span class="description">Usually there's many risks around in a organization. Trough classification (according to <i>your</i> needs) you will be able to set priorities and profile them in a way their treatment and handling is systematic. Btw, this is a basic requirement for most Security related regulations.</span>
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
echo "					<form name=\"risk_classification_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="applicable">Classification Type</label>
						<span class="description">This is the begining of the classification of risks. Let's say you are clasifying cars, an example of "Type" could be "Size". Later, you will name several options (names) for that Type of classification, such as "Big". "Small", Etc. Most regulations and standards require classifications such as "Confidentiality, Sensibility or Integrity" level, Etc. If you havent created a Classification type before, you will need to create one.</span>
						<select id="applicable" name="risk_classification_type"class="chzn-select">
<?
						risk_classification_type_html_drop_menu("$risk_classification_item[risk_classification_type]","");
?>
						</select>
						<span class="description">or name a new type (this option superseeds any previous selection):</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"risk_classification_type_new\" id=\"risk_classification_criteria_new\" value=\"\"/>";?>
						<label for="name">Name</label>
						<span class="description">You will need to create a name for your classification. Examples could be "High", "Low", etc.</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"risk_classification_name\" id=\"risk_classification_name\" value=\"$risk_classification_item[risk_classification_name]\"/>";?>
						
						<label for="description">Classification Criteria</label>
						<span class="description">Very important. It's crucial when classifying to be <i>consistent</i> with the criteria you use to say a given risk is one or another type. Ideally your criteria should be simple and practical. Dont get too creative here. Examples: "The risk worth is higher than a 40k EUR", "The disclosure of this risk could mean legal actions against the company", Etc.</span>
<? echo "						<textarea name=\"risk_classification_criteria\" class=\"filter-text\">$risk_classification_item[risk_classification_criteria]</textarea>";?>
						<label for="name">Value</label>
						<span class="description">At a later stage of your classification (and Risk Management) this will be useful to give numerical priorities to each classificatoin type, Etc. Values represent the significant of this classification. Examples could be 3, 5, 1, Etc. Note: dont use 0! Default if not completed is 1.</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"risk_classification_value\" id=\"risk_classification_value\" value=\"$risk_classification_item[risk_classification_value]\"/>";?>
						

				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="risk">
				    <INPUT type="hidden" name="subsection" value="risk_classification_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"risk_classification_id\" value=\"$risk_classification_item[risk_classification_id]\">"; ?>

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
