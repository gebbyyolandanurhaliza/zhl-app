<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4>
		<i class="fa fa-pencil-square-o"></i>
		Notify Party for <strong><?php echo $customer_name ?></strong>
	</h4>
</div>

<div class="modal-body">
	<div class="row">
		<div class="col-md-12">
			<div class="table-scrollable-borderless">
				<table id="tbl_prev_notify_party" class="table table-bordered">
					<thead>
						<tr>
							<th>Notify Party</th>
							<th>Remark</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if (!empty($rec_prev)){
                            $np_sebelum = '';
							foreach ($rec_prev as $rec) {
                                if (strtoupper(trim($np_sebelum)) != strtoupper(trim($rec->notify_party))){
                                    if ($rec->notify_party){
                                        echo "<tr onclick='select_notify_party(this)' style='cursor: pointer;' title='Click to Select'>";
                                        echo "<td>$rec->notify_party</td>";
                                        echo "<td>$rec->remark</td>";
                                        echo "</tr>";
                                    }
                                }
                                $np_sebelum = $rec->notify_party;
							}
						} else {
							echo "<tr><td colspan='2'>No Previous Notify Party</td></tr>";
						}
						?>
					</tbody>
				</table>
			</div>	
		</div>
		
		<!--<div class="col-md-12">-->
			<div class="col-md-12">
				<label class="control-label">Selected Notify Party :</label>				
				<textarea rows="3" style="width: 100%;" class="form-control autosizeme" id="selected_notify_party"></textarea>
			</div>
		
<!--			<div class="col-md-6">
				<label class="control-label">Selected Notify Party 1 :</label>				
				<textarea rows="3" style="width: 100%;" class="form-control autosizeme" id="selected_notify_party1"></textarea>
			</div>

			<div class="col-md-6">
				<label class="control-label">Selected Notify Party 2 :</label>
				<textarea rows="3" style="width: 100%;" class="form-control autosizeme" id="selected_notify_party2"></textarea>
			</div>-->
		<!--</div>-->
	</div>
</div>

<div class="modal-footer">
	<div class="form-actions">
		<div class="row">
			<div class="col-md-12">
				<!--<input type="button" id="btn_append_consignee" class="btn green" value="Append Consignee">--> 
				<input type="button" id="btn_use_notify_party1" class="btn green pull-left" value="Use As Notify Party 1" > 
				<input type="button" id="btn_use_notify_party2" class="btn green pull-left" value="Use As Notify Party 2" > 
				<!--<input type="button" id="btn_use_notify_party_all" class="btn purple-seance" value="Use All Notify Party" >--> 
				<button type="reset" data-dismiss="modal" class="btn red">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#tbl_prev_notify_party').dataTable({
		"bLengthChange": false,
	});
</script>

<script>
	
	function select_notify_party(idx){
		 function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        $r = idx.rowIndex;
		document.getElementById('selected_notify_party').value = getText(document.getElementById('tbl_prev_notify_party').rows[$r].cells[0]);
//        document.getElementById('selected_notify_party1').value = getText(document.getElementById('tbl_prev_notify_party').rows[$r].cells[0]);
//		document.getElementById('selected_notify_party2').value = getText(document.getElementById('tbl_prev_notify_party').rows[$r].cells[1]);
	}

	$('#btn_use_notify_party1').click(function(){
		var sel_rem = $('#selected_notify_party').val();
		if (sel_rem == ''){
			bootbox.alert('Selected Notify Party are empty!');
			return false;
		};
		$('#notify_party1').text($('#selected_notify_party').val());
		$('#modal_notify_party').modal('hide');
	});
	
	$('#btn_use_notify_party2').click(function(){
		var sel_rem = $('#selected_notify_party').val();
		if (sel_rem == ''){
			bootbox.alert('Selected Notify Party are empty!');
			return false;
		};
		$('#notify_party2').text($('#selected_notify_party').val());
		$('#modal_notify_party').modal('hide');
	});
	
//	$('#btn_use_notify_party_all').click(function(){
//		var sel_rem1 = $('#selected_notify_party1').val();
//		var sel_rem2 = $('#selected_notify_party2').val();
//		
//		if (sel_rem1 == '' && sel_rem2 == ''){
//			bootbox.alert('All Selected Notify Party are empty!');
//			return false;
//		};
//		$('#notify_party1').text($('#selected_notify_party1').val());
//		$('#notify_party2').text($('#selected_notify_party2').val());
//		$('#modal_notify_party').modal('hide');
//	});
</script>