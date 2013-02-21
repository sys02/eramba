<?php
include_once("header.php");
include_once("lib/dashboard_general_lib.php");
$operations_chart_data = list_dashboard_chart("security_operations_dashboard_tbl");
?>

	<section id="content-wrapper">
		<div id="widgets-area-wrap">
			<div id="main-area">


				<div class="widget">
					<div class="widget-header">Number of Projects</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',    'Total',  'Project Planned', 'Project Initiated', 'Project Complete'],
						      <?php
						     	
						      	foreach ( $operations_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['security_operations_dashboard_project_count']; ?>, <?php echo $data['security_operations_dashboard_project_idea']; ?>, <?php echo $data['security_operations_dashboard_project_initiated']; ?>, <?php echo $data['security_operations_dashboard_project_complet']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization3')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
									fontSize: 11 }
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization3" style="height: 200px;"></div>

					</div>
				</div>
				
			<div class="widget">
					<div class="widget-header">Planned Projects: Current Vs. Planned Budget</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',    'Planned Budget',  'Current Budget'],
						      <?php
						     	
						      	foreach ( $operations_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['security_operations_dashboard_plan_budget_plan']; ?>, <?php echo $data['security_operations_dashboard_current_budget_plan']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization34')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
									fontSize: 11 }
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization34" style="height: 200px;"></div>

					</div>
				</div>
			
			<div class="widget">
					<div class="widget-header">Ongoing Projects: Current Vs. Planned Budget</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',    'Planned Budget',  'Current Budget'],
						      <?php
						     	
						      	foreach ( $operations_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['security_operations_dashboard_plan_budget_on']; ?>, <?php echo $data['security_operations_dashboard_current_budget_on']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization54')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
									fontSize: 11 }
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization54" style="height: 200px;"></div>

					</div>
				</div>
			
				<div class="widget">
					<div class="widget-header">Completed Projects: Current Vs. Planned Budget</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',    'Planned Budget',  'Current Budget'],
						      <?php
						     	
						      	foreach ( $operations_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['security_operations_dashboard_plan_budget_com']; ?>, <?php echo $data['security_operations_dashboard_current_budget_com']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization55')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
									fontSize: 11 }
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization55" style="height: 200px;"></div>

					</div>
				</div>

				<div class="widget">
					<div class="widget-header">Number of Security Incidents</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',  'Total',  'Incident Reported', 'Incident Open', 'Incident Closed'],
						      <?php
						     	
						      	foreach ( $operations_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['security_operations_dashboard_incident_count']; ?>, <?php echo $data['security_operations_dashboard_incident_reported']; ?>, <?php echo $data['security_operations_dashboard_incident_open']; ?>, <?php echo $data['security_operations_dashboard_incident_closed']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization4')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
								fontSize: 11 }
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization4" style="height: 200px;"></div>

					</div>
				</div>
				

			</div>
		</div>
	</section>

<?
include_once("footer.php");
?>
