<div class="table-responsive">
    <table id="tbl-selectAR-hasRecorded" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No. Reference</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Currency</th>
                <th>Amount</th>
                <th>Created By</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectHeader as $row): ?>
            <tr data-id="<?php echo encode_str($row->header_id);?>" onclick="clickGo(this);">
                <td><?php echo $row->no_facture;?></td>
                <td><?php echo date('d-m-Y', strtotime($row->trans_date));?></td>
                <td><?php echo $row->customer_company_name;?></td>
                <td><?php echo $row->currency_bayar;?></td>
                <td class="text-right"><?php echo number_format($row->amount, 2);?></td>
                <td><?php echo ucfirst(strtolower($row->created_by));?></td>
                <td class="text-right"><?php echo date('F, d Y h:i:s A', strtotime($row->created_date));?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $("#tbl-selectAR-hasRecorded").dataTable();
        
        /*$("#tbl-selectAR-hasRecorded tbody tr").click( function (){
            var header  = $(this).data('id');
            //alert(header);
            window.location = "<?php //echo site_url();?>ARtrans/reviewARpayment/" +header;
        });*/
    });
    function clickGo(x){
        var header  = $(x).data('id');
        //alert(header);
        window.location = "<?php echo site_url();?>ARtrans/reviewARpayment/" +header;
    }
</script>