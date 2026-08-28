<div class="row">


    <div class="col-sm-12">
        <div class="table-responsive">
            <table id="tbl-selectAP-hasRecorded" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No Reference</th>
                        <th>Date of Journal</th>
                        <th>Currency</th>
                        <th>Rate</th>
                        <th>Debet</th>
                        <th>Credit</th>

                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_selectHeader as $s):
                        $tgl_jurnal = date_format(date_create($s->tanggal), "d F Y");
                        $tgl_invoice = date_format(date_create($s->tanggal), "d F Y");
                        ?>
                        <tr onclick="pilih(this)" style="cursor: pointer;">
                            <td><?php echo $s->no_reff; ?></td>
                            <td><?php echo $s->tanggal; ?></td>
                            <td><?php echo $s->currency; ?></td>
                            <td><?php echo $s->rate; ?></td>
                            <td><?php echo number_format($s->debet, 2, ".", ","); ?></td>
                            <td><?php echo  number_format($s->credit, 2, ".", ","); ?></td>

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
                        window.location.href = url + "General_Journal_zht_tims/edit?id=" + InvoiceNumber + "";
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