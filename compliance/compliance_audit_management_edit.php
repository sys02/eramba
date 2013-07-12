<?
	include_once("lib/tp_lib.php");
	include_once("lib/tp_type_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/compliance_management_lib.php");
	include_once("lib/compliance_exception_lib.php");
	include_once("lib/compliance_package_lib.php");
	include_once("lib/compliance_package_item_lib.php");
	include_once("lib/compliance_response_strategy_lib.php");
	include_once("lib/compliance_status_lib.php");
	include_once("lib/compliance_item_security_service_join_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/compliance_audit_management_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$audit_id = $_GET["audit_id"];
	
	$base_url_list  = build_base_url($section,"compliance_audit_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$tp_id = $_GET["tp_id"];
	$compliance_management_item_id = $_GET["compliance_management_item_id"];
	$compliance_management_id = $_GET["compliance_management_id"];
	$compliance_management_response_id = $_GET["compliance_management_response_id"];
	$compliance_management_status_id = $_GET["compliance_management_status_id"];
	$compliance_management_exception_id = $_GET["compliance_management_exception_id"];
	$compliance_security_services_join_security_services_id = $_GET["compliance_security_services_join_security_services_id"];

	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($compliance_management_id)) {
		$compliance_management_update = array(
			'compliance_management_response_id' => $compliance_management_response_id,
			'compliance_management_status_id' => $compliance_management_status_id,
			'compliance_management_status_id' => $compliance_management_status_id,
			'compliance_management_exception_id' => $compliance_management_exception_id
		);	
		update_compliance_management($compliance_management_update,$compliance_management_id);
		add_system_records("compliance","compliance_management_edit","$compliance_management_id",$_SESSION['logged_user_id'],"Update","");

		# remove all security services for this compliance management item and then add the ones i just got.
		delete_compliance_item_security_services_join($compliance_management_item_id);

		if (count($compliance_security_services_join_security_services_id)>0) {
		foreach($compliance_security_services_join_security_services_id as $security_service_id) {
			if ($security_service_id > 0) {
			add_compliance_item_security_services_join($compliance_management_item_id, $security_service_id);
			}
		}
		}
	}


	# ---- END TEMPLATE ------

	$tp_item = lookup_tp("tp_id", $tp_id);
	


?>

	<section id="content-wrapper">
	<?
		echo "<h3>Compliance Management: $tp_item[tp_name]</h3>";
	?>
		<div class="controls-wrapper">
			
			<div class="actions-wraper">
				<a href="#" class="actions-btn">
					Actions
					<span class="select-icon"></span>
				</a>
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
echo "					<li><a href=\"downloads/compliance_management_export.csv\">Dowload</a></li>";
} else { 
echo "					<li><a href=\"$base_url_list&action=csv&tp_id=$tp_id\">Export</a></li>";
}
?>
				</ul>
			</div>
		</div>
		<br class="clear"/>

<?
echo "	<form name=\"compliance_exception_edit\" method=\"POST\" action=\"$base_url_list\">";
	$compliance_package_list = list_compliance_package(" WHERE compliance_package_tp_id = \"$tp_id\" AND compliance_package_disabled = \"0\"");
	
	foreach($compliance_package_list as $compliance_package_item) {

echo "<ul id=\"accordion\">\n";
$short_description = "".substr($compliance_package_item[compliance_package_description],0,60)."...";
echo "<br><h4>$compliance_package_item[compliance_package_original_id] - $compliance_package_item[compliance_package_name] ($short_description)</h4>\n";
//echo "<br class=\"clear\"/>\n";

	$compliance_package_item_list = list_compliance_package_item(" WHERE compliance_package_id = \"$compliance_package_item[compliance_package_id]\" AND compliance_package_item_disabled = \"0\"");

	if ( count($compliance_package_item_list) != 0 ) {

echo "	<table class=\"main-table\">\n";
echo "			<thead>\n";
echo "				<tr>\n";
echo "					<th>Item Name & Id</th>\n";
echo "					<th>Item Description</th>\n";
echo "					<th>Auditor FAQ</th>\n";
echo "					<th>Auditor Name</th>\n";
echo "					<th>Auditor Feedback</th>\n";
echo "				</tr>\n";
echo "			</thead>\n";
echo "			<tbody>\n";
			
		foreach($compliance_package_item_list as $compliance_package_item_item) {
	
		# load the ocmpliance_management_item data
		$compliance_management_item = lookup_compliance_audit_management_for_specific_audit($audit_id, $compliance_package_item_item[compliance_package_item_id]);

echo "	<tr class=\"even\">\n";
echo "		<td class=\"action-cell\">\n";
echo "			<div class=\"cell-label\">\n";
echo "			$compliance_package_item_item[compliance_package_item_original_id] - $compliance_package_item_item[compliance_package_item_name]";
echo "			</div>\n";
echo "		</td>\n";
echo "			<td>$compliance_package_item_item[compliance_package_item_description]</td>\n";
echo "			<td>Auditor FAQ</td>\n";
echo "	<td> <input type=\"text\" maxlength=\"100\" name=\"auditor_name_pack_item_id:$compliance_package_item_item[compliance_package_item_id]\" value=\"$compliance_management_item[compliance_audit_management_audit_name]\"</td>\n";
echo "			<td><textarea name=\"feedback_pack_item_id:$compliance_package_item_item[compliance_package_item_id]\" rows=\"4\" cols=\"50\">$compliance_management_item[compliance_audit_management_feedback]</textarea></td>\n";
echo "		</tr>\n";

		}

		echo '</tbody>';
	echo '</table>';

	}
	echo '</ul>';
	}
?>
		
	<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update_compliance_audit_management">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_audit_list">
	<? echo    "<INPUT type=\"hidden\" name=\"tp_id\" value=\"$tp_id\">"; ?>
	<? echo    "<INPUT type=\"hidden\" name=\"audit_id\" value=\"$audit_id\">"; ?>

			<a>
			    <INPUT type="submit" value="Save" class="add-btn"> 
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
