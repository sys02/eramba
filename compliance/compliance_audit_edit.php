<?

	include_once("lib/compliance_audit_lib.php");
	include_once("lib/compliance_package_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$compliance_audit_id = $_GET["compliance_audit_id"];
	
	$base_url_list = build_base_url($section,"compliance_audit_list");

	if (is_numeric($compliance_audit_id)) {
		$compliance_audit_item = lookup_compliance_audit("compliance_audit_id",$compliance_audit_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Compliance Audit</h3>
		<span class="description">Record your next audits</span>
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
echo "					<form name=\"compliance_audit_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="applicable">Compliance Audit Title</label>
						<span class="description">Provide a descriptive title. Example: SOX Lithuania</span>
<? echo "					<input class=\"filter-text\" type=\"text\" name=\"compliance_audit_title\" id=\"\" value=\"$compliance_audit_item[compliance_audit_title]\">"; ?>
						
						<label for="description">Compliance Package</label>
						<span class="description">Which of the following compliance packages are involved on this audit?</span>

						<select id="applicable" name="compliance_audit_package_id" class="chzn-select">
<?
		$compliance_package_provider_name_list = list_compliance_package_unique();
		foreach($compliance_package_provider_name_list as $compliance_package_provider_name_item) {
			$provider_id = lookup_tp("tp_id",$compliance_package_provider_name_item[compliance_package_tp_id]);
			echo "<option value=\"$provider_id[tp_id]\">$provider_id[tp_name]</option>\n";
		}
			echo "<option value=\"-1\">Not Applicable</option>\n";
?>
						</select>

			<label for="name">Audit Date</label>
						<span class="description">When is the audit taking place?</span>
<? echo "	<input type=\"text\" class=\"filter-date datepicker\" name=\"compliance_audit_date\" id=\"\" value=\"$compliance_audit_item[compliance_audit_date]\"/>";?>
						
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_audit_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"compliance_audit_id\" value=\"$compliance_audit_item[compliance_audit_id]\">"; ?>

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
