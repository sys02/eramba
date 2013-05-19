<?

	include_once("lib/project_improvements_lib.php");
	include_once("lib/project_improvements_status_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$project_improvements_id = $_GET["project_improvements_id"];
	
	$base_url_list = build_base_url($section,"project_improvements_list");

	if (is_numeric($project_improvements_id)) {
		$project_improvements_item = lookup_project_improvements("project_improvements_id",$project_improvements_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Project</h3>
		<span class="description">Use this form to create or edit new improvement projects</span>
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
						<label for="name">Project Title</label>
						<span class="description">Give the project a title, name or code so it's easily identified on the project list menu</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"project_improvements_title\" id=\"project_improvements_title\" value=\"$project_improvements_item[project_improvements_title]\"/>";?>
						
	<label for="description">Goal</label>
	<span class="description">Describe the project Goal, it's roadmap and deliverables.</span>
<? echo "<textarea name=\"project_improvements_goal\" class=\"filter-text\">$project_improvements_item[project_improvements_goal]</textarea>";?>
	
	<label for="description">RCA</label>
	<span class="description">Describe the root cause analysis of why this is required.</span>
<? echo "<textarea name=\"project_improvements_goal\" class=\"filter-text\">$project_improvements_item[project_improvements_rca]</textarea>";?>
	
	<label for="description">Proactive Plan</label>
	<span class="description">If this project aims to mitigate an incident or improve something on your system, describe the proactive plans (stop the bleeding).</span>
<? echo "<textarea name=\"project_improvements_goal\" class=\"filter-text\">$project_improvements_item[project_improvements_proactive]</textarea>";?>
		
	<label for="description">Reactive Plan</label>
	<span class="description">If this project aims to mitigate an incident or improve something on your system, describe the long term plans.</span>
<? echo "<textarea name=\"project_improvements_goal\" class=\"filter-text\">$project_improvements_item[project_improvements_reactive]</textarea>";?>
						
	<label for="description">Project Start Date</label>
	<span class="description">Document the project kick-off date. The date format for this field is YYYY-MM-DD, the default is todays date.</span>
<? echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"project_improvements_start\" id=\"project_improvements_start\" value=\"$project_improvements_item[project_improvements_start]\"/>";?>
						
	<label for="description">Project Deadline</label>
	<span class="description">Document the project deadline. The date format for this field is YYYY-MM-DD, the default is todays date.</span>
<? echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"project_improvements_deadline\" id=\"project_improvements_deadline\" value=\"$project_improvements_item[project_improvements_deadline]\"/>";?>
						
	<label for="description">Project Owner</label>
	<span class="description">Document the project owner, someone who is responsible for make this project deliver what has been documented on the times specified above</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"project_improvements_owner_id\" id=\"project_improvements_owner_id\" value=\"$project_improvements_item[project_improvements_owner_id]\"/>";?>
	
	<label for="description">Planned Budget</label>
	<span class="description">Document the planned and approved budget for this project</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"project_improvements_plan_budget\" id=\"project_improvements_plan_budget\" value=\"$project_improvements_item[project_improvements_plan_budget]\"/>";?>
	
	<label for="description">Current Budget</label>
	<span class="description">Document the current budget for this project</span>
<? echo "<input type=\"text\" class=\"filter-text\" disabled=\"disabled\" name=\"project_improvements_current_budget\" id=\"project_improvements_current_budget\" value=\"$project_improvements_item[project_improvements_current_budget]\"/>";?>
						
	<label for="legalType">Project Status</label>
	<span class="description"></span>
	<select name="project_improvements_status_id" id="" class="chzn-select">
	<option value="-1">Select the Project Status</option>
<?
	list_drop_menu_project_improvements_status($project_improvements_item[project_improvements_status_id],"project_improvements_status_id");	
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
				    <INPUT type="hidden" name="section" value="operations">
				    <INPUT type="hidden" name="subsection" value="project_improvements_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"project_improvements_id\" value=\"$project_improvements_item[project_improvements_id]\">"; ?>
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
