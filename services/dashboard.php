<?php
include_once("header.php");
include_once("lib/dashboard_general_lib.php");
?>

<?php $security_data = list_dashboard_chart("security_services_dashboard_tbl"); ?>

	<section id="content-wrapper">

				<div class="widget">
					<div class="widget-header">Percentage of Failed Audits (%100 being all failed)</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
							// Create and populate the data table.
							var data = google.visualization.arrayToDataTable([
							  ['x', 'Percentage of failed controls'],
							  <?php
								foreach ( $security_data as $data ) : ?>
									<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
									['<?php echo $date ?>', <?php echo $data['service_audit_errors']; ?>],
								<?php endforeach; ?>
							]);
						  
							// Create and draw the visualization.
							new google.visualization.LineChart(document.getElementById('visualization17')).
								draw(data, {curveType: "function",
											width: window_width, height: 200,
											vAxis: {maxValue: 10},
											fontSize: 11
										}
									);
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization17" style="height: 200px;"></div>

					</div>
				</div>

		<div id="widgets-area-wrap">
			<div id="main-area">
				<div class="widget">
					<div class="widget-header">Security Controls OPEX</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
							// Create and populate the data table.
							var data = google.visualization.arrayToDataTable([
							  ['x', 'Proposed', 'Design', 'Transition','Production'],
							  <?php
								foreach ( $security_data as $data ) : ?>
									<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
									['<?php echo $date ?>', <?php echo $data['security_services_dashboard_op_prop']; ?>,<?php echo $data['security_services_dashboard_op_des']; ?>,<?php echo $data['security_services_dashboard_op_tran']; ?>, <?php echo $data['security_services_dashboard_op_prod']; ?>],
								<?php endforeach; ?>
							]);
						  
							// Create and draw the visualization.
							new google.visualization.LineChart(document.getElementById('visualization1')).
								draw(data, {curveType: "function",
											width: window_width, height: 200,
											vAxis: {maxValue: 10},
											fontSize: 11
										}
									);
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization1" style="height: 200px;"></div>

					</div>
				</div>
				
				<div class="widget">
					<div class="widget-header">Security Controls CAPEX</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
							// Create and populate the data table.
							var data = google.visualization.arrayToDataTable([
							  ['x', 'Proposed', 'Design', 'Transition','Production'],
							  <?php
								foreach ( $security_data as $data ) : ?>
									<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
									['<?php echo $date ?>', <?php echo $data['security_services_dashboard_cap_prop']; ?>,<?php echo $data['security_services_dashboard_cap_des']; ?>,<?php echo $data['security_services_dashboard_cap_tran']; ?>, <?php echo $data['security_services_dashboard_cap_prod']; ?>],
								<?php endforeach; ?>
							]);
						  
							// Create and draw the visualization.
							new google.visualization.LineChart(document.getElementById('visualization11')).
								draw(data, {curveType: "function",
											width: window_width, height: 200,
											vAxis: {maxValue: 10},
											fontSize: 11
										}
									);
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization11" style="height: 200px;"></div>

					</div>
				</div>

				<div class="widget">
					<div class="widget-header">Security Controls Resource Utilization</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
							// Create and populate the data table.
							var data = google.visualization.arrayToDataTable([
							  ['x', 'Resource'],
							  <?php
								foreach ( $security_data as $data ) : ?>
									<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
									['<?php echo $date ?>', <?php echo $data['security_services_dashboard_resource']; ?>],
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

				<div class="widget">
					<div class="widget-header">Number of Security Controls by per status</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
							// Create and populate the data table.
							var data = google.visualization.arrayToDataTable([
							  ['x', 'Total', 'Proposed', 'Design', 'Transition', 'Product'],
							  <?php
								foreach ( $security_data as $data ) : ?>
									<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
									['<?php echo $date ?>', <?php echo $data['security_services_dashboard_total']; ?>,<?php echo $data['security_services_dashboard_proposed']; ?>, <?php echo $data['security_services_dashboard_design']; ?>, <?php echo $data['security_services_dashboard_transition']; ?>, <?php echo $data['security_services_dashboard_production']; ?>],
								<?php endforeach; ?>
							]);
						  
							// Create and draw the visualization.
							new google.visualization.LineChart(document.getElementById('visualization3')).
								draw(data, {curveType: "function",
											width: window_width, height: 200,
											vAxis: {maxValue: 10},
											fontSize: 11
										}
									);
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization3" style="height: 200px;"></div>

					</div>
				</div>

			</div>


		</div>
	
	</section>

<?
include_once("footer.php");
?>
