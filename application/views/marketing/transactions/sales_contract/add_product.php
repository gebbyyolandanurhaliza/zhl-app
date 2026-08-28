
<div class="v-scroll">
	<table id="tbl_product" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="w-70">#</th>
				<th class="sembunyi">Product ID</th>
				<th>Product Description</th>
				<th class="w-150">Product Code</th>
				<th class="w-70">Factory</th>				
				<th class="sembunyi">Brand ID</th>
				<th class="sembunyi">UOM ID</th>
				<th class="sembunyi">Factory ID</th>
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
				echo '<td class="brand sembunyi">'.$r->brand_name.'</td>';
				echo '<td class="uom sembunyi">'.$r->uom_quantity_name.'</td>';	
				echo '<td class="uom sembunyi">'.$r->factory_id.'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>	
</div>