<table id="tbl-MasterCOAforAddCost" class="table table-hover table-striped">
    <thead>
        <tr>
            <th>COA Number - - FOR ADD Cost</th>
            <th>Account Name</th>
            <th>COA Group</th>
            <th>Reg Number</th>
            <th>addClass</th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1; $noo= 1;
        foreach ($_getMasterCOA as $row): ?>
        <tr onclick="Pilih_MCOAforAddCost(this)" data-id="mcoa-row-<?php echo $no++;?>">
            <td class="text-center"><?php echo $row->NoCOA;?></td>
            <td><?php echo $row->AccountName;?></td>
            <td class="text-center"><?php echo $row->GroupCOA;?></td>
            <td class="text-center"><?php //echo $row->RegNo;?></td>
            <td class="text-right">mcoa-row-<?php echo $noo++;?></td>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $("#tbl-MasterCOAforAddCost").dataTable();
        
        /*$('#tbl-MasterCOAforAddCost tbody tr').on('click', function (){
            var thisTD = $(this).data('id');
            //alert(thisTD);
            if($(this).hasClass('row-selected') === true){
                $(this).removeClass('row-selected');
                if($('#tbl-cashGeneral tbody tr').hasClass(thisTD) === true){
                    $('.'+thisTD).remove();
                }
            }else{
                $(this).addClass('row-selected');
            }
        });*/
    });
</script>