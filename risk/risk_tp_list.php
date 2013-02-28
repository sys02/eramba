<?
	include_once("lib/tp_lib.php");
	include_once("lib/risk_lib.php");
	include_once("lib/legal_lib.php");
	include_once("lib/risk_classification_lib.php");
	include_once("lib/risk_exception_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/risk_security_services_join_lib.php");
	include_once("lib/risk_tp_join_lib.php");
	include_once("lib/risk_tp_asset_join_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/security_services_status_lib.php");
	include_once("lib/risk_risk_exception_join_lib.php");
	include_once("lib/risk_mitigation_strategy_lib.php");
	include_once("lib/system_records_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$sort = filter_input(INPUT_GET,"sort",FILTER_SANITIZE_STRING);
	$section = filter_input(INPUT_GET,"section",FILTER_SANITIZE_STRING);
	$subsection = filter_input(INPUT_GET,"subsection",FILTER_SANITIZE_STRING);
	$action = filter_input(INPUT_GET,"action",FILTER_SANITIZE_STRING);
	
	$base_url_list = build_base_url($section,"risk_tp_list");
	$base_url_edit = build_base_url($section,"risk_tp_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$tp_id = $_GET["tp_id"];
	
	if ($action == "update") {
		if (is_array($tp_id)) {
			#echo "puta: tp_id is an array<br>";
			foreach($tp_id as $tp) {
				#check this is a valid tp
				$tp_information=lookup_tp("tp_id",$tp);
				if ($tp_information[tp_disabled]!="0") {
					#echo "puta: i'm not doing anything if i dont get a valid tp<br>";
					$action = NULL;
				}
			}
		} else {
			#echo "puta: no tp_id no game<br>";
			$action = NULL;
		}
	}

	$risk_id = $_GET["risk_id"];
	
	# if i get a risk_id, i want to make sure it's a really valid one...otherwise void
	if ($risk_id) {
		$risk_information = lookup_risk("risk_id",$risk_id);
		if ($risk_information[risk_disabled]!="0") {
			$action = NULL;
		}
	} 

	$risk_title = filter_input(INPUT_GET,"risk_title",FILTER_SANITIZE_STRING);
	$risk_tp_what = filter_input(INPUT_GET,"risk_tp_what",FILTER_SANITIZE_STRING);
	$risk_tp_how = filter_input(INPUT_GET,"risk_tp_how",FILTER_SANITIZE_STRING);
	$risk_threat = filter_input(INPUT_GET,"risk_threat",FILTER_SANITIZE_STRING);
	$risk_vulnerabilities = filter_input(INPUT_GET,"risk_vulnerabilities",FILTER_SANITIZE_STRING);
	$risk= filter_input(INPUT_GET,"risk",FILTER_SANITIZE_NUMBER_INT);
	# $tp_asset_id= filter_input(INPUT_GET,"tp_asset_id",FILTER_SANITIZE_NUMBER_INT);
	$tp_asset_id = $_GET["tp_asset_id"];
	$risk_classification = $_GET["risk_classification"];
	# $risk_classification= filter_input(INPUT_GET,"risk_classification",FILTER_SANITIZE_NUMBER_INT);
	$risk_classification_score = $_GET["risk_classification_score"];
	# $risk_classification_score= filter_input(INPUT_GET,"risk_classification_score",FILTER_SANITIZE_NUMBER_INT);
	if (!is_numeric($risk_classification_score)) {
		$risk_classification_score = 0;
	}

	if (!$risk_title) {
		$risk_title = "Un-named Risk";
	}

	# $risk_mitigation_strategy_id = $_GET["risk_mitigation_strategy_id"];
	$risk_mitigation_strategy_id= filter_input(INPUT_GET,"risk_mitigation_strategy_id",FILTER_SANITIZE_NUMBER_INT);
	# $security_services_id = $_GET["security_services_id"];
	$security_services_id= filter_input(INPUT_GET,"security_services_id",FILTER_SANITIZE_NUMBER_INT);
	# $risk_exception_id = $_GET["risk_exception_id"];
	$risk_exception_id= filter_input(INPUT_GET,"risk_exception_id",FILTER_SANITIZE_NUMBER_INT);

	$risk_periodicity_review = $_GET["risk_periodicity_review"];
	$risk_residual_score = $_GET["risk_residual_score"];
	if (!is_numeric($risk_residual_score)) {
		$risk_residual_score = $risk_classification_score;
	}

	$security_services_id = $_GET["security_services_id"];
	$risk_exception_id = $_GET["risk_exception_id"];
	
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" && is_numeric($risk_id) && !empty($tp_id)) {
		# echo "puta, deberia estar updateando risk tp";
		$risk_update = array(
			'risk_title' => $risk_title,
			'risk_tp_what' => $risk_tp_what,
			'risk_tp_how' => $risk_tp_how,
			'risk_threat' => $risk_threat,
			'risk_vulnerabilities' => $risk_vulnerabilities,
			'risk_classification_score' => $risk_classification_score,
			'risk_mitigation_strategy_id' => $risk_mitigation_strategy_id,
			'risk_periodicity_review' => $risk_periodicity_review,
			'risk_residual_score' => $risk_residual_score
		);	
		update_risk($risk_update,$risk_id);
		add_system_records("risk","risk_tp_edit","$risk_id",$_SESSION['logged_user_id'],"Update","");
		
		# delete all tps for this risk
		if ($risk_id) {
		delete_risk_tp_join($risk_id);
		}

		# add all selected tps for this risk
		if (is_array($tp_id)) {
			foreach($tp_id as $tp_item) {
				# now i insert this stuff
				add_risk_tp_join($risk_id, $tp_item);
			}
		}
		
		
		# delete all assets for this risk
		delete_risk_tp_asset_join($risk_id);
		
		# add all selected assets for this risk
		if (is_array($tp_asset_id)) {
			foreach($tp_asset_id as $tp_asset_item) {
				# now i insert this stuff
				add_risk_tp_asset_join($risk_id, $tp_asset_item);
			}
		}

		# delete all security services for this risk
		delete_risk_security_services_join($risk_id);
		# add all selected security services for this risk
		if (is_array($security_services_id)) {
			$count_security_services_id_item = count($security_services_id);
			for($count = 0 ; $count < $count_security_services_id_item ; $count++) {
				# now i insert this stuff
				add_risk_security_services_join($risk_id, $security_services_id[$count]);
			}
		}
		
		# delete all risk_exceptions for this risk
		delete_risk_risk_exception_join($risk_id);
		# add all selected security services for this risk
		if (is_array($risk_exception_id)) {
			$count_risk_exception_id_item = count($risk_exception_id);
			for($count = 0 ; $count < $count_risk_exception_id_item ; $count++) {
				# now i insert this stuff
				add_risk_risk_exception_join($risk_id, $risk_exception_id[$count]);
			}
		}

		# 1) delete all classifications for this risk
		delete_risk_classification_join($risk_id);
		# 2) insert all classification for this risk
		if (is_array($risk_classification)) {
			$count_risk_classification_item = count($risk_classification);
			for($count = 0 ; $count < $count_risk_classification_item ; $count++) {
				# now i insert this stuff
				add_risk_classification_join($risk_id, $risk_classification[$count]);
			}
		}

	} elseif ($action == "update" && !is_numeric($risk_id) && !empty($tp_id)) {

		$risk_update = array(
			'risk_title' => $risk_title,
			'risk_tp_what' => $risk_tp_what,
			'risk_tp_how' => $risk_tp_how,
			'risk_threat' => $risk_threat,
			'risk_vulnerabilities' => $risk_vulnerabilities,
			'risk_classification_score' => $risk_classification_score,
			'risk_mitigation_strategy_id' => $risk_mitigation_strategy_id,
			'risk_periodicity_review' => $risk_periodicity_review,
			'risk_residual_score' => $risk_residual_score
		);	
		$risk_id = add_risk($risk_update);

		add_system_records("risk","risk_tp_edit","$risk_id",$_SESSION['logged_user_id'],"Insert","");
		
		# delete all tps for this risk
		if ($risk_id) {
		delete_risk_tp_join($risk_id);
		}

		# add all selected tps for this risk
		if (is_array($tp_id)) {
			foreach($tp_id as $tp_item) {
				# now i insert this stuff
				add_risk_tp_join($risk_id, $tp_item);
			}
		}
		
		# delete all assets for this risk
		delete_risk_tp_asset_join($risk_id);
		
		# add all selected assets for this risk
		if (is_array($tp_asset_id)) {
			foreach($tp_asset_id as $tp_asset_item) {
				# now i insert this stuff
				add_risk_tp_asset_join($risk_id, $tp_asset_item);
			}
		}
		
		# delete all security services for this risk
		delete_risk_security_services_join($risk_id);
		# add all selected security services for this risk
		if (is_array($security_services_id)) {
			$count_security_services_id_item = count($security_services_id);
			for($count = 0 ; $count < $count_security_services_id_item ; $count++) {
				# now i insert this stuff
				add_risk_security_services_join($risk_id, $security_services_id[$count]);
			}
		}
		
		# delete all risk_exceptions for this risk
		delete_risk_risk_exception_join($risk_id);
		# add all selected security services for this risk
		if (is_array($risk_exception_id)) {
			$count_risk_exception_id_item = count($risk_exception_id);
			for($count = 0 ; $count < $count_risk_exception_id_item ; $count++) {
				# now i insert this stuff
				add_risk_risk_exception_join($risk_id, $risk_exception_id[$count]);
			}
		}

		# 1) delete all classifications for this risk
		delete_risk_classification_join($risk_id);
		# 2) insert all classification for this risk
		if (is_array($risk_classification)) {
			$count_risk_classification_item = count($risk_classification);
			for($count = 0 ; $count < $count_risk_classification_item ; $count++) {
				# now i insert this stuff
				add_risk_classification_join($risk_id, $risk_classification[$count]);
			}
		}
		
	 }

	if ($action == "disable" & is_numeric($risk_id)) {
		disable_risk($risk_id);
		delete_risk_tp_join($risk_id);
		add_system_records("risk","risk_tp_edit","$risk_id",$_SESSION['logged_user_id'],"Disable","");
		#i should also disable all risk asociated items
	}

	if ($action == "csv") {
		export_risk_tp_csv();
		add_system_records("risk","risk_tp_edit","$risk_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>


	<section id="content-wrapper">
		<h3>Third Party Risk Analysis</h3>
		<span class=description>Identifying and analysing Risks can be usefull if executed in a simple and practical way. For each Third Party identify and analyse risks.</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit_risk\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add a new Risk 
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
echo '<li><a href="' . $base_url_list . '&download_export=risk_export">Download</a></li>';
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>

		</div>
			
		
		<ul id="accordion">
			
<?
	$tp_list = list_tp(" WHERE tp_disabled=\"0\"");
	foreach($tp_list as $tp_item) {

	echo "<br><h4>Third Party Name: $tp_item[tp_name]</h4>";

	$risk_list = list_risk_tp_join(" WHERE risk_tp_join_tp_id = \"$tp_item[tp_id]\"");

	if (count($risk_list)==NULL) {	
		continue;
	} else {

	foreach ($risk_list as $risk_item) {

	$risk_data = lookup_risk("risk_id",$risk_item[risk_tp_join_risk_id]);
	$risk_mitigation = lookup_risk_mitigation_strategy("risk_mitigation_strategy_id",$risk_data[risk_mitigation_strategy_id]); 

	# i'm now checking the expcetions asociated for expiration date
	$risk_exception_for_this_risk_list = list_risk_risk_exception_join(" WHERE risk_risk_exception_join_risk_id = \"$risk_data[risk_id]\""); 
	foreach($risk_exception_for_this_risk_list as $risk_exception_for_this_risk_item) {
		if (check_risk_exception($risk_exception_for_this_risk_item[risk_risk_exception_join_risk_exception_id])) {
			$warning_expired_exception= " - (Warning: Expired Risk Exception)";
		} else {
			$warning_expired_exception= "";
		}
	}

	unset($risk_exception_expiration);

	# i'm checking if the risk expiration review is ok or not 
	if (check_expired_risk_review($risk_data[risk_id])) {
		$warning_expired_risk = " - (Warning: Expired Risk Review)";
	} else {
		$warning_expired_risk = "";
	}

	# i'm now checking if the controls asociated with this risk (if any) are ok or not
	$security_services_for_this_risk_list = list_risk_security_services_join(" WHERE risk_security_services_join_risk_id = \"$risk_data[risk_id]\""); 

	# want to mitigate but have no controls?
	if (count($security_services_for_this_risk_list) <= "0" && $risk_data[risk_mitigation_strategy_id] == "3") {
			$warning_no_control = " - (Warning: You want to mitigate but there's no controls!)";
	}

	foreach($security_services_for_this_risk_list as $security_services_for_this_risk_item) {
		if ( security_service_check($security_services_for_this_risk_item[risk_security_services_join_security_services_id])) {
			$warning_control = " - (Warning: Mitigation Controls with Issues)";
		} else {
			$warning_control = "";
		}
	}	

	unset($security_services_for_this_risk_list);



echo "			<li>";
echo "				<div class=\"header\">";
echo "					Risk Title: $risk_data[risk_title] $warning_expired_risk $warning_control $warning_expired_exception $warning_no_control";

	unset($warning_expired_risk);
	unset($warning_control);
	unset($warning_expired_exception);
	unset($warning_no_controls);
	
echo "					<span class=\"actions\">";
echo "						<a class=\"edit\" href=\"$base_url_edit&action=edit&risk_id=$risk_data[risk_id]\">edit</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?section=system&subsection=system_records_list&system_records_lookup_section=risk&system_records_lookup_subsection=risk_tp_edit&system_records_lookup_item_id=$risk_data[risk_id]\">records</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"delete\" href=\"?action=edit&section=operations&subsection=project_improvements_edit&ciso_pmo_lookup_section=risk&ciso_pmo_lookup_subsection=risk_tp_edit&ciso_pmo_lookup_item_id=$risk_data[risk_id]\">improve</a>";
echo "						&nbsp;|&nbsp;";
echo "						<a class=\"edit\" href=\"$base_url_list&action=disable&risk_id=$risk_data[risk_id]\">delete</a>";
echo "					</span>";
echo "					<span class=\"icon\"></span>";
echo "				</div>";
echo "				<div class=\"content table\">";
echo "					<table>";
echo "						<tr>";
echo "							<th>Threats</th>";
echo "							<th>Vulnerabilities</th>";
echo "							<th class=\"center\">Risk Score</th>";
echo "							<th class=\"center\">Mitigation Strategy</th>";
echo "							<th class=\"center\">Review Periodicity</th>";
echo "							<th class=\"center\">Residual Risk</th>";
echo "						</tr>";

echo "						<tr>";
echo "							<td class=\"action-cell\">";
echo "								 	$risk_data[risk_threat]";
echo "							</td>";
echo "							<td>$risk_data[risk_vulnerabilities]</td>";
echo "							<td><center>$risk_data[risk_classification_score]</td>";
echo "							<td><center>$risk_mitigation[risk_mitigation_strategy_name]</td>";
echo "							<td><center>$risk_data[risk_periodicity_review]</td>";
echo "							<td><center>$risk_data[risk_residual_score]</td>";
echo "						</tr>";
	#}

echo "					</table>";
echo "<br>";


echo "<div class=\"rounded\">";
echo "<table class=\"sub-table\">";
echo "<tr>";
echo "<th class=\"center\">Why assets  will be shared with this TP?</th>";
echo "<th class=\"center\">How it will be controled</th>";
echo "</tr>";
echo "<tr>";
echo "<td class=\"left\">".substr($risk_data[risk_tp_what],0,200)."...</td>";
echo "<td class=\"left\">".substr($risk_data[risk_tp_how],0,200)."...</td>";
echo "</tr>";
echo "</table>";
echo "</div>";



echo "<br>";
echo "<div class=\"rounded\">";
echo "<table class=\"sub-table\">";
echo "<tr>";
echo "<th class=\"center\">Assets Shared with TP</th>";
echo "<th class=\"center\">Asset Description</th>";
echo "</tr>";

$pre_selected_asset_list = list_risk_tp_asset_join(" WHERE risk_tp_asset_join_risk_id = \"$risk_data[risk_id]\"");	

foreach($pre_selected_asset_list as $pre_selected_asset_item) {

	$asset_data = lookup_asset("asset_id",$pre_selected_asset_item[risk_tp_asset_join_asset_id]);

	echo "<tr>";
	echo "<td class=\"left\">$asset_data[asset_name]</td>";
	echo "<td class=\"left\">".substr($asset_data['asset_description'],0,200)."...</td>";
	echo "</tr>";

}

echo "</table>";
echo "</div>";
echo "<br>";
echo "<br>";
### INJERTO STARTS
echo "					<div class=\"rounded\">";
echo "						<table class=\"sub-table\">";
echo "							<tr>";
	# first i create columns for each category .. no more than 5!
	$risk_classification_list = list_risk_classification_distinct();
	foreach($risk_classification_list as $risk_classification_item) {
		echo "<th><center>$risk_classification_item[risk_classification_type]</th>";
	}
echo "							</tr>";
echo "							<tr>";
	# now i put the values 
	$risk_classification_list = list_risk_classification_distinct();
	foreach($risk_classification_list as $risk_classification_item) {
		# echo "Trola: $risk_classification_item[risk_classification_type] risk: $risk_data[risk_id]";
		$value = pre_selected_risk_classification_values($risk_classification_item[risk_classification_type], $risk_data[risk_id]);	
		# echo "classification: $value";
		$name = lookup_risk_classification("risk_classification_id", $value);
		echo "<td><center>$name[risk_classification_name]</td>";
	}

echo "							</tr>";
echo "						</table>";
echo "					</div>";
echo "<br>";
echo "					<div class=\"rounded\">";
echo "			<table class=\"sub-table\">";
echo "				<tr>";
echo "					<th class=\"center\">Mitigation Control</th>";
echo "					<th class=\"center\">Objective</th>";
echo "					<th class=\"center\">Status</th>";
echo "					<th class=\"center\">Audit Results</th>";
echo "				</tr>";

$security_services_for_this_risk_list = list_risk_security_services_join(" WHERE risk_security_services_join_risk_id = \"$risk_data[risk_id]\""); 
foreach($security_services_for_this_risk_list as $security_services_for_this_risk_item) {
	$security_service_data = lookup_security_services("security_services_id",$security_services_for_this_risk_item[risk_security_services_join_security_services_id]);	
	$security_services_status_name = lookup_security_services_status("security_services_status_id",$security_service_data[security_services_status]);
echo "				<tr>";
	echo "<td class=\"left\">$security_service_data[security_services_name]</td>";
	echo "<td class=\"left\">".substr($security_service_data[security_services_objective],0,100)."...</td>";
	echo "<td class=\"center\">$security_services_status_name[security_services_status_name]</td>";

	if ( check_service_last_audit_result($security_services_for_this_risk_item[risk_security_services_join_security_services_id]) ) {
		$audit_result = "Ok";
	} else {
		$audit_result = "Not Ok";
	}
	echo "<td class=\"center\">$audit_result</td>";


echo "				</tr>";
}
echo "			</table>";
echo "					</div>";
echo "<br>";
echo "					<div class=\"rounded\">";
echo "			<table class=\"sub-table\">";
echo "				<tr>";
echo "					<th class=\"center\">Risk Exceptions</th>";
echo "					<th class=\"center\">Description</th>";
echo "					<th class=\"center\">Author</th>";
echo "					<th class=\"center\">Expiration</th>";
echo "				</tr>";
$risk_exception_for_this_risk_list = list_risk_risk_exception_join(" WHERE risk_risk_exception_join_risk_id = \"$risk_data[risk_id]\""); 
foreach($risk_exception_for_this_risk_list as $risk_exception_for_this_risk_item) {
	$risk_exception_data = lookup_risk_exception("risk_exception_id",$risk_exception_for_this_risk_item[risk_risk_exception_join_risk_exception_id]);	
echo "				<tr>";
	echo "<td class=\"left\">$risk_exception_data[risk_exception_title]</td>";
	echo "<td class=\"left\">$risk_exception_data[risk_exception_description]</td>";
	echo "<td class=\"center\">$risk_exception_data[risk_exception_author]</td>";
	echo "<td class=\"center\">$risk_exception_data[risk_exception_expiration]</td>";
echo "				</tr>";
}
echo "			</table>";
echo "					</div>";
echo "<br>";

### INJERTO ENDS
echo "				</div>";
echo "			</li>";
	}
	}
	}
?>
		</ul>
		
		<br class="clear"/>
		
	</section>
