<?php
/* 
 * 17 Oktober 2016.
 * Atas permintaan Pohlin
 * otomatis load produk sesuai factory saat change factory.
 */
?>

<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_po">
	<thead>
		<tr class="double-border-bottom">
			<th>&nbsp;</th>
			<th>Product Description</th>
			<th>Product Code</th>
			<th>Brand Name</th>
			<th>Factory</th>
			<th>Packing Size</th>
			<th>UOM</th>
			<th>Unit Price</th>
			<th>S.Contract Qty</th>
			<th>Balance Qty</th>
			<th>Quantity</th>
			<th>FOB Factory Price</th>
			<th>Total</th>
			<th>Sodium Metabisulphite</th>
			<th>FCL</th>
			<th>PM Label Code</th>
			<th>PM Label Qty</th>
			<th>Carton Barcode</th>
			<th>Carton Remark</th>
			<th>Marking On Long Side</th>
			<th>Marking On Short Side</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$s_prod_desc		= "style='width:300px;'";
		$s_prod_code		= "style='width:180px;text-align:center;'";
		$s_brand			= "style='width:100px;text-align:center;cursor:pointer;'";
		$s_factory			= "style=width:80px;text-align:center;";
		$s_packsize			= "style='width:150px;text-align:center;'";
		$s_uom				= "style='width:100px;text-align:center;'";
		$s_price			= "style='width:80px;'";
		$s_contract_qty		= "style='width:90px;'";
		$s_balance			= "style='width:110px;'";
		$s_qty				= "style='width:80px;'";
		$s_fobprice			= "style='width:110px;'";
		$s_total			= "style='width:100px;'";
		$s_sodium			= "style='width:180px;'";
		$s_fcl				= "style='width:50px;'";
		$s_pm_code			= "style='width:150px;text-align:center;cursor:pointer;'";
		$s_pm_qty			= "style='width:90px;'";
		$s_barcode			= "style='width:130px;'";
		$s_cart_remark		= "style='width:250px;'";	//"style='width:150px;'";
		$s_mark_longside	= "style='width:200px;'";
		$s_mark_long		= "style='width:250px;'";
		$s_mark_shortside	= "style='width:200px;'";
		$s_mark_short		= "style='width:250px;'";

		if ($contract_product){
			$last_count = 0;
			foreach($contract_product as $d){

				$sub_total = '';

				$qty_contract	= $this->M_mar_purchase_order->get_qty_contract($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
				$qty_po			= $this->M_mar_purchase_order->get_qty_po($contract_hdr_id, $d->contract_dtl_id, $d->product_id);
				$outstanding_qty = $qty_contract-$qty_po;

				switch ($factory_id){
					case 1:
						$detail_po_format = $d->po_code_prefix_psg;
						break;
					case 3:
						$detail_po_format = $d->po_code_prefix_rsup;
						break;
					case 4:
						$detail_po_format = $d->po_code_prefix_psj;
						break;
					
					default:
						$detail_po_format = '000/MM/YY PSS';
						break;
				}

				if ($d->product_view){
					$product_desc = $d->product_view;
				} else {
					$product_desc = $d->product_name;
				}

				if ($outstanding_qty > 0){
					echo "<tr>";
					//Kolom Tombol
					echo "<td class='text-center bg-editable' style='vertical-align: top;'>";
					echo "<input type='button' $disabled_btn style='width: 80px; margin-left: 5px; margin-top: 2px;' class='btn default btn-xs red-stripe' used_si='$used_si' onclick='removeRow(this)' value='Remove'>";
					echo "<input type='hidden' name='po_dtl_id[]' value='0'>";
//														echo "<a data-target='#modal_product' data-toggle='modal' type='button' class='btn default btn-xs blue-stripe'>Detail Product</a>";
					echo "<input type='hidden' name='product_id[]' value='$d->product_id'>";
					echo "<input type='hidden' name='detail_contract_hdr_id[]' value='$d->contract_hdr_id'>";
					echo "<input type='hidden' name='contract_dtl_id[]' value='$d->contract_dtl_id'>";
					echo "<input type='hidden' name='detail_factory_id[]' class='f_id' value='$d->factory_id'>";
					echo form_hidden('detail_po_format[]', $detail_po_format);
//															echo form_hidden('po_format[]', $po_format);
					echo "</td>";
					//Kolom Product Description
					echo "<td  class='bg-editable'>";
					echo "<input name='product_name[]' value='$product_desc' $s_prod_desc class='form-control input-xs input-table' placeholder='Product Name' title='$d->product_name'>";
					echo "</td>";
					//Kolom Product Code
					echo "<td>";
					echo "<input name='product_code[]' value='$d->product_code' $s_prod_code class='form-control input-xs input-table' placeholder='Product Code' readonly='readonly' title='$d->product_code'>";
					echo "</td>";
					//Kolom Brand Name
					echo "<td class='bg-editable'>";
					echo "<input name='detail_brand_id[]' id='br-$last_count' value='$d->brand_id' type='hidden' class='form-control brand-text input-xs input-table'>";
					echo '<div class="input-group" style="margin-bottom: 0px;">';
						echo "<input name='brand[]' id='brn-$last_count' value='$d->brand_name' $s_brand class='form-control input-xs input-table' onClick='viewModalSelectBrand(this.id)' placeholder='Select Brand' readonly='readonly'>";
						echo '<div class="input-group-btn">';
							echo "<input type='button' class='btn btn-xs fontawesome-font fa-grey fa-transparent remove_brand' title='Clear brand name' value='×' id='$last_count'>";
						echo '</div>';
					echo '</div>';
					echo "</td>";	
					//Kolom Factory
					echo "<td>";
					echo "<input name='factory[]' value='$d->factory_abbr' $s_factory class='form-control input-xs input-table' readonly='readonly'>";
					echo "</td>";
					//Kolom Pack Size
					echo "<td class='bg-editable'>";
					echo "<input name='detail_pack_size[]' value='$d->detail_pack_size' $s_packsize class='form-control input-xs input-table'>";
					echo "</td>";															
					//Kolom UOM
					echo "<td>";
					echo "<input name='uom[]' value='$d->cma_uom_quantity_id' $s_uom class='form-control input-xs input-table' readonly='readonly'>";
					echo "</td>";
					//Kolom Unit Price
					echo "<td>";
					echo "<input name='unit_price[]' value='".number_format($d->price, 2, '.', ',')."' $s_price type='text' class='form-control input-xs text-right input-table' readonly='readonly' onkeypress='return isNumber(event)' onkeyup='calculate()'>";
					echo "</td>";
					//Kolom Sales Contract Qty														
					echo "<td>";
					echo "<input name='contract_qty[]' value='".number_format($qty_contract, 0, '.', ',')."' $s_contract_qty type='text' class='form-control input-xs text-right input-table readonly='readonly'>";
					echo "</td>";
					//Kolom Outstanding Qty														
					echo "<td>";
					echo "<input name='outstanding_qty[]' value='".number_format($outstanding_qty, 0, '.', ',')."' $s_balance type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
					echo "</td>";
					//Kolom Qty
					echo "<td class='bg-editable'>";
					echo "<input name='qty[]' $s_qty type='text' required class='form-control input-xs text-right input-table autonum_qty' data-v-min='0' data-v-max='$outstanding_qty' onkeyup='calculate()'>";
					echo "</td>";
					//Kolom FOB Price
					echo "<td class='bg-editable'>";
					echo "<input name='fob_price[]' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob' data-v-min='0' onkeyup='calculate()'>";
//					if ($qty_contract > 0 && $d->price == 0){
//						echo "<input name='fob_price[]' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob' data-v-min='0' onkeyup='calculate()'>";
//					} else {
//						echo "<input name='fob_price[]' $s_fobprice type='text' class='form-control input-xs text-right input-table autonum_fob' data-v-min='0' data-v-max='$d->price' onkeyup='calculate()'>";
//					}
					echo "</td>";
					
					//Kolom Total
					echo "<td>";
					echo "<input name='total[]' value='0.00' $s_total type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
//														echo "<input name='total[]' value='".number_format($sub_total, 2,'.',',')."' style='width:100px;' type='text' class='form-control input-xs text-right input-table' readonly='readonly'>";
					echo "</td>";
					//Kolom Sodium Metabisulphite
					echo "<td class='bg-editable'>";
//															echo "<textarea name='sodium_metabisulphite[]' rows='2' style='width:200px;' class='form-control input-xs input-table'></textarea>";
					echo "<input name='sodium_metabisulphite[]' $s_sodium value='' type='text' class='form-control input-xs input-table'>";
					echo "</td>";
					//Kolom FCL
					echo "<td>";
//															echo form_hidden('estimated_qty[]', $d->estimated_qty);
					echo "<input name='fcl[]' readonly='readonly' type='text' $s_fcl class='form-control input-xs text-right input-table autonumber' data-v-min='0'>";
						echo "<input name='container_20ft[]' value='".number_format($d->container_20ft,0)."' type='hidden'>";
						echo "<input name='container_40ft[]' value='".number_format($d->container_40ft,0)."' type='hidden'>";
					echo "</td>";
					//Kolom PM Label Code
					echo "<td class='bg-editable'>";
						echo '<input name="pm_label_code[]" value="" id="pm-'.$last_count.'" '.$s_pm_code.' onClick="view_modal_label_code(this.id)" class="form-control input-xs input-table" placeholder="Select PM Label Code" readonly="readonly">';
					echo "</td>";
					//Kolom Label Quantity
					echo "<td class='bg-editable'>";
					echo form_hidden('per_packing[]', $d->per_packing);	// Label Qty = Qty x Per Packing
					echo "<input name='label_qty[]' $s_pm_qty type='text' class='form-control input-xs input-table text-right autonum_qty'>";
					echo "</td>";
					//Kolom Carton Barcode
					echo "<td class='bg-editable'>";
					echo "<input name='carton_barcode[]' $s_barcode type='text' class='form-control input-xs input-table text-right carton_barcode_class'>";
					echo "</td>";
					//Kolom Carton Barcode Remark
					echo "<td class='bg-editable'>";
					echo "<input type='button' class='btn btn-block btn-xs purple-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalCartonRemark($last_count)'>";
					echo "<textarea name='carton_remark[]' rows=4 $s_cart_remark id='carton_remark_$last_count' class='form-control input-xs input-table autosizeme carton_remark_class'></textarea>";
					echo "</td>";
					//Kolom Marking On Long Side
					echo "<td class='bg-editable'>";
					echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalSelectMarking($last_count)'>";
					echo "<div class='input-group input-table-group'>";															
					echo "<input name='long_side[]' id='ls-$last_count' $s_mark_longside type='text' class='form-control input-xs text-right input-table autonumber' data-v-max='10' data-v-min='0'>";
					echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix' onClick='viewModalSelectMarking($last_count)'>side</span>";
					echo "</div>";
					echo "<textarea name='marking_long_side[]' id='lm-$last_count' rows=3 $s_mark_long class='form-control input-xs input-table autosizeme'></textarea>";
					echo "</td>";
					//Kolom Marking On Short Side
					echo "<td class='bg-editable'>";
					echo "<input type='button' class='btn btn-block btn-xs green-stripe fontawesome-font' value='&#xf002 show history' onClick='viewModalSelectMarking($last_count)'>";
					echo "<div class='input-group input-table-group'>";
					echo "<input name='short_side[]' id='ss-$last_count' $s_mark_shortside type='text' class='form-control input-xs text-right input-table autonumber' data-v-max='10' data-v-min='0'>";
					echo "<span class='input-group-addon input-table-group-addon bootstrap-touchspin-postfix'>side</span>";
					echo "</div>";
					echo "<textarea name='marking_short_side[]' id='sm-$last_count' rows=3 $s_mark_short class='form-control input-xs input-table autosizeme'></textarea>";
					echo "</td>";

					echo "</tr>";
				}
				$last_count++;
			}
		}
		
		?>
	</tbody>
</table>
<?php 
	$po_format_final = ($po_format) ? $po_format : '000/MM/YY PSS';
	echo form_hidden('po_format', $po_format_final);
?>

<script type="text/javascript">
	$('#tbl_po .remove_detail').on('click', function(){
		var tr = $(this).closest('tr');
		var po_dtl_id	= $(this).attr('id');
		var po_processed_shp = $('#po_processed_shp').val();

		if (po_processed_shp > 0){
			$.bootstrapGrowl('<i class="fa fa-exclamation-circle"></i> This product can not be removed, because already used in Shipping Department.', {
//				ele: 'body', // which element to append to
				type: 'danger', // (null, 'info', 'danger', 'success', 'warning')
				font_size: '13px', //tambahan untuk ukuran font, default ikut font size body
				offset: {
					from: 'top',
					amount: 250
				}, // 'top', or 'bottom'
				align: 'center', // ('left', 'right', or 'center')
				width: 'auto', // (integer, or 'auto')
				delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
				allow_dismiss: true, // If true then will display a cross to close the popup.
				stackup_spacing: 10 // spacing between consecutively stacked growls.
			});
			return false;
		}

		bootbox.confirm('Are you sure want to remove this product?<br>This will remove the Shipping Instruction product',function(result){
			if (result){
				if (po_dtl_id !== '0'){
					$.ajax({
						type: "POST",
						url	: "<?php echo site_url('marketing-transaction/purchase-order/delete_detail')?>",
						data: {po_dtl_id : po_dtl_id},
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
					re_calculate();
				});

			}
		});    
		return false;    
	});

	$('#tbl_po .remove_detail_add').on('click', function(){
		var tr = $(this).closest('tr');

		tr.fadeOut(400, function(){
			tr.remove();
			re_calculate();
		});
	});

	$('#tbl_po .remove_brand').on('click', function(){
		var urut	= $(this).attr('id');

		$('#br-'+urut).val('0');
		$('#brn-'+urut).val('');
	});

</script>

<script src="<?php echo base_url();?>assets/marketing/po_mark.js"></script>
<script>
	jQuery(document).ready(function() { 
		po_mark.init();
	});		
</script>