<?php
if (!empty($currency)) {
    foreach ($currency as $ve) {
        ?>
        <div class="form-group">
            <label class="control-label col-md-3">Rate</label>
            <div class="col-md-3">
                <input type="text" id="rate_currency" name="rate_usd" class="form-control" value="<?php echo $ve->rate_usd; ?>" onkeyup="validasi_enter(event)"  onkeypress="return isNumber(event)" required />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3">SGD Rate</label>
            <div class="col-md-3">
                <input type="text" id="rate_sgd" name="rate_sgd" class="form-control" value="<?php echo $ve->rate_kurs; ?>"  onkeypress="return isNumber(event)" required />
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-1">
                <input type="hidden" id="currency" name="currency" class="form-control" value="<?php echo $ve->currency_id; ?>"  onkeypress="return isNumber(event)" required/>
            </div>
        </div>
        <script>
            $(document).ready(function () {
            $('#btn-save').attr('disabled', false);
            });
        </script>
        <?php
    }
} else {
    ?>     
    <div class="form-group">
        <label class="control-label col-md-3">Rate</label>
        <div class="col-md-3">
            <input type="text" id="rate_currency" name="rate_header" value="0" class="form-control" onkeyup="validasi_enter(event)"  onkeypress="return isNumber(event)" required  />
        </div>
    </div>
    <div class="form-group">
        <label class="control-label col-md-3">SGD Rate</label>
        <div class="col-md-3">
            <input type="text" id="rate_sgd" name="rate_sgd" class="form-control" value="0" onkeypress="return isNumber(event)" required />
        </div>
    </div>

    <div class="form-group">
            <div class="col-md-3">
                <input type="hidden" id="currency" name="currency" class="form-control" value="<?php echo "" ?>"  onkeypress="return isNumber(event)" required/>
                
            </div>
    </div>
    <?php
}
?>
<script>
    $(document).ready(function () {
        var rate = document.getElementById('rate_currency').value;
        var cur_sgd = document.getElementById('rate_sgd').value;
        var cur_id = document.getElementById('currency').value;
        document.getElementById('currency_val').value = rate;        
        document.getElementById('rate_currency').value = rate;
        document.getElementById('rate_sgd').value = cur_sgd;
        document.getElementById('currency').value = cur_id;

        document.getElementById('jr_rate1').value = rate;
        document.getElementById('jr_rate2').value = rate;
        document.getElementById('jr_rate3').value = rate;
        document.getElementById('jr_rate4').value = rate;
        document.getElementById('jr_rate5').value = rate;
        document.getElementById('jr_rate6').value = rate;
        hitung_total();
        $(document).ready(function () {
        $('#btn-save').attr('disabled', false);
        });
    });
</script>