<!--<div class="modal-body">
	<textarea rows="8" class="form-control autosizeme" name="pre_remark" id="pre_remark"><?php // echo empty($pre_remark) ? '' : $pre_remark ?></textarea>
</div>-->

<div class="modal-body">
	
	<div class="table-scrollable-borderless">
		<table id="tbl_previous" class="table table-bordered">
			<thead>
				<tr>
					<th style="width: 150px;">PO Number</th>
					<th>Remarks</th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ($rec_prev as $rec) {
					echo "<tr onclick='select_remark(this)' style='cursor: pointer;' title='Click to Select'>";
					echo "<td class='text-center' style='width:120px;'>$rec->po_number";
//					echo "<input readonly='readonly' style='cursor: pointer;' class='form-control input-xs input-table' value=>";
					echo "</td>";
					echo "<td>$rec->remark";
//					echo "<textarea readonly row='3' style='cursor: pointer;' class='form-control input-xs input-table autosizeme'>$rec->remark</textarea>";
					echo "</td>";
					echo "</tr>";
				}
				?>
			</tbody>
		</table>

	</div>
	<label class="control-label">Selected Remark :</label>
	<textarea rows="5" style="width: 100%;" class="form-control autosizeme" id="selected_remark"></textarea>
		
</div>

<script type="text/javascript">
	$('#tbl_previous').dataTable({
		"bLengthChange": false,
	});
</script>