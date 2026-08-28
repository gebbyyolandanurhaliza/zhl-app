<div class="table-responsive">
    <table id="tbl-selectBrand" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Brand ID</th>
                <th>Brand Name</th>
                <th>Brand CMA</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectBrand as $row): ?>
            <tr onclick="Pilih_Brand(this)" >
                <td><?php echo $row->brand_id;?></td>
                <td><?php echo $row->brand_name;?></td>
                <td><?php echo $row->brand_cma;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl-selectBrand").dataTable();
    });
</script>