<?php
include_once("header.php");
include_once("lib/dashboard_general_lib.php");
$asset_chart_data = list_dashboard_chart("asset_dashboard_tbl");
?>

	<section id="content-wrapper">
		<div id="widgets-area-wrap">
			<div id="main-area">
				<div class="widget">
					<div class="widget-header">Number of assets per type</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',         'Total # of Assets', 'Data Assets', 'Hardware', 'Human', 'Information Systems', 'Software'],
						      <?php
						      	foreach ( $asset_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['count_assets_total']; ?>, <?php echo $data['count_assets_type_one']; ?>,<?php echo $data['count_assets_type_two']; ?>,<?php echo $data['count_assets_type_three']; ?>,<?php echo $data['count_assets_type_four']; ?>,<?php echo $data['count_assets_type_five']; ?>], 
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
				<div class="widget">
					<div class="widget-header">Data Asset Flows Analysis - Warnings by Percentage</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',         'Analysed with missing controls (%)', 'Analysed with failed controls (%)'],
						      <?php
						      	foreach ( $asset_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['percentage_of_missing_controls']; ?>, <?php echo $data['percentage_of_wrong_controls']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization2')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
									fontSize: 11
								}
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization2" style="height: 200px;"></div>
							<p></p>

					</div>
				</div>

			</div>

		</div>
	</section>

<?
include_once("footer.php");
?>
