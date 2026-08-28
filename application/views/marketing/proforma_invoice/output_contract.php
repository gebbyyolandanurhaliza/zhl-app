<label class="col-md-3 control-label" for="varchar">Sales Contract No.</label>
<div class="col-md-9">
	<?php
	$extra_contract = 'required id="contract_list" class="form-control" ';
	$option_contract[''] = '';
	foreach ($cbo_contract as $r):
		$option_contract[$r->contract_hdr_id] = $r->contract_no;
	endforeach;
	echo form_dropdown('contract_list', $option_contract, $contract_hdr_id, $extra_contract);
	echo "<input type='hidden' id='contract_hdr_id' name='contract_hdr_id' value='$contract_hdr_id'>"
	?>
</div>

<script>
	$('#contract_list').on('change', function(){
		var hdr_id = {contract_hdr_id : $('#contract_list').val()};
		
		proforma_invoice.startPageLoading({
			message : 'Please wait...'
		});

		window.setTimeout(function() {
			proforma_invoice.stopPageLoading();
		}, 3000);
		
		$('#contract_hdr_id').val($('#contract_list').val());

		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('proforma_invoice/load_customer') ?>",
			data	: hdr_id,
			success	: function (msg) {
				$('#div_customer').html(msg);
			}
		});
											
		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('proforma_invoice/load_right_top') ?>",
			data	: hdr_id,
			success	: function (msg) {
				$('#div_right_top').html(msg);
			}
		});
		
		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('proforma_invoice/load_detail') ?>",
			data	: hdr_id,
			success	: function (msg) {
				$('#div_detail').html(msg);
			}
		});
		
		$.ajax({
			type	: "POST",
			url		: "<?php echo site_url('proforma_invoice/load_invoice_amount') ?>",
			data	: hdr_id,
			success	: function (msg) {
				$('#div_invoice_amount').html(msg);
			}
		});
		
	});
</script>

<script type="text/javascript">
    $('select').select2({
        allowClear: true
    });
</script>