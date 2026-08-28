<?php 
	$extra_payterm = 'id="payment_term_id" class="form-control select2me"';
	$option_payterm[''] = '';
	foreach($cbo_payterm as $r):
		$option_payterm[$r->payment_term_id] = $r->payment_term;													
	endforeach;
	echo form_dropdown('payment_term_id', $option_payterm, '', $extra_payterm);

?>

<script>
	$('#payment_term_id').select2({
		allowClear:true
	});
</script>