<?php

include_once('configuration.inc');

global $system_conf;
if ( $system_conf['debug'] ) {
	ini_set('display_errors', 1);
} else {
	ini_set('display_errors', 0);
}


global $db_conf;

$link = mysql_connect($db_conf['db_hostname'], $db_conf['db_username'], $db_conf['db_password']);

if (!$link) {
    die('Not connected : ' . mysql_error());
}

$db_selected = mysql_select_db($db_conf['db_name'], $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}

# this runs a query and expects only one result on the select (like LIMIT =1)
function runSmallQuery($query) {
	global $system_conf;
	
	if (!$query) { return; } 
	
	$result = mysql_query($query);
	if (!$result) {
		if ($system_conf['debug']) {
			echo "Invalid query (runSmallQuery) ($query): " . mysql_error();
		} else {
			die();
		}
	}

	$table = array();

	if (mysql_num_rows($result) > 0)
	{
		#while($row = mysql_fetch_row($result)) {
		while($row = mysql_fetch_assoc($result)) {
			return $row;
		}
	}

	mysql_free_result($result);
	return;

}

function runQuery($query) {
	global $system_conf;

	$result = mysql_query($query);
	if (!$result) {
		if ($system_conf['debug']) {
			echo "Invalid query (runSmallQuery) ($query): " . mysql_error();
		} else {
			die();
		}
	}
	
	$table = array();

	if (mysql_num_rows($result) > 0)
	{
		while($row = mysql_fetch_assoc($result)) 
		array_push($table, $row);
	}
	return $table;

}

function runQueryNonAssoc($query) {
	global $system_conf;

	if (!$query) { return; } 
	
	$result = mysql_query($query);
	if (!$result) {
		if ($system_conf['debug']) {
			echo "Invalid query (runQueryNonAssoc) ($query): " . mysql_error();
		} else {
			die();
		}
	}

	$table = array();

	if (mysql_num_rows($result) > 0)
	{
		while($row = mysql_fetch_row($result)) 
		array_push($table, $row);
	}
	mysql_free_result($result);
	return $table;

}

function runUpdateQuery($query) {
	global $system_conf;
	
	if (!$query) { return; } 
	
	$result = mysql_query($query);
	if (!$result) {
		if ($system_conf['debug']) {
			echo "Invalid query (runUpdateQuery) ($query): " . mysql_error();
		} else {
			die();
		}
	} else {
		$last_id = mysql_insert_id();
	}

	return $last_id;
}
	
# http://www.evoluted.net/thinktank/web-development/time-saving-database-functions
# dbRowInsert('my_table', $form_data);
# $form_data = array(
# 'first_name' => $first_name,
# 'last_name' => $last_name
# );
function dbRowInsert($table_name, $form_data) {
    $fields = array_keys($form_data);
    $sql = "INSERT INTO ".$table_name."
    (`".implode('`,`', $fields)."`)
    VALUES('".implode("','", $form_data)."')";
    return mysql_query($sql);
}

# dbRowUpdate('my_table', $form_data, "WHERE id = '$id'");
function dbRowUpdate($table_name, $form_data, $where_clause='')
{
    // check for optional where clause
    $whereSQL = '';
    if(!empty($where_clause))
    {
        // check to see if the 'where' keyword exists
        if(substr(strtoupper(trim($where_clause)), 0, 5) != 'WHERE')
        {
            // not found, add key word
            $whereSQL = " WHERE ".$where_clause;
        } else
        {
            $whereSQL = " ".trim($where_clause);
        }
    }
    // start the actual SQL statement
    $sql = "UPDATE ".$table_name." SET ";
    // loop and build the column /
    $sets = array();
    foreach($form_data as $column => $value)
    {
         $sets[] = "`".$column."` = '".$value."'";
    }
    $sql .= implode(', ', $sets);
    // append the where statement
    $sql .= $whereSQL;
    // run and return the query result
    return mysql_query($sql);
}



