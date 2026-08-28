<div class="form-group required">
	<label class="col-md-4 control-label" for="varchar">Name</label>
	<div class="col-md-7">
		<?php 
			$extra_bank = 'id="bank_id" class="form-control select2me" data-placeholder="Select Bank..."';
			$option_bank[''] = '';
			foreach($cbo_bank as $r):
				$option_bank[$r->bank_id] = $r->bank_name.', '.$r->bank_city;													
			endforeach;
			echo form_dropdown('bank_id', $option_bank, $bank_id, $extra_bank);
		?>
		<span class="help-inline"><?php echo form_error('bank_id') ?></span>
	</div>													
</div>

<script type="text/javascript">
	$('#bank_id').change(function(){
		var bank_id = {bank_id:$("#bank_id").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/sales_contract_get_bank')?>",
			data: bank_id,
			success: function(msg){
				$('#bank_info').html(msg);
			}
		});

	});
</script>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Account Number</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="bank_account_number" id="bank_account_number" value="<?php echo $bank_account_number; ?>" />
	</div>													
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Address</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="bank_address" id="bank_address" value="<?php echo $bank_address; ?>" />
	</div>													
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">City</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="bank_city" id="bank_city" value="<?php echo $bank_city; ?>" />
	</div>	
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Country</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="bank_country_name" id="bank_country_name" value="<?php echo $bank_country_name; ?>" />
	</div>
</div>

<script>
	$('#bank_id').select2({
		allowClear : true
	});
</script>