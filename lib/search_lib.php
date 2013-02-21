<?php
	$search_tables = array(
		'risk_exception' => array( 'risk_exception_title' ),
		'risk' => array( 'risk_title', 'risk_threat' ),
		'asset' => array( 'asset_name', 'asset_description' ),
		'asset_classification' => array( 'asset_classification_criteria' ),
		'asset_label' => array( 'asset_label_name' ),
		'bu' => array( 'bu_name' ),
		'data_asset' => array( 'data_asset_description' ),
		'risk_classification' => array( 'risk_classification_name' ),
		'legal' => array( 'legal_name' ),
		'tp' => array( 'tp_name' ),
		'security_services' => array( 'security_services_name' ),
		'security_incident' => array( 'security_incident_title' ),
		'security_incident_classification' => array( 'security_incident_classification_name' ),
		'compliance_exception' => array( 'compliance_exception_title' ),
		'project_improvements' => array( 'project_improvements_title' ),
		'policy_exceptions' => array( 'policy_exceptions_title' )
	);

	function get_search( $query ) {
		global $search_tables;
		
		$has_results = false;
		foreach ( $search_tables as $tbl => $columns ) {
			$tbl_name = $tbl . '_tbl';

			$where_clause = get_where_clause( $columns, $query );

			$sql = "SELECT * FROM `$tbl_name` WHERE $where_clause";

			$search = runQuery( $sql );
			if ( ! empty( $search ) ) {
				if ( ! $has_results ) {
					echo '<h3>Search results for: <span style="font-weight:normal; font-style:italic">' . $query . '</span></h3><br /><br />';
					$has_results = true;
				}
				
				search_result( $search, $tbl, $columns );
			}
		}
		if ( ! $has_results ) {
			echo '<h3>No search results for: <span style="font-weight:normal; font-style:italic">' . $query . '</span></h3>';
		}
	}

	function search_result( $search, $tbl, $search_columns ) {
		global $correct_tables;

		if ( array_key_exists( $tbl, $correct_tables ) ) {
			$tbl = $correct_tables[ $tbl ];
		}

		$sql_tbl = $tbl . '_list';
		$sql = "SELECT `system_authorization_subsection_cute_name` FROM `system_authorization_tbl` WHERE `system_authorization_subsection_name`='$sql_tbl'";
		$query = runSmallQuery( $sql );

		echo '<div class="search-results-tbl">';
			echo '<h3>' . $query['system_authorization_subsection_cute_name'] . '</h3>';
			foreach ( $search as $search_arr ) {
				echo '<div>';
				echo '<a href="' . get_edit_entry_url( $tbl, $search_arr[ $tbl . '_id' ] ) . '">'; 
				foreach ( $search_columns as $search_column ) {
					echo '<p>' . $search_arr[ $search_column ] . '</p>';
				}
				echo '</a>';
				echo '</div>';
			}
		echo '</div>';
	}

	function get_where_clause( $columns, $query ) {
		$where_clause = '';
		$index = 0;
		foreach ( $columns as $column ) {
			if ( $index == 0 ) {
				$where_clause .= "`$column` LIKE '%$query%'";
			} else {
				$where_clause .= " OR `$column` LIKE '%$query%'";
			}
			$index ++;
		}
		return $where_clause;
	}


	$correct_tables = array(
		'risk' => 'risk_management',
		'security_services' => 'security_catalogue'
	);

	function get_edit_entry_url( $tbl, $id ) {
		$id_col = $tbl;
		global $correct_tables;

		//var_dump( array_key_exists( $tbl, $correct_tables ) );
		if ( array_key_exists( $tbl, $correct_tables ) ) {
			$tbl = $correct_tables[ $tbl ];
		}

		$edit_tbl_name = $tbl . '_edit';
		$sql = "SELECT * FROM `system_authorization_tbl` WHERE `system_authorization_subsection_name` = '$edit_tbl_name'";
		$query = runSmallQuery( $sql );
		$url = 'index.php?section=' . $query['system_authorization_section_name'] . '&subsection=' . $query['system_authorization_subsection_name'] . '&action=edit&' . $id_col . '_id=' . $id;
		return $url;
	}

?>