<?
#ini_set('display_errors', '0');
session_start();
include_once("lib/mysql_lib.php");
include_once("lib/site_lib.php");

$logged_user_id = isset($_SESSION['logged_user_id']) ? $_SESSION['logged_user_id'] : null;

if ( !$logged_user_id || isset($_GET['logout']) ) {
	unset($_SESSION['logged_user_id']);
	header('Location: login.php');
}

$logged_user_data = runSmallQuery( 
	"SELECT * FROM `system_users_tbl` WHERE 
	`system_users_id`='" . $logged_user_id . "'"
);


include_once("header.php");


$section = $_GET["section"];
$subsection = $_GET["subsection"];

$action = isset($_GET["action"]) ? $_GET['action'] : 'list';

if ( validate_section_subsection($section,NULL) && validate_section_subsection(NULL,$subsection) ) {
	include_from_db($section, $subsection, $action);
} else {
	# bu default i send them to the organization tab
	$section="organization";
	$subsection="dashboard";
	include_from_db($section, $subsection, $action);
}


include_once("footer.php");
?>
