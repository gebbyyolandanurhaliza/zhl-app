<div class="row">
    <div class="col-sm-12">
        <div class="btn-group btn-group-sm btn-group-solid">
            <button id="btnShowAll" type="button" class="btn grey-cascade">All</button>
            <button id="btnShowDraft" type="button" class="btn default">Draft</button>
            <button id="btnShowPaid" type="button" class="btn default">Paid</button>
        </div>
        <hr style="border:0;height:1px;background-image:linear-gradient(to right,rgba(0,0,0,0),rgba(0,0,0,1),rgba(0,0,0,0));" />
    </div>

    <div class="col-sm-12">
        <div class="table-responsive">
            <table id="tbl-selectAP-hasRecorded" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>No. Reference</th>
                        <th>Date</th>
                        <th>Supplier</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($_selectHeader as $row): ?>
                    <tr data-id="<?php echo encode_str($row->header_id);?>" onclick="selectReviewAP(this);" class="ap-is-<?php echo ($row->is_draf == 1 ? 'draft': 'paid');?>">
                        <td><?php echo $row->no_facture;?></td>
                        <td><?php echo date('d-m-Y', strtotime($row->trans_date));?></td>
                        <td><?php echo $row->suppliercompany;?></td>
                        <td><?php echo $row->currency_bayar;?></td>
                        <td class="text-right"><?php echo number_format($row->amount, 2);?></td>
                        <td class="text-center">
                            <button type="button" class="btn <?php echo ($row->is_draf == 1 ? 'blue-hoki': 'green-meadow');?> btn-xs">
                                <?php echo ($row->is_draf == 1 ? 'Draft': 'Paid');?>
                            </button>
                        </td>
                        <td><?php echo ucfirst(strtolower($row->created_by));?></td>
                        <td class="text-right"><?php echo date('F, d Y h:i:s A', strtotime($row->created_date));?></td>
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
        
        $("#tbl-selectAP-hasRecorded tbody tr").click( function (){
            var header  = $(this).data('id');
            //alert(header);
            if ($(this).hasClass('ap-is-paid') === true) {
                window.location = "<?php echo site_url();?>APtrans_zht/reviewAPpayment/" +header;
            }else{
                bootbox.dialog({
                    message: "What would you do?",
                    buttons: {
                        pay: {
                            label: "Pay AP",
                            className: "green btn-sm",
                            callback: function() {
                                window.location = "<?php echo site_url();?>APtrans_zht/reviewAPforDraft/" +header;
                            }
                        },
                        review: {
                            label: "Review",
                            className: "blue btn-sm",
                            callback: function() {
                                window.location = "<?php echo site_url();?>APtrans_zht/reviewAPpayment/" +header;
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
        });

        $("#btnShowDraft").click(function(){
            $('.ap-is-paid').addClass('display-none');
            $('.ap-is-draft').removeClass('display-none');
        });

        $("#btnShowPaid").click(function(){
            $('.ap-is-paid').removeClass('display-none');
            $('.ap-is-draft').addClass('display-none');
        });

        $("#btnShowAll").click(function(){
            $('.ap-is-paid').removeClass('display-none');
            $('.ap-is-draft').removeClass('display-none');
        });
    });

    function savePaid(){
        alert("dalksd as");
        return false;
    }

    function selectReviewAP(x){
        var thisX   = x;
        var header  = $(thisX).data('id');
        //alert(header);
        if ($(thisX).hasClass('ap-is-paid') === true) {
            window.location = "<?php echo site_url();?>APtrans_zht/reviewAPpayment/" +header;
        }else{
            bootbox.dialog({
                message: "What would you do?",
                buttons: {
                    pay: {
                        label: "Pay AP",
                        className: "green btn-sm",
                        callback: function() {
                            window.location = "<?php echo site_url();?>APtrans_zht/reviewAPforDraft/" +header;
                        }
                    },
                    review: {
                        label: "Review",
                        className: "blue btn-sm",
                        callback: function() {
                            window.location = "<?php echo site_url();?>APtrans_zht/reviewAPpayment/" +header;
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
    }
</script>