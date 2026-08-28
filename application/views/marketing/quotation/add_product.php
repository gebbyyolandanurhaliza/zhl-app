
<div class="v-scroll">
	<table id="tbl_product" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th class="sembunyi">Product ID</th>
				<th style="text-align: left;">Product Description</th>				
				<th class="w-220" style="text-align: left;">Product Code</th>
				<th class="w-70">Factory</th>				
				<th class="w-130 sembunyi">Brand</th>
				<th class="sembunyi">UOM ID</th>
				<th class="sembunyi">Factory ID</th>
				<th class="w-80 sembunyi">UOM Vol</th>
				<th class="w-100" style="text-align: left;">Pack Size</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach ($record as $r){
				$i++;
				echo '<tr>';
				echo '<td class="text-center">';
				echo '<input type="checkbox" name="chk[]" >';
				echo '</td>';
				echo '<td class="id sembunyi">'.$r->product_id.'</td>';
				echo '<td class="nama">'.$r->product_name.'</td>';
				echo '<td class="code">'.$r->product_code.'</td>';
				echo '<td class="factory text-center">'.$r->factory_abbr.'</td>';
				echo '<td class="brand sembunyi text-center">'.$r->brand_name.'</td>';
				echo '<td class="uom sembunyi">'.$r->cma_uom_quantity_id.'</td>';	
				echo '<td class="f_id sembunyi">'.$r->factory_id.'</td>';
				echo '<td class="uom_volume sembunyi">'.$r->uom_volume.' '.$r->uom_volume_name;
				echo '<td class="pack_size">'.$r->packing_view.'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>	
</div>

<script>
	$('input:checkbox').uniform();
</script>