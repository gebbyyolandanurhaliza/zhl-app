
<div class="portlet light">
    <div class="portlet-body">
        <div class="form-body">

            <section class="">
                <div class="contain_si">
                    <table cellspacing="0" cellpadding="0" border="0" id="tabel_gl" width="100%" height="600px">
                        <thead>
                            <tr class="header">
                                <th text-align="center">Act.<div>Act.</div></th>
                                <th>Description of Goods/Purchase Order No.<div>Description of Goods/Purchase Order No.</div></th>
                                <th>Quantity <small>(Cartoon)</small> <div>Quantity <small>(Cartoon)</small> </div></th>
                                <th>Unit Price <small>(USD)</small><div>Unit Price <small>(USD)</small></div></th>
                                <th>Amount <small>(USD)</small><div>Amount <small>(USD)</small></div></th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            if (!empty($tampil_group)) {
                                $nu = 1;
                                foreach ($tampil_group as $m) {
                                    echo "<tr><td colspan='11' style='text-align:left;font-weight:bold;background-color:#ddd;'>";
                                    if (!empty($m->packing_size)) {
                                        echo $m->packing_size . " ";
                                    }
                                    echo $m->product_category_name;
                                    echo "</td></tr> ";
                                    if (!empty($tampil)) {
                                        $no = 1;
                                        $total_qty = 0;
                                        $total_price = 0;
                                        foreach ($tampil as $s) {
                                            if ($m->product_category_name == $s->product_category_name) {
                                                $amount = $s->quantity * $s->price;
                                                $total_qty += $s->quantity;
                                                $total_price += $s->price;
                                                ?>
                                                <tr class="sour" style="cursor: pointer;">
                                                    <td><button class="tombol" onclick="hapus_dp(this)" >Remove</button></td>
                                                    <td><input type="hidden" name="group_orc[]" value="<?php echo $m->product_category_name; ?>">
                                                        <input type="hidden" name="packing_size[]" value="<?php echo $m->packing_size; ?>">
                                                        <input type="text" class="txt" name="po_number[]" value="<?php echo $s->po_number; ?>" readonly></td>
                                                    <td><input type="text" class="txt number qty_val" name="quantity[]" value="<?php echo number_format($s->quantity, 2); ?>" readonly></td>
                                                    <td><input type="text" class="txt number price_val" name="price[]" value="<?php echo number_format($s->price, 2); ?>" readonly></td>
                                                    <td><input type="text" class="txt number amount_val" name="amount[]" value="<?php echo number_format($amount, 2); ?>" readonly></td>
                                                </tr>
                                                <?php
                                            }
                                        }
//                                        echo "<tr><td colspan='2' style='text-align:left;font-weight:bold;background-color:#fff;'>TOTAL</td>";
//                                        echo "<td style='text-align:right;font-weight:bold;background-color:#fff;'><input type='text' class='txt number qty_group' id='qty_group" . $nu . "' value='" . number_format($total_qty, 2) . "'></td>";
//                                        echo "<td style='text-align:right;font-weight:bold;background-color:#fff;'><input type='text' class='txt number price_group' id='price_group" . $nu . "' value='" . number_format($total_price, 2) . "'></td>";
//                                        echo "<td style='text-align:right;font-weight:bold;background-color:#fff;'><input type='text' class='txt number amount_group' id='amount_group" . $nu . "' value='" . number_format($total_qty * $total_price, 2) . "'></td></tr>";
                                    }
                                    $nu++;
                                }
                            }
                            ?>
                    </table>

                        </tbody>
                </div>
        </div>
    </div>
</div>
</div>