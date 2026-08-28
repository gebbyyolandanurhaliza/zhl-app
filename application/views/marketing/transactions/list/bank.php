<?php
    $extra_bank = 'required id="bank_id" class="form-control "';
    $option_bank[''] = '';
    foreach($cbo_bank as $r):
        $option_bank[$r->bank_id] = $r->bank_name.', '.$r->bank_city;
    endforeach;
    echo form_dropdown('bank_id', $option_bank, '', $extra_bank);

?>

<script>
	$('#bank_id').select2({
		allowClear:true
	});
</script>
