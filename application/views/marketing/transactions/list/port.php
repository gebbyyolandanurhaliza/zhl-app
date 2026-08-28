<?php
														 
	$extra_port = 'id="port_id" class="form-control input-sm" data-placeholder="Port"';
	$option_port[''] = '';
	foreach($cbo_port as $r):
		$option_port[$r->port_id] = $r->port_name;
	endforeach;
	echo form_dropdown('port_id[]', $option_port, '', $extra_port);