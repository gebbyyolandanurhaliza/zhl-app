
<div class="form-group required">
	<label class="col-md-3 control-label" for="varchar">Customer</label>
	<div class="col-md-9">
		<?php
		$extra_customer = 'required id="customer_list" class="form-control" ';
		$option_customer[''] = '';
		foreach ($cbo_customer as $r):
			$option_customer[$r->customer_id.'|'.$r->customer_contact_name] = $r->customer_name;
		endforeach;
		echo form_dropdown('customer_list', $option_customer, $customer_id.'|'.$customer_contact_name, $extra_customer);
		echo "<input type='hidden' name='customer_id' id='customer_id' value='$customer_id'>";
		?>
	</div>	
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">Attn</label>
	<div class="col-md-9">
		<input type="text" class="form-control" name="attn" id="attn" value="<?php echo $attn ?>" />
	</div>
</div>

<script>
	$('#customer_list').on('change', function(){
		var arr_cust_id	= $('#customer_list').val().split('|');
		var cust_id		= {customer_id : arr_cust_id[0]};
		
		$('#customer_id').val(arr_cust_id[0]);
		$('#attn').val(arr_cust_id[1]);

		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('proforma_invoice/load_contract') ?>",
			data	:cust_id,
			success	: function (msg) {
				$('#div_contract').html(msg);
			}
		});
	});
</script>

<script type="text/javascript">
    $('select').select2({
        allowClear: true
    });
</script>