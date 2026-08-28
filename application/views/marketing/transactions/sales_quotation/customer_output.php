										
<!--
<div class="form-group required">
	<label class="col-md-4 control-label" for="varchar">Customer</label>
	<div class="col-md-5">
		<?php
		$extra_customer = 'id="customer_id" class="form-control select2me" data-placeholder="Select Customer..."';
		$option_customer[''] = '';
		foreach($cbo_customer as $r):
			$option_customer[$r->customer_id] = $r->customer_code.' - '.$r->customer_name;
		endforeach;
		echo form_dropdown('customer_id', $option_customer, $customer_id, $extra_customer);
		?>
		<span class="help-inline"><?php echo form_error('customer_id') ?></span>
	</div>
</div>
-->
<script type="text/javascript">
	$('#customer_id').change(function(){
		var customer_id = {customer_id:$("#customer_id").val()};
		$.ajax({
			type: "POST",
			url : "<?php echo site_url('marketing_misc/sales_quotation_get_customer')?>",
			data: customer_id,
			success: function(msg){
				$('#div_customer').html(msg);
			}
		});
	});
</script>

<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">Customer Name</label>
	<div class="col-md-5">
		<input readonly="readonly" type="text" class="form-control" name="customer_name" id="customer_name" value="<?php echo $customer_name; ?>" />
	</div>
	<span class="help-inline"><?php echo form_error('customer_name') ?></span>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">Contact Person</label>
	<div class="col-md-5">
		<input readonly="readonly" type="text" class="form-control" name="customer_contact_name" id="customer_contact_name" value="<?php echo $customer_contact_name; ?>" />
	</div>
	<span class="help-inline"><?php echo form_error('customer_contact_name') ?></span>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">Customer Ref. No.</label>
	<div class="col-md-5">
		<input readonly="readonly" type="text" class="form-control" name="customer_reference" id="customer_reference" value="<?php echo $customer_reference; ?>" />
	</div>
	<span class="help-inline"><?php echo form_error('customer_reference') ?></span>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">Agent</label>
	<div class="col-md-5">
		<?php 
			$extra_agent = 'id= "agent_id" class="form-control select2me"';
			$option_agent[''] = '';
			if ($cbo_agent){
				foreach($cbo_agent as $ag):
					$option_agent[$ag->agent_id] = $ag->agent_name;													
				endforeach;
			}
			echo form_dropdown('agent_id', $option_agent, $agent_id, $extra_agent);
		?>
	</div>
</div>

<script>
	$('#customer_id').select2({
		allowClear : true
	});
	$('#local_currency').select2({
		allowClear : true
	});
	$('#sales_status').select2({
		allowClear : true
	});
	$('#marketing_staff_code').select2({
		allowClear : true
	});
	$('#agent_id').select2({
		allowClear : true
	});
</script>