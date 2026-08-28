<div class="row">


    <div class="col-sm-12">
        <div class="table-responsive">
            <table id="tbl-selectAP-hasRecorded" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Invoice Number</th>
                        <th>Date of Journal</th>
                        <th>Invoice Date</th>
                        <th>Due Date</th>
                        <th>Customer</th>
                        <th>Currency</th>
                        <th>Rate</th>
                        <th>Grand Total</th>
                        <th>Amount</th>
                        <th>Term</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_selectHeader as $s):
                        $tgl_jurnal = date_format(date_create($s->tanggal), "d F Y");
                        $tgl_invoice = date_format(date_create($s->tanggal_invoice), "d F Y");
                        $tgl_tempo = date_format(date_create($s->tanggal_tempo), "d F Y");
                        ?>
                        <tr onclick="pilih(this)" style="cursor: pointer;">
                            <td><?php echo $s->nofaktur; ?></td>
                            <td style="text-align: center"><?php echo $tgl_jurnal; ?></td>
                            <td style="text-align: center"><?php echo $tgl_invoice; ?></td>
                            <td style="text-align: center"><?php echo $tgl_tempo; ?></td>
                            <td><?php echo $s->namavendor; ?></td>
                            <td><?php echo $s->currency; ?></td>
                            <td  style="text-align: right"><?php echo $s->rate; ?></td>
                            <td style="text-align: right"><?php echo number_format($s->hutang, 2, ".", ","); ?></td>
                            <td style="text-align: right"><?php echo number_format($s->hutang * $s->rate, 2, ".", ","); ?></td>
                            <td><?php echo $s->term; ?> Days</td>
                        </tr>
                    <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
        
<script>
    $(document).ready(function() {
        $("#tbl-selectAP-hasRecorded").dataTable();


    });



</script>

<script>

    function pilih(x)
    {

        function getText(el) {
            if (typeof el.textContent === 'string')
                return el.textContent;
            if (typeof el.innerText === 'string')
                return el.innerText;
        }
        $r = x.rowIndex;
        var url = "<?php echo base_url(); ?>";

        var InvoiceNumber = getText(document.getElementById('tbl-selectAP-hasRecorded').rows[$r].cells[0]);

        bootbox.dialog({
            message: "What would you do?",
            buttons: {

                review: {
                    label: "Review",
                    className: "blue btn-sm",
                    callback: function() {
                        window.location.href = url + "Purchase_inv_factory/edit?id=" + InvoiceNumber + "";
                    }
                },
                cancel: {
                    label: "Cancel",
                    className: "default btn-sm",
                    callback: function() {
                        bootbox.hideAll();
                    }
                }
            }
        });


    }
</script>