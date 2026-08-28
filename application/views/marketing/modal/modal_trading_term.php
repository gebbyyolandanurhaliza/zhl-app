<form id="form_trading_term" action="#" method="post" class="form-horizontal" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4>
			<i class="fa fa-pencil-square-o"></i>
			New Trading Terms
		</h4>
	</div>
	
	<div class="modal-body">
		<div class="form-body">
			<div class="form-group required">
				<label class="col-md-3 control-label" for="varchar">Trading Term</label>
				<div class="col-md-9">
					<input required type="text" class="form-control" name="trading_term_name" id="trading_term_name" value="<?php echo $trading_term_name; ?>" />
				</div>
			</div>

			<div class="form-group required">
				<label class="col-md-3 control-label" for="varchar">Remark</label>
				<div class="col-md-9">
					<input required type="text" class="form-control" name="trading_term_remark" id="trading_term_remark" value="<?php echo $trading_term_remark ?>" />
				</div>
			</div>
		</div>
	</div>
	
	<div class="modal-footer">
		<div class="form-actions">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="trading_term_id" value="<?php echo $trading_term_id; ?>">
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
			data: $('#form_trading_term').serialize(),
			success : function(msg){
				$('#trading_term_container').html(msg);
			}
		});
	});
</script>