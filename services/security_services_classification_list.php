<?
	include_once("lib/security_services_classification_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"security_services_classification_list");
	$base_url_edit = build_base_url($section,"security_services_classification_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$security_services_classification_id = $_GET["security_services_classification_id"];
	$security_services_classification_name = $_GET["security_services_classification_name"];
	$security_services_classification_criteria = $_GET["security_services_classification_criteria"];


	$security_services_classification_disabled = $_GET["security_services_classification_disabled"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($security_services_classification_id)) {
		$security_services_classification_update = array(
			'security_services_classification_name' => $security_services_classification_name,
			'security_services_classification_criteria' => $security_services_classification_criteria,
		);	
		update_security_services_classification($security_services_classification_update,$security_services_classification_id);
		add_system_records("operations","security_services_classification_edit","$security_services_classification_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$security_services_classification_update = array(
			'security_services_classification_name' => $security_services_classification_name,
			'security_services_classification_criteria' => $security_services_classification_criteria,
		);	
		$security_services_classification_id = add_security_services_classification($security_services_classification_update);
		add_system_records("operations","security_services_classification_edit","$security_services_classification_id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_security_services_classification($security_services_classification_id);
		add_system_records("operations","security_services_classification_edit","$security_services_classification_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_security_services_classification_csv();
		add_system_records("operations","security_services_classification_edit","$security_services_classification_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Security Services Classification Scheme</h3>
		<span class=description>Define how you would like Security Services to be classied at the time of creating them</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Classification 
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
	echo '<li><a href="' . $base_url_list . '&download_export=security_services_classification_export">Download</a></li>';
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=security_services_classification_name\">Classification Name</a></th>";
echo "					<th><a href=\"$base_url_list&sort=security_services_classification_criteria\">Classification Criteria</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$security_services_classification_list = list_security_services_classification(" WHERE security_services_classification_disabled = 0 AND security_services_classification_id = $show_id");
	} else {
		if ($sort == "security_services_classification_criteria" OR $sort == "security_services_classification_name") {
			$security_services_classification_list = list_security_services_classification(" WHERE security_services_classification_disabled = 0 ORDER by $sort");
		} else {
			$security_services_classification_list = list_security_services_classification(" WHERE security_services_classification_disabled = 0 ORDER by security_services_classification_name");
		}
	}

	foreach($security_services_classification_list as $security_services_classification_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$security_services_classification_item[security_services_classification_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&security_services_classification_id=$security_services_classification_item[security_services_classification_id]\" class=\"edit-action\">edit</a> ";
echo "							<a href=\"$base_url_list&action=disable&security_services_classification_id=$security_services_classification_item[security_services_classification_id]\" class=\"delete-action\">delete</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$security_services_classification_item[security_services_classification_criteria]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
