<?php
$date = $thn . "-". $bln .'-'. $hari;
$newdate = date('Y-m', strtotime("-1 months", strtotime($date)));
$date2 = date('Y-m', strtotime("-1 days", strtotime($date)));
if (!empty($currency)) {
    foreach ($currency as $ve) {
        ?>
        
        <?php
    }
} else {
    ?>         
    <div class="form-group">
        <div class="alert alert-danger fade in">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            Rate Not Found!!!<br />
            Please, Call Accounting Department for Entering Rates for <?php echo $newdate ;?> to <?php echo $date2 ;?>
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