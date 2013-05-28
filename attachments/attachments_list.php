<?
	include_once("lib/attachments_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_POST["action"];
	$compliance_audit_id = $_GET["compliance_audit_id"];
	$attachments_id = $_GET["attachments_id"];
	
	$attachments_ref_section = $_POST["attachments_ref_section"];
	$attachments_ref_subsection = $_POST["attachments_ref_subsection"];
	
	if (empty($_POST["action"])) {
		$action = $_GET["action"];
	}
		
	$attachments_ref_id= $_POST["attachments_ref_id"];
	
	$base_url_list_ref = build_base_url("$attachments_ref_section","$attachments_ref_subsection");
	$base_url_audit_list = build_base_url("compliance","compliance_audit_list");
	$attachment_base_url_list_ref = build_base_url("attachments","attachments_list");

	if ($action == "upload") {


	if ($_FILES["file"]["error"] > 0) {
		echo "Error: " . $_FILES["file"]["error"] . "<br>";
	} else {

		# i get thte original filename
		$attachments_original_name = $_FILES["file"]["name"];
		$attachments_upload_date = give_me_date();

		# generar un ID unico para este archivo
		$attachments_unique_name = uniqid("",TRUE);
	
		# stores the file with this filename
		if (file_exists("downloads/uploads/$attachments_unique_name")) {
			die("Cant save the file<br>");
		} else {
			if(move_uploaded_file($_FILES["file"]["tmp_name"], "downloads/uploads/$attachments_unique_name")) {

				# since the upload went ok, i need to uplaod the info on the database
				
				$attachments = array(
					'attachments_original_name' => $attachments_original_name,
					'attachments_unique_name' => $attachments_unique_name,
					'attachments_ref_section' => $attachments_ref_section,
					'attachments_ref_subsection' => $attachments_ref_subsection,
					'attachments_ref_id' => $attachments_ref_id,
					'attachments_upload_date' => $attachments_upload_date
				);	

				$di = add_attachments($attachments);
				add_system_records("attachments","attachments_list","$di",$_SESSION['logged_user_id'],"File uploaded: $attachments_unique_name","");

				$compliance_audit_id = $attachments[attachments_ref_id];

			} else { 
				die("Cant save the file<br>");
			}


		}

	}

	}

	if ($action == "disable") {
		disable_attachments($attachments_id);
		add_system_records("compliance","attachments_edit",$attachments_id,$_SESSION['logged_user_id'],"Disable","");
	}


	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>Attachment Lists</h3>
		<span class=date>This list shows the number of attachments for a given element</span>
		<br>
		<br>
		<div class="controls-wrapper">
			
		</div>
		<br class="clear"/>
		
		<table class="main-table">
			<thead>
				<tr>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=attachments_unique_name\">File Name</a></th>";
echo "					<th>Source</th>";
echo "					<th><a href=\"$base_url_list&sort=attachments_upload_date\">Upload Date</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------

	if ($compliance_audit_id) {

		$attachments_list = list_attachments(" WHERE attachments_disabled = 0 AND attachments_ref_id = \"$compliance_audit_id\"");

	} else {
	
		if ($show_id) {
			$attachments_list = list_attachments(" WHERE attachments_disabled = 0 AND attachments_id = \"$show_id\"");
		} else {
			if ($sort == "attachments_unique_name" OR $sort == "attachments_upload_date") {
				$attachments_list = list_attachments(" WHERE attachments_disabled = 0 ORDER by $sort");
			} else {
				$attachments_list = list_attachments(" WHERE attachments_disabled = 0");
			}
		}
	}


	if (count($attachments_list)>0) {

	foreach($attachments_list as $attachments_item) {

				if (!$attachments_ref_id) {

					$attachments_ref_id = $attachments_item[attachments_ref_id];	
					$attachments_ref_section = $attachments_item[attachments_ref_section]; 
					$attachments_ref_subsection = $attachments_item[attachments_ref_subsection]; 

					$base_url_list_ref = build_base_url("$attachments_ref_section","$attachments_ref_subsection");
				}

echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "						<a href=\"$base_url_audit_list&download_attachment=$attachments_item[attachments_unique_name]\">$attachments_item[attachments_original_name]</a>";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "					<a href=\"$attachment_base_url_list_ref&action=disable&attachments_id=$attachments_item[attachments_id]&attachments_ref_id=$attachments_ref_id&attachments_ref_section=$attachments_ref_section&attachments_ref_subsection=$attachments_ref_subsection&compliance_audit_id=$attachments_ref_id\" class=\"delete-action\">delete</a>";
echo "						</div>";
echo "					</td>";
echo "					<td><a href=\"$base_url_list_ref&show_id=$attachments_ref_id\">Go!</a></td>";
echo "					<td>$attachments_item[attachments_upload_date]</td>";
echo "				</tr>";
	}
	}

?>
			</tbody>
		</table>

	<?
echo "			<a href=\"$base_url_audit_list\" class=\"cancel-btn\">";
?>
				Cancel
				<span class="select-icon"></span>
			</a>
		
		<br class="clear"/>
	</section>
