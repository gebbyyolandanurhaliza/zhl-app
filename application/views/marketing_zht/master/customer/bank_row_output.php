<tr>
	<td class="bg-editable"><input type="button" class="btn default red-stripe" onclick="removeBank(this)" value="Remove Bank"></td>
	<td class="bg-editable">
		<?php
		$extra_bank = 'id= "bank_id" class="form-control"';
		$option_bank[''] = '';
		if ($cbo_bank) {
			foreach ($cbo_bank as $r):
				$option_bank[$r->bank_id] = $r->bank_name;
			endforeach;
		}
		echo form_dropdown('bank_id[]', $option_bank, $bank_id, $extra_bank);
		?>
	</td>
</tr>

<script type="text/javascript">
	$('select').select2({
		allowClear	: true
	});
</script>
