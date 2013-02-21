<?

	include_once("lib/tp_lib.php");
	include_once("lib/tp_type_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$tp_id = $_GET["tp_id"];
	
	$base_url_list = build_base_url($section,"tp_list");
	$base_url_edit = build_base_url($section,"tp_edit");

	if (is_numeric($tp_id)) {
		$tp_item = lookup_tp("tp_id",$tp_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Third Party</h3>
		<span class="description">No bussiness operates alone. There's always customers (well, hopefully), providers, regulators, etc. It's important to define them clearly from the begining since we'll be using them in order to control support contracts, compliances, audits, etc.</span>
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
echo "					<form name=\"tp_edit\" method=\"GET\" action=\"$base_url\">";
?>
						<label for="name">Name</label>
						<span class="description">Name the third party. Examples: Provider X, Customers, PCI-DSS, etc. </span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"tp_name\" id=\"tp_name\" value=\"$tp_item[tp_name]\"/>";?>
						
						<label for="description">Description</label>
						<span class="description">Describe yor relationship with this third party.</span>
<? echo "						<textarea name=\"tp_description\" class=\"filter-text\">$tp_item[tp_description]</textarea>";?>
						
						<label for="legalType">Type of Third Party</label>
						<span class="description">It's important you clasify your third parties properly. If you want to control support contracts at a later stage, name them "Providers", if they are "Regulators" they will be available at the compliance module.</span>
						<select name="tp_type_id" id="" class="chzn-select">
						<option value="-1">Select the type of third party</option>
<?
						list_drop_menu_tp_type($tp_item[tp_type_id],"tp_type_name");	
?>
						</select>
				</div>
				
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="organization">
				    <INPUT type="hidden" name="subsection" value="tp_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"tp_id\" value=\"$tp_item[tp_id]\">"; ?>

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
