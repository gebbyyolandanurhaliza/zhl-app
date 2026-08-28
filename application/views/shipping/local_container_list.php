<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
				
				<?php //echo $message;?>
				
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Local Container List</span>
						</div>
						<div class="actions">
							<?php echo anchor(site_url('Shipping/container_local_create'), '<i class="fa fa-plus"></i> Create New Local Container', 'class="btn btn-primary"'); ?>
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
								<th class="center">No</th>
								<th class="center" width="15px">Action</th>
<!-- 								<th>Stock Status</th> -->
								<th class="center" width="80px">Type</th>
								<th class="center" width="80px">Barge</th>
								<th>Voyage</th>
								<th>ETD</th>
								<th>ETD Date</th>
								<th>ETA</th>
								<th>ETA Date</th>
								<th>Shipment Date</th>
								<th>From</th>
								<th>To</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$start = 0;
								foreach ($container_number as $country)
								{
							?>
								<tr>
									<td align="center"><?php echo ++$start ?></td>
									<td style="text-align:left" width="50px">
                                                    <a class="btn-sm btn-warning" href="<?php echo site_url('shipping/container_local_edit?stock='.$country->contid); ?>"><i class="fa fa-pencil"></i></a>
                                              <?php if ($country->jumlah_jurnal == '0' || $country->jumlah_jurnal == ''){?>
                                                     <a class="btn-sm btn-danger" href="<?php echo site_url('shipping/container_local_delete?stock='.$country->contid); ?>" onclick="javasciprt: return confirm('Are you sure delete Local Container Shipment Date <?php echo $country->shipmentdate; ?> ?')"><i class="fa fa-trash"></i></a>
                                              <?php } ?>
									</td>
									<?php
									if($country->tipe === '3'){
										$ikk = 'Local Container';
									}elseif($country->tipe === '4'){
										$ikk = 'Local Empty';
									}elseif($country->tipe === '5'){
										$ikk = 'Local Laden';
									}elseif($country->tipe === '6'){
										$ikk = 'Import Return';
									}else{
										$ikk = 'Loose Cargo';
									}
									?>
									<td><?php echo $ikk ?></td>
									<td><?php echo $country->barge ?></td>
									<td><?php echo $country->voyage ?></td>
									<td><?php echo $country->etd ?></td>
 									<td><?php echo date('d-m-Y', strtotime($country->etddate)) ?></td>
									<td><?php echo $country->eta ?></td>
									<td><?php echo date('d-m-Y', strtotime($country->etadate)) ?></td>
									<td><?php echo date('d-m-Y', strtotime($country->shipmentdate)) ?></td>
									<td><?php echo $country->from ?></td>
									<td><?php echo $country->to ?></td>
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