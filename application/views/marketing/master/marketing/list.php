
<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Master Marketing</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('marketing/create_master/marketing'), '<i class="fa fa-plus"></i> Create New Marketing', 'class="btn btn-primary"'); ?>
						</div>
<!--						<div class="tools">							
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="reload"></a>
						</div>-->
					</div>

					<div class="portlet-body flip-scroll">
						<table id="tblmst_marketing" class="table table-bordered table-striped table-condensed flip-content">
							<thead class="flip-content">
								<tr>
									<th width="80px">No</th>
									<th class="text-center">Code</th>
									<th class="text-center">Name</th>									
									<th class="text-center">Cma</th>
									<th class="text-center">Country</th>
									<th class="text-center">Address</th>
									<th class="text-center">Phone</th>
									<th class="text-center">Fax</th>
									<th class="text-center">Email</th>
									<th class="text-center">Created By</th>
									<th class="text-center">Created Date</th>
									<th class="text-center">Updated By</th>
									<th class="text-center">Updated Date</th>
									<th colspan="2" class="text-center">Actions</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$start = 0;
								foreach ($master_data as $master)
								{
								?>
									<tr>
									<td><?php echo ++$start ?></td>
									<td><?php echo $master->marketing_code ?></td>
									<td><?php echo $master->marketing_name ?></td>
									<td><?php echo $master->marketing_cma ?></td>
									<td><?php echo $master->marketing_country ?></td>
									<td><?php echo $master->marketing_address ?></td>
									<td><?php echo $master->marketing_phone ?></td>
									<td><?php echo $master->marketing_fax ?></td>
									<td><?php echo $master->marketing_email ?></td>
									<td><?php echo $master->created_by ?></td>
									<td><?php echo $master->created_date ?></td>
									<td><?php echo $master->updated_by ?></td>
									<td><?php echo $master->updated_date ?></td>
									<td style="text-align:center" width="100px">
								<?php 
									echo anchor(site_url('marketing/edit_master/marketing/'.$master->marketing_id),'Edit'); 
									echo ' | '; 
									echo anchor(site_url('marketing/delete_master/marketing/'.$master->marketing_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure Delete Data '.$master->marketing_code.'?\')"'); 
								?>
									</td>
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
		$("#tblmst_marketing").dataTable();
	});
</script>