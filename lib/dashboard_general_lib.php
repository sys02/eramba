<?php
	
	function list_dashboard_chart($table) {
		$sql = "SELECT * FROM `{$table}` WHERE dashboard_disabled = \"0\" ORDER by dashboard_date ASC";
		$query = runQuery($sql);
		return $query;
	}

?>
