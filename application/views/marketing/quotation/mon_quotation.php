<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Sales Quotation Monitor</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="fullscreen"></a>
						</div>
					</div>
					
					<div class="portlet-body">
						<div class="row">
							<div class="col-md-4 col-sm-4 col-xs-4">
								<a id="dash_open" class="dashboard-stat dashboard-stat-light blue-madison">
									<div class="visual">
										<i class="fa fa-asterisk fa-icon-medium"></i>
									</div>

									<div class="details">
										<div class="number"><?php echo $count_open ?></div>
										<div class="desc">OPEN</div>
									</div>
								</a>
							</div>

							<div id="dash_confirm" class="col-md-4 col-sm-4 col-xs-4">
								<a class="dashboard-stat dashboard-stat-light green-haze">
									<div class="visual">
										<i class="fa fa-check fa-icon-medium"></i>
									</div>

									<div class="details">
										<div class="number"><?php echo $count_confirm ?></div>
										<div class="desc">CONFIRMED</div>
									</div>
								</a>
							</div>
							
							<div id="dash_all" class="col-md-4 col-sm-4 col-xs-4">
								<a class="dashboard-stat dashboard-stat-light red-intense">
									<div class="visual">
										<i class="fa fa-bar-chart fa-icon-medium"></i>
									</div>

									<div class="details">
										<div class="number"><?php echo $count_confirm + $count_open ?></div>
										<div class="desc">TOTAL QUOTATION</div>
									</div>
								</a>
							</div>
						</div>
						
						<br>
						
						<div class="row">
							<div class="col-md-12">
								<div class="table-scrollable-borderless">
									<table id="tmon_quo" class="table table-condensed table-striped">
										<thead>
											<tr>
												<th>No</th>
												<th>Quotation Number</th>
												<th>Document Date</th>
												<th style='text-align: left;'>Customer</th>
												<th style='text-align: left;'>Destination</th>
												<th style='text-align: left;'>Sales Person</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if($monitor_data){
												$i = 1;
												foreach ($monitor_data as $key => $m) {
													echo "<tr>";
													echo "<td style='text-align: center;'>$i</td>";
													echo "<td style='text-align: center;'>";
													echo $m->quotation_number;
													echo "</td>";
													echo "<td style='text-align: center;'>".tgl_ind($m->document_date)."</td>";
													echo "<td>$m->customer_company_name</td>";
													echo "<td>$m->port_name - $m->destination_country</td>";
													echo "<td>$m->sales_firstname $m->sales_lastname</td>";
													echo "<td style='text-align: center;'>$m->status_badges</td>";
													echo "</tr>";
													
													$i++;
												}
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
		</div>
	</div>
</div>

<script>
	$('#tmon_quo').dataTable();
	
	$('#dash_open').on('click', function(){
		window.location.href = "<?php echo site_url('sales-quotation/monitor/open')?>";
	});
	$('#dash_confirm').on('click', function(){
		window.location.href = "<?php echo site_url('sales-quotation/monitor/confirm')?>";
	});
	$('#dash_all').on('click', function(){
		window.location.href = "<?php echo site_url('sales-quotation/monitor')?>";
	});
</script>