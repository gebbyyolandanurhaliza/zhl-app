
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Customer Group</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('master/create_master/group_customer'), '<i class="fa fa-plus"></i> Create New Customer Group', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
						<table id="tblmst_customer_group" class="table table-bordered table-striped table-condensed">
							<thead>
								<tr>
									<th scope="col" width="70px" class="text-center">#</th>
									<th scope="col" width="50px" class="text-center">ID</th>
									<th scope="col" class="text-center">Name</th>									
									<th scope="col" width="100px" class="text-center">COA</th>
									<th scope="col" width="100px" class="text-center">Created By</th>
									<th scope="col" width="120px" class="text-center">Created Date</th>
									<th scope="col" width="100px" class="text-center">Updated By</th>
									<th scope="col" width="120px" class="text-center">Updated Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($group_customer_data as $master)
								{
								?>
									<tr>
										<td style="text-align:center" width="70px">
										<?php  
											echo anchor(site_url('master/delete_master/group_customer/'.$master->customer_group_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-xs red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->customer_group_name.'?\')"'); 
											echo anchor(site_url('master/edit_master/group_customer/'.$master->customer_group_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-xs green-stripe"'); 
										?>
										</td>
										<td class="w-50 text-center"><?php echo $master->customer_group_id ?></td>
										<td><?php echo $master->customer_group_name ?></td>
										<td class="w-100 text-center"><?php echo $master->coa ?></td>
										<td class="w-100"><?php echo $master->created_by ?></td>
										<td class="w-120 text-center"><?php echo $master->created_date ?></td>
										<td class="w-100"><?php echo $master->updated_by ?></td>
										<td class="w-120 text-center"><?php echo $master->updated_date ?></td>
										
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
		$("#tblmst_customer_group").dataTable({
			"sScrollX": "100%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
//			"sScrollY": "500px",
			"autoWidth"	: false
		});
	});
</script>