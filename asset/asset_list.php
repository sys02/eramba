<?
	include_once("lib/bu_lib.php");
	include_once("lib/asset_bu_join_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/legal_lib.php");
	include_once("lib/asset_label_lib.php");
	include_once("lib/asset_classification_lib.php");
	include_once("lib/asset_type_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_edit = build_base_url($section,"asset_edit");
	$base_url_list = build_base_url($section,"asset_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$asset_id = $_GET["asset_id"];
	$asset_name = $_GET["asset_name"];
	$asset_description = $_GET["asset_description"];
	$asset_media_type_id = $_GET["asset_media_type_id"];
	$asset_legal_id = $_GET["asset_legal_id"];
	$asset_label_id = $_GET["asset_label_id"];
	$asset_owner_id = $_GET["asset_owner_id"];
	$asset_guardian_id = $_GET["asset_guardian_id"];
	$asset_user_id = $_GET["asset_user_id"];
	$asset_container_id = $_GET["asset_container_id"];
	$asset_disabled = $_GET["asset_disabled"];
	$asset_classification = $_GET["asset_classification"];
	$asset_bu_join = $_GET["asset_bu_join"];

	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($asset_id)) {
		$asset_update = array(
			'asset_name' => $asset_name,
			'asset_description' => $asset_description,
			'asset_media_type_id' => $asset_media_type_id,
			'asset_label_id' => $asset_label_id,
			'asset_legal_id' => $asset_legal_id,
			'asset_owner_id' => $asset_owner_id,
			'asset_guardian_id' => $asset_guardian_id,
			'asset_user_id' => $asset_user_id,
			'asset_container_id' => $asset_container_id
		);	
		update_asset($asset_update,$asset_id);
		add_system_records("asset","asset_edit","$asset_id",$_SESSION['logged_user_id'],"Update","");

		# 1) delete all classifications for this asset
		delete_asset_classification_join($asset_id);
		# 2) insert all classification for this asset
		if (is_array($asset_classification)) {
			$count_asset_classification_item = count($asset_classification);
			for($count = 0 ; $count < $count_asset_classification_item ; $count++) {
				# now i insert this stuff
				add_asset_classification_join($asset_id, $asset_classification[$count]);
			}
		}
		
		# delete all bu's for this bu 
		if ($asset_id) {
		delete_asset_bu_join($asset_id);
		}

		# add all selected bus for this asset
		if (is_array($asset_bu_join)) {
			foreach($asset_bu_join as $bu_item) {
				# now i insert this stuff
				add_asset_bu_join($asset_id, $bu_item);
			}
		}

	} elseif ($action == "update") {
		$asset_update = array(
			'asset_name' => $asset_name,
			'asset_description' => $asset_description,
			'asset_media_type_id' => $asset_media_type_id,
			'asset_label_id' => $asset_label_id,
			'asset_legal_id' => $asset_legal_id,
			'asset_owner_id' => $asset_owner_id,
			'asset_guardian_id' => $asset_guardian_id,
			'asset_user_id' => $asset_user_id,
			'asset_container_id' => $asset_container_id
		);	
		$new_asset_id =	add_asset($asset_update);
		add_system_records("asset","asset_edit","$new_asset_id",$_SESSION['logged_user_id'],"Insert","");
		
		# 1) delete all classifications for this asset
		delete_asset_classification_join($new_asset_id);
		# 2) insert all classification for this asset
		if (is_array($asset_classification)) {
			$count_asset_classification_item = count($asset_classification);
			for($count = 0 ; $count < $count_asset_classification_item ; $count++) {
				# now i insert this stuff
				add_asset_classification_join($new_asset_id, $asset_classification[$count]);
			}
		}
		
		# delete all bu's for this bu 
		if ($asset_id) {
		delete_asset_bu_join($asset_id);
		}

		# add all selected bus for this asset
		if (is_array($asset_bu_join)) {
			foreach($asset_bu_join as $bu_item) {
				# now i insert this stuff
				add_asset_bu_join($new_asset_id, $bu_item);
			}
		}
	 }

	if ($action == "disable" && is_numeric($asset_id)) {
		disable_asset($asset_id);
		add_system_records("asset","asset_edit","$asset_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_asset_csv();
		add_system_records("asset","asset_edit","$asset_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>


	<section id="content-wrapper">
		<h3>Asset Identification</h3>
		<span class=description>Build a list of significant assets for your security program.</span>
		<br>
		<br>
		
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Asset 
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
	echo '<li><a href="' . $base_url_list . '&download_export=asset_export">Download</a></li>';
} else { 
	echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>

		</div>
		
		<ul id="accordion">
			
<?

	$bu_list = list_bu(" WHERE bu_disabled =\"0\"");

	foreach($bu_list as $bu_item) {

	echo "<br><h4>BU Asset Name: $bu_item[bu_name]</h4>";

		$asset_bu_list = list_asset_bu_join(" WHERE asset_bu_join_bu_id = \"$bu_item[bu_id]\"");

		foreach ($asset_bu_list as $asset_bu_item) {

		$asset_item = lookup_asset("asset_id",$asset_bu_item[asset_bu_join_asset_id]);

		$asset_owner_id = lookup_bu("bu_id",$asset_item[asset_owner_id]);
		$asset_guardian_id = lookup_bu("bu_id",$asset_item[asset_guardian_id]);

		if ($asset_user_id == "0"){
			$asset_user_name = "Everyone";
		} else { 	
			$asset_user_id = lookup_bu("bu_id",$asset_item[asset_user_id]);
			$asset_user_name = $asset_user_id[bu_name];
		}

		$asset_media_type_id = lookup_asset_media_type("asset_media_type_id",$asset_item[asset_media_type_id]);
		$asset_legal_id = lookup_legal("legal_id",$asset_item[asset_legal_id]);
		$asset_label_id = lookup_asset_label("asset_label_id",$asset_item[asset_label_id]);
		$asset_label_name = $asset_label_id[asset_label_name];
		$asset_container_id = lookup_asset("asset_id",$asset_item[asset_container_id]);

echo "			<li>";
echo "				<div class=\"header\">";
echo "					Asset: $asset_item[asset_name]";
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$base_url_edit&action=edit&asset_id=$asset_item[asset_id]\">edit</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"$base_url_list&action=disable&asset_id=$asset_item[asset_id]\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=system&subsection=system_records_list&system_records_lookup_section=asset&system_records_lookup_subsection=asset_edit&system_records_lookup_item_id=$asset_item[asset_id]\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?action=edit&section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=asset&ciso_pmo_lookup_subsection=asset_edit&ciso_pmo_lookup_item_id=$asset_item[asset_id]\">improve</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "				<div class=\"content table\">";
echo "					<table>";
echo "						<tr>";
echo "							<th>Description</th>";
echo "							<th>Type</th>";
echo "							<th>Label</th>";
echo "							<th>Legal Constrains</th>";
echo "							<th>Main Container</th>";
echo "							<th>Owner</th>";
echo "							<th>Guardian</th>";
echo "							<th>User</th>";
echo "						</tr>";

echo "						<tr>";
echo "							<td class=\"action-cell\">";
echo "								<div class=\"cell-label\">";
$asset_description = "".substr($asset_item[asset_description],0,100)."...";
echo "								 	$asset_description";
echo "								</div>";
echo "							</td>";
echo "							<td>$asset_media_type_id[asset_media_type_name]</td>";
echo "							<td>$asset_label_name</td>";
echo "							<td>$asset_legal_id[legal_name]</td>";
echo "							<td>$asset_container_id[asset_name]</td>";
echo "							<td>$asset_owner_id[bu_name]</td>";
echo "							<td>$asset_guardian_id[bu_name]</td>";
echo "							<td>$asset_user_name</td>";
echo "						</tr>";
	#}

echo "					</table>";
echo "<br>";
### INJERTO STARTS
echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
	# first i create columns for each category .. no more than 5!
	$asset_classification_list = list_asset_classification_distinct();
	foreach($asset_classification_list as $asset_classification_item) {
		echo "<th><center>$asset_classification_item[asset_classification_type]</th>";
	}
echo "							</tr>";
echo "							<tr>";
	# now i put the values 
	$asset_classification_list = list_asset_classification_distinct();
	foreach($asset_classification_list as $asset_classification_item) {
		# echo "Trola: $asset_classification_item[asset_classification_type] asset: $asset_item[asset_id]";
		$value = pre_selected_asset_classification_values($asset_classification_item[asset_classification_type], $asset_item[asset_id]);	
		# echo "classification: $value";
		$name = lookup_asset_classification("asset_classification_id", $value);
		echo "<td><center>$name[asset_classification_name]</td>";
	}

echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";

### INJERTO ENDS
echo "				</div>";
echo "			</li>";

	}
	}
?>
		</ul>
		
		<br class="clear"/>
		
	</section>
