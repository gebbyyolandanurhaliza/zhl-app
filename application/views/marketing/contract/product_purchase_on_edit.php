<?php
$w_prod_desc	= "required style=width:300px;";
$w_prod_code	= "style=width:150px;text-align:center;";
$w_factory		= "style=width:80px;text-align:center;";
$w_brand		= "style=width:150px;cursor:pointer;";
$w_pack_size	= "style=width:150px;";
$w_uom			= "style=width:100px;text-align:center;";
$w_quot_qty		= "style=width:100px;";
$w_bal_qty		= "style=width:100px;";
$w_qty			= "style=width:100px;";
$w_price		= "style=width:100px;";
$w_fcl			= "style=width:100px;";
$w_total		= "style=width:130px;";
?>	

<!--<div class="table-responsive">-->
<div class="table-scrollable">
	<table class="table table-bordered table-condensed table-detail scrollable" id="tblsales_contract">
		<thead>
			<tr>
				<th class="w-50">&nbsp;</th>
				<th>Product Description</th>
				<th>Product Code</th>
				<th>Factory</th>
				<th class="w-180">Brand Name</th>
				<th class="w-150">Pack Size</th>
				<th class="w-100">UOM</th>
				<th class="w-100 sembunyi">Quotation Qty</th>
				<th class="w-100">Contract Qty</th>
				<th class="w-100">Qty</th>
				<th class="w-100">Unit Price</th>													
				<th class="w-100">FCL</th>
				<th class="w-130">Total</th>

			</tr>
		</thead>
		<tbody>
			<?php
			if ($contract_detail){
				$last_count = 1;
				foreach ($contract_detail as $cd){
					$sub_total = $cd->price * $cd->quantity;

					$qty_quotation = $cd->qty_quotation;
					$qty_contract = $cd->quantity;
					$po_qty = $cd->po_qty;

//					$po_qty = $this->M_mar_sales_contract->get_qty_po($cd->contract_hdr_id, $cd->product_id);

//					if ($qty_quotation == 0){
//						$balance_qty = 0;
//					} else {
//						$balance_qty = $qty_quotation-$qty_contract;
//					}

					echo "<tr>";
					//Kolom Tombol
					echo "<td class='text-center w-50 bg-editable valign-middle'>";
//						echo "<input type='button' class='btn default btn-xs red-stripe' onclick='removeRow(this)' value='Remove'>";
						echo "<div class='input-group input-table-group'>";
						echo "<input type='button' class='btn default btn-xs red-stripe remove_detail' value='Remove' id='".encode_str($cd->contract_dtl_id,'contract')."'>";
						echo '<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix num">' . $last_count . '</span>';
						echo '</div>';
						echo "<input type='hidden' name='product_id[]' value='$cd->product_id'>";
						echo "<input type='hidden' name='factory_id[]' value='$factory_id'>";
						echo "<input type='hidden' name='contract_dtl_id[]' value='".encode_str($cd->contract_dtl_id,'contract')."'>";
//															echo "<input type='hidden' name='quotation_dtl_id[]' value='$d->quotation_dtl_id'>";
					echo "</td>";
					//Kolom Product Description
					echo "<td class='bg-editable'>";
						echo "<input name='product_name[]' $w_prod_desc value='$cd->product_name' class='form-control input-xs input-table' placeholder='Product Name' title='$cd->product_name'>";
					echo "</td>";
					//Kolom Product Code
					echo "<td>";
						echo "<input name='product_code[]' $w_prod_code value='$cd->product_code' class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$cd->product_code'>";
					echo "</td>";
					//Kolom Factory
					echo "<td>";
						echo "<input name='factory_abbr[]' $w_factory value='$cd->factory_abbr' class='form-control input-xs input-table' readonly='readonly' >";
					echo "</td>";
					//Kolom Brand Name
					echo '<td class="bg-editable">';
						echo '<input name="detail_brand_id[]" value="'.$cd->brand_id.'" id="br-'.$last_count.'" type="hidden" class="form-control brand-text input-xs input-table">';
						echo '<input name="brand_name[]" value="'.$cd->brand_name.'" id="brn-'.$last_count.'" '.$w_brand.' onClick="viewModalSelectBrand(this.id)" class="form-control input-xs input-table" placeholder="Select Brand" readonly="readonly">';
					echo '</td>';
					//Kolom Pack Size
					if ($cd->detail_pack_size){
						$pack_size = $cd->detail_pack_size;
					} else {
						$pack_size = floatval($cd->uom_volume).' '.$cd->uom_volume_name.' x '.$cd->per_packing.' '.$cd->packing_size.' per '.$cd->cma_uom_quantity_id;
					}
					echo "<td class='bg-editable'>";
						echo "<input name='pack_size[]' $w_pack_size value='$pack_size' class='form-control input-xs input-table' title='$pack_size'>";
					echo "</td>";
					//Kolom UOM
					echo "<td>";
						echo "<input name='uom_quantity_name[]' $w_uom value='$cd->uom_quantity_name' class='form-control input-xs input-table' readonly='readonly'>";
					echo "</td>";
					//Kolom Qty Quotation
					echo "<td class='sembunyi'>";
						echo "<input name='qty_quotation[]' $w_quot_qty value='".number_format($qty_quotation, 0, '.', ',')."' class='form-control input-xs text-right input-table' readonly='readonly'>";
						echo form_hidden('po_qty[]', $po_qty);
					echo "</td>";
					//Kolom Balance Qty
					echo "<td>";
						echo "<input name='qty_contract[]' $w_bal_qty value='".number_format($qty_contract, 0, '.', ',')."' class='form-control input-xs text-right input-table' readonly='readonly'>";
					echo "</td>";
					//Kolom Qty
					echo "<td class='bg-editable'>";
						echo "<input name='qty[]' $w_qty required value='$cd->quantity' id='qty-$last_count' po_qty_value='$po_qty' type='text' class='form-control input-xs text-right input-table autonum_qty autofocus' data-v-min='0' onkeyup='calculate()' onfocus='cekpo(this.id)'>";
					echo "</td>";
					//Kolom Unit Price
					echo "<td class='bg-editable'>";
						echo "<input name='unit_price[]' $w_price required value='$cd->price' type='text' class='form-control input-xs text-right input-table autonum_price autofocus' onkeyup='calculate()'>";
					echo "</td>";
					//Kolom FCL																													
					echo "<td class='bg-editable'>";															
//															echo form_hidden('estimated[]', $cd->estimated_qty);
						echo "<input name='fcl[]' $w_fcl required value='$cd->fcl' type='text' class='form-control input-xs text-right input-table autonum_fcl autofocus'>";
						echo "<input name='container_20ft[]' value='".number_format($cd->container_20ft,0)."' type='hidden'>";
						echo "<input name='container_40ft[]' value='".number_format($cd->container_40ft,0)."' type='hidden'>";
					echo "</td>";
					//Kolom Total
					echo "<td>";
						echo "<input name='total[]' $w_total value='".number_format($sub_total, 2,'.',',')."' type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
					echo "</td>";

					echo "</tr>";
					$last_count++;
				}
			}
			?>
		</tbody>
	</table>
