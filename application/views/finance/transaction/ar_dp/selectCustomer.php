<div class="table-responsive">
    <table id="tbl-selectSupplier" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Supplier ID</th>
                <th>Supplier Name</th>
                <th>Group</th>
                <th>COA Number</th>
                <th class="display-none"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectSupplier as $row): ?>
            <tr onclick="Pilih_Supllier(this)">
                <td><?php echo $row->customer_code;?></td>
                <td><?php echo $row->customer_company_name;?></td>
                <td><?php echo $row->customer_group_name;?></td>
                <td><?php echo $row->coa;?></td>
                <td class="display-none"><?php echo $row->name_coa;?></td>
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