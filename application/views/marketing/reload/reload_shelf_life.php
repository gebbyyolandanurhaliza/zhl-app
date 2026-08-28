<?php

$extra_shelf = 'id="product_shelf_life_id" class="form-control select2me"';
$option_shelf[''] = '';
foreach($cbo_shelf as $r):
	$option_shelf[$r->product_shelf_life_id] = $r->product_shelf_life;													
endforeach;
echo form_dropdown('product_shelf_life_id', $option_shelf, $product_shelf_life_id, $extra_shelf);

?>

<script>
	$('#product_shelf_life_id').select2({
		allowClear	: true
	});
</script>