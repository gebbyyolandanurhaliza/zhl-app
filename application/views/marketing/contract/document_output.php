<table id="list-document" class="doc-table">
	<tbody>
		<?php														
		if ($list_document){
			$i = 0;
			foreach($list_document as $doc){
				$checked = false;
				if ($selected_document){
					foreach ($selected_document as $sd){
						if ($sd->document_id == $doc->document_id){
							$checked = true;
						}
					}
				}

				$i++;
				echo "<tr>";
				echo "<td>";
				echo form_checkbox('doc[]', $doc->document_id, $checked);
				echo "</td>";
				echo "<td>$doc->document_name</td>";																
				echo "</tr>";
			}
		}
		?>
	</tbody>
</table>

<script>
	$('input:checkbox').uniform();
</script>