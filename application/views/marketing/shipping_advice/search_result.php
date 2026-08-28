<style type="text/css">		
	.sembunyi{
		display: none;
	}
</style>
<div class="table-scrollable">
	<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_sa">
		<thead>
			<tr class="double-border-bottom">
				<th class="w-100">PO No.</th>
				<th class="w-100">Buyer Ref</th>
				<th class="w-100">Vessel / Voyage</th>
				<th class="w-100">ETD</th>
				<th class="w-100">ETA</th>
				<th class="w-150">Port</th>
				<th class="w-300">Product</th>
				<th class="w-50">20'</th>
				<th class="w-50">40'</th>
				<th class="w-50">CT</th>
				<th class="w-100">Container No.</th>
				<th class="w-100">Seal No.</th>
			</tr>
		</thead>
		<tbody>
			
				<?php
				if ($record){
					foreach ($record as $r) {
						?>
				<tr>
					<td class="sembunyi">
						<input type="hidden" name="condtlid[]" id="condtlid" value="<?php echo $r->condtlid;?>">
						<input type="hidden" name="shipid[]" id="shipid" value="<?php echo $r->shipid;?>">
					</td>

					<td>
						<?php echo $r->po_number;?>
					</td>

					<td>
						<?php echo $r->buyer_si;?>
					</td>

					<td>
						<?php echo $r->vessel;?>
					</td>

					<td>
						<?php echo $r->etdsin;?>
					</td>
					
					<td>
						<?php echo $r->etasin;?>
					</td>
					
					<td>
						<?php echo $r->port_name.', '.$r->destination_country; ?>
					</td>
					
					<td>
						<?php echo $r->total_qty_po.' '.$r->uom.' x '.$r->detail_product_name;?>
					</td>
					
					<td>
						<?php echo $r->total_fcl; ?>
					</td>
					
					<td>
						<?php echo $r->total_fcl; ?>
					</td>
					
					<td>
						<?php echo $r->container_abbr; ?>
					</td>
					
					<td>
						<?php echo $r->container; ?>
					</td>
					
					<td>
						<?php echo $r->seal; ?>
					</td>
				</tr>

				<?php
					}
				} else {
					"<tr><td colspan = '12'>No data available</td></tr>";
				}
				?>
			
		</tbody>
	</table>

</div>
