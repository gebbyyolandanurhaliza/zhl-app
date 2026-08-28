<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">Shipment From</label>
	<div class="col-md-9">
		<?php
		$extra_ship_from = 'class="form-control"';
		$option_ship_from[''] = '';
		$option_ship_from['Singapore'] = 'Singapore';
		$option_ship_from['Indonesia'] = 'Indonesia';

		echo form_dropdown('shipment_from', $option_ship_from, $shipment_from, $extra_ship_from);
		?>
	</div>
</div>

<div class="form-group ">
	<label class="col-md-3 control-label" for="varchar">To</label>
	<div class="col-md-9">											
		<?php 
			$extra_port = 'id="shipment_to" class="form-control" onchange="change_destination()"';
			$option_port[''] = '';
			foreach($cbo_port as $r):
				$country_name = ($r->country_idn != 0) ? " - $r->country_name" : "";
				$option_port[$r->port_id.'|'.$r->country_id] = $r->port_name.$country_name;
			endforeach;
			echo form_dropdown('shipment_to', $option_port, $port_id.'|'.$destination_id, $extra_port);
		?>
			<input type="hidden" id="port_id" name="port_id" value="<?php echo $port_id ?>">
			<input type="hidden" id="destination_id" name="destination_id" value="<?php echo $destination_id ?>" >											
	</div>

	<script>
		function change_destination(){
			var arr_port_list = $('#shipment_to').val().split('|');

			$('#port_id').val(arr_port_list[0]);
			$('#destination_id').val(arr_port_list[1]);
		}
	</script>

</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">
		Shipment Term
	</label>
	<div class="col-md-9" id="trading_term_container">
		<?php
		$extra_tradingterm = 'class="form-control" ';
		$option_tradingterm[''] = '';
		foreach ($cbo_tradingterm as $r):
			$option_tradingterm[$r->trading_term_id] = $r->trading_term_name . ' (' . $r->trading_term_remark . ')';
		endforeach;
		echo form_dropdown('trading_term_id', $option_tradingterm, $trading_term_id, $extra_tradingterm);
		?>
	</div>
</div>

<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">ETD Singapore</label>
	<div class="col-md-9">
		<input type="text" class="form-control" name="etdsin" id="etdsin" value="<?php echo $etdsin ?>" />
	</div>
</div>

<script type="text/javascript">
    $('select').select2({
        allowClear: true
    });
</script>