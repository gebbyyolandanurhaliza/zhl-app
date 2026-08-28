<table id='tbl-MasterCF' class='table table-hover table-striped'>
    <thead>
        <tr>
            <th>Code</th>
            <th>Description</th>
            <th>I/O</th>
            <th>Realization</th>
            <th style="display: none;">Key</th>
            <th style="display: none;">isLast</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($_getMasterCFRLZ as $row): ?>
        <tr onclick='getCF(this)'>
            <td><?php echo $row->cf_code;?></td>
            <td><?php echo $row->cf_code.'. '.$row->cf_name;?></td>
            <td><?php echo $row->io;?></td>
            <td><?php echo $row->rlz_num.'. '.$row->rlz_name;?></td>
            <td style="display: none;"><?php echo $row->cf_key;?></td>
            <td style="display: none;">
                <?php if($_Controller->lastLevelCF($row->cf_key) == TRUE){ echo '1';}else{ echo '0';}?>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<script>
    $(document).ready(function() {
        $('#tbl-MasterCF').dataTable();
    });
</script>