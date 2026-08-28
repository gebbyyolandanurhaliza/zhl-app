<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4>
		<i class="fa fa-pencil-square-o"></i>
		Consignee for <strong><?php echo $customer_name ?></strong>
	</h4>
</div>

<div class="modal-body">
	<div class="table-scrollable-borderless">
		
		<table id="tbl_prev_consignee" class="table table-bordered">
			<thead>
				<tr>
					<th>Consignee</th>
				</tr>
			</thead>
			<tbody>
				<?php
                if (!empty($rec_prev)){
                    $consignee_sebelum = '';
                    foreach ($rec_prev as $rec) {
                        if (strtoupper(trim($consignee_sebelum)) != strtoupper(trim($rec->consignee))){
                            echo "<tr onclick='select_consignee(this)' style='cursor: pointer;' title='Click to Select'>";
                            echo "<td>$rec->consignee";
        //					echo "<textarea readonly row='3' style='cursor: pointer;' class='form-control input-xs input-table autosizeme'>$rec->remark</textarea>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        $consignee_sebelum = $rec->consignee;
                    }
                } else {
                    echo "<tr><td>No Previous Consignee</td></tr>";
                }
				?>
			</tbody>
		</table>

	</div>
	<label class="control-label">Selected Consignee :</label>
	<textarea rows="5" style="width: 100%;" class="form-control autosizeme" id="selected_consignee"></textarea>
</div>

<div class="modal-footer">
	<div class="form-actions">
		<div class="row">
			<div class="col-md-12">
				<!--<input type="button" id="btn_append_consignee" class="btn green" value="Append Consignee">--> 
				<input type="button" id="btn_use_consignee" class="btn green" value="Use Consignee" > 
				<button type="reset" data-dismiss="modal" class="btn red">Close</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$('#tbl_prev_consignee').dataTable({
		"bLengthChange": false,
	});
</script>

<script>
	
	function select_consignee(ind){
		 function getText(el){
            if (typeof el.textContent == 'string') return el.textContent;
            if (typeof el.innerText == 'string') return el.innerText;
        }

        $r = ind.rowIndex;
        document.getElementById('selected_consignee').value = getText(document.getElementById('tbl_prev_consignee').rows[$r].cells[0]);
	}
	
//	$('#btn_append_consignee').click(function(){
//		var sel_rem = $('#selected_consignee').val();
//		if (sel_rem == ''){
//			bootbox.alert('Consignee are empty!');
//			return false;
//		};
//		$('#consignee').append('\n');
//		$('#consignee').append($('#selected_remark').val());		
//		$('#modal_consignee').modal('hide');
//	});
	
	$('#btn_use_consignee').click(function(){
		var sel_rem = $('#selected_consignee').val();
		if (sel_rem == ''){
			bootbox.alert('Consignee are empty!');
			return false;
		};
		
		document.getElementById('consignee').value = sel_rem;
		
//		$('#consignee').text(sel_rem);	// fungi .text ini gak mau jalan...
//		$('#remark').append('\n');		
		$('#modal_consignee').modal('hide');
	});
</script>