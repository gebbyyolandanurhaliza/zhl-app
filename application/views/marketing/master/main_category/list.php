
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font uppercase">Master Main Category</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing/create_master/main_category'), '<i class="fa fa-plus"></i> Create New Main Category', 'class="btn btn-primary"'); ?>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<table id="tblmst_main_category" class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content">
								<tr>
									<th width="75px">#</th>
									<th class="text-center">ID</th>
									<th class="text-center">Name</th>
									<th class="text-center">Created By</th>
									<th class="text-center">Created Date</th>
									<th class="text-center">Updated By</th>
									<th class="text-center">Updated Date</th>
									
								</tr>
							</thead>
							<tbody>
								<?php
								foreach ($master_data as $master)
								{
								?>
									<tr>
										<td style="text-align:center" width="75px">
										<?php 
											echo anchor(site_url('marketing/delete_master/main_category/'.$master->main_category_id),'<i class="fa fa-trash-o"></i>','class="btn default btn-sm red-stripe" onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->main_category_name.'?\')"'); 
											echo anchor(site_url('marketing/edit_master/main_category/'.$master->main_category_id),'<i class="fa fa-edit"></i>', 'class="btn default btn-sm green-stripe"');
										?>
										</td>
										<td><?php echo $master->main_category_id ?></td>
										<td><?php echo $master->main_category_name ?></td>
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

<script type="text/javascript">
	$(document).ready(function () {
		$("#tblmst_main_category").dataTable();
	});
</script>