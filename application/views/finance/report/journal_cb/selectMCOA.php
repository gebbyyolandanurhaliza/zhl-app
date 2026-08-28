<table id="tbl-MasterCOA" class="table table-hover table-striped">
    <thead>
        <tr>
            <th>COA Number</th>
            <th>Account Name</th>
            <th>COA Group</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_getMasterCOA as $row): ?>
        <tr onclick="Pilih_MCOA(this)">
            <td class="text-center"><?php echo $row->NoCOA;?></td>
            <td><?php echo $row->AccountName;?></td>
            <td class="text-center"><?php echo $row->GroupCOA;?></td>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $("#tbl-MasterCOA").dataTable();
    });
</script>