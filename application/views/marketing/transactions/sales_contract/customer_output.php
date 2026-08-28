
<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Company's Name</label>
	<div class="col-md-7">
		<?php 
			$extra_company = 'disabled id="list_customer" class="form-control select2me" data-placeholder="Select Company..."';
			$option_company[''] = '';
			foreach($cbo_company as $r):
				$option_company[$r->customer_id] = $r->customer_company_name;
			endforeach;
			echo form_dropdown('list_customer', $option_company, $customer_id, $extra_company);
			echo form_hidden('customer_id', $customer_id);
		?>		
		<!--<span class="help-inline"><?php // echo form_error('customer_id') ?></span>-->
	</div>
	
</div>

<!--<script type="text/javascript">
	$('#list_customer').change(function(){
		var customer_id = {customer_id:$("#list_customer").val()};
		$.ajax({
			type: "POST",
			url : "<?php // echo site_url('marketing_misc/sales_contract_get_customer')?>",
			data: customer_id,
			success: function(msg){
				$('#header').html(msg);
			}
		});

	});
</script>-->

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Customer Name</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
	</div>
	<span class="help-inline"><?php echo form_error('customer_name') ?></span>
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Customer Country </label>
	<div class="col-md-4" style="padding-right: 3px">
		<?php 
			$extra_country = 'disabled id="country_id" class="form-control select2me" data-placeholder="Select Country..."';
			$option_country[''] = '';
			foreach($cbo_country as $r):
				$option_country[$r->country_id] = $r->country_name;
			endforeach;
			echo form_dropdown('country_id', $option_country, $country_id, $extra_country);
		?>
		<span class="help-inline"><?php echo form_error('country_id') ?></span>
	</div>

	<div class="col-md-3" style="padding-left: 3px">
		<div class="input-icon" id="div_idd">
			<i class="fa fa-phone" style="font-size: 18px; margin-top: 6px;"></i>
			<input type="text" class="form-control text-center" name="country_idd" value="<?php echo $country_idn?>" placeholder="IDD" readonly="readonly" title="IDD Code">
		</div>
	</div>

<!--	<script type="text/javascript">
		$('#country_id').change(function(){
			var selectValues = $('#country_id').val();
			if (selectValues === 0){
				var msg = '<i class="fa fa-phone" style="font-size: 18px; margin-top: 6px;"></i><input type="text" class="form-control text-center" name="country_idd" value="" placeholder="IDD" readonly="readonly" title="IDD Code">';
				$('#div_idd').html(msg);
			} else {
				var country_id = {country_id:$("#country_id").val()};
				$.ajax({
					type: "POST",
					url : "<?php // echo site_url('marketing_misc/get_idd')?>",
					data: country_id,
					success: function(msg){
						$('#div_idd').html(msg);
					}
				});
			}
		});
	</script>-->
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Address</label>
	<div class="col-md-7">
		<textarea readonly="readonly" rows="3" class="form-control autosizeme" name="customer_address" id="customer_address" ><?php echo $customer_address; ?></textarea>
	</div>
	<span class="help-inline"><?php echo form_error('customer_address') ?></span>
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Customer Phone</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="customer_phone" id="customer_phone" value="<?php echo $customer_phone; ?>" />
	</div>
	<span class="help-inline"><?php echo form_error('customer_phone') ?></span>
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Customer Fax</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="customer_fax" id="customer_fax" value="<?php echo $customer_fax; ?>" />
	</div>
	<span class="help-inline"><?php echo form_error('customer_fax') ?></span>
</div>

<div class="form-group">
	<label class="col-md-4 control-label" for="varchar">Customer Email</label>
	<div class="col-md-7">
		<input readonly="readonly" type="text" class="form-control" name="customer_email" id="customer_email" value="<?php echo $customer_email; ?>" />													
	</div>
	<span class="help-inline"><?php echo form_error('customer_email') ?></span>
</div>

<script>
	$('#customer_id').select2({
		allowClear : true
	});
	$('#country_id').select2({
		allowClear : true
	});
	$('#customer_address').autosize();
</script>