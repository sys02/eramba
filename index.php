<?
#ini_set('display_errors', '0');
session_start();
include_once("lib/mysql_lib.php");

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


include_from_db($section, $subsection, $action);

/*

if ($section == "organization") {

	if ($subsection == "bu" OR $subsection == "process") {
		if ($action == "edit_bu") {
			include("organization/bu_edit.php");
		} elseif ($action == "edit_process") {
			include("organization/process_edit.php");
		} else { 
			include("organization/bu_list.php");
		}
	}
	# template for each section
	if ($subsection == "legal") {
		if ($action == "edit") {
			include("organization/legal_edit.php");
		} else { 
			include("organization/legal_list.php");
		}
	}
	if ($subsection == "tp") {
		if ($action == "edit") {
			include("organization/tp_edit.php");
		} else { 
			include("organization/tp_list.php");
		}
	}
} elseif ($section == "asset") {

	if ($subsection == "asset_identification") {
		if ($action == "edit") {
			include("asset/asset_edit.php");
		} else { 
			include("asset/asset_list.php");
		}
	}
	if ($subsection == "asset_classification") {
		if ($action == "edit") {
			include("asset/asset_classification_edit.php");
		} else { 
			include("asset/asset_classification_list.php");
		}
	}
	
	if ($subsection == "data_asset") {
		if ($action == "edit") {
			include("asset/data_asset_edit.php");
		} else { 
			include("asset/data_asset_list.php");
		}
	}

} elseif ($section == "risk") {

	if ($subsection == "risk_management") {
		if ($action == "edit") {
			include("risk/risk_management_edit.php");
		} else { 
			include("risk/risk_management_list.php");
		}
	}
	if ($subsection == "risk_exception") {
		if ($action == "edit") {
			include("risk/risk_exception_edit.php");
		} else { 
			include("risk/risk_exception_list.php");
		}
	}
	
	if ($subsection == "risk_classification") {
		if ($action == "edit") {
			include("risk/risk_classification_edit.php");
		} else { 
			include("risk/risk_classification_list.php");
		}
	}

} elseif ($section == "security_services") {
	
	if ($subsection == "dashboard") {
		include("services/dashboard.php");
	}
	
	if ($subsection == "security_catalogue") {
		if ($action == "edit") {
			include("services/security_catalogue_edit.php");
		} else { 
			include("services/security_catalogue_list.php");
		}
	}
	
	if ($subsection == "security_services_audit") {
		if ($action == "edit_security_services_audit") {
			include("services/security_services_audit_edit.php");
		} else { 
			include("services/security_services_audit_list.php");
		}
	}
	
	if ($subsection == "service_contracts") {
		if ($action == "edit_service_contracts") {
			include("services/service_contracts_edit.php");
		} else { 
			include("services/service_contracts_list.php");
		}
	}

} elseif ($section == "system") {
	
	if ($subsection == "system_records") {
		if ($action == "edit") {
			include("system/system_records_edit.php");
		} else { 
			include("system/system_records_list.php");
		}
	}
	if ($subsection == "system_authentication") {
			include("system/system_authentication_edit.php");
	}
	if ($subsection == "system_authorization") {
		if ($action == "edit") {
			include("system/system_authorization_edit.php");
		} else { 
			include("system/system_authorization_list.php");
		}
	}
	if ($subsection == "system_roles") {
		if ($action == "edit") {
			include("system/system_roles_edit.php");
		} else { 
			include("system/system_roles_list.php");
		}
	}

} elseif ($section == "compliance") {

	
	if ($subsection == "compliance_package") {
		if ($action == "edit_compliance_package") {
			include("compliance/compliance_package_edit.php");
		} elseif ($action == "edit_compliance_package_item") {
			include("compliance/compliance_package_item_edit.php");
		} elseif ($action == "show_upload_form") {
			include("compliance/compliance_package_upload.php");
		} else { 
			include("compliance/compliance_list.php");
		}
	}

	if ($subsection == "compliance_management") {
		if ($action == "list_compliance_management") {
			include("compliance/compliance_management_list.php");
		} elseif ($action == "start_compliance_management") {
			include("compliance/compliance_management_list_step_two.php");
		} elseif ($action == "csv") {
			include("compliance/compliance_management_list_step_two.php");
		} elseif ($action == "edit") {
			include("compliance/compliance_management_edit.php");
		} elseif ($action == "update") {
			include("compliance/compliance_management_list_step_two.php");
		} else { 
			include("compliance/compliance_management_list.php");
		}
	}
	
	if ($subsection == "compliance_exception") {
		if ($action == "edit") {
			include("compliance/compliance_exception_edit.php");
		} else { 
			include("compliance/compliance_exception_list.php");
		}
	}

} elseif ($section == "operations") {
	
	if ($subsection == "project_improvements") {
		if ($action == "edit") {
			include("operations/project_improvements_edit.php");
		} else { 
			include("operations/project_improvements_list.php");
		}
	}

}
*/

include_once("footer.php");
?>
