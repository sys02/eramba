<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/risk_exception_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$risk_exception_id = $_GET["risk_exception_id"];
	
	$base_url_list = build_base_url($section,"risk_exception_list");

	if (is_numeric($risk_exception_id)) {
		$risk_exception_item = lookup_risk_exception("risk_exception_id",$risk_exception_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Risk Exception</h3>
		<span class="description">Risk Exceptions are very usefull at the time of accepting a known risk. Once approved, they provide substantiation to Risk items.</span>
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
echo "					<form name=\"risk_exception_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="applicable">Risk Exception Title</label>
						<span class="description">Provide a descriptive title. Example: Mac-OS Antivirus</span>
<? echo "					<input type=\"text\" class=\"filter-text\" name=\"risk_exception_title\" id=\"\" value=\"$risk_exception_item[risk_exception_title]\">"; ?>
						
						<label for="description">Description</label>
						<span class="description">A good description should include what the risk is (threat, vulnerablities, impact, etc), the options which where considered and discarded, etc.</span>
<? echo "						<textarea name=\"risk_exception_description\" class=\"filter-text\">$risk_exception_item[risk_exception_description]</textarea>";?>

						<label for="name">Author</label>
						<span class="description">The identity of the person who will approve this Risk Exception.</span>
<? echo "	<input type=\"text\" class=\"filter-text\" name=\"risk_exception_author\" id=\"\" value=\"$risk_exception_item[risk_exception_author]\"/>";?>
						
			<label for="name">Expiration</label>
						<span class="description">Set the deadline for this Risk Exception. At the expiration day, a full re-assesment on this exception is usually done.</span>
<? echo "	<input type=\"text\" class=\"filter-date datepicker\" name=\"risk_exception_expiration\" class=\"filter-date\" id=\"\" value=\"$risk_exception_item[risk_exception_expiration]\"/>";?>
						
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="risk">
				    <INPUT type="hidden" name="subsection" value="risk_exception_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"risk_exception_id\" value=\"$risk_exception_item[risk_exception_id]\">"; ?>

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