</div>

<script type="text/javascript">
	$('#tblsales_contract .remove_detail').on('click', function(){
		var tr = $(this).closest('tr');
		var con_dtl_id	= $(this).attr('id');
		
		bootbox.confirm('Are you sure want to remove this product?',function(result){
			if (result){
				if (con_dtl_id !== '0'){
					$.ajax({
						type: "POST",
						url	: "<?php echo site_url('sales_contract/delete_detail')?>",
						data: {contract_dtl_id : con_dtl_id},
						success : function(){
							$.bootstrapGrowl('<i class="fa fa-info-circle"></i> Remove Product Success.', {
		//							ele: 'body', // which element to append to
									type: 'success', // (null, 'info', 'danger', 'success', 'warning')
									offset: {
										from: 'top',
										amount: 250
									}, // 'top', or 'bottom'
									align: 'center', // ('left', 'right', or 'center')
									width: 'auto', // (integer, or 'auto')
									delay: 3000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
									allow_dismiss: true, // If true then will display a cross to close the popup.
									stackup_spacing: 10 // spacing between consecutively stacked growls.
								});
						}
					});
				}

				tr.fadeOut(400, function(){
					tr.remove();
					updateRowOrder();
					re_calculate();
				});
				
			}			
		});    
		return false;    
	});
	
	$('.autonum_qty').autoNumeric('init',{
		mDec	: 0
	});
	
	$('.autonum_price').autoNumeric('init',{
		mDec	: 2
	});
	
	$('.autonum_fcl').autoNumeric('init',{
		mDec	: 2
	});
	
	$('.autonumber').autoNumeric('init');
	
	//select all text on focused
	$('.autofocus').on('click', function(){
		this.select();
	});
	
	$('.autonumber').on('click', function(){
		this.select();
	});
</script>