<?php
include_once("header.php");
include_once("lib/dashboard_general_lib.php");

$risk_chart_data = list_dashboard_chart("risk_dashboard_tbl");

?>
	<section id="content-wrapper">
		<div id="widgets-area-wrap">
			<div id="main-area">
				
			<div class="widget">

					<div class="widget-header">Number of Risks per Type</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',         'Asset Risks', 'TP Risks', 'Bussiness Risks'],
						      <?php
						     	
						      	foreach ( $risk_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['risk_dashboard_count_asset_risks']; ?>, <?php echo $data['risk_dashboard_count_tp_risks']; ?>,<?php echo $data['risk_dashboard_count_buss_risks']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization19')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
								fontSize: 11
								}
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization19" style="height: 200px;"></div>
							<p></p>

					</div>
				</div>

				<div class="widget">
					<div class="widget-header">Risk with Issues (Only TP and Assets Risks!)</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',         'Expired Revisions (%)', 'Risks with Expired Risk Exceptions (%)', 'Risks using Failed Controls (%)'],
						      <?php
						     	
						      	foreach ( $risk_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['risk_dashboard_percentage_expired_risks']; ?>, <?php echo $data['risk_dashboard_percentage_expired_exceptions']; ?>,<?php echo $data['risk_dashboard_percentage_fail_controls']; ?>],
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
					<div class="widget-header">Risk Index</div>
					<div class="widget-content">

						<script type="text/javascript">
						var window_width = $(window).width() - 100;
						  function drawVisualization() {
						    // Create and populate the data table.
						    var data = google.visualization.arrayToDataTable([
						      ['x',         'Risk Score', 'Risk Residual'],
						      <?php
						     	
						      	foreach ( $risk_chart_data as $data ) : ?>
						      		<?php $date = date( "m-Y", strtotime($data["dashboard_date"]) ); ?>
						      		['<?php echo $date ?>', <?php echo $data['risk_dashboard_count_risk_index']; ?>, <?php echo $data['risk_dashboard_count_risk_residual_index']; ?>],
						      	<?php endforeach; ?>
						    ]);
						  
						    // Create and draw the visualization.
						    new google.visualization.LineChart(document.getElementById('visualization89')).
						        draw(data, {curveType: "function",
						                    width: window_width, height: 200,
						                    vAxis: {maxValue: 10},
								fontSize: 11
								}
						            );
						  }

						  google.setOnLoadCallback(drawVisualization);

						</script>

							<div id="visualization89" style="height: 200px;"></div>
							<p></p>

					</div>
				</div>

			</div>

		</div>
	
	</section>

<?
include_once("footer.php");
?>
