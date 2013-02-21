<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/asset_classification_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$asset_classification_id = $_GET["asset_classification_id"];
	
	$base_url_edit = build_base_url($section,"asset_classification_edit");
	$base_url_list = build_base_url($section,"asset_classification_list");

	if (is_numeric($asset_classification_id)) {
		$asset_classification_item = lookup_asset_classification("asset_classification_id",$asset_classification_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create an Asset Classification</h3>
		<span class="description">Usually there's many assets around in a organization. Trough classification (according to <i>your</i> needs) you will be able to set priorities and profile them in a way their treatment and handling is systematic. Btw, this is a basic requirement for most Security related regulations.</span>
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
echo "					<form name=\"asset_classification_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="applicable">Classification Type</label>
						<span class="description">This is the begining of the classification of assets. Let's say you are clasifying cars, an example of "Type" could be "Size". Later, you will name several options (names) for that Type of classification, such as "Big". "Small", Etc. Most regulations and standards require classifications such as "Confidentiality, Sensibility or Integrity" level, Etc. If you havent created a Classification type before, you will need to create one.</span>
						<select id="applicable" name="asset_classification_type"class="chzn-select">
<?
						asset_classification_type_html_drop_menu("$asset_classification_item[asset_classification_type]","");
?>
						</select>
						<span class="description">or name a new type (this option superseeds any previous selection):</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"asset_classification_type_new\" id=\"asset_classification_criteria_new\" value=\"\"/>";?>
						<label for="name">Name</label>
						<span class="description">You will need to create a name for your classification. Examples could be "High", "Low", etc.</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"asset_classification_name\" id=\"asset_classification_name\" value=\"$asset_classification_item[asset_classification_name]\"/>";?>
						
						<label for="description">Classification Criteria</label>
						<span class="description">Very important. It's crucial when classifying to be <i>consistent</i> with the criteria you use to say a given asset is one or another type. Ideally your criteria should be simple and practical. Dont get too creative here. Examples: "The asset worth is higher than a 40k EUR", "The disclosure of this asset could mean legal actions against the company", Etc.</span>
<? echo "						<textarea name=\"asset_classification_criteria\">$asset_classification_item[asset_classification_criteria]</textarea>";?>
						<label for="name">Value</label>
						<span class="description">At a later stage of your classification (and Risk Management) this will be useful to give numerical priorities to each classificatoin type, Etc. Values represent the significant of this classification. Examples could be 3, 5, 1, Etc. Note: dont use 0! Default if not completed is 1.</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"asset_classification_value\" id=\"asset_classification_value\" value=\"$asset_classification_item[asset_classification_value]\"/>";?>
						

				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="asset">
				    <INPUT type="hidden" name="subsection" value="asset_classification_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"asset_classification_id\" value=\"$asset_classification_item[asset_classification_id]\">"; ?>
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
