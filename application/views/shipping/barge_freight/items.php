<?php
if ($items) {
    $rowspan = count($items);
    foreach ($items as $key => $item) { ?>
        <tr>
            <?php
            if ($key == 0) { ?>

                <!-- hidden items -->
                <input type="hidden" class="form-control" name="head[]" value="1" readonly>
                <input type="hidden" class="form-control" name="row[]" value="<?= count($items) ?>" readonly>
                <!-- hidden items -->

                <td class="remove" data-row="<?= count($items) ?>">
                    <button class="btn btn-sm btn-danger " type="button"><i class="fa fa-trash"></i></button>
                </td>
                <td>
                    <input type="text" class="form-control" name="jo_ref[]">
                </td>
                <td>
                    <input type="text" class="form-control" name="con_type_name[]" value="<?= $item->con_type_name ?>" readonly>
                </td>
                <td width="250">
                    <input type="text" class="form-control" name="pod[]" value="<?= $item->destination_tujuan ?> - <?= $item->destination_abbr ?> " readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="uom[]" value="<?= strtoupper($item->container_size . ' ' . $item->container_abbr) ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="description[]" value="<?= $item->desc_nama ?>" readonly>
                    <input type="hidden" class="form-control" name="freight_desc_list[]" value="<?= $item->desc_list_id ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="freight_per_mt[]" value="<?= $item->freight_per_mt  ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control text-right" name="unit_price[]" value="<?= number_format($item->unit_price, 2) ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control text-right autonum_qty" name="qty[]" data-v-min="0" value="" onkeyup="calculate()" autocomplete="off" required>
                </td>
                <td>
                    <input type="text" class="form-control text-right" name="amount[]" value="" readonly>
                </td>

            <?php
            } else { ?>
                <!-- hidden items -->
                <input type="hidden" class="form-control" name="jo_ref[]">
                <input type="hidden" class="form-control" name="head[]" value="0" readonly>
                <input type="hidden" class="form-control" name="row[]" value="" readonly>
                <!-- hidden items -->
                <td class="remove" data-row="<?= count($items) ?>">
                    <button class="btn btn-sm btn-danger " type="button"><i class="fa fa-trash"></i></button>
                </td>
                <td>
                    <input type="hidden" class="form-control" name="jo_ref[]">
                </td>
                <td>
                    <input type="hidden" class="form-control" name="con_type_name[]" value="<?= $item->con_type_name ?>" readonly>
                </td>
                <td width="250">
                    <input type="hidden" class="form-control" name="pod[]" value="<?= $item->destination_tujuan ?> - <?= $item->destination_abbr ?> " readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="uom[]" value="<?= strtoupper($item->container_size . ' ' . $item->container_abbr) ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="description[]" value="<?= $item->desc_nama ?>" readonly>
                    <input type="hidden" class="form-control" name="freight_desc_list[]" value="<?= $item->desc_list_id ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control" name="freight_per_mt[]" value="<?= $item->freight_per_mt  ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control text-right" name="unit_price[]" value="<?= number_format($item->unit_price, 2) ?>" readonly>
                </td>
                <td>
                    <input type="text" class="form-control text-right autonum_qty" name="qty[]" data-v-min="0" value="" autocomplete="off" onkeyup="calculate()">
                </td>
                <td>
                    <input type="text" class="form-control text-right" name="amount[]" value="" autocomplete="off" readonly>
                </td>
            <?php
            }
            ?>
            <?= $no++ ?>
        </tr>

<?php
    }
}
?>

<script>
    // function delete_row(start, end) {
    //     'use strict';
    //     var awal = start.rowIndex;
    //     var length = parseInt(awal) + parseInt(end);
    //     if (confirm("Are you sure remove this row?") == true) {
    //         var x = length;
    //         for (let index = 0; index <= end; index++) {
    //             document.getElementById("tblList").deleteRow(x);
    //             x--;
    //         }

    //         calculate();
    //     }
    // }
    'use strict';
    $('#tblList tr .remove').click(function(e) {

        var row = $(this).data('row') - 1;

        if (confirm("Are you sure remove this row?") == true) {

            // for (let index = 0; index < row; index++) {
            //     $(this).parent().next().remove();
            // }

            $(this).parent().remove();

            calculate();
        }
    });

    $('.autonum_qty').autoNumeric('init', {
        mDec: 0
    });

    $('#total_amount,#amount_due').autoNumeric('init', {
        mDec: 2
    });

    function calculate() {
        'use strict';
        var int = 0;
        var total = 0;

        var total_amount = 0;

        $('#tbl_list_item tr').each(function() {
            var qty = remove_thousand_separator($(this).find("input[name='qty[]']").val());
            var price = remove_thousand_separator($(this).find("input[name='unit_price[]']").val());
            var total_row = qty * price;

            $(this).find("input[name='amount[]']").autoNumeric('init', {
                mDec: 2
            });

            $(this).find("input[name='amount[]']").autoNumeric('set', total_row);

            total_amount += total_row;

        });

        $('#total_amount').autoNumeric('set', total_amount);

        var total_amount = remove_thousand_separator($('#total_amount').val());
        var gst_value = remove_thousand_separator($('#gst_value').val());

        var total = total_amount + gst_value;
        $('#amount_due').autoNumeric('set', total);
    }
</script>