<div class='col-md-10'>
	<select class='form-control' name='shipdate' id='shipdate'>
		<?php
		foreach ($ship as $r) :
			$sdate = new DateTime($r->shipmentdate);
			$tglship = date_format($sdate, 'd/m/Y');
		?>
			<option value="<?= $r->shipmentdate; ?>"><?= $tglship; ?></option>
		<?php endforeach; ?>
	</select>
</div>

<input type="hidden" id="id" name="id" value="<?= $id; ?>">
<input type="hidden" id="flag" name="flag" value="<?= $flag; ?>">
<input type="hidden" id="shipid" name="shipid" value="<?= $shipid; ?>">
<input type="hidden" id="etd" name="etd" value="<?= $etd; ?>">
<input type="hidden" id="desc" name="desc" value="<?= $desc; ?>">

<button type="button" class="col-md-2 btn blue" onclick="save_move_multiple()">MOVE</button>

<script type="text/javascript">
	$('#shipdate').select2();
</script>