<div class="table-responsive">
    <table id="tbl-selectInvoice" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Currency</th>
                <th>Rate</th>
                <th>Total Before</th>
                <th>Total</th>
                <th>Remarks</th>
                <th style="display: none;">addClass</th>
                <th>In Draft</th>
                <th style="display: none;">Jenis</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $noo= 1;
            foreach ($_selectInvoice as $row): ?>
            <?php if(in_array($row->nofaktur, $_arrDraf)): ?>
            <tr onclick="javascript:bootbox.alert('Invoice number already exists in Draft!');" data-id="ismo-row-<?php echo $no++;?>" style="background-color:#D1D1D1">
            <?php else: ?>
            <tr onclick="Pilih_Invoice(this); selectRowInv(this);" data-id="ismo-row-<?php echo $no++;?>" class="not-draft">
            <?php endif; ?>
                <td><?php echo $row->nofaktur;?></td>
                <td><?php echo $row->currency_id;?></td>>
                <td class="text-right"><?php echo number_format($row->rate_invc, 6);?></td>
                <td class="text-right"><?php echo number_format($row->hutang, 2);?></td>
                <td class="text-right"><?php echo number_format($row->hutang - $row->bayar, 2);?></td>
                <td class="text-left"><?php echo $row->remarks; ?></td>
                <td class="text-right" style="display: none;">ismo-row-<?php echo $noo++;?></td>
                <td class="text-center"><?php echo (in_array($row->nofaktur, $_arrDraf) ? 'Yes' : 'No');?></td>
                <td style="display: none;"><?php echo $row->jenis_trans; ?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectInvoice").dataTable();
    });

    function selectRowInv(x){
    	var thisX	= x;
    	var thisTD 	= $(thisX).data('id');
        //alert(thisTD);
        if($(thisX).hasClass('not-draft') === true){
            if($(thisX).hasClass('row-selected') === true){
                $(thisX).removeClass('row-selected');
                if($('#tbl-detail-invoice tbody tr').hasClass(thisTD) === true){
                    $('.'+thisTD).remove();
                }
            }else{
                $(thisX).addClass('row-selected');
            }
            //CountGrandTotal();
        }
    }
</script>