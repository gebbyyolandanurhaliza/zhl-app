<div class="form-group">
	<label class="col-md-3 control-label" for="varchar">Agent</label>
	<div class="col-md-5">
		<?php 
			$extra_agent = 'id= "agent_id" class="form-control select2me"';
			$option_agent[''] = '';
			if ($cbo_agent){
				foreach($cbo_agent as $r):
					$option_agent[$r->agent_id] = $r->agent_name;													
				endforeach;
			}
			echo form_dropdown('agent_id', $option_agent, $agent_id, $extra_agent);
		?>
	</div>
</div>

<script>
	$('#agent_id').select2({
		allowClear : true
	});
</script>