<?php
include_once("header.php");
include_once("lib/dashboard_general_lib.php");

$risk_chart_data = list_dashboard_chart("bcm_plans_dashboard_tbl");

?>
	<section id="content-wrapper">
		<div id="widgets-area-wrap">
			<div id="main-area">
				<div class="widget">
					<div class="widget-header">Number of Plans with Fauly Audits</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',         'Number of Plans', 'Plans with faulty Audits'],
						      <?php
						     	
						      	foreach ( $risk_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['bcm_plans_dashboard_count']; ?>, <?php echo $data['bcm_plans_dashboard_failed_audits']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
								fontSize: 11
								}
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization" style="height: 200px;"></div>
							<p></p>

					</div>
				</div>

			</div>

		</div>
	
	</section>

<?
include_once("footer.php");
?>
