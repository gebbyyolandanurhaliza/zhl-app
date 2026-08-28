<?php
	$extra_shelf = 'id="shelf_id" class="form-control input-sm w-100" data-placeholder="Shelf Life"';
	$option_shelf[''] = '';
	foreach($cbo_shelf as $r):
		$option_shelf[$r->product_shelf_life_id] = $r->product_shelf_life;
	endforeach;
	echo form_dropdown('shelf_id[]', $option_shelf, '', $extra_shelf);
