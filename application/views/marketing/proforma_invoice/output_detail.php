
<div class="form-group">
	<label class="col-md-12 control-label" for="varchar">Terms of Payment</label>
	<div class="col-md-12">
		<?php
		$extra_payterm = 'id="payment_term" class="form-control"';
		$option_payterm[''] = '';
		if ($cbo_payterm){
			foreach ($cbo_payterm as $r):
				$option_payterm[$r->payment_term_id] = $r->payment_term;
			endforeach;
		}
		echo form_dropdown('payment_term_id', $option_payterm, $payment_term_id, $extra_payterm);
		?>
	</div>
</div>

<div class="form-group">
	<div class="col-md-6">
		<label class="control-label">Sales Marketing</label>
		<div>
			<?php 
				$extra_sm = 'id="sales_marketing_id" class="form-control" ';
				$option_sm[''] = '';
				foreach($cbo_sales_marketing as $r):
					$option_sm[$r->userid] = $r->firstname.' '.$r->lastname;
				endforeach;
				echo form_dropdown('sales_marketing_id', $option_sm, $sales_marketing_id, $extra_sm);
			?>
		</div>
	</div>

	<div class="col-md-6">
		<label class="control-label">Bank Details</label>
		<div>
			<?php 
				$extra_bank = 'required id="bank_id" class="form-control "';
				$option_bank[''] = '';
				foreach($cbo_bank as $r):
					$option_bank[$r->bank_id] = $r->bank_name.', '.$r->bank_city;													
				endforeach;
				echo form_dropdown('bank_id', $option_bank, $bank_id, $extra_bank);
			?>
		</div>
	</div>
</div>

<br>
									
<div class="table-scrollable">
	<table class="table table-bordered table-condensed table-detail scrollable" id="tbl_pi" style='table-layout: fixed;'>
		<thead>
			<tr class="double-border-bottom">
				<th style='width:40px; text-align: center;'>No</th>
				<th>Product Description</th>
				<th style='width:100px; text-align: center;'>Quantity</th>
				<th style='width:100px; text-align: center;'>UOM</th>
				<th style='width:100px; text-align: center;'>Unit Price US$</th>
				<th style='width:150px; text-align: right;'>Amount US$</th>
			</tr>
		</thead>
		<tbody>
			<?php 
			$grand_total	= '0.00';

			if ($rec_detail){
				$no = 1;
				foreach($rec_detail as $r){
					$product_desc	= ($r->detail_product_desc) ? $r->detail_product_desc : $r->product_view;
					$product_pack	= $r->detail_pack_size;

//							$vol			= ($r->uom_volume > 0) ? floatval($r->uom_volume).' '.$r->uom_volume_name.' X ' : '';
//							$pack			= ($r->per_packing > 0) ? floatval($r->per_packing) : '';
//							$fat			= ($r->fat_content > 0) ? ' (FAT '.floatval($r->fat_content).'%)' : '';
//							$product_pack	= $vol.$pack.$fat;

					echo "<tr>";

					echo "<td class='text-center'>$no</td>";

					echo "<td class='bg-editable'>";
//					echo form_hidden('pi_dtl_id[]', 0);
					echo form_hidden('product_id[]', $r->product_id);
					echo form_hidden('contract_dtl_id[]', $r->contract_dtl_id);
					echo "<input name='product_name[]' value='$product_desc' class='form-control input-xs input-table' placeholder='Product Name' title='$product_desc'>";
					echo "<input name='product_pack[]' value='$product_pack' class='form-control input-xs input-table' placeholder='Product Packing' title='$product_pack'>";
//							echo $r->product_name;
					echo "</td>";

					echo "<td>";
					echo "<input name='quantity[]' value='".number_format($r->quantity, 0)."' readonly='readonly' class='form-control input-xs input-table text-center'>";
					echo "</td>";

					echo "<td>";
					echo form_hidden('uom_quantity_id[]', $r->uom_quantity_id);
					echo "<input name='uom_quantity_name[]' value='$r->uom_quantity_name' readonly='readonly' class='form-control input-xs input-table text-center'>";
					echo "</td>";

					echo "<td>";
					echo "<input name='unit_price[]' value='".number_format($r->price, 3)."' readonly='readonly' class='form-control input-xs input-table text-center'>";
					echo "</td>";

					echo "<td>";
					echo "<input name='amount[]' value='".number_format($r->total, 2)."' readonly='readonly' class='form-control input-xs input-table text-right'>";
					echo "</td>";

					echo "</tr>";

					$grand_total += $r->total;
					$no++;
				}
			}
			?>
		</tbody>

	</table>
</div>

<input type="hidden" name="contract_amount" id="contract_amount" value="<?php echo $contract_amount ?>">

<!--<script src="<?php // echo base_url();?>assets/marketing/proforma_invoice.js"></script>-->
<script>
	$('select').select2({
		allowClear: true
	});
</script>