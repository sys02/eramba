<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/asset_label_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$asset_label_id = $_GET["asset_label_id"];
	
	$base_url_list = build_base_url($section,"asset_label_list");

	if (is_numeric($asset_label_id)) {
		$asset_label_item = lookup_asset_label("asset_label_id",$asset_label_id);
	}

?>

	<section id="content-wrapper">
		<h3>Edit or Create an Asset Label Classification</h3>
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
echo "					<form name=\"asset_label_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name</label>
						<span class="description">You will need to create a name for your classification. Examples could be "Confidential", "Classified", etc.</span>
<? echo "						<input type=\"text\" name=\"asset_label_name\" id=\"asset_label_name\" value=\"$asset_label_item[asset_label_name]\"/>";?>
						
						<label for="description">Classification Criteria</label>
						<span class="description">Very important. It's crucial when classifying to be <i>consistent</i> with the criteria you use to say a given risk is one or another type. Ideally your criteria should be simple and practical. I wouldnt get too creative here.</span>
<? echo "						<textarea name=\"asset_label_criteria\">$asset_label_item[asset_label_criteria]</textarea>";?>
						

				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="asset">
				    <INPUT type="hidden" name="subsection" value="asset_label_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"asset_label_id\" value=\"$asset_label_item[asset_label_id]\">"; ?>

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
