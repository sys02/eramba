<?

	include_once("lib/bcm_plans_lib.php");
	include_once("lib/project_improvements_lib.php");
	include_once("lib/project_improvements_status_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/security_services_status_lib.php");
	include_once("lib/security_services_status_lib.php");
	include_once("lib/security_services_audit_calendar_lib.php");
	include_once("lib/bcm_plans_catalogue_audit_calendar_join_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$bcm_plans_id = $_GET["bcm_plans_id"];
	
	$base_url_list = build_base_url($section,"bcm_plans_list");

	if (is_numeric($bcm_plans_id)) {
		$plan_item = lookup_bcm_plans("bcm_plans_id",$bcm_plans_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Continuity Plan</h3>
		<span class="description">Use this form to create or edit a Continuity Plan</span>
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">
<?
echo "					<form name=\"edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Plan Title</label>
						<span class="description">Give the plan a title, name or code so it's easily identified on the plan list menu</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"bcm_plans_title\" id=\"bcm_plans_title\" value=\"$plan_item[bcm_plans_title]\"/>";?>
						
	<label for="description">Plan Objective</label>
	<span class="description">Describe the plan objective, it should be something short and straightforward to understand.</span>
<? echo "<textarea name=\"bcm_plans_objective\" class=\"filter-text\">$plan_item[bcm_plans_objective]</textarea>";?>
	
	<label for="description">Plan Audit Metric</label>
	<span class="description">Continuity plans without regular testing and audits are doomed to fail. Set your audit metric criteria (Response time?, etc)</span>
<? echo "<textarea name=\"bcm_plans_metric\" class=\"filter-text\">$plan_item[bcm_plans_metric]</textarea>";?>
	
	<label for="description">Success Criteria</label>
	<span class="description">Define a success criteria for the metric you have just defined (Under 2 hs, etc)</span>
<? echo "<textarea name=\"bcm_plans_success_criteria\" class=\"filter-text\">$plan_item[bcm_plans_success_criteria]</textarea>";?>
						
						
	<label for="description">Plan Sponsor</label>
	<span class="description">Who is responsible for keeping this plan realitistic, communicateed and applicable? (quite a job, right?)</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"bcm_plans_sponsor_name\" id=\"bcm_plans_sponsor_name\" value=\"$plan_item[bcm_plans_sponsor_name]\"/>";?>
	
	<label for="description">Lunch Criteria</label>
	<span class="description">Describe the criteria the plan responsible should use to know if it's appropiate to kick the plan or not in the case of an emergency.</span>
<? echo "<textarea name=\"bcm_plans_lunch_criteria\" class=\"filter-text\">$plan_item[bcm_plans_lunch_criteria]</textarea>";?>
	
	<label for="description">Lunch Responsible</label>
	<span class="description">There should be someone who is authorized to lunch this plan (sometimes the Plan Sponsor)</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"bcm_plans_who_declares\" id=\"bcm_plans_who_declares\" value=\"$plan_item[bcm_plans_who_declares]\"/>";?>
	
	<label for="legalType">Plan Status</label>
	<span class="description">Describe the status of the plan. Only productive plans are considered "live" plans!</span>
	<select name="bcm_plans_status" id="" class="chzn-select">
	<option value="-1">Select the Plan Status</option>
<?
	list_drop_menu_security_services_status($plan_item[bcm_plans_status],"");	
?>
	</select>

	<label for="name">Regular Review (Audit)</label>
	<span class="description">Trust but control, that's my mother in law piece of advice for my wife... At regular intervals, it's a very good idea to audit (internaly or by third parties) continuity plans. Choose one or many months on which you'll each year review this service.</span>
						<select name="bcm_plans_audit_calendar[]" id="" class="" multiple="multiple">
<?
	$pre_selected_list = list_bcm_plans_catalogue_audit_calendar_join(" WHERE bcm_plans_catalogue_id = \"$plan_item[bcm_plans_id]\""); 
	$pre_selected_items = array();
	foreach($pre_selected_list as $pre_selected_audits) {
			array_push($pre_selected_items,$pre_selected_audits[bcm_plans_audit_calendar_id]);
	}
	list_drop_menu_security_services_audit_calendar($pre_selected_items, "");	
?>
						</select>

			</div>
			<div class="tab" id="tab2">
				advanced tab
			</div>
		</div>
	</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="edit">
				    <INPUT type="hidden" name="section" value="bcm">
				    <INPUT type="hidden" name="subsection" value="bcm_plans_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"bcm_plans_id\" value=\"$plan_item[bcm_plans_id]\">"; ?>
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
