<div class="table-responsive">
    <table id="tbl-selectInvoice" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Invoice Date</th>
                <th>No. Invoice</th>
                <th>Currency</th>
                <th>Rate</th>
                <th>Total Before</th>
                <th>Total</th>
                <th>Remarks</th>
                <th hidden>addClass</th>
                <th hidden>Jenis</th>
                <th>Rate Invoice</th>
                <th>Different Rate</th>
                <th>Different Rate Sgd</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $noo= 1;
            foreach ($_selectInvoice as $row): ?>
            <tr onclick="Pilih_Invoice(this); selectRowInvAR(this);" data-id="ismo-row-<?php echo $no++;?>">
                <td><?php echo date("d-m-Y",strtotime($row->tanggal));?></td>
                <td><?php echo $row->nofaktur;?></td>
                <td><?php echo $row->currency_id;?></td>
                <td class="text-right"><?php echo number_format($row->rate_invc, 6);?></td>
                <td class="text-right"><?php echo number_format($row->piutang, 2);?></td>
                <td class="text-right"><?php echo number_format($row->piutang - $row->bayar, 2);?></td>
                <td class="text-left"><?php echo $row->remarks; ?></td>
                <td hidden>ismo-row-<?php echo $noo++;?></td>
                <td hidden><?php echo $row->jenis_trans; ?></td>
                <td class="text-right"><?php echo number_format($row->rate, 6); ?></td>
                <td class="text-right"><?php echo number_format($row->rate_invc - $row->rate, 6); ?></td>
                <td class="text-right"><?php echo number_format($row->rate_invc_sgd - $row->rate_sgd, 6); ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectInvoice").dataTable();
        
        /*$('#tbl-selectInvoice tbody tr').on('click', function (){
            var thisTD = $(this).data('id');
            //alert(thisTD);
            if($(this).hasClass('row-selected') === true){
                $(this).removeClass('row-selected');
                if($('#tbl-detail-invoice tbody tr').hasClass(thisTD) === true){
                    $('.'+thisTD).remove();
                }
            }else{
                $(this).addClass('row-selected');
            }
            CountGrandTotal();
        });*/
    });

    function selectRowInvAR(x){
        var thisX   = x;
        var thisTD = $(thisX).data('id');
        //alert(thisTD);
        if($(thisX).hasClass('row-selected') === true){
            $(thisX).removeClass('row-selected');
            if($('#tbl-detail-invoice tbody tr').hasClass(thisTD) === true){
                $('.'+thisTD).remove();
            }
        }else{
            $(thisX).addClass('row-selected');
        }
        CountGrandTotal();
    }
</script>