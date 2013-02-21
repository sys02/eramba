<?php
include_once("header.php");
include_once("lib/dashboard_general_lib.php");
$system_chart_data = list_dashboard_chart("system_dashboard_tbl");
?>

	<section id="content-wrapper">
		<div id="widgets-area-wrap">
			<div id="main-area">
				<div class="widget">
					<div class="widget-header">Number of correct/incorrect logins</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',         'Correct Logins', 'Incorrect Logins'],
						      <?php
						     	
						      	foreach ( $system_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['system_dashboard_login_ok']; ?>, <?php echo $data['system_dashboard_login_not_ok']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
										fontSize: 11 }
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization" style="height: 200px;"></div>

					</div>
				</div>

			</div>

		</div>
	
	</section>

<?
include_once("footer.php");
?>
