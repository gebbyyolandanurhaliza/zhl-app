<?php foreach ($npbb_temp as $r){ ?>
    <div class="form-group" style="margin-bottom:1px;">
        <label class="col-md-3 label-sm">Date</label>
        <div class="col-md-4">
            <input  class="form-control input-sm date date-picker" name="transdate" data-date="02-12-2012" data-date-format="dd-mm-yyyy" value="<?php echo date("d-m-Y", strtotime($r->transdate)); ?>" required>
        </div>
    </div>
    <div class="form-group" style="margin-bottom:1px;">
        <label class="col-md-3 label-sm">Factory</label>
        <div class="col-md-6">
            <select class="form-control select2me" data-placeholder="Company" name="company">
                    <option value="<?php echo $r->customerid; ?>"><?php echo $r->customercompany; ?></option>
                    <?php 
                    foreach ($customer as $x) {
                            if ($r->customerid != $x->customerid){
                            echo '<option value="'.$x->customerid.'">'.$x->customercompany.'</option>';
                        }}
                    ?>
            </select>
        </div>
    </div>
    <div class="form-group" style="margin-bottom:1px;">
        <div class="col-md-4 col-md-offset-3">
            <select class="form-control select2me" data-placeholder="Currency" name="cur" >
                    <option value="<?php echo $r->currencyid; ?>"><?php echo $r->currencyid; ?></option>
                    <?php 
                    foreach ($cur as $x) {
                            if ($r->currencyid != $x->currency_id){
                            echo '<option value="'.$x->currency_id.'">'.$x->currency_id.'</option>';
                    }}
                    ?>
            </select>
         </div>
    </div>
<?php } ?>