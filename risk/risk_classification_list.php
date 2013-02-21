<?
	include_once("lib/risk_classification_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"risk_classification_list");
	$base_url_edit = build_base_url($section,"risk_classification_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$risk_classification_id = $_GET["risk_classification_id"];
	$risk_classification_name = $_GET["risk_classification_name"];
	$risk_classification_criteria = $_GET["risk_classification_criteria"];
	$risk_classification_type = $_GET["risk_classification_type"];
	$risk_classification_type_new = $_GET["risk_classification_type_new"];

	if ($risk_classification_type_new) {
		$risk_classification_type = $risk_classification_type_new;
	}

	$risk_classification_value = $_GET["risk_classification_value"];
	if (!is_numeric($risk_classification_value)) {
		$risk_classification_value = 1;
	}

	$risk_classification_disabled = $_GET["risk_classification_disabled"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($risk_classification_id)) {
		$risk_classification_update = array(
			'risk_classification_name' => $risk_classification_name,
			'risk_classification_criteria' => $risk_classification_criteria,
			'risk_classification_type' => $risk_classification_type,
			'risk_classification_value' => $risk_classification_value
		);	
		update_risk_classification($risk_classification_update,$risk_classification_id);
		add_system_records("risk","risk_classification_edit","$risk_classification_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$risk_classification_update = array(
			'risk_classification_name' => $risk_classification_name,
			'risk_classification_criteria' => $risk_classification_criteria,
			'risk_classification_type' => $risk_classification_type,
			'risk_classification_value' => $risk_classification_value
		);	
		$risk_classification_id = add_risk_classification($risk_classification_update);
		add_system_records("risk","risk_classification_edit","$risk_classification_id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_risk_classification($risk_classification_id);
		add_system_records("risk","risk_classification_edit","$risk_classification_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_risk_classification_csv();
		add_system_records("risk","risk_classification_edit","$risk_classification_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Risk Classification Scheme</h3>
		<span class=description>As part of the process of managing Risks, the classification of them is a critical componenent to set clear priorities and leverage from the Risk analsys. Define your Risk classification criterias in a usefull way!
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
echo "					<li><a href=\"downloads/risk_classification_export.csv\">Dowload</a></li>";
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=risk_classification_name\">Classification Name</a></th>";
echo "					<th><a href=\"$base_url_list&sort=risk_classification_criteria\">Classification Criteria</a></th>";
echo "					<th><center><a href=\"$base_url_list&sort=risk_classification_type\">Type</a></th>";
echo "					<th><center><a href=\"$base_url_list&sort=risk_classification_value\">Value</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$risk_classification_list = list_risk_classification(" WHERE risk_classification_disabled = 0 AND risk_classification_id = $show_id");
	} else {
		if ($sort == "risk_classification_criteria" OR $sort == "risk_classification_name" OR $sort == "risk_classification_type" OR $sort == "risk_classification_value") {
			$risk_classification_list = list_risk_classification(" WHERE risk_classification_disabled = 0 ORDER by $sort");
		} else {
			$risk_classification_list = list_risk_classification(" WHERE risk_classification_disabled = 0 ORDER by risk_classification_type");
		}
	}

	foreach($risk_classification_list as $risk_classification_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$risk_classification_item[risk_classification_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&risk_classification_id=$risk_classification_item[risk_classification_id]\" class=\"edit-action\">edit</a> ";
echo "							<a href=\"$base_url_list&action=disable&risk_classification_id=$risk_classification_item[risk_classification_id]\" class=\"delete-action\">delete</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$risk_classification_item[risk_classification_criteria]</td>";
echo "					<td><center>$risk_classification_item[risk_classification_type]</td>";
echo "					<td><center>$risk_classification_item[risk_classification_value]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
