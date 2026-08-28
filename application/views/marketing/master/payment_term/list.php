
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Payment Term</span>
						</div>
						<div class="actions">
							<?php
							if ($position_id){
								if ($position_id == 1 || $position == 7){
									echo anchor(site_url('marketing/create_master/payment_term'), '<i class="fa fa-plus"></i> Create New Payment Term', 'class="btn btn-primary"'); 
								}
							}
							?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
						<table id="tblmst_payment_term" class="table table-bordered table-striped table-condensed">
							<thead>
								<tr>
									<th scope="col" width="30px" class="text-center">#</th>
									<th scope="col" width="450px" class="text-center">Payment Term</th>
									<th scope="col" width="100px" class="text-center">Created By</th>
									<th scope="col" width="100px" class="text-center">Created Date</th>
									<th scope="col" class="text-center">Updated By</th>
									<th scope="col" class="text-center">Updated Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($master_data as $master)
								{
								?>
									<tr>
										<td style="text-align:center" width="100px">
										<?php  
											echo anchor(site_url('marketing/delete_master/payment_term/'.$master->payment_term_id),'<i class="fa fa-trash-o"></i>',' class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->payment_term.'?\')"'); 
											echo anchor(site_url('marketing/edit_master/payment_term/'.$master->payment_term_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe" title="deactive"'); 
										?>
										</td>										
										<td><?php echo $master->payment_term ?></td>										
										<td><?php echo $master->created_by ?></td>
										<td class="text-center"><?php echo $master->created_date ?></td>
										<td><?php echo $master->updated_by ?></td>
										<td class="text-center"><?php echo $master->updated_date ?></td>
										
									</tr>
								<?php
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

<script type="text/javascript">
	$(document).ready(function () {
		$("#tblmst_payment_term").dataTable({
			"sScrollX": "100%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
//			"sScrollY": "500px",
			"autoWidth"	: false
		});
	});
</script>