<?
	include_once("lib/compliance_package_lib.php");
	include_once("lib/compliance_package_item_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/tp_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	# i might need post as well
	if ($_POST["action"] == "upload_compliance_package") {
		$sort = $_POST["sort"];
		$section = $_POST["section"];
		$subsection = $_POST["subsection"];
		$action = $_POST["action"];
		# this is needed for uplodas .. which uses POST
		$tp_id= $_POST["tp_id"];
	}
	
	$base_url_upload = build_base_url($section,"compliance_package_upload");
	$base_url_list = build_base_url($section,"compliance_package_list");
	$base_url_edit = build_base_url($section,"compliance_package_edit");
	$base_url_item_edit = build_base_url($section,"compliance_package_item_edit");
	$compliance_package_url = build_base_url("organization","tp_list");
	
	# local variables - YOU MUST ADJUST THIS! 
	$compliance_package_id = $_GET["compliance_package_id"];
	$compliance_package_tp_id = $_GET["compliance_package_tp_id"];
	$compliance_package_original_id = $_GET["compliance_package_original_id"];
	$compliance_package_name = $_GET["compliance_package_name"];
	$compliance_package_description = $_GET["compliance_package_description"];
	$compliance_package_type_id = $_GET["compliance_package_type_id"];
	$compliance_package_disabled = $_GET["compliance_package_disabled"];
	
	$compliance_package_item_id = $_GET["compliance_package_item_id"];
	$compliance_package_item_original_id = $_GET["compliance_package_item_original_id"];
	$compliance_package_item_name = $_GET["compliance_package_item_name"];
	$compliance_package_item_description = $_GET["compliance_package_item_description"];
	

	# i need to make sure i have a tp_id where to asociate whatever compliance package i'm been trown
	if ($action == "upload_compliance_package") {	
		if ($tp_id) {
			$tp_search = lookup_tp("tp_id",$tp_id);
			if (empty($tp_search)){
				echo "error, cant do this witohut a tp";
				exit;
			} else {
				if ($tp_search[tp_disabled] == "1") {
				echo "error, cant do this witohut an enabled tp";
				}
			}
		} else {
			echo "error, cant do this witohut a tp";
			exit;
		}

		# here i start the upload calls
		$uploaded_file = $_FILES['compliance_package_csv_file']['tmp_name'];
		
		# send this csv for parsing ..
		parse_compliance_package_csv($uploaded_file,$tp_id);

	}
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" && is_numeric($compliance_package_id)) {
		$compliance_package_update = array(
			'compliance_package_original_id' => $compliance_package_original_id,
			'compliance_package_name' => $compliance_package_name,
			'compliance_package_description' => $compliance_package_description,
			'compliance_package_type_id' => $compliance_package_type_id
		);	
		update_compliance_package($compliance_package_update,$compliance_package_id);
		add_system_records("organization","compliance_package","$compliance_package_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update") {
		$compliance_package_update = array(
			'compliance_package_tp_id' => $compliance_package_tp_id,
			'compliance_package_original_id' => $compliance_package_original_id,
			'compliance_package_name' => $compliance_package_name,
			'compliance_package_description' => $compliance_package_description,
			'compliance_package_type_id' => $compliance_package_type_id
		);	
		$compliance_package_id = add_compliance_package($compliance_package_update);
		add_system_records("organization","compliance_package","$compliance_package_id",$_SESSION['logged_user_id'],"Insert","");
	} elseif ($action == "update_compliance_package_item_id" && is_numeric($compliance_package_item_id)) {
		$compliance_package_update = array(
			'compliance_package_id' => $compliance_package_id,
			'compliance_package_item_original_id' => $compliance_package_item_original_id,
			'compliance_package_item_name' => $compliance_package_item_name,
			'compliance_package_item_description' => $compliance_package_item_description
		);	
		$compliance_package_item_id = update_compliance_package_item($compliance_package_update, $compliance_package_item_id);
		add_system_records("organization","compliance_package_item","$compliance_package_item_id",$_SESSION['logged_user_id'],"Update","");
	} elseif ($action == "update_compliance_package_item_id") {
		$compliance_package_update = array(
			'compliance_package_id' => $compliance_package_id,
			'compliance_package_item_original_id' => $compliance_package_item_original_id,
			'compliance_package_item_name' => $compliance_package_item_name,
			'compliance_package_item_description' => $compliance_package_item_description
		);	
		$compliance_package_item_id = add_compliance_package_item($compliance_package_update);
		add_system_records("organization","compliance_package_item","$compliance_package_item_id",$_SESSION['logged_user_id'],"Insert","");
	}

	if ($action == "disable_compliance_package") {
		disable_compliance_package($compliance_package_id);
		add_system_records("organization","compliance_package","$compliance_package_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "delete_forever") {
	}
	
	if ($action == "disable_compliance_package_item") {
		disable_compliance_package_item($compliance_package_item_id);
		add_system_records("organization","compliance_package_item","$compliance_package_item_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_compliance_package_csv();
		add_system_records("organization","tp","$compliance_package_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Compliance Package Database</h3>
		<span class=description>Most security organizations are subject to multiple compliances (or they set regulations to other partners). A key starting point in defining a Compliance Program is defining what exact regulations (compliance packages) and requirements (compliance packages items) your security program is subject to.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit_compliance_package\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add new Compliance Package 
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
echo "					<li><a href=\"downloads/compliance_package_export.csv\">Dowload</a></li>";
} else { 
echo "					<li><a href=\"$base_url_upload&action=show_upload_form\">Upload</a></li>";
}
?>
				</ul>
			</div>
		</div>
		
		<ul id="accordion">
<?
		$compliance_package_provider_name_list = list_compliance_package_unique();

		foreach($compliance_package_provider_name_list as $compliance_package_provider_name_item) {

			# $provider_id = lookup_compliance_package("compliance_package_id",$compliance_package_provider_name_item[compliance_package_tp_id]);
			$provider_id = lookup_tp("tp_id",$compliance_package_provider_name_item[compliance_package_tp_id]);

echo "			<li>";
echo "				<div class=\"header\">";
echo "					1. Regulator or Compliance Authority: $provider_id[tp_name]";
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$compliance_package_url&sort=$provider_id[tp_id]\">view this third party regulator</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"edit\" href=\"$base_url_edit&compliance_package_tp_id=$compliance_package_provider_name_item[compliance_package_tp_id]&action=edit_compliance_package\">add a new compliance package</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "";
echo "				<div class=\"content table\">";
echo "";

	$compliance_package_list = list_compliance_package(" WHERE compliance_package_tp_id = \"$compliance_package_provider_name_item[compliance_package_tp_id]\" AND compliance_package_disabled = \"0\"");


	foreach($compliance_package_list as $compliance_package_item) {

echo "					<table>";
echo "						<tr>";
echo "							<th><center>Package ID</th>";
echo "							<th>Compliance package name</th>";
echo "							<th>Description</th>";
echo "						</tr>";
echo "";
echo "						<tr>";
echo "							<td class=\"center\">$compliance_package_item[compliance_package_original_id]</td>";
echo "							<td class=\"action-cell\">";
echo "								<div class=\"cell-label\">";
echo "									$compliance_package_item[compliance_package_name]";
echo "								</div>";
echo "								<div class=\"cell-actions\">";
echo "	<a href=\"$base_url_edit&action=edit_compliance_package&compliance_package_id=$compliance_package_item[compliance_package_id]\" class=\"edit_action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "	<a href=\"$base_url_list&action=disable_compliance_package&compliance_package_id=$compliance_package_item[compliance_package_id]\" class=\"delete_action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "	<a href=\"$base_url_item_edit&action=edit_compliance_package_item&compliance_package_id=$compliance_package_item[compliance_package_id]\" class=\"delete_action\">add compliance package item</a>";
echo "								</div>";
echo "							</td>";
echo "							<td>$compliance_package_item[compliance_package_description]</td>";
echo "						</tr>";
echo "";
echo "					</table>";
echo "";
echo "<br>";
echo "					<div class=\"rounded\">";

			$compliance_package_item_list = list_compliance_package_item(" WHERE compliance_package_id = \"$compliance_package_item[compliance_package_id]\" 
									AND compliance_package_item_disabled = \"0\"
									");
	
			if ( count($compliance_package_item_list) != 0 ) {
					
echo "						<table class=\"sub-table\">";
echo "							<tr>";
echo "								<th><center>Item ID</th>";
echo "								<th>Item name</th>";
echo "								<th>Item description</th>";
echo "							</tr>";

			foreach($compliance_package_item_list as $compliance_package_item_item) {
			

echo "							<tr>";
echo "								<td class=\"center\">$compliance_package_item_item[compliance_package_item_original_id]</td>";
echo "								<td class=\"action-cell\">";
echo "									<div class=\"cell-label\">";
echo "										$compliance_package_item_item[compliance_package_item_name]";
echo "									</div>";
echo "									<div class=\"cell-actions\">";
echo "<a href=\"$base_url_item_edit&action=edit_compliance_package_item&compliance_package_id=$compliance_package_item[compliance_package_id]&compliance_package_item_id=$compliance_package_item_item[compliance_package_item_id]\" class=\"edit-action\">edit</a> ";
echo "	<a href=\"$base_url_list&action=disable_compliance_package_item&compliance_package_item_id=$compliance_package_item_item[compliance_package_item_id]\" class=\"delete-action\">delete</a>";
echo "									</div>";
echo "								</td>";
echo "								<td>$compliance_package_item_item[compliance_package_item_description]</td>";
echo "							</tr>";
			}

echo "						</table>";
			}
echo "					</div>				";
echo "<br>";

					}

echo "				</div>";
echo "			</li>";
			
			}
?>
		</ul>
		
		<br class="clear"/>
		
	</section>
</body>
</html>
