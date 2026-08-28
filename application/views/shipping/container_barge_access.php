<div class="page-content">
	
	<div class="container-fluid">
		<div class="row ">
			<div class="col-md-12">
								
				<div class="portlet light">
					<div class="portlet-title">
						<div class="caption">
							<i class="fa fa-table theme-font"></i>
							<span class="caption-subject theme-font bold uppercase">Container (Barge Access)</span>
						</div>
					</div>

					<div class="portlet-body flip-scroll">
						<table class="table table-bordered table-striped" id="mytable">
							<thead>
                                    <tr>
                                        <th>Action</th>
                                        <th>No</th>
                                        <th>Shipment Date</th>
                                        <th>Vessel (Barge)</th>
                                        <th>Voyage</th>
                                        <th>ETD</th>
                                        <th>ETD Date</th>
                                        <th>ETA</th>
                                        <th>ETA Date</th>
                                        <th>From</th>
                                        <th>To</th>
                                        <th>Created By</th>
                                        <th>Created Date</th>
                                        <th>LastUpdated By</th>
                                        <th>LastUpdated Date</th>
                                    </tr>
							</thead>
							<tbody class="tbl-pete" id="tbl-pete">
								<?php
								$start = 0;
								foreach ($container_inward as $country)
								{
								?>

								<tr>
									<td style="text-align:center" width="100px">
                                     <a class="btn-sm btn-warning" href="<?php echo site_url('shipping/container_shipper_show?cont='.$country->contid); ?>"><i class="fa fa-pencil"></i></a>
									</td>
									<td class="center"><?php echo ++$start ?></td>
									<td><?php echo $country->shipmentdate ?></td>
									<td align="center"><?php echo $country->barge?></td>
									<td><?php echo $country->voyage ?></td>
									<td><?php echo $country->etd ?></td>
									<td><?php echo $country->etadate ?></td>
 									<td><?php echo $country->eta ?></td>
									<td><?php echo $country->etadate ?></td>
									<td><?php echo $country->from ?></td>
									<td><?php echo $country->to ?></td>
									<td><?php echo $country->createdby ?></td>
									<td><?php echo $country->createddate ?></td>
									<td><?php echo $country->lastupdatedby ?></td>
									<td><?php echo $country->lastupdateddate ?></td>
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