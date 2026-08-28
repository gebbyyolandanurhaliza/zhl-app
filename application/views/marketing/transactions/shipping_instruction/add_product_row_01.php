<?php
	if ($product_dtl){
		$i = $no;
		foreach($product_dtl as $pd){
			$i++;
			echo "<tr id='$pd->po_hdr_id'>";

			echo "<td class='text-center' style='width:50px;vertical-align: middle;'><span class='num'>$i</span></td>";

			echo "<td style='width: 18%;' class='sembunyi'>";
			echo form_hidden('ship_product_id[]',0);
			echo form_hidden('po_dtl_id[]',encode_str($pd->po_dtl_id));
			echo form_hidden('product_id[]', encode_str($pd->product_id));
			echo "<input type='text' value='$pd->product_view' title='$pd->product_view' class='form-control input-xs input-table' readonly='readonly' />";
			echo "</td>";

			echo "<td class='bg-editable'>";
			echo "<input type='text' name='product_name[]' value='$pd->product_name' title='$pd->product_name' class='form-control input-xs input-table' />";
			echo "</td>";

			echo "<td style='width:12%;'>";
			echo "<input type='text' value='$pd->brand_name' title='$pd->brand_name' class='form-control input-xs input-table text-center' readonly='readonly' />";
			echo "</td>";

			if ($pd->detail_pack_size){
				$pack_size = $pd->detail_pack_size;
			} else {
				$pack_size = number_format($pd->uom_volume,0,'.',',')." ". $pd->uom_volume_name." per ".$pd->cma_uom_quantity_id;
			}

			echo "<td class='bg-editable' style='width: 12%;'>";
			echo "<input name='detail_pack_size[]' value='$pack_size' title='$pack_size' type='text' class='form-control input-xs input-table text-right' />";
			echo "</td>";
			
			if (isset($pd->detail_palletized)){
				$checked = ($pd->detail_palletized == 1 ? true : false);
			} else {
				$checked = false;
			}

			echo "<td class='bg-editable text-center' style='width: 5%;'>";
			echo form_checkbox("detail_palletized[$pd->po_dtl_id]", $pd->po_dtl_id, $checked);
			echo "</td>";

			$pallet_qty = isset($pd->pallet_qty) ? $pd->pallet_qty : 0;

			echo "<td class='bg-editable' style='width: 9%;'>";
			echo "<input type='text' value='".number_format($pallet_qty,0,'.',',')."' name='pallet_qty[]' class='form-control input-xs input-table text-right autonum' data-v-min='0'/>";
			echo "</td>";

			echo "<td style='width: 10%;'>";
			echo "<input type='text' value='".number_format($pd->quantity,0,'.',',')." $pd->uom_quantity_name' class='form-control input-xs input-table text-right' readonly='readonly' />";
			echo "</td>";

			echo "<td style='width: 10%;'>";
			echo "<input type='text' value='".number_format($pd->price,2,'.',',')." per $pd->cma_uom_quantity_id' class='form-control input-xs input-table text-right' readonly='readonly' />";
			echo "</td>";

			if ($agent_list){	// jika tidak ada agent maka invoice price defaultnya unit price
				$inv_price = $pd->price;
			} else {
				if ($ship_id > 0){
					$inv_price = $pd->invoice_price;
				} else {
					$inv_price = $pd->price;
				}
			}

			echo "<td class='bg-editable' style='width: 10%;'>";
			echo "<input name='invoice_price[]' value='$inv_price' type='text' class='form-control input-xs input-table text-right autonum_inv' data-v-min='0'/>";
			echo "</td>";

			echo "</tr>";
			
		}
	}
?>
<script>
	$('input:checkbox').uniform();
</script>