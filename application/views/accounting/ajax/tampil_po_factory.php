<script type="text/javascript">

    var addedrows = new Array();
    $(document).ready(function () {
        $("#tabel_gl tbody tr").on("click", function (event) {
            var ok = 0;
            var theid = $(this).attr('id').replace("sour", "");
            var sum = 0;
            var rater = 0;
            var newaddedrows = new Array();
            //var grandtotal = 0;

            for (index = 0; index < addedrows.length; ++index) {
                // if already selected then remove
                if (addedrows[index] == theid) {
                    $(this).css("color", "#333");
                    // remove from second table :
                    var tr = $("#dest" + theid);
                    tr.css("color", "#FF)000");
                    tr.fadeOut(400, function () {
                        tr.remove();
                        //rate();
                        debit();
                        hitung_total();
                    });
                    ok = 1;


                } else {
                    newaddedrows.push(addedrows[index]);
                }

            }
            addedrows = newaddedrows;
            
            if (!ok) {
                addedrows.push(theid);
                $(this).css("color", "#FF0000");
                $('#tabel tr:last').after('<tr id="dest' + theid + '"><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                    <td><input type="hidden" name="txtship_id[]" class="txt txtship_id" value="' + $(this).find("td").eq(8).html() + '" />\n\
                        <input type="hidden" name="ship_product_id[]" class="txt txtship_product_id" value="' + $(this).find("td").eq(9).html() + '" />\n\
                        <input type="text" class="txt" name="Detail_po[]" value="' + $(this).find("td").eq(0).html() + '"></td>\n\
                    <td><input type="hidden" class="txt" name="txtItemId[]" value="' + $(this).find("td").eq(1).html() + '">\n\
                        <input type="text" class="txt" name="txtItemName[]" value="' + $(this).find("td").eq(2).html() + '">\n\
                        <input type="hidden" class="txt" name="NoCOADet[]" value="' + $(this).find("td").eq(11).html() + '"></td>\n\
                    <td><input type="text" class="txt txtRate " name="txtRate[]" value="' + $(this).find("td").eq(10).html() + '"></td>\n\
                    <td><input type="text" class="txt number quantity" onKeyup="hitung_total()" name="txtQty[]" value="' + $(this).find("td").eq(3).html() + '"></td>\n\
                    <td><input type="text" class="txt" name="txtunit[]" value="' + $(this).find("td").eq(7).html() + '">\n\
                        <input type="hidden" name="txtSummary[]" class="txt txtSummary" value="0" /></td>\n\
                    <td><input type="text" class="txt number prices" name="txtunitprice[]" onKeyup="hitung_total()" value="' + $(this).find("td").eq(4).html() + '"></td>\n\
                    <td><input type="text" class="txt number amount" name="txtamount[]" value="' + $(this).find("td").eq(5).html() + '"></td>\n\
                    <td><input type="text" class="txt number txtSGD" name="txtusd[]" value="' + $(this).find("td").eq(6).html() + '"></td>\n\
                    <td><select name="txtGST[]" onchange="cek_gst()" class="txt txtGST">\n\
                            <option value="">Select</option>\n\
                            <option value="GST">GST</option>\n\
                            <option value="ZER">Zero Rate</option>\n\
                            <option value="EXP">Exampt</option>\n\
                            <option value="OUT">Out of Scope</option>\n\
                        </select>\n\
                    </td>\n\
                    <td><input type="text" name="txtGSTValue[]" class="txt number autonumber txtGSTValue" onkeypress="return isNumber(event)"  value="0"  /></td>\n\
                    </tr>');
            }
            hitung_total();
            cek_gst();

        });

    });
</script>  
<table class="datatable table table-bordered table-hover" id="tabel_gl">
    <thead>
        <tr class="header">
            <th>PO Number<div>PO Number</div></th>
            <th>Item ID<div>Item ID</div></th>
            <th style="display:none">Item Name<div>Item Name</div></th>
            <th>Quantity<div>Quantity</div></th>
            <th>Unit Price<div>Unit Price</div></th>
            <th>Amount<div>Amount</div></th>
            <th>USD Equivalent<div>USD Equivalent</div></th>
            <th style="display:none">NPBB Number<div>NPBB Number</div></th>
            <th style="display:none">Unit<div>Unit</div></th>
            <th>Rate<div>Rate</div></th>
            <th>COA<div>COA</div></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!empty($list_po)) {
            $no = 1;
            foreach ($list_po as $v) {
                ?>
                <tr style="cursor: pointer;" id="sour<?php echo $no++; ?>">
                    <td><?php echo $v->po_number; //0   ?></td>
                    <td><?php echo $v->product_code; //1   ?></td>
                    <td style="display:none"><?php echo $v->product_name; //2   ?></td>
                    <td><?php echo number_format($v->sisa, 2); //3   ?></td>
                    <td><?php echo number_format($v->fob_price, 2); //4   ?></td>
                    <td><?php echo number_format($v->sisa * $v->fob_price, 2); //5   ?></td>
                    <td><?php echo number_format($v->sisa * $v->fob_price * $v->rate_usd, 2); //6   ?></td>
                    <td style="display:none"><?php echo $v->uom_quantity_name; //7  ?></td>
                    <td style="display:none"><?php echo $v->ship_id; //8  ?></td>
                    <td style="display:none"><?php echo $v->ship_product_id; //9  ?></td>
                    <td><?php echo $v->rate_usd; //10  ?></td>
                    <td><?php echo $v->coa_cogs; //10  ?></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
