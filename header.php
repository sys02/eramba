<?php
	# ini_set('display_errors', 'on');
	include_once("lib/site_lib.php");
	$base_url = build_base_url("main","land_site");
?>

<!DOCTYPE html>
<html lang="en">
<head>
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
echo "	<script type=\"text/javascript\" src=\"js/input-filters.js\"></script>";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/normalize.css\" />";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/styles.css\" />";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/chosen.css\" />";
echo "	<link rel=\"stylesheet\" type=\"text/css\" href=\"css/chosen.css\" />";
?>

<script type="text/javascript" src="//www.google.com/jsapi"></script>

    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>

	<link rel="stylesheet" href="css/jquery-ui.css" />
	<script>
		$(function() {
			$( ".datepicker" ).datepicker({ dateFormat: 'yy-mm-dd' });
		});
	</script>
	
	<title>eramba security manager</title>
	
	<script>
	$(document).ready(function(){
		$("#search-field").hide();
		$("#add-control-items").hide();

		$("#search-control-icon").click(function(){
			$("#search-field").animate({
			    left: 'toggle',
			}, 200);
			$("#search-field input:visible").focus();
		});
		
		$('#search-field').keypress(function (e) {
			  if (e.which == 13) {
			    $(this).parents('form').submit();
			  }
		});
		
		$("#add-control-icon").click(function(){
			$("#add-control-items").toggle();
		});
	});
	
	$(document).ready(function() {
		$("#accordion").accordion();
	});
		
	
	$(document).ready(function(){
			$(".chzn-select").chosen({
				no_results_text: "No results matched",
				placeholder_text: "Select Some Options..."
			}).change(function(event, value){
				var select = $(event.currentTarget),
					textarea = select.prev('textarea'),
					textareaVal = textarea.val(),
					currentValue, addValue, replaceQuery;

				if (value.hasOwnProperty('selected')) {
					
					if (value.selected === -1) return;

					currentValue = $('option[value="' + value.selected + '"]', select).text().trim(),

					addValue = ((textareaVal) ? ', ' : '') + currentValue;

					textarea.val(textareaVal + addValue);
				}

				if (value.hasOwnProperty('deselected')) {
					if (value.selected === -1) return;

					currentValue = $('option[value="' + value.deselected + '"]', select).text().trim(),
					
					replaceQuery = currentValue;

					if (textareaVal.indexOf(currentValue) === 0 && textareaVal.indexOf(currentValue + ', ') !== -1) {
						replaceQuery = currentValue + ', ';
					}

					if (textareaVal.indexOf(currentValue) > 0) {
						replaceQuery = ', ' + currentValue;
					}

					textarea.val( textareaVal.replace(replaceQuery, ''));
				}
			});
			
			$(".tab-wrapper > ul li a").click(function(event) {
				event.preventDefault();
				$(".tab-wrapper > ul li").each(function() {
				    $(this).removeClass("active");
				});
				$(this).parent().addClass("active");

				$(".tab-content > div").hide();
				var content = "#" + $(this).attr("href");
				$(content).show();
			});
	
			$(".tab-content div.tab").hide();
			$(".tab-content div.tab:first").show();
			
		}); 

	</script>
</head>
<body>
	<section id="header-wrapper">
		<div id="header-inner">
			<a href="/" id="logo">
			</a>
			<div id="user-box">
				<div id="user-links">
					<a href="#" id="user-profile"><?php echo $logged_user_data['system_users_name'] . ' ' . $logged_user_data['system_users_surname']; ?></a>
					<a href="?logout=1" id="user-sign-out">Sign out</a>
				</div>
<?php
echo "				<img src=\"img/profile-pic.png\" alt=\"Profile pic\"/>";
?>
			</div>
<!--
			<div id="login-box">
				<form name="login" method="POST" action="<?echo "$base_url"?>">
					<div class="login-form">
						
							<span>Login <input type="text" name="system_login" /></span>
							<span>Password <input type="password" name="system_passwd" /></span>
						
					</div>
						
					<input type="submit" class="login-button" value="Log in" />
				</form>
			</div>
-->

		</div>
	</section>
	<section id="menu-wrapper">
		<nav id="menu-top">

			<ul id="menu-items">
				<?php show_menu_main(); ?>
				<!--<li><a href="?section=organization&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "organization")?>>Organization</a></li>
				<li><a href="?section=asset&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "asset")?>>Asset Management</a></li>
				<li><a href="?section=risk&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "risk")?>>Risk Management</a></li>
				<li><a href="?section=security_services&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "security_services")?>>Security Services</a></li>
				<li><a href="?section=compliance&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "compliance")?>>Compliance</a></li>
				<li><a href="?section=operations&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "operations")?>>Security Operations</a></li>
				<li><a href="?section=system&subsection=dashboard" <?php is_this_menu_active($_GET["section"], "system")?>>System</a></li>-->
				<li id="search-icon"><a href="search.php"></a></li>
			</ul>
			
		</nav>
		<nav id="menu-sub">
			<ul>
			<?php
				show_menu_sub(@$_GET["section"]);
			?>
			</ul>
		</nav>
	</section>
