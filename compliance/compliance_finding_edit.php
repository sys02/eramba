<?

	include_once("lib/compliance_package_lib.php");
	include_once("lib/compliance_finding_lib.php");
	include_once("lib/compliance_finding_status_lib.php");
	include_once("lib/compliance_audit_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];

	$compliance_audit_id= $_GET["compliance_audit_id"];
	$compliance_finding_id = $_GET["compliance_finding_id"];
	
	$base_url_list = build_base_url($section,"compliance_audit_list");

	if (is_numeric($compliance_finding_id)) {
		$compliance_finding_item = lookup_compliance_finding("compliance_finding_id",$compliance_finding_id);
		$compliance_audit_information = lookup_compliance_audit("compliance_audit_id",$compliance_finding_item[compliance_audit_id]);
	} else {
		$compliance_audit_information = lookup_compliance_audit("compliance_audit_id",$compliance_audit_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create an Audit Finding </h3>
		<span class="description">Use this form to create or edit an audit finding</span>
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
echo "					<form name=\"edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Finding Title</label>
						<span class="description">Provide a descriptive title for this audit finding</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"compliance_finding_title\" id=\"compliance_finding_title\" value=\"$compliance_finding_item[compliance_finding_title]\"/>";?>

		<label for="description">Compliance Item with Issues</label>
		<span class="description">Select the compliance item which has audit issues</span>
		<select name="compliance_finding_package_item_id" class="chzn-select">
		<option name=\"-1\">Not Applicable</option>
<?
	$compliance_package_list = list_compliance_package(" where compliance_package_tp_id = \"$compliance_audit_information[compliance_audit_package_id]\" and compliance_package_disabled = \"0\""); 
	if (count($compliance_package_list)>0) {
		# i might have more than one .. so for each compliance package , i count and search how many have controls, etc
		foreach($compliance_package_list as $compliance_package_item) {
			$compliance_package_item_list = list_compliance_package_item(" where compliance_package_id = \"$compliance_package_item[compliance_package_id]\" and compliance_package_item_disabled = \"0\"");
			foreach($compliance_package_item_list as $compliance_package_item_list_list) {
				if ($compliance_package_item_list_list[compliance_package_item_id] == $compliance_finding_item[compliance_finding_package_item_id]) {
				echo "<option value=\"$compliance_package_item_list_list[compliance_package_item_id]\" selected=\"selected\">$compliance_package_item_list_list[compliance_package_item_original_id] - $compliance_package_item_list_list[compliance_package_item_name]</option>\n";
				} else {
				echo "<option value=\"$compliance_package_item_list_list[compliance_package_item_id]\">$compliance_package_item_list_list[compliance_package_item_original_id] - $compliance_package_item_list_list[compliance_package_item_name]</option>\n";
				}
			}
			
		}
	}
	
?>
						
	</select>

	<label for="description">Description</label>
	<span class="description">Describe the audit finding.</span>
<? echo "<textarea name=\"compliance_finding_description\">$compliance_finding_item[compliance_finding_description]</textarea>";?>
						
						<label for="description">Status</label>
						<span class="description">Is this finding still an open one?</span>

						<select id="applicable" name="compliance_finding_status" class="chzn-select">
<?
			list_drop_menu_compliance_finding_status($compliance_finding_item[compliance_finding_status],"");
?>
						</select>

		<label for="name">Finding Deadline</label>
		<span class="description">By when this audit finding needs to be solved.</span>
<?
echo "	<input type=\"text\" class=\"filter-date datepicker\" name=\"compliance_finding_deadline\" id=\"\" value=\"$compliance_finding_item[compliance_finding_deadline]\"/>";
?>
						

			</div>
		</div>
	</div>
		

				    <INPUT type="hidden" name="action" value="edit_compliance_finding">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_audit_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"compliance_audit_id\" value=\"$compliance_audit_id\">"; ?>
<? echo " 			    <INPUT type=\"hidden\" name=\"compliance_finding_id\" value=\"$compliance_finding_item[compliance_finding_id]\">"; ?>
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
		
</body>
</html>
