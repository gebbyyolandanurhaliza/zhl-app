<div class="table-responsive">
    <table id="tbl-selectSupplier" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Supplier ID</th>
                <th>Supplier Name</th>
                <th>Group</th>
                <th>COA Number</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectSupplier as $row): ?>
            <tr onclick="Pilih_Supllier(this)">
                <td><?php echo $row->supplierid;?></td>
                <td><?php echo $row->suppliercompany;?></td>
                <td><?php echo $row->group;?></td>
                <td><?php echo $row->nocoa;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectSupplier").dataTable();
    });
</script>