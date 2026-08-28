<table id="tbl-MasterCOA-row2" class="table table-hover table-striped">
    <thead>
        <tr>
            <th>COA Number - - INI DI CASH BANK ROW 2</th>
            <th>Account Name</th>
            <th>COA Group</th>
            <th>Reg Number</th>
            <th>addClass</th>
            <th hidden></th>
            <th hidden></th>
            <th hidden></th>

        </tr>
    </thead>
    <tbody>
        <?php $no = 1; $noo= 1;
        foreach ($_getMasterCOA as $row): ?>
        <tr onclick="Pilih_MCOArow2(this)" data-id="mcoa-row-<?php echo $no++;?>">
            <!-- <td class="text-center"><?php echo $row->NoCOA;?></td> -->
            <td class="text-center"><?php echo $row->NoCOA . "-" . $row->kode_department . "-001" ;?></td>
            <td><?php echo $row->AccountName;?></td>
            <td class="text-center"><?php echo $row->GroupCOA;?></td>
            <td class="text-center"><?php //echo $row->RegNo;?></td>
            <td class="text-right">mcoa-row-<?php echo $noo++;?></td>
            <td hidden class="text-right"><?php echo $row->sub_account_type;?></td>
            <td hidden class="text-right"><?php echo $row->NoCOA;?></td>
            <td hidden class="text-right"><?php echo $row->kode_department;?></td>

        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $("#tbl-MasterCOA-row2").dataTable();
    });
</script>