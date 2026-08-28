<table class="table table-bordered table-striped" id="mytable">
	<thead>
		<tr>
		<th>Action</th>
		<th class="center" width="80px">No</th>
		<th>Stock Status</th>
		<th class="center" width="80px">Container Number</th>
		<th>Container Type</th>
		<th>Remark</th>
		<th>Loading Port</th>
		<th>Arrival Date</th>
		<th>Free Time</th>
		<th>Factory</th>
		<th>Supplier</th>
		<th>Import BL NO</th>
		<th>ETA PSG/RSUP</th>
		<th>Free Time Expiry Date</th>
		</tr>
	</thead>
	<tbody>
		<?php
				$start = 0;
				foreach ($shipping_liner as $country)
				{
			?>
				<tr>

					<?php if($country->status_note=='0'){?> 
					<td style="text-align:center" width="100px">
                                    <a class="btn-sm btn-warning" href="<?php echo site_url('shipping/container_stock_edit?stock='.$country->stock_id_hdr); ?>"><i class="fa fa-pencil"></i></a>
                                    <a class="btn-sm btn-danger" href="<?php echo site_url('shipping/container_stock_delete?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure delete Container <?php echo $country->container_number; ?> ?')"><i class="fa fa-trash"></i></a>
					</td>
					<?php
					}else{?>
					<td style="text-align:center" width="100px">                                   
									<a class="btn-sm btn green" href="<?php echo site_url('shipping/container_stock_reuse?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure Re-Use Container <?php echo $country->container_number; ?> ?')"><i class="fa fa-refresh"></i></a>
									<a class="btn-sm btn-green" href="<?php echo site_url('shipping/container_stock_edit_block?stock='.$country->stock_id_hdr); ?>"><i class="fa fa-eye"></i></a>
					</td>
					<?php } ?>
					<td class="center"><?php echo ++$start ?></td>
					<td align="center"><?php 
					if($country->status_note=='0'){
						echo "<b style='color : red;'>Stock Ready</b>";
					}elseif($country->status_note=='1'){
						echo "<b style='color : red;'>Stock Has Been Used</b>";
					}elseif($country->status_note=='2'){
						echo "<b style='color : green;'>Return To Singapore</b>";
					}elseif ($country->status_note=='3') {
						echo "<b style='color : blue;'>Transfer from Stock Container</b>";
					}
					?></td>
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
					<td><?php echo $country->Remark ?></td>
						<td><?php echo $country->loading_port ?></td>
					<td><?php echo $country->arrival_date ?></td>
					<td><?php echo $country->free_time ?></td>
					<td><?php 
					if($country->factory=='RSUP'){
						echo "Riau Sakti Unites Plantations";
					}elseif($country->factory=='PSG'){
						echo "Pulau Sambu Guntung";
					}else{
						echo "Insert Factory...!!!";
					}
					?></td>
					<td><?php echo $country->supplier ?></td>
					<td><?php echo $country->import_bl_no ?></td>
					<td><?php echo $country->eta ?></td>
					<td><?php echo $country->free_time_expiry ?></td>
					</tr>
			<?php
				}
			?>
	</tbody>
</table>
		
<script type="text/javascript">
	$(document).ready(function () {
		$("#mytable").dataTable();
	});
</script>