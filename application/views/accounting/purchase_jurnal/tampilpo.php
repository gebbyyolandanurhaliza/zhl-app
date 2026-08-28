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
                    $(this).css("color", "#FF0000");
                    // remove from second table :
                    var tr = $("#dest" + theid);
                    tr.css("color", "#FF0000");
                    tr.fadeOut(400, function () {
                        tr.remove();
                        //rate();
                        debit();
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
                        + $(this).find("td").eq(11).html() + '</td><td>'
                        + $(this).find("td").eq(12).html() + '</td><td>'
                        + $(this).find("td").eq(13).html() + '</td></tr>');
            }
            

        });

    });

    function cekRate() {
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
                <h4 class="modal-title">List of Items.</h4>
            </div>
            <div class="modal-body">
                <section class="">
                    <div class="contain">
                        <table class="table table-bordered" id="tabel_coa" width="1350%">
                            <thead  class="header">
                            <th style="display:none"></th>
                            <th style="width:10%">PO <div>PO</div></th>
                            <th style="width:10%">NoCOA <div>NoCOA</div></th>
                            <th style="width:20%">Items <div>Items</div></th>
                            <th style="width:25%">Items Name <div>Items Name</div> </th>
                            <th style="width:5%">Qty <div>Qty</div></th>
                            <th style="width:5%">Qty per Unit<div>Qty per Unit</div></th>
                            <th style="display:none">Unit</th>
                            <th style="display:none">Price</th>
                            <th style="width:10%">Amount <div>Amount</div></th>
                            <th style="display:none">Rate</th>
                            <th style="display:none">Usd Equivalent</th>
                            <th style="display:none">GST Type</th>
                            <th style="display:none">GST Value</th>
                            <th style="width:10%">Down Payment <div>Down Payment</div></th>

                            </thead>
                            <tbody width="100%">
                                <?php
                                if (!empty($tampilpo)) {
                                    $no = 1;
                                    foreach ($tampilpo as $s) {
                                        $qtypi = $s->qtywhs - $s->qty_pi;
                                        if ($s->per1000 == '1') {
                                            $qty = $s->qtypo / 1000;
                                            $per1000 = "1000";
                                        } else {
                                            $qty = $s->qtypo;
                                            $per1000 = "1";
                                        }
                                        if ($qtypi > 0) {
                                            ?>
                                            <tr id="sour<?php echo $no++; ?>">
                                                <td style="display:none"></td>
                                                <td><input type="text" name="npbbni[]" class="txt" value="<?php echo $s->mainpo; ?>" required/></td>
                                                <td><input type="text" name="coa_argl[]" class="txt coa_argl" value="200104" required/></td>
                                                <td><input type="text" name="txtidem[]" readonly class="txt" value="<?php echo $s->itemid; ?>" required/><input type="hidden" name="npbbno[]" class="txt" value="<?php echo $s->mainpo; ?>" required/></td>
                                                <td><input type="text" name="txtinem[]" readonly class="txt" value="<?php echo $s->itemname; ?>" /></td>
                                                <td>
                                                    <input type="text" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="<?php echo $s->qtypo; ?>" />
                                                    <input type="hidden" name="txtqty_pi[]" class="txt number txtqty_pi" value="<?php echo $s->qty_pi; ?>" />
                                                    <input type="hidden" name="txtxxx[]" class="txt number txtsummary" />
                                                </td>
                                                <td>
                                                    <input type="text" name="txtper1000[]" class="txt number txtper1000" value="<?php echo $per1000; ?>" />
                                                </td>
                                                <td style="display:none"><input type="text" name="txtunit[]" readonly class="txt" value="<?php echo $s->uomname; ?>" /></td>
                                                <td style="display:none"><input type="text" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="<?php echo $s->unitprice; ?>" /></td>
                                                <td><input type="text" name="txtamount[]" readonly class="txt number txtamount" value="<?php echo $qty * $s->unitprice; ?>" /></td>
                                                <td style="display:none"><input type="text" name="txtrate[]" readonly class="txt number txtrate  hitung_baris" value="<?php echo $s->rate; ?>" /></td>
                                                <td style="display:none"><input type="text" name="txtgrand[]" readonly class="txt number txtgrand" value="<?php echo (($s->qtypo - $s->qty_pi) * $s->unitprice) * $s->rate; ?>" />
                                                    <input type="hidden" name="txtnpbb[]" readonly class="txt" value="<?php echo $s->npbbno; ?>" /></td>
                                                <td  style="display:none">
                                                    <select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">
                                                        <option value="">Select</option>
                                                        <option value="GST">GST</option>
                                                        <option value="ZER">Zero Rate</option>
                                                        <option value="EXP">Exampt</option>
                                                        <option value="OUT">Out of Scope</option>
                                                    </select>
                                                </td>
                                                <td  style="display:none">
                                                    <input type="text" name="gst_value[]" class="txt gst_value" value="0" required/>

                                                </td>
                                                <td>
                                                    <input type="text" name="uang_muka[]" class="txt uang_muka" value="<?php echo $s->uang_muka; ?>" required/>
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
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn red" data-dismiss="modal">Choose</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

