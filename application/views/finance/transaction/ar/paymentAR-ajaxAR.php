<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Reff. Number</label>
            <div class="col-sm-8">
                <input value="<?php echo $_setNoAP;?>" type="text" id="txtJurNum" name="txtFacture" class="form-control input-sm" readonly/>
                <ul class="dropdown-menu txtJurNum" style="margin-left:15px;margin-right:0px; max-height: 300px; overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu"  id="ddJurNum"></ul>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Voucher number</label>
            <div class="col-sm-8">
                <input value="<?php echo $_getFaktur->NomorAR;?>" style="background-color: #D2E0D1;" type="text" name="txtVoucher" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Trans Date</label>
            <div class="col-sm-8">
                <input value="<?php echo date('Y-m-d');?>" name="txtTransDate" type="text" class="form-control input-sm" readonly/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Voucher Date</label>
            <div class="col-sm-8">
                <input value="<?php echo date('Y-m-d', strtotime($_getFaktur->Tanggal));?>" name="txtVoucherDate" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd" readonly/>
            </div>
        </div>
    </div>
    
</div>

<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Customer</label>
            <div class="col-sm-8">
                <input value="<?php echo $_getFaktur->SupplierID;?>" type="text" name="txtSuplierID" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <label class="control-label col-sm-2">Voucher Remark</label>
            <div class="col-sm-10">
                <input value="<?php echo $_getFaktur->Remarks;?>" type="text" name="txtSuplierRemark" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Voucher Currency</label>
            <div class="col-sm-8">
                <select class="form-control input-sm" name="selCurrencyVoucher" >
                    <option value=""></option>
                    <?php foreach ($_selectCurrency as $row): ?>
                        <?php if($_getFaktur->CurrencyID == $row->currency_id): ?>
                            <option value="<?php echo $row->currency_id; ?>" selected><?php echo $row->currency_id; ?></option>
                        <?php else: ?>
                            <option value="<?php echo $row->currency_id; ?>"><?php echo $row->currency_id; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Voucher Rate</label>
            <div class="col-sm-8">
                <input value="<?php echo $_getFaktur->Rate;?>" name="txtRateVoucher" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd" readonly/>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Amount</label>
            <div class="col-sm-8">
                <input value="<?php echo number_format($_getTotal, 2);?>" type="text" id="inputTotalVoucher" name="txtTotalVoucher" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">to USD</label>
            <div class="col-sm-8">
                <input value="<?php echo number_format($_getRateSGD*$_getTotal, 2);?>" type="text" name="txtRateSGD" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>
</div>
<script>
    $("select :selected").each(function() {
        $(this).parent().data("default", this);
    });
    $("select").change(function(e) {
        $($(this).data("default")).prop("selected", true);
    });
</script>