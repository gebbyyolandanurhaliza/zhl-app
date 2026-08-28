<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php //echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Stock Container</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('Shipping/container_stock_create'), '<i class="fa fa-plus"></i> Create New Stock', 'class="btn btn-primary"'); ?>
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
								<th class="center" width="80px">Container Number</th>
								<th>Container ID</th>
								<th>Loading Port</th>
								<th>Arrival Date</th>
								<th>Free Time</th>
								<th>Remark</th>
								<th>Action</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$start = 0;
								foreach ($container_number as $country)
								{
							?>
								<tr>
									<td class="center"><?php echo ++$start ?></td>
									<td><?php echo $country->container_number ?></td>
									<td><?php echo $country->container_id ?></td>
									<td><?php echo $country->loading_port ?></td>
									<td><?php echo $country->free_time ?></td>
									<td><?php echo $country->arrival_date ?></td>
									<td><?php echo $country->Remark ?></td>
									<td style="text-align:center" width="100px">
									<?php 
									echo anchor(site_url('Shipping/edit_container_stock/'.$country->stock_id),'Edit'); 
									echo ' | '; 
									echo anchor(site_url('Shipping/delete_container_stock/container_stock/'.$country->stock_id),'Delete','onclick="javasciprt: return confirm(\'Are You Sure ?\')"'); 
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