<div class="modal fade" id="coa" tabindex="-1" role="basic" aria-hidden="true">
    <div class="modal-dialog modal-full">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                <h4 class="modal-title">List of Master COA</h4>
            </div>
            <div class="modal-body">
                <table class="table table-bordered" id="tabel_coa"  width="100%">
                    <thead width="100%">
                    <th width="10%">MainPO</ph>
                    <th width="10%">Items</th>
                    <th width="10%">Items Name </th>
                    <th width="10%">Qty</th>
                    <th width="10%">Unit</th>
                    <th width="10%">Price</th>
                    <th width="10%">Amount</th>
                    <th width="10%">currency Items</th>
                    <th width="10%">Rate</th>
                    <th width="10%">Usd Equivalent</th>
                    <th width="10%">NPBBNO</ph>
                    </thead>
                    <tbody width="100%">
                        <?php
                        if (!empty($tampilpo)) {
                            foreach ($tampilpo as $s) {
                                $tmp = $s->qty-$s->qty_pi;
                                if($tmp > 0){
                                ?>
                                <tr onclick="ambil(this)" style="cursor: pointer;">                      
                                    <td width="10%"><?php echo $s->mainpo; ?></td>
                                    <td width="10%"><?php echo $s->itemid; ?></td>
                                    <td width="10%"><?php echo $s->itemname; ?></td>
                                    <td width="10%"><?php echo $s->qty; ?></td>
                                    <td width="10%"><?php echo $s->uomname; ?></td>
                                    <td width="10%"><?php echo $s->unitprice; ?></td>
                                    <td width="10%"><?php echo $s->total; ?></td>
                                    <td width="10%"><?php echo $s->currency; ?></td>
                                    <td width="10%"><?php echo $s->rate; ?></td>
                                    <td width="10%"><?php echo $s->total*$s->rate; ?></td>
                                    <td width="10%"><?php echo $s->npbbno; ?></td>
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
<script>
	var grandTotal = 0;
   
    function ambil(x) {
        function getText(el) {
            if (typeof el.textContent === 'string')
                return el.textContent;
            if (typeof el.innerText === 'string')
                return el.innerText;
        }
        
        $r = x.rowIndex;
        var numPO = getText(document.getElementById('tabel_coa').rows[$r].cells[0]);
        var itemmID = getText(document.getElementById('tabel_coa').rows[$r].cells[1]);
        var itemmname = getText(document.getElementById('tabel_coa').rows[$r].cells[2]);
        var qty = getText(document.getElementById('tabel_coa').rows[$r].cells[3]);
        var uom = getText(document.getElementById('tabel_coa').rows[$r].cells[4]);
        var price = getText(document.getElementById('tabel_coa').rows[$r].cells[5]);
        var total = getText(document.getElementById('tabel_coa').rows[$r].cells[6]);
        var currency = getText(document.getElementById('tabel_coa').rows[$r].cells[7]);
        var rate = getText(document.getElementById('tabel_coa').rows[$r].cells[8]);
        var grand = getText(document.getElementById('tabel_coa').rows[$r].cells[9]);
        var npbb = getText(document.getElementById('tabel_coa').rows[$r].cells[10]);

        grandTotal += Number(total);
        document.getElementById("nota_debet").value = grandTotal;
        var num = 1;
        for (var i = 0; i < num; i++) {
            $('table[id="tabel"]').append('<tr>\n\
              <td></td>\n\
              <td><input type="text" name="txtidem[]" readonly class="txt" value="'+itemmID+'" required/><input type="hidden" name="npbbno[]" class="txt" value="'+numPO+'" required/></td>\n\
              <td><input type="text" name="txtinem[]" readonly class="txt" value="'+itemmname+'" /></td>\n\
              <td><input type="text" onKeyup="debit()" name="txtqty[]" onkeypress="return isNumber(event)" class="txt number txtqty" value="'+qty+'" /></td>\n\
              <td><input type="text" name="txtunit[]" readonly class="txt" value="'+uom+'" /></td>\n\
              <td><input type="text" onKeyup="debit()" name="txtprice[]" onkeypress="return isNumber(event)" class="txt number txtprice" value="'+price+'" /></td>\n\
              <td><input type="text" name="txtamount[]" readonly class="txt number txtamount" value="'+total+'" /></td>\n\
              <td><input type="text" name="txtcurrency[]" readonly class="txt" value="'+currency+'" /></td>\n\
              <td><input type="text" name="txtrate[]" readonly class="txt number txtrate" value="'+rate+'" /></td>\n\
              <td><input type="text" name="txtgrand[]" readonly class="txt number txtgrand" value="'+grand+'" /><input type="hidden" name="txtnpbb[]" readonly class="txt" value="'+npbb+'" /></td>\n\
        </tr>');
        }
        $('#coa').modal('hide');
    }

     function deleterow(x){
        $r=x.rowIndex;
        
        if (confirm("Are you sure remove this row?") == true) {
             document.getElementById("tabel").deleteRow($r);
        }
    }
</script>