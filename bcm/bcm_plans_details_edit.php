<?

	include_once("lib/site_lib.php");
	include_once("lib/bcm_plans_details_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$bcm_plans_details_bcm_plan_id = $_GET["bcm_plans_details_bcm_plan_id"];

	$bcm_plans_details_id = $_GET["bcm_plans_details_id"];
	
	$base_url_list = build_base_url($section,"bcm_plans_list");

	if (is_numeric($bcm_plans_details_id)) {
		$bcm_plans_details_data = lookup_bcm_plans_details("bcm_plans_details_id",$bcm_plans_details_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Detailed Continuity Plan</h3>
		<span class="description">This is the tools used to create an emergency plan. Emergency plans are short and very much to the point. Have you noticed aircraft emergency plans? there's no point in writing long manuals since at emergency times there's no time to read. Keep it to the point and you'll do fine.</span>
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
echo "					<form name=\"legal_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Step</label>
						<span class="description">In this plan, where this step goes?</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"bcm_plans_details_step\" id=\"bcm_plans_details_step\" value=\"$bcm_plans_details_data[bcm_plans_details_step]\"/>";?>
						
<label for="description">When</label>
<span class="description">When reading an emergency procedure, is important to know who does what in particular when! Example: no longer than 5 minutes after declared the crisis.</span>
<? echo "<textarea class=\"filter-text\" name=\"bcm_plans_details_when\">$bcm_plans_details_data[bcm_plans_details_when]</textarea>";?>

<label for="description">Who</label>
<span class="description">Someone gotta do something. Who is that someone?</span>
<? echo "<textarea class=\"filter-text\" name=\"bcm_plans_details_who\">$bcm_plans_details_data[bcm_plans_details_who]</textarea>";?>

<label for="description">Does Something</label>
<span class="description">Valid examples: Warms up engines, Starts passive DC infrastructure. There's no point in writting how in details that is to be done since you shouldnt expect someone to learn to do something while in the middle of an emergency</span>
<? echo "<textarea class=\"filter-text\" name=\"bcm_plans_details_what\">$bcm_plans_details_data[bcm_plans_details_what]</textarea>";?>

<label for="description">Where</label>
<span class="description">Sometimes without knowing where someone has to do something the task is stuck.</span>
<? echo "<textarea class=\"filter-text\" name=\"bcm_plans_details_where\">$bcm_plans_details_data[bcm_plans_details_where]</textarea>";?>

<label for="description">How</label>
<span class="description">Keep this to the bare minimum</span>
<? echo "<textarea class=\"filter-text\" name=\"bcm_plans_details_how\">$bcm_plans_details_data[bcm_plans_details_how]</textarea>";?>

			</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="edit_details">
				    <INPUT type="hidden" name="subsection" value="bcm_plans_list">
				    <INPUT type="hidden" name="section" value="bcm">
<? echo " 			    <INPUT type=\"hidden\" name=\"bcm_plans_details_id\" value=\"$bcm_plans_details_data[bcm_plans_details_id]\">"; ?>
<?
if ($bcm_plans_details_bcm_plan_id) {
	echo "<INPUT type=\"hidden\" name=\"bcm_plans_details_bcm_plan_id\" value=\"$bcm_plans_details_bcm_plan_id\">";
} else { 
	echo "<INPUT type=\"hidden\" name=\"bcm_plans_details_bcm_plan_id\" value=\"$bcm_plans_details_data[bcm_plans_details_bcm_plan_id]\">";
}
?>

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
