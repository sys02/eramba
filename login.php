<?php
	session_start();

	include_once("lib/mysql_lib.php");
	include_once("lib/system_security_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/security_services_dashboard_lib.php");
	include_once("lib/organization_dashboard_lib.php");
	include_once("lib/risk_dashboard_lib.php");
	include_once("lib/system_records_lib.php");
	include_once("lib/asset_dashboard_lib.php");
	include_once("lib/compliance_dashboard_lib.php");
	include_once("lib/security_operations_dashboard_lib.php");
	include_once("lib/system_dashboard_lib.php");
	include_once("lib/security_services_audit_lib.php");
	include_once("lib/bcm_dashboard_lib.php");

	$login_error=0;

	if ( isset($_POST['login-submit']) ) {
		$system_users_login = $_POST['login'];
		$system_users_password = $_POST['password'];

		if($user_id = authenticate_user_credentials($system_users_login, $system_users_password)) {
			# echo "good credentials for $user_id";
			$_SESSION['logged_user_id'] = $user_id; 

			# make a record
			add_system_records("system","system_authorization_edit",$_SESSION['logged_user_id'],"$user_id","Login","");

			# everytime someone logs in the system, i need to make sure i add all the dashboard statistics
			security_services_dashboard_data(NULL);
			risk_dashboard_data(NULL);
			asset_dashboard_data(NULL);
			compliance_dashboard_data(NULL);
			security_operations_dashboard_data(NULL);
			system_dashboard_data(NULL);
			organization_dashboard_data(NULL);
			bcm_plans_dashboard_data(NULL);

			# update new audits in case we are in a new year
			new_year_audit_updates();
	
			header('Location: index.php');
		} else {
			# echo "wrong credentials";
			add_system_records("system","system_authorization","$user_id","$system_users_login","Wrong Login","");
			$login_error=1;	
		} 
	

	}

	$logged_user = isset( $_SESSION['logged_user_id'] ) ? true : false;

	if ( $logged_user ) {
		header('Location: index.php');
	}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>eramba security manager</title>
	<meta charset="UTF-8" />
			
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	      
	<meta name="author" content=""/>
	<meta name="Copyright" content="" />
	<meta http-equiv="X-UA-Compatible" content="IE=9" />
	<meta http-equiv="Pragma" content="no-cache" />
	
<?php
echo "	<script type=\"text/javascript\" src=\"js/jquery.min.js\"></script>";
echo "	<script type=\"text/javascript\" src=\"js/jquery-ui.min.js\"></script>";
echo "	<script type=\"text/javascript\" src=\"js/admin.scripts.js\"></script>";
echo "	<script type=\"text/javascript\" src=\"js/chosen.jquery.js\"></script>";
echo "	<script type=\"text/javascript\" src=\"js/accordion.js\"></script>";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/normalize.css\" />";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/styles.css\" />";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/chosen.css\" />";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/chosen.css\" />";
?>

	<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
	</script>
	
	

</head>
<body>


<? 

	if ($login_error) {
		error_message("Wrong Credentials", "A01");	
	} else {
		
echo "	<div id=\"centerbox-page-wrapper\" class=\"login\">";
echo "		<div id=\"centerbox-page-overlay\">";
echo "		</div>";
echo "		<img src=\"img/centerbox-login-top.png\" id=\"centerbox-login-top\" width=\"131\" height=\"47\" />";
echo "		<div id=\"centerbox-page-content\">";
echo "			<form id=\"login\" name=\"login\" method=\"POST\">";
echo "				<div class=\"centerbox-entry\">";
echo "					<label for=\"login\">Login</label>";
echo "					<input type=\"text\" name=\"login\" id=\"login\" />";
echo "				</div>";
echo "				<div class=\"centerbox-entry\">";
echo "					<label for=\"password\">Password</label>";
echo "					<input type=\"password\" name=\"password\" id=\"password\" />";
echo "				</div>";
echo "				<div class=\"centerbox-entry\">";
echo "					<input type=\"submit\" name=\"login-submit\" id=\"submit\" value=\"Sign in\" />";
echo "				</div>";
echo "				<!--<div class=\"centerbox-entry\">";
echo "					<p><a href=\"#\">Forgot password?</a><span> or </span><a href=\"#\">Create New</a></p>";
echo "				</div>-->";
echo "			</form>";
echo "		</div>";
echo "	</div>";

	}
?>
</body>
</html>
