<?

# this will show an html drop menu for any given classification type
function asset_classification_type_html_drop_menu($preselected) {
	$sql = "SELECT 
		DISTINCT(asset_classification_type)
		from
		asset_classification_tbl
		WHERE
		asset_classification_disabled = \"0\"
		";

	$results = runQuery($sql);

	foreach($results as $item) {
			if ($item[asset_classification_type] == $preselected) {
				echo "<option selected=\"selected\" value=\"$item[asset_classification_type]\">$item[asset_classification_type]</option>\n";
			} else {
				echo "<option value=\"$item[asset_classification_type]\">$item[asset_classification_type]</option>\n";
			} 
	}

}

# this will show an html drop menu for any given classification type
function risk_classification_type_html_drop_menu($preselected) {
	$sql = "SELECT 
		DISTINCT(risk_classification_type)
		from
		risk_classification_tbl
		WHERE
		risk_classification_disabled = \"0\"
		";

	$results = runQuery($sql);

	foreach($results as $item) {
			if ($item[risk_classification_type] == $preselected) {
				echo "<option selected=\"selected\" value=\"$item[risk_classification_type]\">$item[risk_classification_type]</option>\n";
			} else {
				echo "<option value=\"$item[risk_classification_type]\">$item[risk_classification_type]</option>\n";
			} 
	}

}

# this will show an html drop menu for any given classification type
function security_incident_classification_type_html_drop_menu($preselected) {
	$sql = "SELECT 
		DISTINCT(security_incident_classification_type)
		from
		security_incident_classification_tbl
		WHERE
		security_incident_classification_disabled = \"0\"
		";

	$results = runQuery($sql);

	foreach($results as $item) {
			if ($item[security_incident_classification_type] == $preselected) {
				echo "<option selected=\"selected\" value=\"$item[security_incident_classification_type]\">$item[security_incident_classification_type]</option>\n";
			} else {
				echo "<option value=\"$item[security_incident_classification_type]\">$item[security_incident_classification_type]</option>\n";
			} 
	}

}

?>
