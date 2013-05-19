<?

	include_once("lib/project_improvements_lib.php");
	include_once("lib/project_improvements_status_lib.php");
	include_once("lib/project_improvements_expenses_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$project_improvements_id = $_GET["project_improvements_id"];
	$project_improvements_expense_id= $_GET["project_improvements_expense_id"];
	
	$base_url_list = build_base_url($section,"project_improvements_list");

	if (is_numeric($project_improvements_id)) {
		$project_improvements_item = lookup_project_improvements("project_improvements_id",$project_improvements_id);
	}

	if (is_numeric($project_improvements_expense_id)) {
		$project_expenses_item = lookup_project_improvements_expenses("project_improvements_expenses_id",$project_improvements_expense_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Project Expense</h3>
		<span class="description">Use this form to create or edit new improvement expense. In this way you can control financial expenses on your projects.</span>
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
						<label for="name">Expense Amount</label>
						<span class="description">Register the amount you have invested on this project</span>
<? echo "						<input type=\"text\" class=\"filter-number\" name=\"project_improvements_expenses_amount\" id=\"project_improvements_expenses_amount\" value=\"$project_expenses_item[project_improvements_expenses_amount]\"/>";?>
						
	<label for="description">Description</label>
	<span class="description">Describe the expense description.</span>
<? echo "<textarea name=\"project_improvements_expenses_description\" class=\"filter-text\">$project_expenses_item[project_improvements_expenses_description]</textarea>";?>
						

		<label for="name">Expense Date</label>
		<span class="description">Record the date when the expense was made.</span>
<?
echo "	<input type=\"text\" class=\"filter-date datepicker\" name=\"project_improvements_expenses_date\" id=\"\" value=\"$project_expenses_item[project_improvements_expenses_date]\"/>";
?>
						

			</div>
		</div>
	</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="edit_expenses">
				    <INPUT type="hidden" name="section" value="operations">
				    <INPUT type="hidden" name="subsection" value="project_improvements_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"project_improvements_id\" value=\"$project_improvements_item[project_improvements_id]\">"; ?>
<? echo " 			    <INPUT type=\"hidden\" name=\"project_improvements_expenses_id\" value=\"$project_improvements_expense_id\">"; ?>
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
