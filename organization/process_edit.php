<?

	include_once("lib/process_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$process_id = $_GET["process_id"];
	$bu_id = $_GET["bu_id"];
	
	$base_url_list = build_base_url($section,"bu_list");

	if (is_numeric($process_id)) {
		$process_item = lookup_process("process_id",$process_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Business Process</h3>
		<span class="description">Describe the main functions of each Business Unit. There shouldnt be more than three or four. If you dare going too much in detail you might exponentially increase the task of understanding your organization and all that level of detail might not bring substantial value. Start small.</span>
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
echo "					<form name=\"process_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name</label>
						<span class="description">Give a clear name to the main processes. Examples could be: Build Systems, Hire Employees, Prepare Accounting, Manage Payments to Third Parties, Etc.</span>
<? echo "						<input type=\"text\" name=\"process_name\" class=\"filter-text\" id=\"process_name\" value=\"$process_item[process_name]\"/>";?>
						
						<label for="description">Description</label>
						<span class="description">Give a brief description of what the Process does, so everyone is in the same page.</span>
<? echo "						<textarea name=\"process_description\" class=\"filter-text\">$process_item[process_description]</textarea>";?>
						<label for="name">Recovery Time Objective (RTO)</label>
						<span class="description">This will later be used as the main criteria to develop a backup plan for the systems that support this business process.</span>
<? echo "						<input type=\"text\" name=\"process_revenue\" id=\"process_revenue\" value=\"$process_item[process_revenue]\"/>";?>
						<label for="name">Maximun Tolerable Outage (MTO)</label>
						<span class="description">Right. This question will be useful at the time of preparing your Business Continuity Management (BCM) program. You need to provide a number of days, which this process could be completly stopped before it causes great disruption to the organization. Example: 1, 4, 6 (do not write anything else than a integer number). Default MTO is 360 Days.</span>
<? echo "						<input type=\"text\" name=\"process_mto\" id=\"process_mto\" value=\"$process_item[process_mto]\"/>";?>
				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update_process">
				    <INPUT type="hidden" name="section" value="organization">
				    <INPUT type="hidden" name="subsection" value="bu_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"bu_id\" value=\"$bu_id\">"; ?>
<? echo " 			    <INPUT type=\"hidden\" name=\"process_id\" value=\"$process_id\">"; ?>
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
