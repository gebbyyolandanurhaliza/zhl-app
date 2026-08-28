
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Factory</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing/create_master/factory'), '<i class="fa fa-plus"></i> Create New Factory', 'class="btn btn-primary"'); ?>
						</div>
<!--						<div class="tools">							
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="reload"></a>
						</div>-->
					</div>

					<div class="portlet-body flip-scroll">
						<div class="table-scrollable-borderless">
						<table id="tblmst_factory" class="table table-bordered table-striped table-condensed">
							<thead>
								<tr>
									<th scope="col" class="text-center w-85">#</th>
									<th scope="col" class="text-center">Name</th>									
									<th scope="col" class="text-center w-50">Abbreviation</th>
									<th scope="col" class="text-center w-80">Location</th>
									<th scope="col" class="text-center w-150">Address</th>
									<th scope="col" class="text-center w-70">Phone</th>
									<th scope="col" class="text-center w-70">Fax</th>
									<th scope="col" class="text-center w-100">Created By</th>
									<th scope="col" class="text-center w-100">Created Date</th>
									<th scope="col" class="text-center w-100">Updated By</th>
									<th scope="col" class="text-center w-100">Updated Date</th>
								</tr>
							</thead>
							<tbody>
								<?php
								
								foreach ($master_data as $master)
								{
								?>
									<tr>
										<td style="text-align:center" width="85px">
										<?php 
											echo anchor(site_url('marketing/delete_master/factory/'.$master->factory_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->factory_name.'?\')"'); 
											echo anchor(site_url('marketing/edit_master/factory/'.$master->factory_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"'); 
										?>
										</td>
										<td><?php echo $master->factory_name ?></td>
										<td class="text-center"><?php echo $master->factory_abbr ?></td>
										<td class="text-center"><?php echo $master->factory_location ?></td>
										<td><?php echo $master->factory_address ?></td>
										<td class="text-center"><?php echo $master->factory_phone ?></td>
										<td class="text-center"><?php echo $master->factory_fax ?></td>
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
		$("#tblmst_factory").dataTable({
			"sScrollX": "120%", //This is what made my columns increase in size.
			"bScrollCollapse": true,
//			"sScrollY": "500px",
			"autoWidth"	: false
		});
	});
</script>