
<div class="page-content">
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
								
				<?php echo $message;?>
				
				<div class="portlet light">
					
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Agent</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing/create_master/agent'), '<i class="fa fa-plus"></i> Create New Agent', 'class="btn btn-primary"'); ?>
						</div>
					</div>
					
					<div class="portlet-body flip-scroll">
						<div class="search_result"> <!-- Hasil pencarian tampilkan disini -->
							<div class="table-scrollable-borderless">
								<table id="tblmst_agent" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th width="30px">#</th>
											<th scope="col" class="text-center">Name</th>
											<th scope="col" class="text-center">Address</th>
											<th scope="col" class="text-center">Country</th>
											<th scope="col" class="text-center">Phone</th>
											<th scope="col" class="text-center">Fax</th>
											<th scope="col" class="text-center">Email</th>
											<th scope="col" class="text-center">Customer</th>
 											<th scope="col" class="text-center">Contact Name</th>
											<th scope="col" class="text-center">Contact Phone</th>
											<th scope="col" class="text-center">Contact Email</th>
											<th scope="col" class="text-center">Created By</th>
											<th scope="col" class="text-center">Created Date</th>
											<th scope="col" class="text-center">Updated By</th>
											<th scope="col" class="text-center">Updated Date</th>
										</tr>
									</thead>
									<tbody>
										<?php
										
										foreach ($master_data as $master){
										?>
											<tr>
												<td style="text-align:center" width="100px">
												<?php 
													echo anchor(site_url('marketing/delete_master/agent/'.$master->agent_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->agent_name.'?\')"'); 
													echo anchor(site_url('marketing/edit_master/agent/'.$master->agent_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"'); 
												?>												
												</td>
												<td><?php echo $master->agent_name ?></td>
												<td><?php echo $master->agent_address ?></td>
												<td><?php echo $master->agent_country ?></td>
												<td><?php echo $master->agent_phone ?></td>
												<td><?php echo $master->agent_fax ?></td>
												<td><?php echo $master->agent_email ?></td>
												<td><?php echo $master->customer_name ?></td>
												<td><?php echo $master->agent_contact_name ?></td>
												<td><?php echo $master->agent_contact_phone ?></td>
												<td><?php echo $master->agent_contact_email ?></td>
												<td><?php echo $master->created_by ?></td>
												<td><?php echo $master->created_date ?></td>
												<td><?php echo $master->updated_by ?></td>
												<td><?php echo $master->updated_date ?></td>
												
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
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$("#tblmst_agent").dataTable({
			"sScrollX": "200%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
//			"sScrollY": "500px",
			"autoWidth"	: false
		});
	});
</script>