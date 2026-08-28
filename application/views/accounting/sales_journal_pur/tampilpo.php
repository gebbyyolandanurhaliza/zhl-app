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
                    $(this).css("background-color", "#fff");
                    // remove from second table :
                    var tr = $("#dest" + theid);
                    tr.css("background-color", "#FF3700");
                    tr.fadeOut(400, function () {
                        tr.remove();
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
                $(this).css("background-color", "#cacaca");
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
                        + $(this).find("td").eq(11).html() + '</td></tr>');
            }
            //debit();
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
                <h4 class="modal-title">List of Master COA</h4>
            </div>
            <div class="modal-body">
		   <table class="table table-bordered" id="tabel_coa" width="1300%">
                    <thead width="100%">
                    <th width="50%"  style="display:none"></th>
                    <th width="130%">Invoice NO</th>
                    <th width="50%">Items</th>
                    <th width="130%">Items Name </th>
                    <th width="130%">Qty</th>
                    <th width="130%">Quantity</th>
                    <th width="130%">Unit</th>
                    <th width="130%">Price</th>
                    <th width="130%">Amount</th>
                    <th width="130%">currency Items</th>
                    <th width="130%">Rate</th>
                    <th width="130%">Usd Equivalent</th>
                    
                    </thead>
                    <tbody width="100%">
                        <?php
                        if (!empty($tampilpo)) {
                            $no = 1;
                            foreach ($tampilpo as $s) {
                                $qty_si = $s->qty - $s->qty_SIP;
                                if($qty_si > 0){
                                ?>
                                <tr id="sour<?php echo $no++; ?>">
                                    <td  style="display:none"></td>
                                    <td><input type="text" name="npbbno[]" class="txt" value="<?php echo $s->invno; ?>" required/></td>
                                    <td><input type="text" name="txtidem[]" readonly class="txt" value="<?php echo $s->itemid; ?>" required/><input type="hidden" name="npbbno[]" class="txt" value="<?php echo $s->invno; ?>" required/></td>
                                    <td><input type="text" name="txtinem[]" readonly class="txt" value="<?php echo $s->itemname; ?>" /></td>
                                    <td>
                                        <input type="text" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="<?php echo $s->qty - $s->qty_SIP; ?>" />
                                        <input type="hidden" name="txtqty_pi[]" class="txt number txtqty_pi" value="<?php echo $s->qty_SIP; ?>" />
                                        <!-- <input type="hidden" name="npbbid[]" class="txt number npbbid" value="<?php echo $s->contract_id; ?>" />
                                        <input type="hidden" name="productid[]" class="txt number productid" value="<?php echo $s->product_id; ?>" /> -->
                                    </td>
                                    <td><input type="text" name="txtquantity[]" class="txt number txtquantity" value="<?php echo $s->Quantity; ?>"></td>
                                    <td><input type="text" name="txtunit[]" readonly class="txt" value="<?php echo $s->uom; ?>" /></td>
                                    <td><input type="text" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="<?php echo $s->unitprice; ?>" /></td>
                                    <td><input type="text" name="txtamount[]" readonly class="txt number txtamount" value="<?php echo  $s->total; ?>" /></td>
                                    <td><input type="text" name="txtcurrency[]" readonly class="txt" value="<?php echo $s->currency; ?>" /></td>
                                    <td><input type="text" name="txtrate[]" readonly class="txt number txtrate" value="<?php echo $s->rate; ?>" /></td>
                                    <td><input type="text" name="txtgrand[]" readonly class="txt number txtgrand" value="<?php echo (($s->qty - $s->qty_SIP)*$s->unitprice)*$s->rate; ?>" /><!-- <input type="hidden" name="txtnpbb[]" readonly class="txt" value="<?php echo $s->npbbno; ?>" /> --></td>
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
                <button type="button" class="btn red" data-dismiss="modal">Close</button>
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
