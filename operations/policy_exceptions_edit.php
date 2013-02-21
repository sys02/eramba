<?

	include_once("lib/site_lib.php");
	include_once("lib/policy_exceptions_lib.php");
	include_once("lib/policy_exceptions_status_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$policy_exceptions_id = $_GET["policy_exceptions_id"];
	
	$base_url_list = build_base_url($section,"policy_exceptions_list");

	if (is_numeric($policy_exceptions_id)) {
		$policy_exceptions_item = lookup_policy_exceptions("policy_exceptions_id",$policy_exceptions_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Policy Exception</h3>
		<span class="description">Use this form to create or edit a Policy Exception</span>
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
						<label for="name">Policy Exception Title</label>
						<span class="description">Give a descriptive title to this Exception</span>
<? echo "						<input class=\"filter-text\" type=\"text\" name=\"policy_exceptions_title\" id=\"policy_exceptions_title\" value=\"$policy_exceptions_item[policy_exceptions_title]\"/>";?>
						
	<label for="description">Description</label>
	<span class="description">Describe the Policy Exception in detail (when, what, where, why, whom, how).</span>
<? echo "<textarea name=\"policy_exceptions_description\" class=\"filter-text\">$policy_exceptions_item[policy_exceptions_description]</textarea>";?>
	
	<label for="legalType">Policy Exception Status</label>
	<span class="description">Describe the Exception status</span>
	<select name="policy_exceptions_status" id="" class="chzn-select">
	<option value="-1">Select the Status</option>
<?
	list_drop_menu_policy_exceptions_status($policy_exceptions_item[policy_exceptions_status],"policy_exceptions_status_name");	
?>
	</select>
	
	<label for="description">Owner</label>
	<span class="description">Describe for whom this Exception is</span>
<? echo "<input type=\"text\" class=\"filter-text\" name=\"policy_exceptions_owner\" id=\"policy_exceptions_owner\" value=\"$policy_exceptions_item[policy_exceptions_owner]\"/>";?>
						
	<label for="description">Expirations</label>
	<span class="description">Exceptions are not eternal, they must expire at some time</span>
<? echo "<input type=\"text\" class=\"filter-date datepicker\" name=\"policy_exceptions_expiration_date\" id=\"policy_exceptions_expiration_date\" value=\"$policy_exceptions_item[policy_exceptions_expiration_date]\"/>";?>
	
			</div>
			<div class="tab" id="tab2">
				advanced tab
			</div>
		</div>
	</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="edit">
				    <INPUT type="hidden" name="section" value="operations">
				    <INPUT type="hidden" name="subsection" value="policy_exceptions_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"policy_exceptions_id\" value=\"$policy_exceptions_item[policy_exceptions_id]\">"; ?>
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
