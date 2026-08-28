<?php 
	$extra_payterm = 'id="payment_term" class="form-control select2me"';
	$option_payterm[''] = '';
	foreach($cbo_payterm as $r):
		$option_payterm[$r->payment_term] = $r->payment_term;													
	endforeach;
	echo form_dropdown('payment_term', $option_payterm, '', $extra_payterm);

?>

<script>
	$('#payment_term').select2({
		allowClear:true
	});
</script>