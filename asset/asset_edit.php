<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/bu_lib.php");
	include_once("lib/asset_bu_join_lib.php");
	include_once("lib/asset_type_lib.php");
	include_once("lib/asset_label_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/legal_lib.php");
	include_once("lib/asset_classification_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$asset_id= $_GET["asset_id"];
	
	$base_url_edit = build_base_url($section,"asset_edit");
	$base_url_list = build_base_url($section,"asset_list");

	if (is_numeric($asset_id)) {
		$asset_item = lookup_asset("asset_id",$asset_id);
	}

?>

	<section id="content-wrapper">
		<h3>Edit or Create an Asset</h3>
		<span class="description">Identifing assets is perhaps one of the most important tasks for a Security Program. It all revolves around understanding what is that the program intends to protect. You might need to ask yourselfeve the 5w + 1H (Why, Where, What, When, Who and How!) for each single piece of assets it's <i>reasonable</i> to spend time with.</span>
				
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
<?
#echo "					<a href=\"$base_url&action=edit&asset_id=$asset_item[asset_id]\">General</a>";
?>
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">
<?
echo "					<form name=\"asset_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name</label>
						<span class="description">Give a name to the asset your program is intended to protect.</span>
<?
echo "						<input type=\"text\" class=\"filter-text\" name=\"asset_name\" id=\"\" value=\"$asset_item[asset_name]\"/>";
?>
						
						<label for="legalType">Related BUs</label>
						<span class="description">Choose one (or many) BU that is related to this Asset</span>
						<select name="asset_bu_join[]" id="" class="chzn-select" multiple="multiple">
						<option value="-1">Select a BU...</option>
<?
			$pre_selected_bu_list = list_asset_bu_join(" WHERE asset_bu_join_asset_id = \"$asset_item[asset_id]\"");	
			$pre_selected_items = array();
			foreach($pre_selected_bu_list as $pre_selected_bu_item) {
				array_push($pre_selected_items,$pre_selected_bu_item[asset_bu_join_bu_id]);
			}
			list_drop_menu_bu($pre_selected_items,"bu_name");	
?>
						</select>
						
						<label for="description">Description</label>
						<span class="description">Give a brief description on what the asset is.</span>
<?
echo "						<textarea id=\"\" name=\"asset_description\" class=\"filter-text\">$asset_item[asset_description]</textarea>";
?>

						<label for="legalType">Asset Label</label>
						<span class="description">Choose a label from your asset label classification</span>
						<select name="asset_label_id" id="asset_label_id" class="chzn-select">
						<option value="-1">Select a label</option>
<?
						list_drop_menu_asset_label($asset_item[asset_label_id],"asset_label_name");	
?>
						</select>
						
						<label for="legalType">Asset Type</label>
						<span class="description">This one is important. There's an obvious difference in between what <a href="http://dictionary.cambridge.org/dictionary/british/data?q=data" target="_blank">data</a> and an <a href="http://dictionary.cambridge.org/dictionary/british/asset?q=asset" target="_blank">asset</a> is. Data is an asset. An asset is not necesarily data. Examples: Credit Card Numbers, Invoices, Personal Information, Project Names, Etc are data (and potentially assets too). Windows servers, chairs, computers, etc are most likely assets for your program.</span>
						<select name="asset_media_type_id" id="asset_media_type" class="chzn-select">
						<option value="-1">Select Asset Type</option>
<?
						list_drop_menu_asset_media_type($asset_item[asset_media_type_id],"asset_media_type_name");	
?>
						</select>
						
						<label for="legalType">Applicable Liabilities</label>
						<span class="description">In the unlikely case of un-authorized disclosure or questionable integrity, confidentialiy or availability it might be that some liabilities might affect the asset. List the most significant (previously defined under Organization).</span>
						<select name="asset_legal_id" id="asset_liabiliites" class="chzn-select">
						<option value="0">No liabilities</option>
<?
						list_drop_menu_legal($asset_item[asset_legal_id],"legal_name");	
?>
						</select>

						<label for="legalType">Owners, Guardians and Users</label>
						<span class="description">Try to define, under which bussiness organizations the Owners, Guardians (On whom's responsability is the adequated availability of the asset) of the assets and Users.</span>
						<select name="asset_owner_id" id="" class="chzn-select">
						<option value="-1">Select an Owner...</option>
<?
						list_drop_menu_bu($asset_item[asset_owner_id],"bu_name");	
?>
						</select>
						<br>
						<select name="asset_guardian_id" id="" class="chzn-select">
						<option value="-1">Select a Guardian...</option>
<?
						list_drop_menu_bu($asset_item[asset_guardian_id],"bu_name");	
?>
						</select>
						<br>
						<select name="asset_user_id" id="" class="chzn-select">
						<option value="-1">Select a User...</option>
						<option value="0">Everyone!<option>
<?
						list_drop_menu_bu($asset_item[asset_user_id],"bu_name");	
?>
						</select>
						<br>
						<label for="legalType">Classification</label>
						<span class="description">Use the previously defined asset classification criterias and choose the appropiate classification profile for this asset.</span>
<?
$asset_classification_types = list_asset_classification_distinct();

foreach($asset_classification_types as $asset_classification_types_item) {
	echo "<select name=\"asset_classification[]\" class=\"chzn-select\">";
	echo "<option value=\"-1\">Classification: $asset_classification_types_item[asset_classification_type]</option>";

	$pre_selected_value = pre_selected_asset_classification_values($asset_classification_types_item[asset_classification_type], $asset_item[asset_id]);	

	# llamar una funcion que me liste un html drop menu por cada classification type que yo le diga										
	list_drop_menu_asset_classification($pre_selected_value,"asset_classification_name","$asset_classification_types_item[asset_classification_type]");
	echo "</select>";
	echo "</br>";
}

?>

						<label for="legalType">Main Container Asset</label>
						<span class="description">Most assets are contained at some point in time within another asset. Example: Financial Data might be contained in another asset, called "Financial SpreadSheets".</span>
						<select name="asset_container_id" id="" class="chzn-select">
						<option value="-1">Select a Container...</option>
<?
						list_drop_menu_asset($asset_item[asset_container_id],"asset_name");	
?>
						</select>




						
				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">
				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="asset">
				    <INPUT type="hidden" name="subsection" value="asset_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"asset_id\" value=\"$asset_item[asset_id]\">"; ?>

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
