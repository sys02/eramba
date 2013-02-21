<?
	include_once("lib/asset_label_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"asset_label_list");
	$base_url_edit = build_base_url($section,"asset_label_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$asset_label_id = $_GET["asset_label_id"];
	$asset_label_name = $_GET["asset_label_name"];
	$asset_label_criteria = $_GET["asset_label_criteria"];


	$asset_label_disabled = $_GET["asset_label_disabled"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($asset_label_id)) {
		$asset_label_update = array(
			'asset_label_name' => $asset_label_name,
			'asset_label_criteria' => $asset_label_criteria,
		);	
		update_asset_label($asset_label_update,$asset_label_id);
		add_system_records("asset","asset_label","$asset_label_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$asset_label_update = array(
			'asset_label_name' => $asset_label_name,
			'asset_label_criteria' => $asset_label_criteria,
		);	
		add_asset_label($asset_label_update);
		add_system_records("asset","asset_label","$asset_label_id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_asset_label($asset_label_id);
		add_system_records("asset","asset_label","$asset_label_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_asset_label_csv();
		add_system_records("asset","asset_label","$asset_label_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Asset Labeling Classification</h3>
		<span class=description>Define how you would like assets to be labeled</span>
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
echo "					<li><a href=\"downloads/asset_label_export.csv\">Dowload</a></li>";
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=asset_label_name\">Classification Name</a></th>";
echo "					<th><a href=\"$base_url_list&sort=asset_label_criteria\">Classification Criteria</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$asset_label_list = list_asset_label(" WHERE asset_label_disabled = 0 AND asset_label_id = $show_id");
	} else {
		if ($sort == "asset_label_criteria" OR $sort == "asset_label_name") {
			$asset_label_list = list_asset_label(" WHERE asset_label_disabled = 0 ORDER by $sort");
		} else {
			$asset_label_list = list_asset_label(" WHERE asset_label_disabled = 0 ORDER by asset_label_name");
		}
	}

	foreach($asset_label_list as $asset_label_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$asset_label_item[asset_label_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&asset_label_id=$asset_label_item[asset_label_id]\" class=\"edit-action\">edit</a> ";
echo "							<a href=\"$base_url_list&action=disable&asset_label_id=$asset_label_item[asset_label_id]\" class=\"delete-action\">delete</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$asset_label_item[asset_label_criteria]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
