<?
	include_once("lib/system_users_lib.php");
	include_once("lib/system_conf_pwd_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/system_users_lib.php");
	include_once("lib/system_group_role_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$show_id = isset($_GET["show_id"]) ? $_GET["show_id"] : null;
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"system_authorization_list");
	$base_url_edit = build_base_url($section,"system_authorization_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$system_users_id = $_GET["system_users_id"];
	$system_users_name = $_GET["system_users_name"];
	$system_users_surname = $_GET["system_users_surname"];
	$system_users_group_role_id = $_GET["system_users_group_role_id"];
	$system_users_login = $_GET["system_users_login"];
	$system_conf_admin_pwd = $_GET["system_conf_admin_pwd"];
	$system_users_disabled = $_GET["system_users_disabled"];

	# i need to know who is asking to do what ..
	$current_logged_user_id = $_SESSION['logged_user_id'];

	# make sure that if the want to update, the username is valid
	if ($action == "update") {
		if ( clean_login_username($system_users_login) ) {
			site_error("<b>Not a good login name!</b> Your login must have letters, numbers and if you wish any of the following characters: . - _");
			unset($action);
		}
	}

	# if admin is asking ,then it's all right, he can do whatever .. but! if it's not admin, then that person
	# can only modify his account
	if ($action == "update" || $action == "disabled" || $action == "csv") {
		# this shouldnt happen
		if (is_numeric($current_logged_user_id)) {

			if ($current_logged_user_id != "1" && $current_logged_user_id != $system_users_id) {
			#echo "Error: a non admin ($current_logged_user_id)  is trying to do something wiht the account of $system_users_id";	
			site_error("<b>Not enough priviledges</b> If you want to create a new login, you must be logged as \"admin\"");
			unset($action);
			}

		} else {
			#echo "Error: i dont know who is logged in .. this is strange<br>";
			unset($action);
		}
	}

	if (empty($system_users_login) && $action == "edit") { 
		$action = NULL;
	}
	
	# dont change the password unless its nececesyry
	# and if you want to change it, make sure it's compliant with our policies (site_lib.php)
	if ($action == "update") {
	if ($system_conf_admin_pwd == "untouched") {
		$pwd=0;
	} elseif ( ! clean_login_password($system_conf_admin_pwd) ) { 
		$pwd=1;
	} else {
		site_error("<b>Not a good password!</b> Your password must have letters, numbers and if you wish any of the following characters: !@#$^&()[]{}");
		unset($action);
	}
	}

	# if they want to do something with "admin", ensure they dont try to assign a role
	if ($system_users_id == "1") {
		$system_users_group_role_id = "-1";
		$system_users_login = "admin";
		$system_users_name = "System";
		$system_users_surname = "Administrator";
	}

	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($action == "update" & is_numeric($system_users_id)) {
		$system_users_update = array(
			'system_users_name' => $system_users_name,
			'system_users_surname' => $system_users_surname,
			'system_users_login' => $system_users_login,
			'system_users_group_role_id' => $system_users_group_role_id
		);	
		update_system_users($system_users_update,$system_users_id);
		add_system_records("system","system_authorization_edit","$system_users_id",$_SESSION['logged_user_id'],"Update","");

		if ($pwd) {
		# now i have to update his SHA1 password
		$time = time();
		$system_conf_pwd = array(
			'system_conf_timestamp' => $time,
			'system_conf_login_id' => $system_users_id,
			'system_conf_pwd' => $system_conf_admin_pwd
		);	
		add_system_conf_pwd($system_conf_pwd);
		}

	} elseif ($action == "update") {
		$system_users_update = array(
			'system_users_name' => $system_users_name,
			'system_users_surname' => $system_users_surname,
			'system_users_login' => $system_users_login,
			'system_users_group_role_id' => $system_users_group_role_id
		);	
		$system_users_id = add_system_users($system_users_update);
		add_system_records("system","system_authorization_edit","$system_users_id",$_SESSION['logged_user_id'],"Insert","");
		
		if ($pwd) {
		# now i have to update his SHA1 password
		$time = time();
		$system_conf_pwd = array(
			'system_conf_timestamp' => $time,
			'system_conf_login_id' => $system_users_id,
			'system_conf_pwd' => $system_conf_admin_pwd
		);	
		add_system_conf_pwd($system_conf_pwd);
		}
	}

	if ($action == "disable") {
		disable_system_users($system_users_id);
		add_system_records("system","system_authorization_edit","$system_users_id",$_SESSION['logged_user_id'],"Disable","");
	}

	if ($action == "csv") {
		export_system_users_csv();
		add_system_records("system","system_authorization_edit","$system_users_id",$_SESSION['logged_user_id'],"Export","");
	}

	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>User Authorization</h3>
		<span class=description>Define which system user can access what. Remember! Only those users listed here can access the system!</span>
		<br>
		<br>
		<div class="controls-wrapper">
<?
echo "			<a href=\"$base_url_edit&action=edit\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add a new User 
			</a>
			
			<div class="actions-wraper">
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
	echo '<li><a href="' . $base_url_list . '&download_export=system_users_export">Download</a></li>';
} else { 
echo "					<li><a href=\"$base_url_list&action=csv\">Export All</a></li>";
}
?>
				</ul>
			</div>
		</div>
		<br class="clear"/>
		
		<table class="main-table">
			<thead>
				<tr>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
echo "					<th><a class=\"asc\" href=\"$base_url_list&sort=system_users_login\">Login</a></th>";
?>
<?
echo "					<th><a href=\"$base_url_list&sort=system_users_name\">Name</a></th>";
echo "					<th><a href=\"$base_url_list&sort=system_users_surname\">Surname</a></th>";
echo "					<th>Group</a></th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
	#echo "$_SESSION[logged_user_id]";

	$logged_user = $_SESSION[logged_user_id];
	# i must have a logged user .. if i dont, something is weird and i should stop.
	# if the logged user is admin, i can see all users
	if ($logged_user == "1") {
		$system_users_list = list_system_users(" WHERE system_users_disabled = 0");
	} elseif (is_numeric($logged_user)) {
		$system_users_list = list_system_users(" WHERE system_users_disabled = 0 AND system_users_id = $logged_user");
	}

	foreach($system_users_list as $system_users_item) {
echo "				<tr class=\"even\">";
echo "					<td class=\"action-cell\">";
echo "						<div class=\"cell-label\">";
echo "							$system_users_item[system_users_login]";
echo "						</div>";
echo "						<div class=\"cell-actions\">";
echo "							<a href=\"$base_url_edit&action=edit&system_users_id=$system_users_item[system_users_id]\" class=\"edit-action\">edit</a> ";
if ($system_users_item['system_users_group_role_id'] != -1) {
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"$base_url_list&action=disable&system_users_id=$system_users_item[system_users_id]\" class=\"delete-action\">delete</a>";
}
echo "						&nbsp;|&nbsp;";
echo "							<a href=\"?section=system&subsection=system_records_list&system_records_lookup_section=system&system_records_lookup_subsection=system_authorization_edit&system_records_lookup_item_id=$system_users_item[system_users_id]\" class=\"delete-action\">records</a>";
echo "						</div>";
echo "					</td>";
echo "					<td>$system_users_item[system_users_name]</td>";
echo "					<td>$system_users_item[system_users_surname]</td>";
					$group_role_id = lookup_system_group_role("system_group_role_id",$system_users_item[system_users_group_role_id]);
echo "					<td>$group_role_id[system_group_role_name]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>
		
		<br class="clear"/>
		
	</section>
