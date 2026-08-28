<td class="text-center" style="vertical-align: middle;">3</td>
<td nowrap><input value="Cash" name="txtRemarkDetail[]" class="txt" readonly/></td>
<td nowrap><input id="inputTotalLastRow" value="<?php echo $_totalAmount;?>" name="txtTotalDetal[]" class="txt txtnum"/></td>
<td nowrap><input id="inputEquiLastRow" name="txtEquiDetail[]" class="txt txtnum"/></td>
<td nowrap><select class="txt" name="txtCurrDetail[]" id="inCurLastRow">
        <option value="">Choose...</option>
        <?php foreach ($_selectCurrency as $row): ?>
            <option value="<?php echo $row->currency_symbol; ?>"><?php echo $row->currency_id; ?></option>
        <?php endforeach; ?>
    </select></td>
<td nowrap><input value="<?php echo $_getMasterCOA->NoCOA;?>" name="txtCOADetail[]" class="txt" readonly/></td>
<td nowrap>
    <input name="txtCFDetail[]" class="txt" id="cf-row-3" onclick="viewModalCashFlow(this.id)" readonly/>
    <input name="txtCFKeyDetail[]" type="hidden" class="txt" id="cf-row-3-key" readonly/>
</td>