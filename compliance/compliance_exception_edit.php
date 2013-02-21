<?

	include_once("lib/general_classification_lib.php");
	include_once("lib/compliance_exception_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$compliance_exception_id = $_GET["compliance_exception_id"];
	
	$base_url_list = build_base_url($section,"compliance_exception_list");

	if (is_numeric($compliance_exception_id)) {
		$compliance_exception_item = lookup_compliance_exception("compliance_exception_id",$compliance_exception_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Compliance Exception</h3>
		<span class="description">Compliance Exceptions are very usefull at the time of accepting a known non-compliancy. Once approved, they provide substantiation to Compliance items.</span>
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
echo "					<form name=\"compliance_exception_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="applicable">Compliance Exception Title</label>
						<span class="description">Provide a descriptive title. Example: Mac-OS Antivirus</span>
<? echo "					<input class=\"filter-text\" type=\"text\" name=\"compliance_exception_title\" id=\"\" value=\"$compliance_exception_item[compliance_exception_title]\">"; ?>
						
						<label for="description">Description</label>
						<span class="description">A good description should include what the compliance is (threat, vulnerablities, impact, etc), the options which where considered and discarded, etc.</span>
<? echo "						<textarea class=\"filter-text\" name=\"compliance_exception_description\">$compliance_exception_item[compliance_exception_description]</textarea>";?>

						<label for="name">Author</label>
						<span class="description">The identity of the person who will approve this Compliance Exception.</span>
<? echo "	<input class=\"filter-text\" type=\"text\" name=\"compliance_exception_author\" id=\"\" value=\"$compliance_exception_item[compliance_exception_author]\"/>";?>
						
			<label for="name">Expiration</label>
						<span class="description">Set an expiration day for this exception. At that point in time you want to re-assess the decision to grant an exception. As always, the date format is YYYY-MM-DD.</span>
<? echo "	<input type=\"text\" class=\"filter-date datepicker\" name=\"compliance_exception_expiration\" id=\"\" value=\"$compliance_exception_item[compliance_exception_expiration]\"/>";?>
						
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_exception_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"compliance_exception_id\" value=\"$compliance_exception_item[compliance_exception_id]\">"; ?>

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
