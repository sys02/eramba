<?

	include_once("lib/asset_lib.php");
	include_once("lib/data_asset_lib.php");
	include_once("lib/data_asset_status_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/data_asset_security_services_join_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$data_asset_id = $_GET["data_asset_id"];
	$asset_id = $_GET["asset_id"];
	
	$base_url_list = build_base_url($section,"data_asset_list");
	$base_url_edit = build_base_url($section,"data_asset_edit");

	if (is_numeric($data_asset_id)) {
		$data_asset_item = lookup_data_asset("data_asset_id",$data_asset_id);
		$asset_item = lookup_asset("asset_id",$data_asset_item[data_asset_asset_id]);
	} elseif ($asset_id) {
		$asset_item = lookup_asset("asset_id",$asset_id);
	}

?>


	<section id="content-wrapper">
		<h3>Analyse a Data Asset</h3>
		<span class="description">In the end, is your core data assets that you struggle to protect every day, isnt it?. It's important you identify for each data asset status (creation, modification, storage, transit and deletion) how those assets are protected.</span>
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
echo "					<form name=\"data_asset_edit\" method=\"GET\" action=\"$base_url_edit\">";
?>
						<label for="name">Data Asset Name</label>
						<span class="description">This is the name of the asset being analysed.</span>
<? echo "						<input disabled type=\"text\" class=\"filter-text\" name=\"asset_name\" id=\"asset_name\" value=\"$asset_item[asset_name]\"/>";?>
						
						<label for="description">Data Asset Description</label>
						<span class="description">This is the description of the asset being analysed..</span>
<? echo "						<textarea disabled name=\"asset_description\" class=\"filter-text\">$asset_item[asset_description]</textarea>";?>
						
						<label for="description">Data Asset Status</label>
						<span class="description">Choose the status being analysed..</span>
						<select name="data_asset_status_id" id="" class="chzn-select">
						<option value="-1">Choose one...</option>
<?
						list_drop_menu_data_asset_status($data_asset_item[data_asset_status_id],"data_asset_status_name");	
?>
						
						</select>

						<label for="description">Status Description</label>
						<span class="description">Describe a bit more the status you have previously selected...</span>
<? echo "						<textarea name=\"data_asset_description\" class=\"filter-text\">$data_asset_item[data_asset_description]</textarea>";?>

						<label for="legalType">Compensating Controls</label>
						<span class="description">Choose the most suitable available compensating controls (you can select multiple) or NONE if you have nothing suitable</span>
						<select name="security_services_id[]" id="" class="" multiple="multiple">
						<option value="-1">Select a Compensating Control...</option>
<?
			$pre_selected_security_services_list = list_data_asset_security_services_join(" WHERE data_asset_security_services_join_data_asset_id = \"$data_asset_item[data_asset_id]\"");	
			$pre_selected_items = array();
			foreach($pre_selected_security_services_list as $pre_selected_security_services_item) {
				array_push($pre_selected_items,$pre_selected_security_services_item[data_asset_security_services_join_security_services_id]);
			}
			list_drop_menu_security_services($pre_selected_items,"security_services_name");	
?>
						</select>


				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update_data_asset">
				<? echo "   <INPUT type=\"hidden\" name=\"asset_id\" value=\"$asset_id\">";?>
				    <INPUT type="hidden" name="section" value="asset">
				    <INPUT type="hidden" name="subsection" value="data_asset_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"data_asset_id\" value=\"$data_asset_item[data_asset_id]\">"; ?>
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
