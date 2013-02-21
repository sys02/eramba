<?
#ini_set('display_errors', '0');
session_start();
include_once("lib/mysql_lib.php");
include_once("lib/search_lib.php");

$logged_user_id = isset($_SESSION['logged_user_id']) ? $_SESSION['logged_user_id'] : null;

if ( !$logged_user_id || isset($_GET['logout']) ) {
	unset($_SESSION['logged_user_id']);
	header('Location: login.php');
}

if ( isset($_GET['section']) ) {
	header('Location: index.php?section=' . $_GET['section']);
}

$logged_user_data = runSmallQuery( 
	"SELECT * FROM `system_users_tbl` WHERE 
	`system_users_id`='" . $logged_user_id . "'"
);


include_once("header.php");

?>

<section id="content-wrapper" class="search-page">
	<h3>Search (ultra-beta!)</h3>
	<form name="search-form" method="get" id="search-form">
		<input type="text" class="filter-text" name="search-query" placeholder="Enter search here..." />
		<input type="submit" name="search-submit" value="Search!" class="add-btn" />
	</form>
	<div id="search-results">
		<?php
			if ( isset( $_GET['search-submit'] ) && $_GET['search-query'] != '' ) {
				$query = $_GET['search-query'];
				$results = get_search($query);
				echo '<pre>';
				print_r($results);
			}
			
			
		?>
	</div>
</section>


<?php
include_once("footer.php");
?>
