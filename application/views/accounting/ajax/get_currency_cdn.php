<?php
if (!empty($currency)) {
    foreach ($currency as $ve) {
?>
        <label class="control-label col-md-1">Rate</label>
        <div class="col-md-2">
            <input type="text" id="rate_currency" name="rate" value="<?php echo $ve->rate_usd; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" />
        </div>
        <label class="control-label col-md-2">Rate SGD</label>
        <div class="col-md-2">
            <input type="text" id="rate_sgd" name="rate_sgd" value="<?php echo $ve->rate_kurs; ?>" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" />
        </div>
    <?php
    }
} else {
    ?>
    <label class="control-label col-md-1">Rate</label>
    <div class="col-md-2">
        <input type="text" id="rate_currency" name="rate" value="0" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" />
    </div>
    <label class="control-label col-md-2">Rate SGD</label>
    <div class="col-md-2">
        <input type="text" id="rate_sgd" name="rate_sgd" value="0" onkeyup="return isNumber(event)" class="form-control" onkeypress="return valid_enter(event)" />
    </div>
<?php
}
?>