<?

	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	#$base_url_list  = build_base_url($section,"compliance_package_list");

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
						<span class="description">Select a File to Attach</span>
<? 
	echo "<input type=\"file\" name=\"compliance_package_csv_file\"><br>";
?>
				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="upload_compliance_package">
				    <INPUT type="hidden" name="section" value="compliance">
				    <INPUT type="hidden" name="subsection" value="compliance_package_list">

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
