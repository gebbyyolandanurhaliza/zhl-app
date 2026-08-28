<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-md-12">
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Sales Contract Monitor</span>
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
								<a id="dash_outstanding" class="dashboard-stat dashboard-stat-light blue-madison">
									<div class="visual">
										<i class="fa fa-asterisk fa-icon-medium"></i>
									</div>

									<div class="details">
										<div class="number"><?php echo $c_outstanding?></div>
										<div class="desc">OUTSTANDING</div>
									</div>
								</a>
							</div>

							<div id="dash_completed" class="col-md-4 col-sm-4 col-xs-4">
								<a class="dashboard-stat dashboard-stat-light green-haze">
									<div class="visual">
										<i class="fa fa-check fa-icon-medium"></i>
									</div>

									<div class="details">
										<div class="number"><?php echo $c_completed ?></div>
										<div class="desc">COMPLETED</div>
									</div>
								</a>
							</div>
							
							<div id="dash_deleted" class="col-md-4 col-sm-4 col-xs-4">
								<a class="dashboard-stat dashboard-stat-light red-intense">
									<div class="visual">
										<i class="fa fa-trash-o fa-icon-medium"></i>
									</div>

									<div class="details">
										<div class="number"><?php echo $c_deleted ?></div>
										<div class="desc">DELETED</div>
									</div>
								</a>
							</div>
						</div>
						
						<br>
						
						<div class="row">
							<div class="col-md-12">
								<div class="table-scrollable-borderless">
									<table id="tmon_con" class="table table-condensed table-striped">
										<thead>
											<tr>
												<th>No</th>
												<th>Sales Contract Number</th>
												<th>Date</th>
												<th style='text-align: left;'>Customer</th>
												<th style='text-align: left;'>Destination</th>
												<th style='text-align: left;'>Sales Marketing</th>
												<?php
												switch ($status) {
													case 'COMPLETED':
														
														break;
													
													case 'DELETED':
														echo "<th style='text-align: left;'>Deleted By</th>";
														break;

													default:
														echo "<th style='text-align: left;'>Issued By</th>";
														break;
												}
												?>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<?php 
											if($monitor_data){
												$i = 1;
												foreach ($monitor_data as $row) {
													$con_no = $row->contract_no;
													$con_link = site_url('sales-contract/show-find_temp/?id='.encode_str($row->contract_hdr_id, 'contract'));
													$pdf_link = site_url('sales-contract/generate-pdf/?id='.encode_str($row->contract_hdr_id)).'&no='.encode_str($row->contract_no).'&dt='.encode_str(date('d-M-Y', strtotime($row->contract_date)));

													echo "<tr>";
													echo "<td style='text-align: center;'>$i</td>";
													echo "<td style='text-align: center;'>";
													echo "<a target='_blank' href='$con_link'><span class='font-blue-steel'><strong>$con_no</strong></span></a>";
													echo "<a href='$pdf_link' class='btn btn-xs' target='_blank' title='Click to View PDF'><i class='fa fa-file-pdf-o'></i> PDF</a>";
													echo "</td>";
													echo "<td style='text-align: center;'>".tgl_ind($row->contract_date)."</td>";
													echo "<td>$row->customer_company_name</td>";
													if (trim_all($row->destination == '')){
														echo "<td></td>";
													} else {
														echo "<td>$row->port_name - $row->destination</td>";
													}
													echo "<td>".  strtoupper($row->sales_marketing_id)."</td>";
													
													switch ($status) {
														case 'COMPLETED':
//															echo "<td></td>";
															$label_type = 'label-success';
															break;
														
														case 'DELETED':
															echo "<td>".strtoupper($row->deleted_by)."</td>";
															$label_type = 'label-danger';
															break;

														default:
															echo "<td>".strtoupper($row->created_by)."</td>";
															$label_type = 'label-primary';
															break;
													}
													
													echo "<td style='text-align: center;'><span class='label label-sm $label_type'>$status</span></td>";
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
	$('#tmon_con').dataTable();
	
	$('#dash_outstanding').on('click', function(){
		window.location.href = "<?php echo site_url('sales-contract/monitor')?>";
	});
	$('#dash_completed').on('click', function(){
		window.location.href = "<?php echo site_url('sales-contract/monitor/completed')?>";
	});
	$('#dash_deleted').on('click', function(){
		window.location.href = "<?php echo site_url('sales-contract/monitor/deleted')?>";
	});
</script>