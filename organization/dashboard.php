<?php
include_once("header.php");
include_once("lib/dashboard_general_lib.php");
$asset_chart_data = list_dashboard_chart("organization_dashboard_tbl");
?>

	<section id="content-wrapper">

		
		<div id="widgets-area-wrap">
			<div id="main-area">
				<div class="widget">
					<div class="widget-header">Number of BU and Processes</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
							// Create and populate the data table.
							var data = google.visualization.arrayToDataTable([
							  ['x',         'BU', 'Process'],
							  <?php
								foreach ( $asset_chart_data as $data ) : ?>
									<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
									['<?php echo $date ?>', <?php echo $data['organization_dashboard_count_bu']; ?>, <?php echo $data['organization_dashboard_count_process']; ?>],
								<?php endforeach; ?>
							]);
						  
							// Create and draw the visualization.
							new google.visualization.LineChart(document.getElementById('visualization')).
								draw(data, {
										curveType: "function",
										width: window_width, height: 200,
										vAxis: {maxValue: 10},
										// this is an option to change font size for entire chart
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
					<div class="widget-header">Number of Third Parties and Legal Constrains</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
							// Create and populate the data table.
							var data = google.visualization.arrayToDataTable([
							  ['x', 'Third Parties', 'Legal'],
							  <?php
								foreach ( $asset_chart_data as $data ) : ?>
									<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
									['<?php echo $date ?>', <?php echo $data['organization_dashboard_count_legal']; ?>, <?php echo $data['organization_dashboard_count_tp']; ?>],
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

					</div>
				</div>

			</div>

		</div>
	</section>

<?
include_once("footer.php");
?>
