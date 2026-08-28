<div class="table-responsive">
    <table id="tbl-selectInvoice" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No. Invoice</th>
                <th>Rate</th>
                <th>Total Before</th>
                <th>Total</th>
                <th style="display: none;">addClass</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $noo= 1;
            foreach ($_selectInvoice as $row): ?>
            <tr onclick="Pilih_Invoice(this)" data-id="ismo-row-<?php echo $no++;?>">
                <td><?php echo $row->nofaktur;?></td>
                <td class="text-right"><?php echo number_format($row->rate_akhir, 2);?></td>
                <td class="text-right"><?php echo number_format($row->hutang, 2);?></td>
                <td class="text-right"><?php echo number_format($row->hutang-$row->bayar, 2);?></td>
                <td class="text-right" style="display: none;">ismo-row-<?php echo $noo++;?></td>
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
            if($(this).hasClass('row-selected') === true){
                $(this).removeClass('row-selected');
                if($('#tbl-detail-invoice tbody tr').hasClass(thisTD) === true){
                    $('.'+thisTD).remove();
                }
            }else{
                $(this).addClass('row-selected');
            }
            CountGrandTotal();
        });
    });
</script>