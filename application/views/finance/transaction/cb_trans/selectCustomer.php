<div class="table-responsive">
    <table id="tbl-selectCustomer" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Group</th>
                <th>COA Number</th>
                <th>Customer Key</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectCustomer as $row): ?>
            <tr onclick="Pilih_Customer(this)">
                <td><?php echo $row->customer_code;?></td>
                <td><?php echo $row->customer_name;?></td>
                <td><?php echo $row->customer_group_name;?></td>
                <td><?php echo $row->coa;?></td>
                <td><?php echo $row->customer_id;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectCustomer").dataTable();
    });
</script>