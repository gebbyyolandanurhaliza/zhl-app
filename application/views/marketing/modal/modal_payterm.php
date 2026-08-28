<form id="form_payterm" action="#" method="post" class="form-horizontal" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4>
			<i class="fa fa-pencil-square-o"></i>
			New Payment Terms
		</h4>
	</div>
	<div class="modal-body">
		<div class="form-body">								
			<div class="form-group required">
				<label class="col-md-3 control-label" for="varchar">Payment Term</label>
				<div class="col-md-9">
					<input required type="text" class="form-control" name="payment_term" id="payment_term" value="<?php echo $payment_term; ?>" />
				</div>
			</div>

		</div>
	</div>
	<div class="modal-footer">
		<div class="form-actions">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" /> 
					<button type="button" data-dismiss="modal" class="btn green" id="btn_simpan"><?php echo $button ?></button> 
					<button type="reset" data-dismiss="modal" class="btn red">Cancel</button>	
				</div>
			</div>
		</div>
	</div>	

</form>

<script>
	$('#btn_simpan').on('click',function(){		
		$.ajax({
			type: "POST",
			url	: "<?php echo $action; ?>",
			data: $('#form_payterm').serialize(),
			success : function(msg){
				$('#payterm_container').html(msg);
			}
		});
	});
</script>