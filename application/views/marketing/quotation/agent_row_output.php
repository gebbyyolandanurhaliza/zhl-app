<tr>
	<td class="bg-editable"><input type="button" class="btn default red-stripe" onclick="removeRow(this)" value="Remove"></td>
	<td class="bg-editable">
		<?php 
			$extra_agent = 'id= "agent_id" class="form-control"';
			$option_agent[''] = '';
			if ($cbo_agent){
				foreach($cbo_agent as $r):
					$option_agent[$r->agent_id] = $r->agent_name;													
				endforeach;
			}
			echo form_dropdown('agent_id[]', $option_agent, $agent_id, $extra_agent);
		?>
	</td>
	<td class="bg-editable">
		<input type="text" class="form-control autonum_com_percent text-right"  onkeyup="agent_percent()" name="agent_com_percent[]" id="agent_com_percent" data-a-sign=" %" data-p-sign="s" data-v-max="100" placeholder="0.00 %" value=""/>
	</td>
	<td class="bg-editable">
		<input type="text" class="form-control autonum_com_unit text-right"  onkeyup="agent_unit()" name="agent_com_unit[]" id="agent_com_unit" data-p-sign="s" placeholder="0.00" value=""/>
	</td>
	<td class="bg-editable text-center">		
		<?php echo form_checkbox('agent_invoice[]', '1', false) ?>
	</td>
	
</tr>

<script type="text/javascript">
	$('select').select2({
		allowClear	: true
	});
	
	$('.autonum_com_percent').autoNumeric('init',{
		aSign	: ' %',		
		pSign	: 's'		//suffix to the right
	});
	
	$('.autonum_com_unit').autoNumeric('init',{
		pSign	: 's'
	});
</script>

