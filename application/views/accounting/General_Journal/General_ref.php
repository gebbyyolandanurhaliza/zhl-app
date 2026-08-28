<div class="form-group">
    <label class="control-label col-md-3">Reff. Number</label>
    <div class="col-md-9">
        <input type="text" id="refno" name="refno" onchange="ambil_tabel()" value="<?php echo "$_reff"; ?>" onkeypress="return valid_enter(event)" class="form-control" required readonly/>
        <label class="CurID"></label>
    </div>
</div>