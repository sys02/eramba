<?
	include_once("lib/asset_classification_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_edit = build_base_url($section,"asset_classification_edit");
	$base_url_list = build_base_url($section,"asset_classification_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$asset_classification_id = $_GET["asset_classification_id"];
	$asset_classification_name = $_GET["asset_classification_name"];
	$asset_classification_criteria = $_GET["asset_classification_criteria"];
	$asset_classification_type = $_GET["asset_classification_type"];
	$asset_classification_type_new = $_GET["asset_classification_type_new"];

	if ($asset_classification_type_new) {
		$asset_classification_type = $asset_classification_type_new;
	}

	$asset_classification_value = $_GET["asset_classification_value"];
	if (!is_numeric($asset_classification_value)) {
		$asset_classification_value = 1;
	}

	$asset_classification_disabled = $_GET["asset_classification_disabled"];
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($asset_classification_id)) {
		$asset_classification_update = array(
			'asset_classification_name' => $asset_classification_name,
			'asset_classification_criteria' => $asset_classification_criteria,
			'asset_classification_type' => $asset_classification_type,
			'asset_classification_value' => $asset_classification_value
		);	
		update_asset_classification($asset_classification_update,$asset_classification_id);
		add_system_records("asset","asset_classification_edit","$asset_classification_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$asset_classification_update = array(
			'asset_classification_name' => $asset_classification_name,
			'asset_classification_criteria' => $asset_classification_criteria,
			'asset_classification_type' => $asset_classification_type,
			'asset_classification_value' => $asset_classification_value
		);	
		$asset_classification_id = add_asset_classification($asset_classification_update);
		add_system_records("asset","asset_classification_edit","$asset_classification_id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable") {
		disable_asset_classification($asset_classification_id);
		add_system_records("asset","asset_classification_edit","$asset_classification_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_asset_classification_csv();
		add_system_records("asset","asset_classification_edit","$asset_classification_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Asset Classification Scheme</h3>
		<span class=description>You'll be classifying assets very soon, it's very important you decide a classification method that fits you the best. Keep in mind it must be usefull! </span>
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
echo "					<li><a href=\"downloads/asset_classification_export.csv\">Dowload</a></li>";
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
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=asset_classification_name\">Classification Name</a></th>";
echo "					<th><a href=\"$base_url_list&sort=asset_classification_criteria\">Classification Criteria</a></th>";
echo "					<th><center><a href=\"$base_url_list&sort=asset_classification_type\">Type</a></th>";
echo "					<th><center><a href=\"$base_url_list&sort=asset_classification_value\">Value</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	if ($show_id) {
		$asset_classification_list = list_asset_classification(" WHERE asset_classification_disabled = 0 AND asset_classification_id = $show_id");
	} else {
		if ($sort == "asset_classification_criteria" OR $sort == "asset_classification_name" OR $sort == "asset_classification_type" OR $sort == "asset_classification_value") {
			$asset_classification_list = list_asset_classification(" WHERE asset_classification_disabled = 0 ORDER by $sort");
		} else {
			$asset_classification_list = list_asset_classification(" WHERE asset_classification_disabled = 0 ORDER by asset_classification_type");
		}
	}

	foreach($asset_classification_list as $asset_classification_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$asset_classification_item[asset_classification_name]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&asset_classification_id=$asset_classification_item[asset_classification_id]\" class=\"edit-action\">edit</a> ";
echo "							<a href=\"$base_url_list&action=disable&asset_classification_id=$asset_classification_item[asset_classification_id]\" class=\"delete-action\">delete</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$asset_classification_item[asset_classification_criteria]</td>";
echo "					<td><center>$asset_classification_item[asset_classification_type]</td>";
echo "					<td><center>$asset_classification_item[asset_classification_value]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
