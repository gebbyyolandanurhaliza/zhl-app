<style>
    .row-selected{
        color: red;
    }
</style>
<div class="table-responsive">
    <table id="tbl-selectSupplier" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Group</th>
                <th>COA Number</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectSupplier as $row): ?>
            <tr onclick="Pilih_Supllier(this)">
                <td><?php echo $row->customer_code;?></td>
                <td><?php echo $row->customer_company_name;?></td>
                <td><?php echo $row->customer_group_name;?></td>
                <td><?php echo $row->new_coa;?></td>
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