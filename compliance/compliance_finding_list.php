<?
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/compliance_finding_lib.php");
	include_once("lib/compliance_finding_status_lib.php");
	include_once("lib/compliance_audit_lib.php");
	include_once("lib/compliance_package_item_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];


	$compliance_audit_id = $_GET["compliance_audit_id"];
	$compliance_finding_id = $_GET["compliance_finding_id"];

	
	$base_url_list = build_base_url($section,"compliance_finding_list");
	$base_url_audt_list = build_base_url($section,"compliance_audit_list");
	$base_url_edit  = build_base_url($section,"compliance_finding_edit");
	
	if ($action == "disable") {
		disable_compliance_finding($compliance_finding_id);
		add_system_records("compliance","compliance_finding_edit",$compliance_finding_id,$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_compliance_finding_csv();
		add_system_records("compliance","compliance_finding_edit",$compliance_finding_id,$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------
	if (is_numeric($compliance_audit_id)) { 
		if (!$sort) {
		$compliance_finding_list = list_compliance_finding(" WHERE compliance_audit_id = \"$compliance_audit_id\" AND compliance_finding_disabled = \"0\"");
		} else {
		$compliance_finding_list = list_compliance_finding(" WHERE compliance_audit_id = \"$compliance_audit_id\" AND compliance_finding_disabled = \"0\" ORDER by $sort");
		}
	} else {
		exit;
	}

?>

	<section id="content-wrapper">
		<h3>List of Expenses</h3>
		<span class=description>This is the list of audit findings for a given audit</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&compliance_audit_id=$compliance_audit_id\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Audit Finding 
			</a>
			
			<div class="actions-wraper">
				<a href="#" class="actions-btn">
					Actions
					<span class="select-icon"></span>
				</a>
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
	echo '<li><a href="' . $base_url_list . '&download_export=compliance_finding_export">Download</a></li>';
} else { 
echo "					<li><a href=\"$base_url_list&compliance_audit_id=$compliance_audit_id&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>
		</div>
		<br class="clear"/>
		
		<table class="main-table">
			<thead>
				<tr>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th>Title</th>";
echo "					<th>Compliance Item</th>";
echo "					<th>Description</th>";
echo "					<th><a class=\"asc\" href=\"$base_url_list&compliance_audit_id=$compliance_audit_id&sort=compliance_finding_deadline\">Deadline</a></th>";
echo "					<th><a class=\"asc\" href=\"$base_url_list&compliance_audit_id=$compliance_audit_id&sort=compliance_finding_status\">Status</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------

	foreach($compliance_finding_list as $compliance_finding_item) {

		$finding = lookup_compliance_finding("compliance_finding_id",$compliance_finding_item[compliance_finding_id]);
		$package_item = lookup_compliance_package_item("compliance_package_item_id",$compliance_finding_item["compliance_finding_package_item_id"]);
		$tmp = "$package_item[compliance_package_item_original_id] - $package_item[compliance_package_item_name]";

echo "	<tr class=\"even\">";
echo "	<td class=\"action-cell\">";
echo "	<div class=\"cell-label\">";
echo "	$finding[compliance_finding_title]";
echo "	</div>";
echo "	<div class=\"cell-actions\">";
echo "	<a href=\"$base_url_edit&compliance_finding_id=$compliance_finding_item[compliance_finding_id]\" class=\"edit-action\">edit</a> ";
echo "	&nbsp;|&nbsp;";
echo "	<a href=\"$base_url_list&action=disable&compliance_finding_id=$compliance_finding_item[compliance_finding_id]&compliance_audit_id=$compliance_audit_id\" class=\"delete-action\">delete</a>";
echo "	&nbsp;|&nbsp;";
echo "	<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=compliance&system_records_lookup_subsection=compliance_finding_edit&system_records_lookup_item_id=$compliance_finding_item[compliance_finding_id]\" class=\"delete-action\">records</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>".substr($tmp,0,60)."</td>";
echo "					<td>".substr($compliance_finding_item[compliance_finding_description],0,60)."...</td>";
echo "					<td>$compliance_finding_item[compliance_finding_deadline]</td>";

	$status = lookup_compliance_finding_status("compliance_finding_status_id", $compliance_finding_item[compliance_finding_status]); 
echo "					<td>$status[compliance_finding_status_name]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>

<?
echo "			<a href=\"$base_url_audt_list\" class=\"cancel-btn\">";
?>
				Cancel
				<span class="select-icon"></span>
			</a>
