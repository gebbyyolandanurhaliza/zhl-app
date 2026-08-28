<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">User's Group</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('User_group/create'), '<i class="fa fa-plus"></i> Create New Group', 'class="btn btn-primary"'); ?>
						</div>
<!--						<div class="tools">							
							<a href="javascript:;" class="collapse"></a>
							<a href="javascript:;" class="reload"></a>
						</div>-->
					</div>

					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped" id="mytable">
							<thead>
								<tr>
									<th class="center" width="80px">No</th>
									<th>User's Group ID</th>
									<th>User's Group Name</th>
									<th>User's Group Remark</th>
									<th>Created By</th>
									<th>Created Date</th>
									<th>Updated By</th>
									<th>Updated Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$start = 0;
								foreach ($user_group_data as $ugd)
								{
							?>
								<tr>
									<td class="center"><?php echo ++$start ?></td>
									<td><?php echo $ugd->user_group_id ?></td>
									<td><?php echo $ugd->user_group_name ?></td>
									<td><?php echo $ugd->user_group_remark ?></td>
									<td><?php echo $ugd->created_by ?></td>
									<td><?php echo $ugd->created_date ?></td>
									<td><?php echo $ugd->updated_by ?></td>
									<td><?php echo $ugd->updated_date ?></td>
									<td style="text-align:center" width="150px">
									<?php 
									echo anchor(site_url('User_group/access/'.$ugd->user_group_id),'Access'); 
									echo ' | '; 
									echo anchor(site_url('User_group/edit/'.$ugd->user_group_id),'Edit'); 
									echo ' | '; 
									echo anchor(site_url('User_group/delete/'.$ugd->user_group_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure Want To Delete '.$ugd->user_group_name.' ?\')"'); 
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
		$("#mytable").dataTable();
	});
</script>