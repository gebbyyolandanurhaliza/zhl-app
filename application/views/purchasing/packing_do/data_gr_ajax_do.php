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
                        // debit();
                        // hitung_amount();
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
            var gst_select = 'FALSE';
            //alert(txtamount[1].value);
            
            // if no match found then add the row :
            if (!ok) {
                // retrieve the id of the element to match the id of the new row :
                addedrows.push(theid);
                $(this).css("color", "#FF0000");
                $('#tabel tr:last').after('<tr id="dest' + theid + '"><td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>\n\
                    <td><input type="hidden" class="txt" name="txtIdgr[]" value="' + $(this).find("td").eq(0).html() + '"><input type="text" class="txt" name="txtItemName[]" value="' + $(this).find("td").eq(1).html() + '"></td>\n\
                    <td><input type="text" class="txt" name="txtItemNPBB[]" value="' + $(this).find("td").eq(2).html() + '"></td>\n\
                    <td><input type="text" class="txt" name="txtItemQty[]" value="' + $(this).find("td").eq(3).html() + '"><input type="hidden" class="txt" name="txtdocno[]" value="' + $(this).find("td").eq(4).html() + '"><input type="hidden" class="txt" name="txtmainpo[]" value="' + $(this).find("td").eq(5).html() + '"><input type="hidden" class="txt" name="txtItemId[]" value="' + $(this).find("td").eq(6).html() + '"></td>\n\
                    <td><input type="text" class="txt" readonly value="' + $(this).find("td").eq(7).html() + '"></td>\n\
                    <td><input type="text" class="txt" name="txtItemGW[]" value=""></td>\n\
                    <td><input type="text" class="txt" name="txtItemNW[]" value=""></td>\n\
                    </tr>');
            }

        });

    });
</script> 


<table class="datatable table table-bordered table-hover" id="tabel_gl">
    <thead>
        <tr class="header">
            <th hidden>ID<div>ID</div></th>
            <th>Descriptions<div>Description</div></th>
            <th>NPBB No<div>NPBB No</div></th>
            <th>Quantity<div>Quantity</div></th>
            
        </tr>
    </thead>
    <tbody>
        <?php 
            if(!empty($_datagr)){
                $no = 1;
                foreach ($_datagr as $r) {
                    ?>
                    <tr style="cursor: pointer;" id="sour<?php echo $no++; ?>">
                        <td hidden><?=$r->id; ?></td>
                        <td><?=$r->itemname; ?></td>
                        <td><?=$r->npbbno; ?></td>
                        <td><?=number_format($r->sisa_qty,3,'.',''); ?></td>
                        <td hidden><?=$r->docno; ?></td>
                        <td hidden><?=$r->mainpo; ?></td>
                        <td hidden><?=$r->itemid; ?></td>
                        <td hidden><?=$r->uom; ?></td>
                    </tr>
                    <?php
                }
            }
        ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function () {
        $("#search").keyup(function () {
            _this = this;
            $.each($("#tabel_gl tbody tr"), function () {
                if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                    $(this).hide();
                else
                    $(this).show();
            });
        });
    });
        
</script>
<script type="text/javascript">
    function hapus_dp(btn) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        hitung_amount();
    }
</script>