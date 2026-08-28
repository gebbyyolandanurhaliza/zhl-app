

<div class="v-scroll">
	<table id="tbl_product" class="table table-condensed table-hover">
		<thead>
			<tr>
				<th class="w-150">#</th>
				<th>Name</th>
				<th class="w-120">Code</th>
				<th class="sembunyi">UOM ID</th>
				<th class="sembunyi">Brand ID</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$i = 0;
			foreach ($record as $r){
				$i++;
				echo '<tr>';
				echo '<td class="text-center">';
				echo '<button bariske = '.$i.' type="button" class="btn btn-xs blue btnselect">Select</button>';
				echo '</td>';
				echo '<td class="nama">'.$r->product_name.'</td>';
				echo '<td class="code">'.$r->product_code.'</td>';
				echo '<td class="uom sembunyi">'.$r->uom_quantity_name.'</td>';
				echo '<td class="brand sembunyi">'.$r->brand_name.'</td>';
				echo '</tr>';
			}
			?>
		</tbody>
	</table>	
</div>


<script type="text/javascript">
		
$('.btnselect').click(function(){
//		var bariske = $(this).attr('bariske');
		var $tr = $(this).closest("tr");
		var nama = $tr.find('.nama').text();
		var code = $tr.find('.code').text();
		var uom = $tr.find('.uom').text();
		var brand = $tr.find('.brand').text();
		
		$('#tbl_quotation > tbody:last-child').append(
				'<tr>\n\
					<td class="text-center w-50"><input type="button" class="btn default btn-sm red-stripe" onclick="removeRow(this)" value="Remove"></td> \n\
					<td class="w-300"><input name="product_name[]" class="form-control input-sm input-table" placeholder="Product Name" readonly="readonly" value="'+nama+'" title="'+nama+'"></td>\n\
					<td class="w-150"><input name="product_code[]" class="form-control input-sm input-table" placeholder="Product Code" readonly="readonly" value="'+code+'" title="'+code+'"></td>\n\
					<td class="w-180"><input value="'+brand+'" name="brand[]" class="form-control input-sm input-table" readonly="readonly"></td>\n\
					<td class="w-60"><input value="'+uom+'" name="uom[]" class="form-control input-sm input-table" readonly="readonly"></td>\n\
					<td class="w-60"><input name="pack_size[]" class="form-control input-sm input-table" readonly="readonly"></td>\n\
					<td class="w-100"><input name="price[]" type="text" class="form-control input-sm text-right input-table"></td>\n\
					<td class="w-130"><input name="qty[]" type="text" class="form-control input-sm text-right input-table"></td>\n\
					<td class="w-130"><input name="total[]" type="text" class="form-control input-sm text-right input-table"></td>\n\
				</tr>'
			);
		
		$('#modal_product').modal('hide');		
		
	});
	
</script>
