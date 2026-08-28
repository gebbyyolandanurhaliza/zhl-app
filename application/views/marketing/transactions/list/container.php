<?php
														 
	$extra_container = 'id="container_id" class="form-control input-sm input-table container-size" data-placeholder="Container Size"';
	$option_container[''] = '';
	foreach($cbo_container as $r):
		$option_container[$r->container_id] = $r->container_name;
	endforeach;
	echo form_dropdown('container_id[]', $option_container, '', $extra_container);
