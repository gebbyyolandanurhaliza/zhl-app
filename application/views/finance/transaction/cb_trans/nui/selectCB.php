<div class="row">
    <div class="col-sm-12 table-responsive">
        <table id="tbl-select-cashbank-hasRecorded" class="table table-hover table-striped">
            <thead>
                <tr>
                    <th>Reff. Number</th>
                    <th>Date</th>
                    <th>Code</th>
                    <th>From/To</th>
                    <th>Description</th>
                    <th>Currency</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($_selectHeaderCashBank as $row): ?>
                    <tr data-id="<?php echo encode_str($row->header_id); ?>">
                        <td class="text-uppercase"><?php echo $row->no_reff; ?></td>
                        <td class="text-right"><?php echo date('F, d Y', strtotime($row->date1)); ?></td>
                        <td><?php echo $row->cashbank_code; ?></td>
                        <td><?php echo $row->from_to; ?></td>
                        <td><?php echo $row->trans_description; ?></td>
                        <td class="text-center"><?php echo $row->currency_id; ?></td>
                        <td class="text-right"><?php echo number_format($row->amount, 2); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#tbl-select-cashbank-hasRecorded").dataTable();
        
        $("#tbl-select-cashbank-hasRecorded tbody tr").click( function (){
            var header  = $(this).data('id');
            //bootbox.alert('Bego loe!! '+header);
            window.location = "<?php echo site_url();?>CBtransNui/reviewCashBank/" +header;
        });
    });
</script>