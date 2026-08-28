<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Currency</label>
            <div class="col-sm-8">
                <select class="form-control input-sm" name="txtCurrBayar" id="txtCUR2" onchange="changeCur(this.value)" style="background-color: #D2E0D1;">
                    <option value=""></option>
                    <?php foreach ($_selectCurrency as $row): ?>
                        <?php if($row->currency_symbol == $_selected): ?>
                            <option value="<?php echo $row->currency_symbol; ?>" selected><?php echo $row->currency_id; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
                        <?php endif; ?>
                        
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Weekly Rate</label>
            <div class="col-sm-8">
                <input id="txtInputRateWeekly" type="text" value="<?php echo number_format($_getKurs->rate_usd, 2);?>" name="txtRateBayar" class="form-control input-sm" required/>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Rate Negotiation</label>
            <div class="col-sm-8">
                <input type="text" value="<?php echo number_format($_getKurs->rate_usd, 2);?>" name="txtRateNego" class="form-control input-sm" required/>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Rate Equivalent</label>
            <div class="col-sm-8">
                <input type="text" value="0" name="txtRateEqui" class="form-control input-sm" required/>
            </div>
        </div>
    </div>
</div>
<script>
    function changeCur(val){
        //var val = $(this).val();
        bootbox.alert('You choose the currency, '+val);
        $.ajax({
            url:"<?php echo site_url('Transaction_CashBank/ajaxSetAPFormCurrency');?>",
            type:"POST",
            data:"curID="+val,
            datatype:"json",
            cache:false,
            success:function(msg){
                $("#ajax-formCurrency").html(msg);
            }				
        });
        
        document.getElementById('inCurLastRow').value = val;
    }
</script>
<script>
    $(document).ready(function() {
        var val     = $('#inputTotalLastRow').val();
        var rate    = $('#txtInputRateWeekly').val();
        var equi1   = $('#inputUSDRow1').val();
        var total   = parseFloat(val.replace(/,/g, ""));
        var equiR   = parseFloat(equi1.replace(/,/g, ""));
        var hasil   = total*parseFloat(rate);
        var selisih = hasil-equiR;
        //alert(equiR-total);
        $('#inputEquiLastRow').val(addCommas(hasil.toFixed(2)));
        $('#inputEquiSelisih').val(addCommas(selisih.toFixed(2)));
    });
    
    function addCommas(nStr) {
        nStr += '';
        x = nStr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }

</script>