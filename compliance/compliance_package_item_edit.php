<?

	include_once("lib/compliance_package_lib.php");
	include_once("lib/compliance_package_item_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$compliance_package_item_id = $_GET["compliance_package_item_id"];
	$compliance_package_id = $_GET["compliance_package_id"];
	
	$base_url_list  = build_base_url($section,"compliance_package_list");
	
	if (is_numeric($compliance_package_id)) {
		$compliance_package_item = lookup_compliance_package("compliance_package_id",$compliance_package_id);
	}

	if (is_numeric($compliance_package_item_id)) {
		$compliance_package_item_item = lookup_compliance_package_item("compliance_package_item_id",$compliance_package_item_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Compliance Package Item</h3>
		<span class="description"></span>
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
echo "					<form name=\"compliance_package_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Compliance Package Id</label>
						<span class="description"></span>
<? echo "						<input disabled type=\"text\" class=\"\" name=\"compliance_package_id\" id=\"\" value=\"$compliance_package_item[compliance_package_original_id]\"/>";?>
						<label for="name">Compliance Package Name</label>
						<span class="description"></span>
<? echo "						<input disabled type=\"text\" class=\"\" name=\"compliance_package_name\" id=\"\" value=\"$compliance_package_item[compliance_package_name]\"/>";?>
						<label for="name">Compliance Package Item Id</label>
						<span class="description"></span>
<? echo "						<input type=\"text\" name=\"compliance_package_item_original_id\" id=\"\" value=\"$compliance_package_item_item[compliance_package_item_original_id]\"/>";?>
						
						<label for="name">Item Name</label>
						<span class="description"></span>
<? echo "						<input type=\"text\" class=\"\" name=\"compliance_package_item_name\" id=\"\" value=\"$compliance_package_item_item[compliance_package_item_name]\"/>";?>
						
						<label for="description">Description</label>
						<span class="description"></span>
<? echo "						<textarea class=\"\" name=\"compliance_package_item_description\">$compliance_package_item_item[compliance_package_item_description]</textarea>";?>
				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update_compliance_package_item_id">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_package_list">
<? echo "    
	 <INPUT type=\"hidden\" name=\"compliance_package_item_id\" value=\"$compliance_package_item_item[compliance_package_item_id]\">
	 <INPUT type=\"hidden\" name=\"compliance_package_id\" value=\"$compliance_package_id\">
"; ?>
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
