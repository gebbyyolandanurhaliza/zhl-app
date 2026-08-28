
<tr>
	<td>
		<?php
		echo form_checkbox('doc[]', $doc_id, $checked);
		?>
	</td>
	<td>
		<?php echo $doc_name ?>
		<span class="text text-danger"> *</span>
	</td>
</tr>

<script>
	$('input:checkbox').uniform();
</script>