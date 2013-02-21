<?

	include_once("lib/system_records_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$system_records_id = $_GET["system_records_id"];
	$author = $_SESSION['logged_user_id'];

	$system_records_lookup_section = $_GET["system_records_lookup_section"]; 
	$system_records_lookup_subsection = $_GET["system_records_lookup_subsection"]; 
	$system_records_lookup_item_id = $_GET["system_records_lookup_item_id"];
	
	$base_url_list = build_base_url($section,"system_records_list");

	if (is_numeric($system_records_id)) {
		$system_records_item = lookup_system_records("system_records_id",$system_records_id);
	}

?>


	<section id="content-wrapper">
		<h3>Add a Note</h3>
		<span class="description">For pretty much everything on this system you are able to add notes (as records, meaning you cant change them once made) to keep track of specific things (like audits, change of plans, etc).</span>
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
echo "					<form name=\"system_records_edit\" method=\"GET\" action=\"$base_url_list\">";
echo "		<span class=\"description\">You are adding a record to the following: $system_records_lookup_section/$system_records_lookup_subsection: id #$system_records_lookup_item_id</span>";
?>
						<label for="description">Notes</label>
						<span class="description">Write down a note!</span>
<? echo "						<textarea name=\"system_records_notes\" class=\"filter-text\"></textarea>";?>
				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="system">
				    <INPUT type="hidden" name="subsection" value="system_records_list">
				   <? echo " <INPUT type=\"hidden\" name=\"system_records_lookup_author\" value=\"$author\">"; ?>
<?
echo "\n";
echo "				    <INPUT type=\"hidden\" name=\"system_records_lookup_section\" value=\"$system_records_lookup_section\">\n";
echo "				    <INPUT type=\"hidden\" name=\"system_records_lookup_subsection\" value=\"$system_records_lookup_subsection\">\n";
echo "				    <INPUT type=\"hidden\" name=\"system_records_lookup_item_id\" value=\"$system_records_lookup_item_id\">\n";

echo "				    <INPUT type=\"hidden\" name=\"system_records_lookup_action\" value=\"add_note\">\n";
?>

<? echo " 			    <INPUT type=\"hidden\" name=\"system_records_id\" value=\"$system_records_item[system_records_id]\">"; ?>

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
