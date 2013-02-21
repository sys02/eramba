<?
	include_once("lib/system_records_lib.php");
	include_once("lib/system_users_lib.php");
	include_once("lib/site_lib.php");
	include_once("lib/system_authorization_lib.php");

	# general variables - YOU SHOULDNT NEED TO CHANGE THIS
	$sort = $_GET["sort"];
	$section = $_GET["section"];
	$subsection = $_GET["subsection"];
	$action = $_GET["action"];
	
	$base_url_list = build_base_url($section,"system_records_list");
	$base_url_edit = build_base_url($section,"system_records_edit");
	
	# local variables - YOU MUST ADJUST THIS! 
	$system_records_id = $_GET["system_records_id"];
	$system_records_name = $_GET["system_records_name"];
	$system_records_description = $_GET["system_records_description"];
	$system_records_disabled = $_GET["system_records_disabled"];


	# this will get called often ...
	# if i have any of this items, then i need to show that! .. there might be a need to add
	$system_records_lookup_section = $_GET["system_records_lookup_section"];
	$system_records_lookup_subsection = $_GET["system_records_lookup_subsection"];
	$system_records_lookup_item_id = $_GET["system_records_lookup_item_id"];
	$system_records_lookup_action = $_GET["system_records_lookup_action"];
	$system_records_lookup_author = $_GET["system_records_lookup_author"];
	$system_records_notes = $_GET["system_records_notes"];

	# if i have all this values, then i can search for something specific ...
	if (!empty($system_records_lookup_section) AND !empty($system_records_lookup_subsection) AND !empty($system_records_lookup_item_id)) {
		$specific_query = " WHERE system_records_section=\"$system_records_lookup_section\" AND system_records_subsection=\"$system_records_lookup_subsection\" AND system_records_item_id=\"$system_records_lookup_item_id\"";
	} 
	 
	#actions .. edit, update or disable - YOU MUST ADJUST THIS!
	if ($system_records_lookup_action == "add_note") {
		add_system_records($system_records_lookup_section, $system_records_lookup_subsection, $system_records_lookup_item_id, $system_records_lookup_author, "Note", $system_records_notes);
	}

	if ($action == "csv") {
		export_system_records_csv();
	}
	# ---- END TEMPLATE ------

?>

	<section id="content-wrapper">
		<h3>System Records (beta!)</h3>
		<div class="controls-wrapper">
<?
#echo "			<a href=\"$base_url&action=edit\" class=\"add-btn\">";
echo "			<a href=\"$base_url_edit&action=edit&system_records_lookup_section=$system_records_lookup_section&system_records_lookup_subsection=$system_records_lookup_subsection&system_records_lookup_item_id=$system_records_lookup_item_id\" class=\"add-btn\">";
?>
				<span class="add-icon"></span>
				Add a New Note	
			</a>
			
			<div class="actions-wraper">
				<a href="#" class="actions-btn">
					Actions
					<span class="select-icon"></span>
				</a>
				<ul class="action-submenu">
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------
if ($action == "csv") {
echo "					<li><a href=\"downloads/system_records_export.csv\">Dowload</a></li>";
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
echo "					<th><a href=\"$base_url_list&sort=system_records_date\">When</a></th>";
echo "					<th><a href=\"$base_url_list&sort=system_records_action\">What</a></th>";
echo "					<th><a href=\"$base_url_list&sort=system_records_section\">To Whom</a></th>";
echo "					<th><a href=\"$base_url_list&sort=system_records_author\">By whom</a></th>";
echo "					<th><a href=\"$base_url_list&sort=NULL\"></a>Notes</th>";
?>
				</tr>
			</thead>
	
			<tbody>
<?
# -------- TEMPLATE! YOU MUST ADJUST THIS ------------

$page_limit = 40;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$page_offset = ($page-1)*$page_limit;

	if ($sort == "system_records_description" OR $sort == "system_records_section" OR $sort == "system_records_action" OR $sort == "system_records_author") {
	$system_records_list = list_system_records(" $speficic_query ORDER by $sort LIMIT {$page_limit} OFFSET {$page_offset}");
	} else {
	$system_records_list = list_system_records(" $specific_query ORDER by system_records_date DESC LIMIT {$page_limit} OFFSET {$page_offset}");
	}

	foreach($system_records_list as $system_records_item) {

		# $record_url = get_system_edit_entry_url( $system_records_item['system_records_subsection'], $system_records_item['system_records_item_id'] );
		# $cute_names = get_system_record_cute_name( $system_records_item['system_records_subsection'] );

		$cute_name = lookup_system_authorization("system_authorization_subsection_name",$system_records_item['system_records_subsection']); 

		$username = lookup_system_users("system_users_id",$system_records_item['system_records_author']);

echo "				<tr class=\"even\">";
echo "					<td>$system_records_item[system_records_date]</td>";
echo "					<td>$system_records_item[system_records_action]</td>";
echo "					<td>$cute_name[system_authorization_subsection_cute_name] / #$system_records_item[system_records_item_id]</td>";
echo "					<td>$username[system_users_login]</td>";
echo "					<td>$system_records_item[system_records_notes]</td>";
echo "				</tr>";
	}

?>
			</tbody>
		</table>

		<?php 
			$count_system_records_list = count(list_system_records(" $specific_query"));
			$count_pages = ceil($count_system_records_list/$page_limit);
		?>

		<br class="clear"/>
		<div class="table-tools table-tools-bottom">
			<div class="paginator">

				<?php if ($page > 1) : ?>
				<span class="prev-btn">
					<a href="<?php echo $base_url_list; ?>&page=<?php echo $page-1; ?>" rel="prev"> </a>
				</span>
				<?php endif; ?>

				<span class="page-numbers">
					<?php if ($page > 2) : ?>
					<span><a href="<?php echo $base_url_list; ?>&page=1">1</a></span>
					<span> ... </span>
					<?php endif; ?>

					<?php if ($page != 1) : ?>
					<span><a href="<?php echo $base_url_list; ?>&page=<?php echo $page-1; ?>"><?php echo $page-1; ?></a></span>
					<?php endif; ?>

					<span class="current"><?php echo $page; ?></span>

					<?php if ($page != $count_pages) : ?>
					<span><a href="<?php echo $base_url_list; ?>&page=<?php echo $page+1; ?>"><?php echo $page+1; ?></a></span>	
					<?php endif; ?>

					<?php if ($page < $count_pages-1) : ?>
					<span> ... </span>
					<span><a href="<?php echo $base_url_list; ?>&page=<?php echo $count_pages; ?>"><?php echo $count_pages; ?></a></span>
					<?php endif; ?>
				</span>

				

				<?php if ($page < $count_pages) : ?>
				<span class="next-btn">
					<a href="<?php echo $base_url_list; ?>&page=<?php echo $page+1; ?>" rel="next"> </a>
				</span>
				<?php endif; ?>

			</div>
		</div>
	</section>
