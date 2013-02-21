<?

	include_once("lib/system_group_role_lib.php");
	include_once("lib/system_authorization_lib.php");
	include_once("lib/system_authorization_group_role_join_lib.php");
	include_once("lib/site_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$system_group_role_id = isset( $_GET["system_group_role_id"] ) ? $_GET["system_group_role_id"] : $_GET["system_roles_id"];
	
	$base_url_list = build_base_url($section,"system_roles_list");

	if (is_numeric($system_group_role_id)) {
		$system_group_role_item = lookup_system_group_role("system_group_role_id",$system_group_role_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a Group Role</h3>
		<span class="description">Group permissions and give them a name ... you will need this to ensure the right level of access to the system users.</span>
		<?
echo "					<form name=\"system_group_role_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
		<div class="tab-wrapper"> 
			<ul class="tabs">
				<li class="first active">
					<a href="tab1">General</a>
					<span class="right"></span>
				</li>
			</ul>
			
			<div class="tab-content">
				<div class="tab" id="tab1">

						<label for="name">Name</label>
						<span class="description">Give a name to the system_group_role constrain. Examples: Data Privacy Regulations, Customer Contractual Agreements, Etc. </span>
<? echo "						<input type=\"text\" name=\"system_group_role_name\" class=\"filter-text\" id=\"system_group_role_name\" value=\"$system_group_role_item[system_group_role_name]\"/>";?>
						
						<label for="description">Description</label>
						<span class="description">Describe what this system_group_role constrain is about so everyone understands.</span>
<? echo "						<textarea name=\"system_group_role_description\" class=\"filter-text\">$system_group_role_item[system_group_role_description]</textarea>";?>
						<label for="legalType">Read Access</label>
						<span class="description">Select the areas of the module where you want to allow READ access</span>
						<select name="system_group_role_read_access[]" id="" class="" multiple="multiple">
<?
	$pre_selected_system_group_role_read_access = list_system_authorization_group_role_join(" WHERE system_authorization_group_role_role_id= \"$system_group_role_item[system_group_role_id]\"");	
	$pre_selected_items = array();

	foreach($pre_selected_system_group_role_read_access as $pre_selected_auth_item) {
		array_push($pre_selected_items,$pre_selected_auth_item[system_authorization_group_auth_id]);
	}

	list_drop_menu_system_authorization_read($pre_selected_items,"system_authorization_id");	
?>
						</select>
						<label for="legalType">Write Access</label>
						<span class="description">Select the areas of the module where you want to allow WRITE access</span>
						<select name="system_group_role_write_access[]" id="" class="" multiple="multiple">
<?
	$pre_selected_system_group_role_read_access = list_system_authorization_group_role_join(" WHERE system_authorization_group_role_role_id= \"$system_group_role_item[system_group_role_id]\"");	
	$pre_selected_items = array();

	foreach($pre_selected_system_group_role_read_access as $pre_selected_auth_item) {
		array_push($pre_selected_items,$pre_selected_auth_item[system_authorization_group_auth_id]);
	}

	list_drop_menu_system_authorization_write($pre_selected_items,"system_authorization_id");	
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
				    <INPUT type="hidden" name="section" value="system">
				    <INPUT type="hidden" name="subsection" value="system_roles_list">
<? echo " 			<INPUT type=\"hidden\" name=\"system_group_role_id\" value=\"$system_group_role_item[system_group_role_id]\">"; ?>

			<a>
			    <INPUT type="submit" value="Submit" class="add-btn"> 
			</a>
			
<?
echo "			<a href=\"$base_url_list\" class=\"cancel-btn\">";
?>
				Cancel
				<span class="select-icon"></span>
			</a>
			
		</div>
		</form>
		<br class="clear"/>
		
	</section>
</body>
</html>
