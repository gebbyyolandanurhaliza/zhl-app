<?php foreach ($_getMasterCOA as $row): ?>
<td class="text-center" style="vertical-align: middle;">
    <button class="btn btn-xs btn-link biasa" type="button" ><i class="fa fa-arrow-down"></i></button></td>
<td nowrap><input type="text" name="txtNoCOA[]"  class="txt" value="<?php echo $row->NoCOA; ?>" readonly/></td>
<td nowrap><input type="text" name="txtNameCOA[]" class="txt" value="<?php echo $row->AccountName; ?>" readonly/></td>
<td nowrap><input type="number" name="txtDebit[]" onKeyup="calculateAmountDebit()" <?php if ($_getNoReff == 'O'){ echo 'readonly';}?> class="col-debit txt" /></td>
<td nowrap><input type="number" name="txtCredit[]" onKeyup="calculateAmountCredit()" <?php if ($_getNoReff != 'O'){ echo 'readonly';}?> class="col-credit txt"/></td>
<td nowrap><input type="text" name="txtRemark[]" class="txt"/></td>
<td nowrap>
    <input id="cf-1" type="text" name="txtCashFlow[]" onClick="viewModalCashFlow(this.id)" class="txt cf-text"/>
    <input id="cf-1-key" type="hidden" name="txtCashFlowKey[]" class="txt"/>
</td>
<?php endforeach;