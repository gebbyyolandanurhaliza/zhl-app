<div class="table-responsive">
	<table class="table table-bordered table-condensed table-detail" id="tbl_quotation">
		<thead>
			<tr>
				<th scope="col" style="width:50px !important">#</th>
				<th scope="col">Product Description</th>
				<th scope="col">Product Code</th>
				<th scope="col">Product Brand</th>
				<th scope="col">UOM</th>													
				<th scope="col">Price</th>
				<th scope="col">Quantity</th>
				<th scope="col">Total Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ($detail){
				foreach ($detail as $d){
					echo '<tr>';
					echo '<td class="text-center w-50 bg-editable valign-middle">';
					echo '<input type="button" class="btn default btn-xs red-stripe" onclick="removeRow(this)" value="Remove">';
					echo '<input type="hidden" name="product_id[]" class="p_id" value="'.$d->product_id.'">';
					echo '<input type="hidden" name="factory_id[]" class="f_id" value="'.$factory_id.'">';
					echo '<input type="hidden" name="quotation_dtl_id[]" value="">';
					echo '</td>';
					echo '<td class="w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="'.$d->product_name.'" title="'.$d->product_name.'"></td>';
					echo '<td class="w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="'.$d->product_code.'" title="'.$d->product_code.'"></td>';
					echo '<td class="w-180"><input name="brand[]" value="'.$d->brand_name.'" class="form-control input-xs input-table" readonly="readonly"></td>';
					echo '<td class="w-150"><input name="uom[]" value="'.$d->uom_quantity_name.'" class="form-control input-xs input-table" readonly="readonly"></td>';
					echo '<td class="w-100 bg-editable"><input required name="price[]" value="" type="text" class="form-control input-xs text-right input-table autonum_price autofocus" onkeyup="calculate()"></td>';
					echo '<td class="w-100 bg-editable"><input required name="qty[]" value="" type="text" class="form-control input-xs text-right input-table autonum_qty autofocus" data-v-min="0" onkeyup="calculate()"></td>';
					echo '<td class="w-130"><input name="total[]" value="" type="text" class="form-control input-xs text-right input-table" readonly="readonly">';
					echo '</tr>';
				}
			}
			?>
		</tbody>
	</table>
</div>