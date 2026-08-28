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
					if ($r->packing_view){
						$pack_size = $r->packing_view;
					} else {
						$pack_size = floatval($r->uom_volume).' '.$r->uom_volume_name.' x '.floatval($r->per_packing).' '.$r->packing_size.' per '.$r->cma_uom_quantity_id;
					}					
					echo '<td class="packing" style="width:200px;">'.$pack_size.'</td>';
					//idx = 9
					echo '<td class="container_20ft sembunyi">'.number_format($r->container_20ft,0).'</td>';
					//idx = 10
					echo '<td class="container_40ft sembunyi">'.number_format($r->container_40ft,0).'</td>';
//					//idx = 11
//					echo '<td class="available_container" style="vertical-align:middle; width:100px;"><div class="row">';
//					if ($r->container_20ft > 0) {
//						echo '<span class="label label-sm label-primary">20ft</span>';
//					}
//					if ($r->container_40ft > 0) {
//						echo '<span class="label label-sm label-danger">40ft</span>';
//					}
//					echo '</div></td>';
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