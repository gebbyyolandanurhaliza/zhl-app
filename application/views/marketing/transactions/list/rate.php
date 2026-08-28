<div class="form-group required">
	<label class="col-md-3 control-label" for="varchar">Rate to USD</label>
	<div class="col-md-3">		
		<input required type="text" class="form-control text-right" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
	</div>
</div>

<div class="form-group required">
	<label class="col-md-3 control-label" for="varchar">Rate to SGD</label>
	<div class="col-md-3">
		<input required type="text" class="form-control text-right" name="rate_sgd" id="rate_sgd" placeholder="0.000000" value="<?php echo $rate_sgd; ?>" title="6 digits decimal" />
	</div>
</div>

<script type="text/javascript">
	$('#rate_usd').autoNumeric('init',{
		mDec	: 6
	});
	
	$('#rate_sgd').autoNumeric('init',{
		mDec	: 6
	});
</script>