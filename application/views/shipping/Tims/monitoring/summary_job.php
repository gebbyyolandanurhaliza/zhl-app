
<div class="page-content">
	<div class="container-fluid">
		<div class="row">
			
			<div class="col-md-12">
				
				<?php 
				echo $message;
				echo form_open(site_url('Tims_mon/batch_print'), 'target="_blank" method="post" class="form-horizontal"');
				?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Monitoring Summary Job</span>
						</div>
						<div class="tools">
							<a href="javascript:;" class="collapse">
							</a>
							<a href="javascript:;" class="reload">
							</a>
							<a href="javascript:;" class="fullscreen"></a>
						</div>
					</div>
					
					<div class="portlet-body form">
						
						<div class="form-body row">
							<div class="col-md-12">
								
								<div class="panel panel-default">
									<div class="panel-heading">
										<h5 class="panel-title"><i class='fa fa-filter'></i> Filter Summary Job</h5>
									</div>
									<div class="panel-body">
									

										<div class="form-group">
											<label class="col-md-2 control-label" for="varchar">Current Date</label>
											<div class="col-md-4">
												<div class="input-group date-picker input-daterange" data-date="<?php echo $current_date ?>" data-date-format="dd/mm/yyyy">
													<input type="text" class="form-control" id="schedule_date1" name="schedule_date1" value="<?php echo $ship_date1 ?>" title="date format : dd/mm/yyyy">
													<span class="input-group-addon" style="background: transparent; border-color: transparent">to</span>
													<input type="text" class="form-control" id="schedule_date2" name="schedule_date2" value="<?php echo $ship_date2; ?>" title="date format : dd/mm/yyyy">
												</div>
											</div>
										</div>
                                      
									</div>
									<div class="panel-footer">
										<input type="button" id="btn_filter" class="btn blue fontawesome-font" value="&#xf0b0 Filter ">
										
									</div>
								</div>
								
							</div>
						</div>
						
						<div class="flip-scroll">
							<!--<div class="col-md-12">-->
							<table class="table" style="margin-bottom: 1px;">

								<thead>
									<tr>

                                        <th style="width: 200px; text-align: center;">Current Date</th>
										<th style="width: 150px; text-align: left;">Vehicle No/th</th>
										<th style="width: 150px; text-align: left;">Driver Name</th>
										<th style="width: 150px; text-align: left;">Job</th>
										<th style="width: 100px; text-align: left;">Clients</th>
										<th style="width: 100px; text-align: center;">Time</th>
                                        <th style="width: 100px; text-align: center;">Send To</th>
                                        <th style="width: 100px; text-align: center;">Chasis</th>
										<th  style="width: 100px; left;">Status</th>
                                             
									</tr>
								</thead>
							</table>
							<div class="doc-scroll" style="height: 350px;">
								<div id="filtered_table" class="table-scrollable-borderless">
									<table id="tblmon_job" class="table table-condensed table-striped">

										<tbody>
											<?php
											
											?>
										</tbody>
									</table>
								</div>
							</div>
							<!--</div>-->
						</div>
						
					</div><!--/.portlet_body -->
					
					<div class="form-actions">
						<div class="row">
							<div class="col-md-1">
								<button class="btn btn-warning" id="btn_print" type="submit"><i class="fa fa-print"></i> Print Selected...</button>
							</div>
						
							

						</div>
					</div>
					
				</div>
				
				<?php echo form_close() ?>
			</div>
		</div>
	</div>
</div>

 <script>
	// $('#tblmon_job').dataTable();
	$('#btn_filter').on('click', function(){
           
	
		var schdate1	= $('#schedule_date1').val();
		var schdate2	= $('#schedule_date2').val();

		sambu.startPageLoading();
		
		window.setTimeout(function() {
			sambu.stopPageLoading();
		}, 2000);
		
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('Tims_mon/mon_summary_job_filter')?>",
			data: {
			
				schedule_date1	: schdate1,
				schedule_date2	: schdate2,
             
			},
			success: function(msg){
				$('#filtered_table').html(msg);
			}
		})
	});

</script> 
