<table id="tbl_product_head" class="table table-condensed table-hover table-fixed" style="margin-bottom: 2px; width:99%;">
	<thead>
		<tr>
			<th class="w-70" style="width:70px;">#</th>
			<th class="sembunyi">Product ID</th>
			<th style="text-align: left;">Product Description</th>
			<th style="width:220px; text-align: left;">Product Code</th>
			<th style="width:70px;">Factory</th>				
			<th class="sembunyi">Brand ID</th>
			<th class="sembunyi">UOM ID</th>
			<th class="sembunyi">Factory ID</th>
			<th style="width:200px; text-align: left;">Packing</th>
			<th class="sembunyi">Estimated 20ft</th>
			<th class="sembunyi">Estimated 40ft</th>
			<th class="sembunyi">Per Packing</th>
			<th class="sembunyi">Contract Detail ID</th>
			<th class="sembunyi">Contract Price</th>
			<th class="sembunyi">Contract Qty</th>
			<th class="sembunyi">PO Qty</th>
			<th class="sembunyi">Outstanding Qty</th>
			<th class="sembunyi">Contract Brand ID</th>
			<th class="sembunyi">Contract Brand Name</th>
			<th class="sembunyi">Qty Max</th>
			
			<!--<th>Available Container</th>-->
		</tr>
	</thead>
	
</table>
<div class="v-scroll">
	<table id="tbl_product" class="table table-condensed table-hover" style="width:100%;">
		<tbody>
			<?php
			$i = 0;
			if ($record){
				foreach ($record as $r){
					if (isset($contract_hdr_id)){ // jika diambil dr product di contract
						$qty_contract = $this->M_mar_purchase_order->get_qty_contract($contract_hdr_id, $r->contract_dtl_id, $r->product_id);
						$qty_po = $this->M_mar_purchase_order->get_qty_po($contract_hdr_id, $r->contract_dtl_id, $r->product_id);
						if ($qty_contract > 0){
							$outstanding_qty = $qty_contract-$qty_po;
							$quantity = $outstanding_qty;
							$qty_max = "data-v-max='".strval($outstanding_qty)."'";
						} else {
							$outstanding_qty = 0;
							$quantity = 0;
							$qty_max = '';
						}
						
//						if ($qty_contract > 0){
//							if ($act == 'add'){
//								$qty_max = "data-v-max='".strval($qty_contract - $qty_po)."'";
//								$quantity = strval($r->quantity) > strval($qty_contract - $qty_po) ? strval($qty_contract - $qty_po) : $r->quantity - $r->po_qty;
//							} else {
//								$qty_max = "data-v-max='".strval($outstanding_qty)."'";
//								$quantity = $r->quantity;
//								$outstanding_qty = $outstanding_qty;
//							}
//						} else {
//							$qty_max = '';
//							$quantity = 0;
//						}
					} else {
						$outstanding_qty = 0;
						$quantity		 = (isset($r->po_qty) ? $r->po_qty : 0);
						$qty_max = '';
						if (isset($r->contract_dtl_id)){
							if ($r->quantity > 0){
								$outstanding_qty = $r->quantity - $r->po_qty;
							}
						}						
					}
					
					$i++;
					echo '<tr>';
					//idx = 0
					echo '<td class="text-center" style="width:70px;">';
					echo '<input type="checkbox" name="chk[]" >';
					echo '</td>';
					//idx = 1
					echo '<td class="id sembunyi">'.$r->product_id.'</td>';
					//idx = 2
					echo '<td class="nama">'.$r->product_name.'</td>';
					//idx = 3
					echo '<td class="code" style="width:220px; text-align: left;">'.$r->product_code.'</td>';
					//idx = 4
					echo '<td class="factory text-center" style="width:70px;">'.$r->factory_abbr.'</td>';
					//idx = 5
					echo '<td class="brand sembunyi">'.$r->brand_name.'</td>';
					//idx = 6
					echo '<td class="uom sembunyi">'.$r->cma_uom_quantity_id.'</td>';	
					//idx = 7
					echo '<td class="factory sembunyi">'.$r->factory_id.'</td>';
					//idx = 8
					if (isset($r->packing_view)){
						if ($r->packing_view){
							$pack_size = $r->packing_view;
						} else {
							$pack_size = floatval($r->uom_volume).' '.$r->uom_volume_name.' x '.floatval($r->per_packing).' '.$r->packing_size.' per '.$r->cma_uom_quantity_id;
						}
					} else {
						if (isset($r->detail_pack_size)){
							if ($r->detail_pack_size){
								$pack_size = $r->detail_pack_size;
							} else {
								$pack_size = floatval($r->uom_volume).' '.$r->uom_volume_name.' x '.floatval($r->per_packing).' '.$r->packing_size.' per '.$r->cma_uom_quantity_id;
							}
						}
					}
					echo '<td class="packing" style="width:200px;">'.$pack_size.'</td>';
					//idx = 9
					echo '<td class="container_20ft sembunyi">'.number_format($r->container_20ft,0).'</td>';
					//idx = 10
					echo '<td class="container_40ft sembunyi">'.number_format($r->container_40ft,0).'</td>';
					//idx = 11
					echo '<td class="per_packing sembunyi">'.$r->per_packing.'</td>';
					//idx = 12
					echo '<td class="contract_dtl_id sembunyi">'.(isset($r->contract_dtl_id) ? $r->contract_dtl_id : 0).'</td>';
					//idx = 13
					echo '<td class="contract_price sembunyi">'.(isset($r->price) ? $r->price : 0).'</td>';
					//idx = 14
					echo '<td class="contract_qty sembunyi">'.(isset($r->quantity) ? number_format($r->quantity,0) : 0).'</td>';
					//idx = 15
					echo '<td class="po_qty">'.$quantity.'</td>';
//					echo '<td class="po_qty">'.(isset($r->po_qty) ? $r->po_qty : 0).'</td>';
					//idx = 16					
					echo '<td class="outstanding_qty sembunyi">'.number_format($outstanding_qty,0).'</td>';
					//idx = 17
					echo '<td class="brand_id sembunyi">'.(isset($r->brand_id) ? $r->brand_id : 0).'</td>';
					//idx = 18
					echo '<td class="brand_name sembunyi">'.(isset($r->brand_name) ? $r->brand_name : '').'</td>';
					//idx = 19
					echo '<td class="qty_max sembunyi">'.$qty_max.'</td>';
					echo '</tr>';
				}
			} else {
				echo '<tr><td colspan=10 style="text-align: center;">No Data Available</td></tr>';
			}
			?>
		
		</tbody>
	</table>	
</div>

<script>
	$('input:checkbox').uniform();
</script>