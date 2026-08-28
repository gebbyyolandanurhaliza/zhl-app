<script type="text/javascript">
            
   var addedrows = new Array();
    $(document).ready(function () {
        $("#tabel_coa tbody tr").on("click", function (event) {
            var ok = 0;
            var theid = $(this).attr('id').replace("sour", "");
            var sum = 0;
            var rater = 0;
            var newaddedrows = new Array();
            //var grandtotal = 0;

            for (index = 0; index < addedrows.length; ++index) {
                // if already selected then remove
                if (addedrows[index] == theid) {
                    $(this).css("color", "#000");
                    // remove from second table :
                    var tr = $("#dest" + theid);
                    tr.css("color", "#FF0000");
                    tr.fadeOut(400, function () {
                        tr.remove();
                        //rate();
                        hitung_total();
                    });
                    //addedrows.splice(theid, 1);   
                    //the boolean
                    ok = 1;

                } else {
                    newaddedrows.push(addedrows[index]);
                    //grandtotal += Number(txtamount[index].value);
                }

            }
            addedrows = newaddedrows;
                //alert(txtamount[1].value);
            
            // if no match found then add the row :
            if (!ok) {
                // retrieve the id of the element to match the id of the new row :
                addedrows.push(theid);
                $(this).css("color", "#FF0000");
                $('#destinationtable tr:last').after('<tr id="dest' + theid + '"><td>'
                        + $(this).find("td").eq(0).html() + '</td><td>'
                        + $(this).find("td").eq(2).html() + '</td><td>'
                        + $(this).find("td").eq(3).html() + '</td><td>'
                        + $(this).find("td").eq(4).html() + '</td><td>'
                        + $(this).find("td").eq(5).html() + '</td><td>'
                        + $(this).find("td").eq(6).html() + '</td><td>'
                        + $(this).find("td").eq(7).html() + '</td><td>'
                        + $(this).find("td").eq(8).html() + '</td><td>'
                        + $(this).find("td").eq(9).html() + '</td><td>'
                        + $(this).find("td").eq(10).html() + '</td><td>'
                        + $(this).find("td").eq(11).html() + '</td><td>'
                        + $(this).find("td").eq(12).html() + '</td></tr>');
            }
           // debit();
           //rate();
           hitung_total();

        //var txtamount = document.getElementsByClassName('txtamount');
        // $("#destinationtable .txtgrand").each(function () {
        //     //add only if the value is number
        // if (!isNaN(this.value) && this.value.length != 0) {
        //     sum += parseFloat(this.value);
        //     }
        // var total = document.getElementsByClassName('jur_total');
        // var jur_det = document.getElementsByClassName('jur_deb');
        // var jur_credit = document.getElementsByClassName('jur_credit');
        // var rate = document.getElementById('rate').value ;
        
        // rater = sum*rate;
        // total[0].value = sum;
        // jur_det[0].value = rater;
        // total[5].value = sum;
        // jur_credit[5].value = rater;
        
        // hitung_total();
          //  alert(grandtotal);
       // });
        });
        
    });

    function cekRate(){
        // if(document.getElementById('cur').value === ""){
        //     alert("Please Select Currency");
        // }
    }
</script>       

<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Items</h4>
            </div>
            <div class="modal-body">
		   <table class="table table-bordered" id="tabel_coa" width="1300%">
                    <thead width="100%">
                    <th width="50%" style="display:none"></th>
                    <th width="130%">PO</th>
                    <th width="50%">NoCOA</th>
                    <th width="50%">Items</th>
                    <th width="130%">Items Name </th>
                    <th width="130%">Qty</th>
                    <th width="130%">Unit</th>
                    <th width="130%">Price</th>
                    <th width="130%">Amount</th>
                    <th width="130%">Rate</th>
                    <th width="130%">Usd Equivalent</th>
                    <th width="130%">GST Type</th>
                    <th width="130%">GST Value</th>
                    
                    </thead>
                    <tbody width="100%">
                        <?php
                        if (!empty($tampilpo)) {
                            $no = 1;
                            foreach ($tampilpo as $s) {
                                $qtypi = $s->qty - $s->qty_pi;
                                if($qtypi > 0){
                                ?>
                                <tr id="sour<?php echo $no++; ?>">
                                    <td style="display:none"></td>
                                    <td><input type="text" name="npbbnu[]" class="txt" value="<?php echo $s->po_number; ?>" required/></td>
                                    <td><input type="text" name="coa_argl[]" class="txt coa_argl" value="200104" required/></td>
                                    <td>
                                        <input type="text" name="txtidem[]" readonly class="txt" value="<?php echo $s->itemid; ?>" required/>
                                        <input type="hidden" name="npbbno[]" class="txt" value="<?php echo $s->po_hdr_id; ?>" required/>
                                        <input type="hidden" name="npbbni[]" class="txt" value="<?php echo $s->po_number; ?>" required/>
                                    </td>
                                    <td>
                                        <input type="text" name="txtinem[]" readonly class="txt" value="<?php echo $s->ItemName; ?>" />
                                        <input type="hidden" name="txtprodi[]" readonly class="txt" value="<?php echo $s->product_id; ?>" />
                                    </td>
                                    <td>
                                        <input type="text" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="<?php echo $s->qty - $s->qty_pi; ?>" />
                                        <input type="hidden" name="txtqty_pi[]" class="txt number txtqty_pi" value="<?php echo $s->qty_pi; ?>" />
                                    </td>
                                    <td><input type="text" name="txtunit[]" readonly class="txt" value="<?php echo $s->UOM; ?>" /></td>
                                    <td><input type="text" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="<?php echo $s->unitprice; ?>" /></td>
                                    <td><input type="text" name="txtamount[]" readonly class="txt number txtamount" value="<?php echo  ($s->qty - $s->qty_pi)*$s->unitprice; ?>" /></td>
                                    <td><input type="text" name="txtrate[]" readonly class="txt number txtrate  hitung_baris" value="<?php echo $s->rate; ?>" /></td>
                                    <td><input type="text" name="txtgrand[]" readonly class="txt number txtgrand" value="<?php echo (($s->qty - $s->qty_pi)*$s->unitprice)*$s->rate; ?>" /><input type="hidden" name="txtnpbb[]" readonly class="txt" value="<?php echo $s->po_number; ?>" /></td>
                                    <td>
                                        <select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">
                                            <option value="">Select</option>
                                            <option value="GST">GST</option>
                                            <option value="ZER">Zero Rate</option>
                                            <option value="EXP">Exampt</option>
                                            <option value="OUT">Out of Scope</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="text" name="gst_value[]" class="txt gst_value" value="0" required/>
                                        <input type="hidden" name="uang_muka[]" class="txt uang_muka" value="<?php //echo $s->uang_muka; ?>" required/>
                                    </td>

                                </tr> 
                                <?php
                                }
                            }
                        }
                        ?>

                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red" data-dismiss="modal">Choose</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#tabel_coa").dataTable({
            "scrollY": 300,
            "scrollX": true});
    });
</script>
