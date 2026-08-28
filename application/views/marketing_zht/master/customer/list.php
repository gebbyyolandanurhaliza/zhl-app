
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Customer</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing_zht/create_master/customer'), '<i class="fa fa-plus"></i> Create New Customer', 'class="btn btn-primary"'); ?>
						</div>
					</div>
					
					<div class="portlet-body flip-scroll">
						<div class="col-md-12">
							<!-- search form here -->
						</div>						
						
						<div class="search_result"> <!-- Hasil pencarian tampilkan disini -->
							<div class="table-scrollable-borderless">
								<table id="tblmst_customer" class="table table-bordered table-striped table-condensed">
									<thead>
										<tr>
											<th width="30px">#</th>
											<th scope="col" class="text-center">Code</th>
											<th scope="col" class="text-center">Name</th>									
											<th scope="col" class="text-center">Company Name</th>
											<th scope="col" class="text-center">Country</th>
											<th scope="col" class="text-center">Reference No.</th>
											<th scope="col" class="text-center">Contract Number</th>
											<th scope="col" class="text-center">Address</th>
											<th scope="col" class="text-center">Phone</th>
											<th scope="col" class="text-center">Fax</th>
											<th scope="col" class="text-center">Email</th>
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
													echo anchor(site_url('marketing_zht/delete_master/customer/'.$master->customer_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->customer_name.'?\')"'); 
													echo anchor(site_url('marketing_zht/edit_master/customer/'.$master->customer_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"'); 
												?>												
												</td>
												<td><?php echo $master->customer_code ?></td>
												<td><?php echo $master->customer_name ?></td>
												<td><?php echo $master->customer_company_name ?></td>
												<td><?php echo $master->customer_country ?></td>
												<td><?php echo $master->customer_reference ?></td>
												<td><?php echo $master->customer_contract_no ?></td>
												<td><?php echo $master->customer_address ?></td>
												<td><?php echo $master->customer_phone ?></td>
												<td><?php echo $master->customer_fax ?></td>
												<td><?php echo $master->customer_email ?></td>
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
		$("#tblmst_customer").dataTable({
			"sScrollX": "200%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
//			"sScrollY": "500px",
			"autoWidth"	: false
		});
	});
</script>