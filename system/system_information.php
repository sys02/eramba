<?

include_once('lib/site_lib.php');
include_once('lib/configuration.inc');

$section = $_GET["section"];
$subsection = $_GET["subsection"];

global $system_conf;

if ($action == "update_all_dashboards") {

	# this is kinda ugly .. wtf...
	include_once("lib/security_services_dashboard_lib.php");
	include_once("lib/organization_dashboard_lib.php");
	include_once("lib/risk_dashboard_lib.php");
	include_once("lib/asset_dashboard_lib.php");
	include_once("lib/compliance_dashboard_lib.php");
	include_once("lib/security_operations_dashboard_lib.php");
	include_once("lib/system_dashboard_lib.php");
	include_once("lib/bcm_dashboard_lib.php");
			
	# everytime someone logs in the system, i need to make sure i add all the dashboard statisticpl
	security_services_dashboard_data("1");
	risk_dashboard_data("1");
	asset_dashboard_data("1");
	compliance_dashboard_data("1");
	security_operations_dashboard_data("1");
	system_dashboard_data("1");
	organization_dashboard_data("1");
	bcm_plans_dashboard_data("1");

}
	
$base_url_list = build_base_url($section,$subsection);

echo "<a href=\"$base_url_list&action=update_all_dashboards\">Update all Dashboards for this month</a>";
echo "<br>";
echo "<br>";
echo "System Version $system_conf[app_version] - licensed under $system_conf[license_number]";
echo "<br>";
echo "<a href=\"http://eramba.org\">www.eramba.org</a>";

?>
