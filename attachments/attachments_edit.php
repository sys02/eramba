<?

	include_once("lib/site_lib.php");
	include_once("lib/attachments_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/configuration.inc");

	global $system_conf;

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];

	$action = $_POST["action"];

	$attachments_ref_section = $_GET["attachments_ref_section"];
	$attachments_ref_subsection = $_GET["attachments_ref_subsection"];
	$attachments_ref_id= $_GET["attachments_ref_id"];

	$base_url_list  = build_base_url($section,"attachments_list");

?>

	<section id="content-wrapper">
		<h3>Upload an Attachment</h3>
		<span class="description">You are allowed to upload attachments to most items on the system. Use this form to attach any type of document.</span>
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
echo "					<form name=\"compliance_package_edit\" method=\"POST\" action=\"$base_url_list\" enctype=\"multipart/form-data\">";
?>
						<label for="description">Upload File</label>
<?
	if (empty($system_conf['permit_uploads'])) {
		echo "<span class=\"description\">WARNING: File uploads are DISABLED on your configuration file. You need to edit the configuration file lib/configuratio.inc and enable \"permit_uploads\"</span>";
	} else {
		echo "<span class=\"description\">Select a File to Attach</span>";
	}
		echo "<input type=\"file\" name=\"file\"><br>";
?>
				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="upload">
				    <INPUT type="hidden" name="section" value="attachments">
				    <INPUT type="hidden" name="subsection" value="attachments_list">
<?
echo "				    <INPUT type=\"hidden\" name=\"attachments_ref_section\" value=\"$attachments_ref_section\">";
echo "				    <INPUT type=\"hidden\" name=\"attachments_ref_subsection\" value=\"$attachments_ref_subsection\">";
echo "				    <INPUT type=\"hidden\" name=\"attachments_ref_id\" value=\"$attachments_ref_id\">";
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
