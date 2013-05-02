<?
	include_once("lib/compliance_audit_lib.php");
	include_once("lib/compliance_finding_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/tp_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"compliance_audit_list");
	$base_url_edit = build_base_url($section,"compliance_audit_edit");
	
	$base_url_edit_finding = build_base_url($section,"compliance_finding_edit");
	$base_url_list_finding = build_base_url($section,"compliance_finding_list");

	# local variables - YOU MUST ADJUST THIS! 
	$compliance_audit_id = $_GET["compliance_audit_id"];
	$compliance_audit_title = $_GET["compliance_audit_title"];
	$compliance_audit_date = $_GET["compliance_audit_date"];
	$compliance_audit_package_id = $_GET["compliance_audit_package_id"];
	$compliance_audit_disabled = $_GET["compliance_audit_disabled"];
	
	# compliance finding stuf
	$compliance_finding_id = $_GET["compliance_finding_id"];
	$compliance_finding_title = $_GET["compliance_finding_title"];
	$compliance_finding_description = $_GET["compliance_finding_description"];
	$compliance_finding_status = $_GET["compliance_finding_status"];
	$compliance_finding_deadline = $_GET["compliance_finding_deadline"];
	$compliance_finding_disabled = $_GET["compliance_finding_disabled"];
	 
	# actions for compliance findings stuff ..
	if ($action == "edit_compliance_finding" & is_numeric($compliance_finding_id)) {
		$compliance_finding_update = array(
			'compliance_finding_title' => $compliance_finding_title,
			'compliance_finding_description' => $compliance_finding_description,
			'compliance_finding_deadline' => $compliance_finding_deadline,
			'compliance_finding_status' => $compliance_finding_status,
		);	
		update_compliance_finding($compliance_finding_update,$compliance_finding_id);
		add_system_records("compliance","compliance_finding_edit","$compliance_finding_id",$_SESSION['logged_user_id'],"Update","");

	} elseif ($action == "edit_compliance_finding") {
		$compliance_finding_update = array(
			'compliance_audit_id' => $compliance_audit_id,
			'compliance_finding_title' => $compliance_finding_title,
			'compliance_finding_description' => $compliance_finding_description,
			'compliance_finding_deadline' => $compliance_finding_deadline,
			'compliance_finding_status' => $compliance_finding_status,
		);	
		$compliance_finding_id = add_compliance_finding($compliance_finding_update);
		add_system_records("compliance","compliance_finding_edit",$compliance_finding_id,$_SESSION['logged_user_id'],"Insert","");
	}


	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($compliance_audit_id)) {
		$compliance_audit_update = array(
			'compliance_audit_title' => $compliance_audit_title,
			'compliance_audit_date' => $compliance_audit_date,
			'compliance_audit_package_id' => $compliance_audit_package_id
		);	
		update_compliance_audit($compliance_audit_update,$compliance_audit_id);
		add_system_records("compliance","compliance_audit_edit","$compliance_audit_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$compliance_audit_update = array(
			'compliance_audit_title' => $compliance_audit_title,
			'compliance_audit_date' => $compliance_audit_date,
			'compliance_audit_package_id' => $compliance_audit_package_id
		);	
		$compliance_audit_id = add_compliance_audit($compliance_audit_update);
		add_system_records("compliance","compliance_audit_edit",$compliance_audit_id,$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_compliance_audit($compliance_audit_id);
		add_system_records("compliance","compliance_audit_edit",$compliance_audit_id,$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_compliance_audit_csv();
		add_system_records("compliance","compliance_audit_edit",$compliance_audit_id,$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Audit Calendar</h3>
		<span class=date>Keeping tidy a calendar of Audits is helpful for prepation and planning. In this section you can keep track all audit findings (non-compliances) in order to work on their mitigation plans.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add a new Audit 
			</a>
			
		</div>
		<br class="clear"/>
		
		<table class="main-table">
			<thead>
				<tr>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=compliance_audit_title\">Audit Title</a></th>";
echo "					<th><a href=\"$base_url_list&sort=compliance_audit_title\">Audit Date</a></th>";
echo "					<th><a href=\"$base_url_list&sort=compliance_audit_date\">Compliance Package</a></th>";
echo "					<th><center><a href=\"$base_url&sort=compliance_audit_expiration\">Audit Findings</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$compliance_audit_list = list_compliance_audit(" WHERE compliance_audit_disabled = 0 AND compliance_audit_id = $show_id");
	} else {
		if ($sort == "compliance_audit_title" OR $sort == "compliance_audit_date" OR $sort == "compliance_audit_package_id" OR $sort == "compliance_audit_expiration") {
			$compliance_audit_list = list_compliance_audit(" WHERE compliance_audit_disabled = 0 ORDER by $sort");
		} elseif (is_numeric($sort)) {
			$compliance_audit_list = list_compliance_audit(" WHERE compliance_audit_disabled = 0 AND compliance_audit_id = \"$sort\" ORDER by $sort");
		} else {
			$compliance_audit_list = list_compliance_audit(" WHERE compliance_audit_disabled = 0 ORDER by compliance_audit_title");
		}
	}

	foreach($compliance_audit_list as $compliance_audit_item) {

	if ($compliance_audit_item[compliance_audit_package_id] == "-1") {
		$compliance_audit_item[compliance_audit_package_id] = "Not defined";
	}

echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$compliance_audit_item[compliance_audit_title]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "					<a href=\"$base_url_edit&action=edit&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "					<a href=\"$base_url_list&action=disable&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "					<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=compliance&system_records_lookup_subsection=compliance_audit_edit&system_records_lookup_item_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action delete-action\">records</a>";
echo "					<a href=\"?action=edit&section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=compliance&ciso_pmo_lookup_subsection=compliance_audit_edit&ciso_pmo_lookup_item_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">improve</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$compliance_audit_item[compliance_audit_date]</td>";

	$compliance_package_name = lookup_tp("tp_id",$compliance_audit_item[compliance_audit_package_id]); 

echo "					<td>$compliance_package_name[tp_name]</td>";
echo "							<td class=\"action-cell\">

								<div class=\"cell-label\">
			";

		$count = list_compliance_finding(" WHERE compliance_finding_disabled = \"0\" AND compliance_audit_id = \"$compliance_audit_item[compliance_audit_id]\" ");	
		echo count($count). " Items";

echo "
								</div>

								<div class=\"cell-actions\">
<a href=\"$base_url_edit_finding&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action\">add finding</a> 
<a href=\"$base_url_list_finding&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">view all finding</a>
						</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
