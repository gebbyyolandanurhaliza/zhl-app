<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4>
		<i class="fa fa-pencil-square-o"></i>
		Marking On Long / Short Side
	</h4>
</div>

<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<div class="table-scrollable-borderless">
				<table id="tbl_prev_marking" class="table table-bordered">
					<thead>
						<tr>
							<th>Marking</th>
							<th>Side</th>
							<th>Long/Short</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($rec_prev)){
							foreach ($rec_prev as $rec) {
								if ($rec->marking){
									echo "<tr onclick='select_marking(this)' style='cursor: pointer;' title='Click to Select'>";
									echo "<td>$rec->side</td>";									
									echo "<td>$rec->side_count</td>";
									echo "<td>$rec->marking</td>";
									echo "</tr>";
								}
							}
//						} else {
//							echo "<tr><td colspan='3'>No Marking History</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>	
		</div>
		
		<div class="col-md-12">
			<label class="control-label">Selected Marking :</label>
			<div class="input-group">
				<!--<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix" id="selected_label_marking"></span>-->
				<input class="form-control text-right" id="selected_marking_side">
				<span class="input-group-addon input-table-group-addon bootstrap-touchspin-postfix">side</span>
			</div>
			<textarea rows="3" style="width: 100%;" class="form-control autosizeme" id="selected_marking"></textarea>
		</div>
	</div>
</div>

<div class="modal-footer">
	<div class="form-actions">
		<div class="row">
			<div class="col-md-12">
				<input type="button" idx="<?php echo $idx ?>" id="btn_use_marking_long" class="btn green pull-left" value="Use As Marking Long Side"> 
				<input type="button" idx="<?php echo $idx ?>" id="btn_use_marking_short" class="btn green pull-left" value="Use As Marking Short Side"> 
				<button type="reset" data-dismiss="modal" class="btn red">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#tbl_prev_marking').dataTable({
		"bLengthChange": false,
	});
</script>

<script>
	
	function select_marking(idx){
		 function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        $r = idx.rowIndex;
//		document.getElementById('selected_label_marking').value = 'Selected Marking : '+getText(document.getElementById('tbl_prev_marking').rows[$r].cells[0]);
		document.getElementById('selected_marking_side').value= getText(document.getElementById('tbl_prev_marking').rows[$r].cells[1]);
		document.getElementById('selected_marking').value = getText(document.getElementById('tbl_prev_marking').rows[$r].cells[2]);
		
	}
	
	

	$('#btn_use_marking_long').click(function(){
		var idx = $(this).attr('idx');
		var sel_mark = $('#selected_marking').val();
		var sel_mark_side = $('#selected_marking_side').val();
		if (sel_mark === '' && sel_mark_side === ''){
			bootbox.alert('Selected marking are empty!');
			return false;
		};
		$('#ls-'+idx).val($('#selected_marking_side').val());
		$('#lm-'+idx).text($('#selected_marking').val());
		$('#modal_marking').modal('hide');		
		
	});
	
	$('#btn_use_marking_short').click(function(){
		var idx = $(this).attr('idx');
		var sel_mark = $('#selected_marking').val();
		var sel_mark_side = $('#selected_marking_side').val();
		if (sel_mark === '' && sel_mark_side === ''){
			bootbox.alert('Selected marking are empty!');
			return false;
		};
		$('#ss-'+idx).val($('#selected_marking_side').val());
		$('#sm-'+idx).text($('#selected_marking').val());
		$('#modal_marking').modal('hide');
	});
</script>