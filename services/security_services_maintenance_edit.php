	
<?

	include_once("lib/site_lib.php");
	include_once("lib/security_services_lib.php");
	include_once("lib/security_services_maintenance_lib.php");
	include_once("lib/security_services_audit_audit_result_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$security_services_maintenance_id = $_GET["security_services_maintenance_id"];
		
	$base_url_list = build_base_url($section,"security_services_maintenance_list");

	if (is_numeric($security_services_maintenance_id)) {
		$audit_item = lookup_security_services_maintenance("security_services_maintenance_id",$security_services_maintenance_id);
		$service_item = lookup_security_services("security_services_id",$audit_item[security_services_maintenance_security_service_id]);
	}

?>

	<section id="content-wrapper">
		<h3>Security Control Maintanence Records</h3>
		<span class="description">The objective is to keep track of the regular tasks Service Controls require in order to function properly</span>
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
echo "<form name=\"audit_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Maintenance Task</label>
						<span class="description">What is required to do in order to execute this maintenance task?</span>
<?
echo "						<textarea id=\"\" name=\"security_services_maintenance_task\">$audit_item[security_services_maintenance_task]</textarea>";
?>
						
						<label for="legalType">Task Conclusion</label>
						<span class="description">How did the task go?</span>
<?
echo "				<textarea id=\"\" name=\"security_services_maintenance_result_description\">$audit_item[security_services_maintenance_result_description]</textarea>";

?>
		<label for="name">Task Owner</label>
		<span class="description">Who did the task?</span>

<?
echo "				<input type=\"text\" name=\"security_services_maintenance_engineer\" value=\"$audit_item[security_services_maintenance_engineer]\"/>";

?>
						
				<label for="name">Maintenance Start Date</label>
				<span class="description">Register the date at which this maintenance task started.</span>
<?
echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"security_services_maintenance_start_maintenance_date\" id=\"\" value=\"$audit_item[security_services_maintenance_start_maintenance_date]\"/>";
?>
				<label for="name">Maintenance End Date</label>
				<span class="description">Register the date at which this maintenance task ended.</span>
<?
echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"security_services_maintenance_end_maintenance_date\" id=\"\" value=\"$audit_item[security_services_maintenance_end_maintenance_date]\"/>";
?>
				<label for="name">Task Result</label>
				<span class="description">Altough this is not strictly an audit, this maintenance task are a good indication to know if services are working or not</spam>
						<select name="security_services_maintenance_result" id="" class="">
<?
	list_drop_menu_security_services_audit_result($audit_item[security_services_maintenance_result], "");	
?>
						</select>

				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">
				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="security_services">
				    <INPUT type="hidden" name="subsection" value="security_services_maintenance_list">
					<INPUT type="hidden" name="service_id" value="<? echo $audit_item[security_services_maintenance_security_service_id] ?>">
					<INPUT type="hidden" name="security_services_maintenance_id" value="<? echo $audit_item[security_services_maintenance_id] ?>">

<?
echo "			<a>";
echo "			    <INPUT type=\"submit\" value=\"Submit\" class=\"add-btn\"> ";
echo "			</a>";
?>
			
<?
echo "			<a href=\"$base_url_list&service_id=$audit_item[security_services_maintenance_security_service_id]\" class=\"cancel-btn\">";
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
