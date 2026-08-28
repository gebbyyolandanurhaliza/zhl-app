<div class="table-responsive">
    <table id="tbl-selectDeposit-hasRecorded" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Date</th>
                <th>Vendor</th>
                <th>Currency</th>
                <th>Rate</th>
                <th>Deposit</th>
                <th>Created By</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectHeader as $row): ?>
            <tr data-id="<?php echo encode_str($row->header_id);?>" onclick="getLinkAPdeposit(this);">
                <td><?php echo $row->no_reff;?></td>
                <td><?php echo date('d-m-Y', strtotime($row->dp_date_inv));?></td>
                <td><?php echo $row->suplier.' - '.$row->suppliercompany;?></td>
                <td><?php echo $row->currency_id;?></td>
                <td class="text-right"><?php echo number_format($row->currency_rate, 6);?></td>
                <td class="text-right"><?php echo number_format($row->dp_total, 2);?></td>
                <td><?php echo ucfirst(strtolower($row->created_by));?></td>
                <td class="text-right"><?php echo date('F, d Y h:i:s A', strtotime($row->created_date));?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $("#tbl-selectDeposit-hasRecorded").dataTable({
            aaSorting: [[2, 'asc']]
        });
        
        /*$("#tbl-selectDeposit-hasRecorded tbody tr").click( function (){
            var header  = $(this).data('id');
            //alert(header);
            window.location = "<?php //echo site_url();?>DownPaymentAP/reviewDepositAP/" +header;
        });*/
    });

    function getLinkAPdeposit(argument) {
        var header  = $(argument).data('id');
        //alert(header);
        window.location = "<?php echo site_url();?>DownPaymentAP/reviewDepositAP/" +header;
    }
</script>