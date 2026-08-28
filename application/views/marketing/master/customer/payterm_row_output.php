<tr>
	<td class="bg-editable"><input type="button" class="btn default red-stripe" onclick="removePayterm(this)" value="Remove Payment Term"></td>
	<td class="bg-editable">
		<?php
		$extra_payterm = 'id= "payment_term_id" class="form-control"';
		$option_payterm[''] = '';
		if ($cbo_payterm) {
			foreach ($cbo_payterm as $r):
				$option_payterm[$r->payment_term_id] = $r->payment_term;
			endforeach;
		}
		echo form_dropdown('payment_term_id[]', $option_payterm, $payment_term_id, $extra_payterm);
		?>
	</td>
</tr>

<script type="text/javascript">
	$('select').select2({
		allowClear	: true
	});
</script>