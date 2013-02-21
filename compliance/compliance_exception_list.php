<?
	include_once("lib/compliance_exception_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"compliance_exception_list");
	$base_url_edit = build_base_url($section,"compliance_exception_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$compliance_exception_id = $_GET["compliance_exception_id"];
	$compliance_exception_title = $_GET["compliance_exception_title"];
	$compliance_exception_description = $_GET["compliance_exception_description"];
	$compliance_exception_author = $_GET["compliance_exception_author"];
	$compliance_exception_expiration = $_GET["compliance_exception_expiration"];

	$compliance_exception_disabled = $_GET["compliance_exception_disabled"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($compliance_exception_id)) {
		$compliance_exception_update = array(
			'compliance_exception_title' => $compliance_exception_title,
			'compliance_exception_description' => $compliance_exception_description,
			'compliance_exception_author' => $compliance_exception_author,
			'compliance_exception_expiration' => $compliance_exception_expiration
		);	
		update_compliance_exception($compliance_exception_update,$compliance_exception_id);
		add_system_records("compliance","compliance_exception_edit","$compliance_exception_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$compliance_exception_update = array(
			'compliance_exception_title' => $compliance_exception_title,
			'compliance_exception_description' => $compliance_exception_description,
			'compliance_exception_author' => $compliance_exception_author,
			'compliance_exception_expiration' => $compliance_exception_expiration
		);	
		$compliance_exception_id = add_compliance_exception($compliance_exception_update);
		add_system_records("compliance","compliance_exception_edit",$compliance_exception_id,$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_compliance_exception($compliance_exception_id);
		add_system_records("compliance","compliance_exception_edit",$compliance_exception_id,$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_compliance_exception_csv();
		add_system_records("compliance","compliance_exception_edit",$compliance_exception_id,$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Compliance Exception Management</h3>
		<span class=description>Sometimes compliance is not possible and Compliance Exceptions are required in order to assess the impact of non-compliance.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add a new Compliance Exception 
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
echo "					<li><a href=\"downloads/compliance_exception_export.csv\">Dowload</a></li>";
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=compliance_exception_title\">Compliance Exception Title</a></th>";
echo "					<th><a href=\"$base_url_list&sort=compliance_exception_description\">Description</a></th>";
echo "					<th><center><a href=\"$base_url_list&sort=compliance_exception_author\">Author</a></th>";
echo "					<th><center><a href=\"$base_url&sort=compliance_exception_expiration\">Expiration</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$compliance_exception_list = list_compliance_exception(" WHERE compliance_exception_disabled = 0 AND compliance_exception_id = $show_id");
	} else {
		if ($sort == "compliance_exception_title" OR $sort == "compliance_exception_description" OR $sort == "compliance_exception_author" OR $sort == "compliance_exception_expiration") {
			$compliance_exception_list = list_compliance_exception(" WHERE compliance_exception_disabled = 0 ORDER by $sort");
		} elseif (is_numeric($sort)) {
			$compliance_exception_list = list_compliance_exception(" WHERE compliance_exception_disabled = 0 AND compliance_exception_id = \"$sort\" ORDER by $sort");
		} else {
			$compliance_exception_list = list_compliance_exception(" WHERE compliance_exception_disabled = 0 ORDER by compliance_exception_title");
		}
	}

	foreach($compliance_exception_list as $compliance_exception_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$compliance_exception_item[compliance_exception_title]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "					<a href=\"$base_url_edit&action=edit&compliance_exception_id=$compliance_exception_item[compliance_exception_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "					<a href=\"$base_url_list&action=disable&compliance_exception_id=$compliance_exception_item[compliance_exception_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "					<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=compliance&system_records_lookup_subsection=compliance_exception_edit&system_records_lookup_item_id=$compliance_exception_item[compliance_exception_id]\" class=\"edit-action delete-action\">records</a>";
echo "					<a href=\"?action=edit&section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=compliance&ciso_pmo_lookup_subsection=compliance_exception_edit&ciso_pmo_lookup_item_id=$compliance_exception_item[compliance_exception_id]\" class=\"delete-action\">improve</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>".substr($compliance_exception_item[compliance_exception_description],0,60)."...</td>";
echo "					<td><center>$compliance_exception_item[compliance_exception_author]</td>";
echo "					<td><center>$compliance_exception_item[compliance_exception_expiration]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
