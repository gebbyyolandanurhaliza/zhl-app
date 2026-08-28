<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Reff. Number</label>
            <div class="col-sm-8">
                <input value="<?php echo $_noReff;?>" type="text" id="txtJurNum" name="txtFacture" class="form-control input-sm" readonly/>
                <ul class="dropdown-menu txtJurNum" style="margin-left:15px;margin-right:0px; max-height: 300px; overflow-y: scroll;" role="menu" aria-labelledby="dropdownMenu"  id="ddJurNum"></ul>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Voucher number</label>
            <div class="col-sm-8">
                <input id="txtJurNum" value="<?php echo $_noAP;?>" style="background-color: #D2E0D1;" type="text" name="txtVoucher" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>

    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Trans Date</label>
            <div class="col-sm-8">
                <input value="<?php echo $_transDate;?>" name="txtTransDate" type="text" class="form-control input-sm" readonly/>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-4">Voucher Date</label>
            <div class="col-sm-8">
                <input value="<?php echo $_apDate;?>" name="txtVoucherDate" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd" readonly/>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Supplier</label>
            <div class="col-sm-8">
                <input value="<?php echo $_suppID;?>" type="text" name="txtSuplierID" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="form-group">
            <label class="control-label col-sm-2">Voucher Remark</label>
            <div class="col-sm-10">
                <input value="<?php echo $_remarks;?>" type="text" name="txtSuplierRemark" class="form-control input-sm" readonly/>
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
                </select>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Voucher Rate</label>
            <div class="col-sm-8">
                <input value="<?php echo $_balace;?>" name="txtRateVoucher" type="text" class="form-control input-sm date-picker" data-date-format="yyyy-mm-dd" readonly/>
            </div>
        </div>
    </div>
</div>

<div class="col-md-12">
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">Amount</label>
            <div class="col-sm-8">
                <input value="<?php echo $_total;?>" type="text" id="inputTotalVoucher" name="txtTotalVoucher" class="form-control input-sm" readonly/>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
            <label class="control-label col-sm-4">to USD</label>
            <div class="col-sm-8">
                <input value="<?php echo $_toUSD;?>" type="text" name="txtRateSGD" class="form-control input-sm" readonly/>
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