<?php
														 
	$extra_port = 'required id="port_id" class="form-control select2me"';
	$option_port[''] = '';
	foreach($cbo_port as $r):
		$option_port[$r->port_id] = $r->port_name;
	endforeach;
	echo form_dropdown('port_id', $option_port, '', $extra_port);
	
?>

<script>
	$('#port_id').select2({
		allowClear : true
	});
</script>