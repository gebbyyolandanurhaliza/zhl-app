<div class="table-responsive">
    <table id="tbl-selectEmployee" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>ID Number</th>
                <th>Name</th>
                <th>Position</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectEmployee as $row): ?>
            <tr onclick="Pilih_Employee(this)">
                <td><?php echo str_pad($row->header_id, 5, 0, STR_PAD_LEFT);?></td>
                <td><?php echo $row->full_name;?></td>
                <td><?php echo $row->department;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
        $("#tbl-selectEmployee").dataTable();
    });
</script>