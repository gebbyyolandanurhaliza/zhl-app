<div class="table-responsive">
    <table id="tbl-select-label-code" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Item ID</th>
                <th>Item Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectLabelCode as $row): ?>
            <tr onclick="pilih_label_code(this)" >
                <td><?php echo $row->itemid;?></td>
                <td><?php echo $row->itemname;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-select-label-code").dataTable();
    });
</script>