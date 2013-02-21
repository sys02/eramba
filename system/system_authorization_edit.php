<?

	include_once("lib/system_group_role_lib.php");
	include_once("lib/system_authorization_lib.php");
	include_once("lib/system_authorization_group_role_join_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_users_lib.php");

	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	$system_users_id = isset( $_GET["system_users_id"] ) ? $_GET["system_users_id"] : $_GET["system_authorization_id"];
	
	$base_url_list = build_base_url($section,"system_authorization_list");

	if (is_numeric($system_users_id)) {
		$item = lookup_system_users("system_users_id",$system_users_id);
	}

?>


	<section id="content-wrapper">
		<h3>Edit or Create a User Authorization</h3>
		<span class="description">Create system users and assign them the appropiate Group Roles</span>
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
echo "					<form name=\"system_group_role_edit\" method=\"GET\" action=\"$base_url_list\">";
?>
						<label for="name">Name</label>
						<span class="description">User First Name</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"system_users_name\" id=\"system_users_name\" value=\"$item[system_users_name]\"/>";?>
						
					<label for="name">Surname</label>
						<span class="description">User Surname</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"system_users_surname\" id=\"system_users_surname\" value=\"$item[system_users_surname]\"/>";?>
					
						<label for="name">Login Name</label>
						<span class="description">Set the login name for this user. It must be the same login name utilized by the authenticator!</span>
<? echo "						<input type=\"text\" class=\"filter-text\" name=\"system_users_login\" id=\"system_users_login\" value=\"$item[system_users_login]\"/>";?>
						<label for="name">Password</label>
						<span class="description">Set a Password for this user!</span>
<? echo "						<input type=\"password\" class=\"filter-text\" name=\"system_conf_admin_pwd\" id=\"system_conf_admin_pwd\" value=\"untouched\"/>";?>

<?
						
if ($item[system_users_id] != "1") { 

	echo "	<label for=\"legalType\">Group Role</label>";
	echo "	<span class=\"description\">Select the access Group Role this user requires</span>";
	echo "	<select name=\"system_users_group_role_id\" id=\"\" class=\"\">";

	list_drop_menu_system_group_role($item[system_users_group_role_id],"system_group_role_id");	

	echo "	</select>";

}

?>

				</div>
				
				<div class="tab" id="tab2">
					advanced tab
				</div>
			</div>
		</div>
		
		<div class="controls-wrapper">

				    <INPUT type="hidden" name="action" value="update">
				    <INPUT type="hidden" name="section" value="system">
				    <INPUT type="hidden" name="subsection" value="system_authorization_list">
<? echo " 			    <INPUT type=\"hidden\" name=\"system_users_id\" value=\"$item[system_users_id]\">"; ?>

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
