<tr>
    <td class="text-center" style="vertical-align: middle;">1</td>
    <td nowrap><input value="Charge" name="txtRemarkDetail[]" class="txt" readonly/></td>
    <td nowrap><input value="<?php echo number_format($_getTotal, 2); ?>" name="txtTotalDetal[]" id="inputAmountRow1" class="txt txtnum" readonly/></td>
    <td nowrap><input value="<?php echo number_format(number_format($_getFaktur->Rate, 2)*$_getTotal, 2);?>" name="txtEquiDetail[]" id="inputUSDRow1" class="txt txtnum" readonly/></td>
    <td nowrap><select class="txt read-only" name="txtCurrDetail[]" id="inCurFirstRow">
            <option value="">Choose...</option>
            <?php foreach ($_selectCurrency as $row): ?>
                <?php if($_getFaktur->CurrencyID == $row->currency_id): ?>
                    <option value="<?php echo $row->currency_id; ?>" selected><?php echo $row->currency_id; ?></option>
                <?php else: ?>
                    <option value="<?php echo $row->currency_id; ?>"><?php echo $row->currency_id; ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select></td>
    <td nowrap><input value="<?php echo $_getCOAsupp;?>" name="txtCOADetail[]" class="txt" readonly/></td>
    <td nowrap>
        <input name="txtCFDetail[]" class="txt" id="cf-row-1" onclick="viewModalCashFlow(this.id)" readonly/>
        <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-1-key" readonly/>
    </td>
</tr>
<tr>
    <td class="text-center" style="vertical-align: middle;">2</td>
    <td nowrap><input value="Exchange Rate Gap" name="txtRemarkDetail[]" class="txt" readonly/></td>
    <td nowrap><input name="txtTotalDetal[]" class="txt txtnum" readonly/></td>
    <td nowrap><input id="inputEquiSelisih" name="txtEquiDetail[]" class="txt txtnum" readonly/></td>
    <td nowrap><select class="txt read-only" name="txtCurrDetail[]">
            <option value="">Choose...</option>
            <?php foreach ($_selectCurrency as $row): ?>
            <option value="<?php echo $row->currency_id; ?>" <?php if($row->currency_id == $_getFaktur->CurrencyID) echo 'selected';?>><?php echo $row->currency_id; ?></option>
            <?php endforeach; ?>
        </select></td>
    <td nowrap><input name="txtCOADetail[]" class="txt" readonly/></td>
    <td nowrap>
        <input name="txtCFDetail[]" class="txt" id="cf-row-2" onclick="viewModalCashFlow(this.id)" readonly/>
        <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-2-key" readonly/>
    </td>
</tr>
<tr id="rowCashBank">
    <td class="text-center" style="vertical-align: middle;">3</td>
    <td nowrap><input value="Cash" name="txtRemarkDetail[]" class="txt" readonly/></td>
    <td nowrap><input name="txtTotalDetal[]" class="txt"/></td>
    <td nowrap><input name="txtEquiDetail[]" class="txt"/></td>
    <td nowrap><select class="txt" name="txtCurrDetail[]">
            <option value="">Choose...</option>
            <?php foreach ($_selectCurrency as $row): ?>
                <option value="<?php echo $row->currency_id; ?>"><?php echo $row->currency_id; ?></option>
            <?php endforeach; ?>
        </select></td>
    <td nowrap><input name="txtCOADetail[]" class="txt" readonly/></td>
    <td nowrap>
        <input name="txtCFDetail[]" class="txt" id="cf-row-3" onclick="viewModalCashFlow(this.id)" readonly/>
        <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-3-key" readonly/>
    </td>
</tr>

<script src="<?php echo base_url();?>assets/global/jq/numToWord.js"></script>
<script>
    $(".read-only :selected").each(function() {
        $(this).parent().data("default", this);
    });
    $(".read-only").change(function(e) {
        $($(this).data("default")).prop("selected", true);
    });
    
    
    
    $(document).ready(function() {
        var numAmount   = document.getElementById('inputUSDRow1').value;
        var toWord      = toWords(numAmount);
        //alert(capitalize(toWord));
        document.getElementById('amountTerbilang').value = 'In Word: United States Dollar '+capitalize(toWord);
        
        function capitalize(s) {
            return s[0].toUpperCase() + s.substr(1);
        }
    });
</script>