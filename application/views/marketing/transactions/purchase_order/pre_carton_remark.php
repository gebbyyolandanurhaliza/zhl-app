<div class="table-responsive">
    <table id="tbl_carton_remark" class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Carton Remark</th>
            </tr>
        </thead>
        <tbody>
            <?php $i=1; foreach ($rec_prev as $row): ?>
				<tr onclick="pilih_carton_remark(this)" >
					<td><?php echo $i++;?></td>
					<td><?php echo $row->carton_remark;?></td>
				</tr>
            <?php endforeach;?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $("#tbl_carton_remark").dataTable();
    });
</script>