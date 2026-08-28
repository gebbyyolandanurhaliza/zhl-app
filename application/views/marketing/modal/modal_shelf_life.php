
<form id="form_shelf_life" action="#" method="post" class="form-horizontal" role="form">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
		<h4>
			<i class="fa fa-pencil-square-o"></i>
			New Shelf Life
		</h4>
	</div>
	<div class="modal-body">
		<div class="form-body">								
			<div class="form-group required">
				<label class="col-md-3 control-label" for="varchar">Product Shelf Life</label>
				<div class="col-md-9">
					<input required type="text" class="form-control" name="shelf_life" id="shelf_life" value="<?php echo $shelf_life; ?>" />
				</div>
			</div>

		</div>
	</div>
	<div class="modal-footer">
		<div class="form-actions">
			<div class="row">
				<div class="col-md-12">
					<input type="hidden" name="shelf_life_id" value="<?php echo $shelf_life_id; ?>" /> 
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
			data: $('#form_shelf_life').serialize(),
			success : function(msg){
				$('#shelf_life_container').html(msg);
			}
		});
	});
</script>