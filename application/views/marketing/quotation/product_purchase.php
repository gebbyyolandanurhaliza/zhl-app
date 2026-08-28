<div class="table-responsive">
	<table class="table table-bordered table-condensed table-detail" id="tbl_quotation">
		<thead>
			<tr>
				<th scope="col" style="width:50px !important">#</th>
				<th scope="col">Product Description</th>
				<th scope="col">Product Code</th>
				<th scope="col">Product Brand</th>
				<th scope="col">Factory</th>
				<th scope="col">Packing Size</th>
				<th scope="col">UOM</th>													
				<th scope="col">Price</th>
				<th scope="col">Quantity</th>
				<th scope="col">Total Amount</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$last_count = 0;
			if ($detail){
				foreach ($detail as $d){
					$last_count++;
					echo '<tr>';
					echo '<td class="text-center w-50 bg-editable valign-middle">';
					echo '<div class="input-group input-table-group">';
					echo '<input type="button" class="btn default btn-xs red-stripe" onclick="removeRowPurchase(this)" value="Remove">';
					echo '<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix num">'.$last_count.'</span>';
					echo '</div>';
					echo '<input type="hidden" name="product_id[]" class="p_id" value="'.$d->product_id.'">';
					echo '<input type="hidden" name="factory_id[]" class="f_id" value="'.$factory_id.'">';
					echo '<input type="hidden" name="quotation_dtl_id[]" value="">';
					echo '</td>';
					echo '<td class="w-300"><input name="product_name[]" class="form-control input-xs input-table" placeholder="Product Name" readonly="readonly" value="'.$d->product_name.'" title="'.$d->product_name.'"></td>';
					echo '<td class="w-180"><input name="product_code[]" class="form-control input-xs input-table" placeholder="Product Code" readonly="readonly" value="'.$d->product_code.'" title="'.$d->product_code.'"></td>';
					echo '<td class="w-180 bg-editable">';
					echo '<input name="detail_brand_id[]" id="br-'. $last_count .'" type="hidden" class="form-control brand-text input-xs input-table">';
					echo '<input name="brand_name[]" id="brn-'. $last_count .'" onClick="viewModalSelectBrand(this.id)" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly" style="cursor:pointer;">';
					echo '</td>';
//					echo '<td class="w-180"><input name="brand[]" value="'.$d->brand_name.'" class="form-control input-xs input-table" readonly="readonly"></td>';
					echo '<td class="w-100"><input name="factory[]" value="' . $d->factory_abbr . '" class="form-control input-xs input-table" readonly="readonly"></td>';
					echo '<td class="w-150"><input name="packing_size[]" value="' . $d->packing_view . '" class="form-control input-xs input-table" readonly="readonly"></td>';
					echo '<td class="w-100"><input name="uom[]" value="'.$d->uom_quantity_name.'" class="form-control input-xs input-table text-center" readonly="readonly"></td>';
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

<script>
	$('.autonum_price').autoNumeric('init', {
		mDec: 3,
		aDec: '.',
		aSep: ','
	});

	$('.autonum_qty').autoNumeric('init', {
		mDec: 0
	});

	//select all text on focused
	$('.autofocus').on('click', function () {
		this.select();
	});

	function updateRowOrderPurchase() {
        $('span.num').each(function (i) {
            $(this).text(i + 1);
        });
    }

    function removeRowPurchase(btn) {
        var row = btn.parentNode.parentNode.parentNode;
		row.parentNode.removeChild(row);
		updateRowOrderPurchase();
    }
</script>