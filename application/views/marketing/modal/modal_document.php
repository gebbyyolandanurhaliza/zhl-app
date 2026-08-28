<form id="form_document" action="#" method="post" class="form-horizontal" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4>
			<i class="fa fa-pencil-square-o"></i>
			<?php
			if ($special_doc == 0){
				echo "New Document";
			} else {
				echo "New Special Document";
			}
			?>
		</h4>
	</div>
	
	<div class="modal-body">
		<div class="form-body">

			<div class="form-group required">
				<label class="col-md-3 control-label" for="varchar">Document Name</label>
				<div class="col-md-9">
					<input required type="text" class="form-control" name="document_name" id="document_name" value="<?php echo $document_name; ?>" />					
				</div>
			</div>

			<div class="form-group">
				<label class="col-md-3 control-label" for="varchar">Document Remark</label>
				<div class="col-md-9">
					<input type="text" class="form-control" name="document_remark" id="document_remark" value="<?php echo $document_remark; ?>" />
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal-footer">
		<div class="form-actions">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="document_id" value="<?php echo $document_id; ?>" />
					<button type="button" data-dismiss="modal" class="btn green" id="btn_simpan"><?php echo $button ?></button>
					<button type="reset" data-dismiss="modal" class="btn red">Cancel</button>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	$('#btn_simpan').on('click',function(){		
		var special_doc = <?php echo $special_doc ?>;
		var doc_name = $('#document_name').val();
		$.ajax({
			type: "POST",
			url	: "<?php echo site_url('marketing/save_master_document_modal/'.$special_doc);?>",
			data: $('#form_document').serialize(),			
			success : function(data){
				if (data){
					if (special_doc == 0){
						$('#list-document > tbody:last-child').append(data);		
					} else {
						$('#list-document-special > tbody:last-child').append(data);
					}
				} else {
					$.bootstrapGrowl('<strong><i class="fa fa-warning"></i> Document "'+doc_name+'" Already exists!</strong>', {
						ele: 'body', // which element to append to
						type: 'danger', // (null, 'info', 'danger', 'success', 'warning')
						offset: {
							from: 'top',
							amount: 250
						}, // 'top', or 'bottom'
						align: 'center', // ('left', 'right', or 'center')
						width: 'auto', // (integer, or 'auto')
						delay: 5000, // Time while the message will be displayed. It's not equivalent to the *demo* timeOut!
						allow_dismiss: true, // If true then will display a cross to close the popup.
						stackup_spacing: 15 // spacing between consecutively stacked growls.
					});
				}
			}
		});
	});
</script>