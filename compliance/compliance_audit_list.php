<?
	include_once("lib/compliance_audit_lib.php");
	include_once("lib/compliance_finding_lib.php");
	include_once("lib/compliance_package_lib.php");
	include_once("lib/compliance_package_item_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/tp_lib.php");
	include_once("lib/compliance_audit_management_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$tp_id = $_GET["tp_id"];

	# compliance managemnet audit sends me stuff on POST, not GET .. so..
	if (empty($action) ) {
		$action = $_POST[action];
	}
	if (empty($tp_id) ) {
		$tp_id = $_POST[tp_id];
	}
	if (empty($audit_id) ) {
		$audit_id = $_POST[audit_id];
	}
	
	$base_url_list = build_base_url($section,"compliance_audit_list");
	$base_url_edit = build_base_url($section,"compliance_audit_edit");
	
	$base_url_edit_finding = build_base_url($section,"compliance_finding_edit");
	$base_url_list_finding = build_base_url($section,"compliance_finding_list");
	
	$base_url_edit_compliance = build_base_url($section,"compliance_audit_management_edit");

	$base_url_edit_attachments = build_base_url("attachments","attachments_edit");
	$base_url_list_attachments = build_base_url("attachments","attachments_list");

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
	$compliance_finding_package_item_id = $_GET["compliance_finding_package_item_id"];
	 
	# actions in regards to the status of the audit
	if ( $action == "re-open_audit" ) {
		update_compliance_audit_status($compliance_audit_id, "0");
		add_system_records("compliance","compliance_audit_edit","$compliance_audit_id",$_SESSION['logged_user_id'],"Update","Status changed to: Re-Open");
	} elseif ($action == "start_audit") {
		update_compliance_audit_status($compliance_audit_id, "1");
		add_system_records("compliance","compliance_audit_edit","$compliance_audit_id",$_SESSION['logged_user_id'],"Update","Status changed to: Started");
	} elseif ($action == "close_audit") {
		update_compliance_audit_status($compliance_audit_id, "2");
		add_system_records("compliance","compliance_audit_edit","$compliance_audit_id",$_SESSION['logged_user_id'],"Update","Status changed to: Closed");
	}

	if ($action == "update_compliance_audit_management") {

		# i must search all compliance_item_packages for this tp_id and then make sure i can read and store the information
		if ( is_numeric($tp_id) ) {

			$compliance_package = list_compliance_package(" WHERE compliance_package_tp_id = \"$tp_id\"");	
			if (count($compliance_package)>0) {

				foreach($compliance_package as $compliance_package_item) {
					$compliance_package_item_item = list_compliance_package_item(" WHERE compliance_package_id = \"$compliance_package_item[compliance_package_id]\" ");	

				foreach($compliance_package_item_item as $item) {

				$tmp_auditor="auditor_name_pack_item_id:".$item[compliance_package_item_id]."";
				$tmp_feedback="feedback_pack_item_id:".$item[compliance_package_item_id]."";

				# $compliance_package_item[compliance_package_item_id] -> That's the key i'm searching on the array $_GET ...
				# I ONLY STORE IN THE DATABASE AUDIT INFORMATION FOR THOSE ITEMS THAT I ACCUTALLY GET AUDIT INFORMATION
				if (!empty($_POST[$tmp_auditor]) && !empty($_POST[$tmp_feedback]) ) {

					# if i have any entry with this id on the table compliance_audit_management_tbl
					# i destroy it and i update it with what i just got

					#$tmp = lookup_compliance_audit_management("compliance_audit_management_comp_item_id",$item[compliance_package_item_id]);
					$tmp = lookup_compliance_audit_management_for_specific_audit($audit_id,$item[compliance_package_item_id]);

					if (!empty($tmp[compliance_audit_management_comp_item_id])) {

						# echo "i have something iwth this id, in eed to update better<br>";
						$audit = array(
							'compliance_audit_management_audit_name' => $_POST[$tmp_auditor],
							'compliance_audit_management_feedback' => $_POST[$tmp_feedback]
						);	
						update_compliance_audit_management($audit, $item[compliance_package_item_id],$audit_id);
						add_system_records("compliance","compliance_audit_list",$item[compliance_package_item_id],$_SESSION['logged_user_id'],"Update","");
					} else {
						# echo "i DONT have something iwth this id, in INSERT<br>";
						$audit = array(
							'compliance_audit_management_audit_id' => $audit_id,
							'compliance_audit_management_comp_item_id' => $item[compliance_package_item_id],
							'compliance_audit_management_audit_name' => $_POST[$tmp_auditor],
							'compliance_audit_management_feedback' => $_POST[$tmp_feedback]
						);	
						$audit_insert_id = add_compliance_audit_management($audit);
						add_system_records("compliance","compliance_audit_list",$audit_insert_id,$_SESSION['logged_user_id'],"Insert","");
						
					}
			
				} else {
					# IF I POST INCOMPLETE AUDITOR OR FEEDBACK FOR ONE ITEM
					# THEN I NEED TO DELETE DE ENTIRE DATA FOR THAT ITEM WITH A DELETE
					delete_compliance_audit_management($item[compliance_package_item_id],$audit_id);
					add_system_records("compliance","compliance_audit_list",$item[compliance_package_item_id],$_SESSION['logged_user_id'],"DELETE","");

				}

				unset($tmp_auditor);
				unset($tmp_feedback);

				}

				}
			}
		}
	
#		$tmp = "auditor_name_pack_item_id:".$compliance_package_item_id."";
#
#		if (array_key_exists("auditor_name_pack_item_id:".$compliance_package_item_id."", $_GET) ) {
#			echo $_GET["auditor_name_pack_item_id:".$compliance_package_item_id.""];
#		} else {
#			echo "fuck<br>";
#		}
	}

	# actions for compliance findings stuff ..
	if ($action == "edit_compliance_finding" & is_numeric($compliance_finding_id)) {
		$compliance_finding_update = array(
			'compliance_finding_title' => $compliance_finding_title,
			'compliance_finding_description' => $compliance_finding_description,
			'compliance_finding_deadline' => $compliance_finding_deadline,
			'compliance_finding_package_item_id' => $compliance_finding_package_item_id,
			'compliance_finding_status' => $compliance_finding_status
		);	
		update_compliance_finding($compliance_finding_update,$compliance_finding_id);
		add_system_records("compliance","compliance_finding_edit","$compliance_finding_id",$_SESSION['logged_user_id'],"Update","");

	} elseif ($action == "edit_compliance_finding") {
		$compliance_finding_update = array(
			'compliance_audit_id' => $compliance_audit_id,
			'compliance_finding_title' => $compliance_finding_title,
			'compliance_finding_description' => $compliance_finding_description,
			'compliance_finding_deadline' => $compliance_finding_deadline,
			'compliance_finding_package_item_id' => $compliance_finding_package_item_id,
			'compliance_finding_status' => $compliance_finding_status
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
		<h3>Audit Management</h3>
		<span class=date>Keep your audits tidy and well documented. </span>
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
echo "					<th><center><a href=\"$base_url&sort=compliance_audit_expiration\">Audit Progress</a></th>";
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

if ( $compliance_audit_item[compliance_audit_status]  == "0") {
	$msg = "Not Initiated";
} elseif ($compliance_audit_item[compliance_audit_status]  == "1") {
	$msg = "Initiated";
} elseif ($compliance_audit_item[compliance_audit_status]  == "2") {
	$msg = "Closed";
}
						echo " - ($msg)";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "					<a href=\"$base_url_edit&action=edit&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action\">edit</a> ";
echo "						&nbsp;|&nbsp;";
echo "					<a href=\"$base_url_list&action=disable&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">delete</a>";
echo "						&nbsp;|&nbsp;";
echo "					<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=compliance&system_records_lookup_subsection=compliance_audit_edit&system_records_lookup_item_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action delete-action\">records</a>";
echo "					<a href=\"?action=edit&section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=compliance&ciso_pmo_lookup_subsection=compliance_audit_edit&ciso_pmo_lookup_item_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">improve</a>";

# here set the option to start or to close an audit
# if status = 0 -> audit not started (i should display "start audit")
# if status = 1 -> audit started (i should display "close audit")
# if status = 2 -> audit closed (i should display "??")
if ( $compliance_audit_item[compliance_audit_status]  == "0") {

	echo "<a href=\"?action=start_audit&section=compliance&subsection=compliance_audit_list&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">| start audit</a>";

} elseif ($compliance_audit_item[compliance_audit_status]  == "1") {
	
	echo "<a href=\"?action=close_audit&section=compliance&subsection=compliance_audit_list&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">| close audit</a>";

} elseif ($compliance_audit_item[compliance_audit_status]  == "2") {
	
	echo "<a href=\"?action=re-open_audit&section=compliance&subsection=compliance_audit_list&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">| re-open closed audit</a>";

}

echo "						</div>";
echo "					</td>";
echo "					<td>$compliance_audit_item[compliance_audit_date]</td>";

	$compliance_package_name = lookup_tp("tp_id",$compliance_audit_item[compliance_audit_package_id]); 

	$counter_items = array();
	$counter_items = compliance_items_on_tp($compliance_audit_item[compliance_audit_package_id],$compliance_audit_item[compliance_audit_id]);
	$missing_math = round(($counter_items[1]*100)/$counter_items[0],1);

echo "<td>$compliance_package_name[tp_name]</td>";

if ( $compliance_audit_item[compliance_audit_status]  == "1" ) {
echo "	<td class=\"action-cell\"> $missing_math % Complete
	<div class=\"cell-label\">
	";
echo "	</div>";
echo "
<div class=\"cell-actions\">
<a href=\"$base_url_edit_compliance&tp_id=$compliance_audit_item[compliance_audit_package_id]&audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"delete-action\">Audit!</a> 
	</td>";
} else {
	echo "<td>$missing_math % Complete</td>";
}

echo "	<td class=\"action-cell\"> 
	<div class=\"cell-label\">
	";

	$count = list_compliance_finding(" WHERE compliance_finding_disabled = \"0\" AND compliance_audit_id = \"$compliance_audit_item[compliance_audit_id]\" ");	
	echo count($count). " Items";

echo "	</div>";

echo "
<div class=\"cell-actions\">
<a href=\"$base_url_edit_finding&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action\">add finding</a> 
<a href=\"$base_url_list_finding&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action\">view all finding</a>
<a href=\"$base_url_edit_attachments&attachments_ref_section=compliance&attachments_ref_subsection=compliance_audit_list&attachments_ref_id=$compliance_audit_item[compliance_audit_id]\" class=\"edit-action\">add attachment</a>
<a href=\"$base_url_list_attachments&compliance_audit_id=$compliance_audit_item[compliance_audit_id]\" class=\"\">view all attachments</a>
						</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
