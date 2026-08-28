<div class="table-responsive">
    <table id="tbl-selectPOsupplier" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>No. Main PO</th>
                <th>Date PO</th>
                <th>Currency</th>
                <th>Rate</th>
                <th>Total</th>
                <th>addClass</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; $noo= 1;
            foreach ($_selectPO as $row): ?>
            <tr onclick="Pilih_POsupp(this)" data-id="ismo-row-<?php echo $no++;?>">
                <td><?php echo $row->mainpo;?></td>
                <td class="text-right"><?php echo date('d-m-Y', strtotime($row->postdate));?></td>
                <td class="text-center"><?php echo $row->currency;?></td>
                <td class="text-right"><?php echo number_format($row->rate, 2);?></td>
                <td class="text-right"><?php echo number_format($row->totaldue, 2);?></td>
                <td class="text-right">ismo-row-<?php echo $noo++;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectPOsupplier").dataTable();
        
        $('#tbl-selectPOsupplier tbody tr').on('click', function (){
            var thisTD = $(this).data('id');
            //alert(thisTD);
            if($(this).hasClass('row-selected') === true){
                $(this).removeClass('row-selected');
                if($('#tbl-detail-po tbody tr').hasClass(thisTD) === true){
                    $('.'+thisTD).remove();
                }
            }else{
                $(this).addClass('row-selected');
            }
            CountGrandTotal();
        });
    });
</script>