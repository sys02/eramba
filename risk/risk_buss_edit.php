	
<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/risk_lib.php");
	include_once("lib/risk_buss_process_join_lib.php");
	include_once("lib/asset_type_lib.php");
	include_once("lib/asset_lib.php");
	include_once("lib/legal_lib.php");
	include_once("lib/process_lib.php");
	include_once("lib/bu_lib.php");
	include_once("lib/asset_classification_lib.php");
	include_once("lib/risk_classification_lib.php");
	include_once("lib/risk_exception_lib.php");
	include_once("lib/risk_risk_exception_join_lib.php");
	include_once("lib/risk_mitigation_strategy_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/risk_security_services_join_lib.php");
	include_once("lib/bcm_plans_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$risk_id= $_GET["risk_id"];
	$tp_id= $_GET["tp_id"];
	
	$base_url_list = build_base_url($section,"risk_buss_list");

	if (is_numeric($risk_id)) {
		$risk_item = lookup_risk("risk_id",$risk_id);
	}

?>

	<section id="content-wrapper">
		<h3>Edit or Create a Business Risk</h3>
		<span class="description">Feared by many, impractical for others, loved for some. Most regulations are very strict in requesting a Risk Management framework being tailor made developed and used by any Security Program. This sections aims to aid on keeping track of such program, at least in it's most minimalistic way.</span>
				
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
<?
#echo "					<a href=\"$base_url&action=edit&risk_id=$risk_item[risk_id]\">General</a>";
?>
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">
<?
echo "					<form name=\"risk_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Risk Title</label>
						<span class="description">Give this risk a descriptive title</span>
<?
echo "						<input type=\"text\" class=\"filter-text\" name=\"risk_title\" id=\"\" value=\"$risk_item[risk_title]\"/>";
?>
						
						<label for="legalType">Applicable Business Units</label>
						<span class="description">Define to which Business Unit is this Risk is applicable</span>
						<select name="bu_id[]" id="" class="chzn-select" multiple="multiple">
						<option value="-1">Select one or many BU's...</option>
<?
			if ($risk_item[risk_id]) {
				$pre_selected_process_list = list_risk_buss_process_join(" WHERE risk_buss_process_join_risk_id = \"$risk_item[risk_id]\"");	
				$pre_selected_items = array();
				foreach($pre_selected_process_list as $pre_selected_process_item) {
					array_push($pre_selected_items,$pre_selected_process_item[risk_buss_process_join_bu_id]);
				}
			}
			list_drop_menu_bu($pre_selected_items,"bu_name");	
?>
		</select>
						
	</select>
	<label for="name">What is the business impact if this threats materializes?</label>
	<span class="description">Try a one line impact description.</span>
<?
echo "	<textarea id=\"\" class=\"filter-text\" name=\"risk_buss_what_if\">$risk_item[risk_buss_what_if]</textarea>";
?>
	<label for="name">Threats</label>
	<span class="description">Describe the applicable threats that apply to the asset we are Risk Analysing. This is a good time to get creative (realistic tough).</span>
<?
echo "	<textarea id=\"\" class=\"filter-text\" name=\"risk_threat\">$risk_item[risk_threat]</textarea>";
?>
						
	<label for="description">Vulnerabilities</label>
	<span class="description">For each one of the described threats, identify it's realted vulnerabilities.</span>
<?
echo "	<textarea id=\"\" class=\"filter-text\" name=\"risk_vulnerabilities\">$risk_item[risk_vulnerabilities]</textarea>";
?>
	</select>
	<br>
	<label for="legalType">Risk Classification</label>
	<span class="description">Use the previously defined risk classification criterias and choose the appropiate classification profile for this risk.</span>
<?
$risk_classification_types = list_risk_classification_distinct();

foreach($risk_classification_types as $risk_classification_types_item) {
	echo "<select name=\"risk_classification[]\" class=\"chzn-select\">";
	echo "<option value=\"-1\">Classification: $risk_classification_types_item[risk_classification_type]</option>";

	$pre_selected_value = pre_selected_risk_classification_values($risk_classification_types_item[risk_classification_type], $risk_item[risk_id]);	

	# llamar una funcion que me liste un html drop menu por cada classification type que yo le diga										
	list_drop_menu_risk_classification($pre_selected_value,"risk_classification_name","$risk_classification_types_item[risk_classification_type]");
	echo "</select>";
	echo "</br>";
}

?>
						<label for="name">Risk Score</label>
						<span class="description">Based on the previous classification, score (numerically) this Risk. Scores become handy at the time of prioritizing risks and provide visibility at a glance.</span>
<?
echo "						<input type=\"text\" class=\"filter-text\" name=\"risk_classification_score\" id=\"\" value=\"$risk_item[risk_classification_score]\"/>";
?>

						<label for="legalType">Risk Mitigation Strategy</label>
						<span class="description">Choose the most suitable mitigation strategy for this Risk</span>
						<select name="risk_mitigation_strategy_id" id="" class="chzn-select">
						<option value="-1">Select a Strategy...</option>
<?
						list_drop_menu_risk_mitigation_strategy($risk_item[risk_mitigation_strategy_id],"risk_mitigation_strategy_id");	
?>
						</select>

						<label for="legalType">Compensating Continuity Plans</label>
						<span class="description">Choose the most suitable continuity plans for this Risk</span>
						<select name="risk_mitigation_bcm_id" id="" class="chzn-select">
						<option value="-1">Select a Compensating Control...</option>
<?
			list_drop_menu_bcm_plans($risk_item[risk_mitigation_bcm_id],"bcm_plans_id");	
?>
						</select>
						
						<label for="name">Risk Residual Score</label>
						<span class="description">If a the time of choosing a Risk Mitigation strategy, your choice was a compensating control (Security Service) then it's important to document to what extent, that Risk Score has been changed (hopefully to a lower value). Remember, there's always a residual risk. Nothing is risk free.</span>
<?
echo "						<input type=\"text\" class=\"filter-text\" name=\"risk_residual_score\" id=\"\" value=\"$risk_item[risk_residual_score]\"/>";
?>
						
						<label for="legalType">Applicable Risk Exceptions</label>
						<span class="description">Altough more commonly used when Compensating controls are not feasible and the risk mitigation strategy is one of the accepting, transfer or avoid type Risk Exceptions are usefull management decisions to attach to a risk. It's better than have it addressed than neglected. If you havent choose any compensating control and opted for a Risk Exception instead, your Residual Risk should be the same as your original Risk Score.</span>
						<select name="risk_exception_id[]" id="" class="chzn-select" multiple="multiple">
						<option value="-1">Select a Risk Exception...</option>
<?
			$pre_selected_risk_exception_list = list_risk_risk_exception_join(" WHERE risk_risk_exception_join_risk_id = \"$risk_item[risk_id]\"");	
			$pre_selected_items = array();
			foreach($pre_selected_risk_exception_list as $pre_selected_risk_exception_item) {
				array_push($pre_selected_items,$pre_selected_risk_exception_item[risk_risk_exception_join_risk_exception_id]);
			}
			print_r($pre_selected_items);
			list_drop_menu_risk_exception($pre_selected_items,"risk_exception_id");	
?>
						</select>

						<label for="name">Risk Review Periodicity</label>
						<span class="description">Register the date at which this Risk will be re-evaluated.</span>
<?
echo "						<input type=\"text\" class=\"filter-date datepicker\" name=\"risk_periodicity_review\" id=\"\" value=\"$risk_item[risk_periodicity_review]\"/>";
?>



						
				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">
				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="risk">
				    <INPUT type="hidden" name="subsection" value="risk_buss_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"risk_id\" value=\"$risk_item[risk_id]\">"; ?>

			<a>
			    <INPUT type="submit" value="Submit" class="add-btn"> 
			</a>
			
<?
echo "			<a href=\"$base_url_list\" class=\"cancel-btn\">";
?>
				Cancel
				<span class="select-icon"></span>
			</a>
</form>
		</div>
		
		<br class="clear"/>
		
	</section>
</body>
</html>
