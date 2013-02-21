	
<?

	include_once("lib/site_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/security_services_audit_audit_result_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$security_services_audit_id = $_GET["security_services_audit_id"];
		
	$base_url_list = build_base_url($section,"security_services_audit_report");

	if (is_numeric($security_services_audit_id)) {
		$audit_item = lookup_security_services_audit("security_services_audit_id",$security_services_audit_id);
		$service_item = lookup_security_services("security_services_id",$audit_item[security_services_audit_security_service_id]);
	}

?>

	<section id="content-wrapper">
		<h3>Security Control Audit</h3>
		<span class="description">The objective is to audit the security control for efficiency utilizing the metrics reviews and success criteria defined on the control. You should be able to add evidence that suppors the audit.</span>
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
<?
#echo "					<a href=\"$base_url&action=edit&audit_id=$audit_item[audit_id]\">General</a>";
?>
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">
<?
echo "<form name=\"audit_edit\" method=\"GET\" action=\"$base_url_list\">\n";
?>
						<label for="name">Audit Metric</label>
						<span class="description">At the time of creating the Security Service, a metric was defined in order to be able to measure the level of efficacy of the control. This should be utilized as the base for this audit review.</span>
<?
echo "						<textarea security_services_audit_edit.php id=\"\" name=\"security_services_audit_metric\">$audit_item[security_services_audit_metric]</textarea>";
?>
						
						<label for="description">Metric Success Criteria</label>
						<span class="description">At the time of creating the Security Service, a success criteria was defined in order to evaluate if the metric results are within acceptable threasholds (audit pass) or not (audit not pass).</span>
<?
echo "						<textarea security_services_audit_edit.php id=\"\" name=\"security_services_audit_criteria\">$audit_item[security_services_audit_criteria]</textarea>";
?>
						
						<label for="legalType">Audit Conclusion</label>
						<span class="description">Describe what evidence was avilable, the accuracy and integrity of the metrics taken and if the metrics are within the expected threasholds or not.</span>
<?
echo "				<textarea id=\"\" name=\"security_services_audit_result_description\">$audit_item[security_services_audit_result_description]</textarea>";

?>
		<label for="name">Audit Owner</label>
		<span class="description">Register the person who has worked on this audit (the auditor name)</span>

<?
echo "				<input type=\"text\" name=\"security_services_audit_auditor\" value=\"$audit_item[security_services_audit_auditor]\"/>";

?>
						
				<label for="name">Audit Start Date</label>
				<span class="description">Register the date at which this audit started.</span>
<?
echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"security_services_audit_start_audit_date\" id=\"\" value=\"$audit_item[security_services_audit_start_audit_date]\"/>";
?>
				<label for="name">Audit End Date</label>
				<span class="description">Register the date at which this audit ended.</span>
<?
echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"security_services_audit_end_audit_date\" id=\"\" value=\"$audit_item[security_services_audit_end_audit_date]\"/>";
?>
				<label for="name">Audit Result</label>
				<span class="description">After evluating the audit evidence, success criteria, etc you are able to conclude with the audit result. Pass or Fail are the available options.</span>
						<select name="security_services_audit_result" id="" class="">
<?
	list_drop_menu_security_services_audit_result($audit_item[security_services_audit_result], "");	
?>
						</select>

				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">
				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="security_services">
				    <INPUT type="hidden" name="subsection" value="security_services_audit_report">
					<INPUT type="hidden" name="service_id" value="<? echo $audit_item[security_services_audit_security_service_id] ?>">
					<INPUT type="hidden" name="security_services_audit_id" value="<? echo $audit_item[security_services_audit_id] ?>">

<?
echo "			<a>";
echo "			    <INPUT type=\"submit\" value=\"Submit\" class=\"add-btn\"> ";
echo "			</a>";
?>
			
<?
echo "			<a href=\"$base_url_list&service_id=$audit_item[security_services_audit_security_service_id]\" class=\"cancel-btn\">";
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
