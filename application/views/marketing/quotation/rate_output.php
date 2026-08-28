<div class="col-md-3">												
	<div id="div_rate_usd" class="input-group">		
		<span class='input-group-addon'>US$</span>
		<input required type="text" rate-set="<?php echo $rate_is_set ?>" class="form-control text-right autofocus" name="rate_usd" id="rate_usd" placeholder="0.000000" value="<?php echo $rate_usd; ?>" title="6 digits decimal" />
		
	</div>
</div>
<div class="col-md-3">
	<div id="div_rate_sgd" class="input-group">
		<span class='input-group-addon'>SIN$</span>
		<input required type="text" class="form-control text-right autofocus" name="rate_sgd" id="rate_sgd" placeholder="0.000000" value="<?php echo $rate_sgd; ?>" title="6 digits decimal" />
	</div>
</div>

<script type="text/javascript">
	//select all text on focused
	$('.autofocus').on('click', function(){
		this.select();
	});
	
	$('#rate_usd').autoNumeric('init',{
		mDec	: 6
	});
	
	$('#rate_sgd').autoNumeric('init',{
		mDec	: 6
	});
</script>