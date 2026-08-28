<div class="table-responsive">
    <table id="tbl-selectDeposit-hasRecorded" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Currency</th>
                <th>Rate</th>
                <th>Deposit</th>
                <th>Status</th>
                <th>Created By</th>
                <th>Created Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectHeader as $row): ?>
            <tr data-id="<?php echo encode_str($row->header_id);?>" data-pre="<?php echo $row->prepaid;?>" onclick="clickGo(this)">
                <td><?php echo $row->no_reff;?></td>
                <td><?php echo date('d-m-Y', strtotime($row->dp_date_inv));?></td>
                <td><?php echo $row->suplier.' - '.$row->customer_company_name;?></td>
                <td><?php echo $row->currency_id;?></td>
                <td class="text-right"><?php echo number_format($row->currency_rate, 6);?></td>
                <td class="text-right"><?php echo number_format($row->dp_total, 2);?></td>
                <td>
                    <?php 
                        if($row->prepaid == 1){
                            echo "Received";
                        }else{
                            echo "Not Yet";
                        }
                    ?>
                </td>
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
            aaSorting: [[0, 'asc']]
        });
        
        /*$("#tbl-selectDeposit-hasRecorded tbody tr").click( function (){
            var header  = $(this).data('id');
            var status  = $(this).data('pre');
            //alert(header);
            if (status == '1') {
                window.location = "<?php //echo site_url();?>DownPaymentAR/reviewDepositAR/" +header;
            } else {
                bootbox.dialog({
                    message: "What would you do?",
                    buttons: {
                        pay: {
                            label: "Receive Deposit",
                            className: "green btn-sm",
                            callback: function() {
                                window.location = "<?php //echo site_url();?>DownPaymentAR/indexPayDepositInvoiceAR/" +header;
                            }
                        },
                        review: {
                            label: "Review",
                            className: "blue btn-sm",
                            callback: function() {
                                window.location = "<?php //echo site_url();?>DownPaymentAR/reviewDepositARjustInvoice/" +header;
                            }
                        },
                        cancel: {
                            label: "Cancel",
                            className: "default btn-sm",
                            callback: function() {
                                bootbox.hideAll()
                            }
                        }
                    }
                });
            }
        });*/
    });

    function clickGo(x){
        var header  = $(x).data('id');
        var status  = $(x).data('pre');
        //alert(header);
        if (status == '1') {
            window.location = "<?php echo site_url();?>DownPaymentAR/reviewDepositAR/" +header;
        } else {
            bootbox.dialog({
                message: "What would you do?",
                buttons: {
                    pay: {
                        label: "Receive Deposit",
                        className: "green btn-sm",
                        callback: function() {
                            window.location = "<?php echo site_url();?>DownPaymentAR/indexPayDepositInvoiceAR/" +header;
                        }
                    },
                    review: {
                        label: "Review",
                        className: "blue btn-sm",
                        callback: function() {
                            window.location = "<?php echo site_url();?>DownPaymentAR/reviewDepositARjustInvoice/" +header;
                        }
                    },
                    cancel: {
                        label: "Cancel",
                        className: "default btn-sm",
                        callback: function() {
                            bootbox.hideAll()
                        }
                    }
                }
            });
        }
    }
</script>