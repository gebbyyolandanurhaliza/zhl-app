<div class="table-responsive">
    <table id="tbl-selectInvoice" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Rate</th>
                <th>Total Before</th>
                <th>Total</th>
                <th style="display: none;">addClass</th>
                <th>In Draft</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $noo= 1;
            foreach ($_selectInvoice as $row): ?>
            <?php if($row->in_draft == 1): ?>
            <tr onclick="javascript:bootbox.alert('Invoice number already exists in Draft!');" data-id="ismo-row-<?php echo $no++;?>" style="background-color:#D1D1D1">
            <?php else: ?>
            <tr onclick="Pilih_Invoice(this)" data-id="ismo-row-<?php echo $no++;?>" class="not-draft">
            <?php endif; ?>
                <td><?php echo $row->nofaktur;?></td>
                <td class="text-right"><?php echo number_format($row->rate_akhir, 6);?></td>
                <td class="text-right"><?php echo number_format($row->hutang, 2);?></td>
                <td class="text-right"><?php echo number_format($row->hutang-$row->bayar, 2);?></td>
                <td class="text-right" style="display: none;">ismo-row-<?php echo $noo++;?></td>
                <td class="text-center"><?php echo ($row->in_draft == 1 ? 'Yes' : 'No');?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectInvoice").dataTable();
        
        $('#tbl-selectInvoice tbody tr').on('click', function (){
            var thisTD = $(this).data('id');
            //alert(thisTD);
            if($(this).hasClass('not-draft') === true){
                if($(this).hasClass('row-selected') === true){
                    $(this).removeClass('row-selected');
                    if($('#tbl-detail-invoice tbody tr').hasClass(thisTD) === true){
                        $('.'+thisTD).remove();
                    }
                }else{
                    $(this).addClass('row-selected');
                }
                CountGrandTotal();
            }
        });
    });
</script>