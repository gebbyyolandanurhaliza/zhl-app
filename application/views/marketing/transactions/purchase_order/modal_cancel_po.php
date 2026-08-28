
<form id="form_cancel_po" action="#" method="post" class="form-horizontal" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4>
			<i class="fa fa-pencil-square-o"></i>
			CANCEL PO - REMARK
		</h4>
	</div>
	<div class="modal-body">
		<div class="form-body">								
			<div class="form-group required">
                <div class="well">
                    Are you sure want to cancel the PO?
                    If <strong>YES</strong>, please fill the reason below!.
                </div>
				<!--<label class="col-md-3 control-label" for="varchar">Remark</label>-->
				<div class="col-md-12">
					<input required type="text" class="form-control" name="cancel_po_remark" id="cancel_po_remark" value="<?php echo $cancel_po_remark; ?>" Placeholder='PO Canceling Reason' />
				</div>
			</div>

		</div>
	</div>
	<div class="modal-footer">
		<div class="form-actions">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="po_hdr_id" value="<?php echo $po_hdr_id; ?>" /> 
					<button type="button" data-dismiss="modal" class="btn green" id="btn_update_cancel">OK</button> 
					<button type="reset" data-dismiss="modal" class="btn red">Close</button>	
				</div>
			</div>
		</div>
	</div>	

</form>

<script>
	$('#btn_update_cancel').on('click',function(){		
		$.ajax({
			type: "POST",
			url	: "<?php echo $action; ?>",
			data: $('#form_cancel_po').serialize(),
			success : function(){
				return location.href="<?php echo site_url('marketing_transaction/purchase_order/cancel_po_success');?>";
			}
		});
	});
</script>