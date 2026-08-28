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
								<th>Container Type</th>
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
									<td><?php  
									if ($country->container_id=='1'){
										echo "20ft Standard Container (s)";
									}elseif ($country->container_id=='2') {
										echo "20ft Reefer Container (s)";
									}elseif ($country->container_id=='3') {
										echo "40ft Standard Container (s)";
									}elseif ($country->container_id=='4') {
										echo "40ft High Cube Container (s)";
									}elseif ($country->container_id=='5') {
										echo "40ft Reefer Container (s)";
									}elseif ($country->container_id=='6') {
										echo "Loose Cargo";
									}elseif ($country->container_id=='7') {
										echo "40ft High Cube Reefer Container (s)";
									}elseif ($country->container_id=='8') {
										echo "See Remarks";
									}else{
										echo "Bulk shipment";
									}
									?></td>
									<td><?php echo $country->loading_port ?></td>
									<td><?php echo $country->free_time ?></td>
									<td><?php echo $country->arrival_date ?></td>
									<td><?php echo $country->Remark ?></td>
									<td style="text-align:center" width="100px">
                                                    <a class="btn-sm btn-warning" href="<?php echo site_url('shipping/container_stock_edit?stock='.$country->stock_id); ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn-sm btn-danger" href="<?php echo site_url('shipping/container_stock_delete?stock='.$country->stock_id); ?>" onclick="javasciprt: return confirm('Are you sure delete  <?php echo $country->container_number; ?> ?')"><i class="fa fa-trash"></i></a>
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