<input type="hidden" name="txtCFKey" id="CFKey" value="<?php echo $_id;?>" readonly />
<div class="table-responsive">
    <table class="table table-striped table-hover" id="table-ajax-setting">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>I/O</th>
                <th>Header</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_selectCashRealization1 as $row1): ?>
                <tr style="font-weight: bold;" data-id="<?php echo $row1->rlz_key?>" data-islast="<?php if($_Controller->lastLevelRlz($row1->rlz_key) == TRUE){ echo '1';}else{ echo '0';}?>">
                    <td><?php echo $row1->rlz_code;?></td>
                    <td><?php echo $row1->rlz_num.'. '.strtoupper($row1->rlz_name);?></td>
                    <td class="text-center"><?php echo $row1->io;?></td>
                    <td><?php echo $row1->rlz_header;?> <?php if($_Controller->lastLevelRlz($row1->rlz_key) == TRUE){ echo '*';}?></td>
                </tr>
                <?php foreach ($_selectCashRealization2 as $row2): ?>
                    <?php if($row2->rlz_header == $row1->rlz_key): ?>
                    <tr class="text-primary" data-id="<?php echo $row2->rlz_key?>" data-islast="<?php if($_Controller->lastLevelRlz($row2->rlz_key) == TRUE){ echo '1';}else{ echo '0';}?>">
                        <td><?php echo $row2->rlz_code;?></td>
                        <td><?php echo $row2->rlz_num.'. '.ucwords(strtolower($row2->rlz_name));?></td>
                        <td class="text-center"><?php echo $row2->io;?></td>
                        <td><?php echo $row2->rlz_header;?> <?php if($_Controller->lastLevelRlz($row2->rlz_key) == TRUE){ echo '*';}?></td>
                    </tr>
                    <?php endif; ?>
                    <?php foreach ($_selectCashRealization3 as $row3): ?>
                        <?php if($row3->rlz_header == $row2->rlz_key && $row2->rlz_header == $row1->rlz_key): ?>
                        <tr class="text-success" data-id="<?php echo $row3->rlz_key?>" data-islast="<?php if($_Controller->lastLevelRlz($row3->rlz_key) == TRUE){ echo '1';}else{ echo '0';}?>">
                            <td><?php echo $row3->rlz_code;?></td>
                            <td><?php echo $row3->rlz_num.'. '.ucfirst($row3->rlz_name);?></td>
                            <td class="text-center"><?php echo $row3->io;?></td>
                            <td><?php echo $row3->rlz_header;?> <?php if($_Controller->lastLevelRlz($row3->rlz_key) == TRUE){ echo '*';}?></td>
                        </tr>
                        <?php endif; ?>
                        <?php foreach ($_selectCashRealization4 as $row4): ?>
                            <?php if($row4->rlz_header == $row3->rlz_key && $row3->rlz_header == $row2->rlz_key && $row2->rlz_header == $row1->rlz_key): ?>
                            <tr class="text-muted" data-id="<?php echo $row4->rlz_key?>" data-islast="<?php if($_Controller->lastLevelRlz($row4->rlz_key) == TRUE){ echo '1';}else{ echo '0';}?>">
                                <td><?php echo $row4->rlz_code;?></td>
                                <td><?php echo $row4->rlz_num.'. '.$row4->rlz_name;?></td>
                                <td class="text-center"><?php echo $row4->io;?></td>
                                <td><?php echo $row4->rlz_header;?> <?php if($_Controller->lastLevelRlz($row4->rlz_key) == TRUE){ echo '*';}?></td>
                            </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
    $('#table-ajax-setting tbody tr').dblclick(function (){
        var row = $(this).closest('tr');
        var rlz_id  = row.data('id');
        var cf_id   = document.getElementById('CFKey').value;
        var isLast  = $(this).data('islast');
        
//        alert('Hello '+rlz_id+' - '+cf_id+' - '+isLast);
        if(isLast === 1){
//            alert('Is last');
            window.location = '<?php echo base_url();?>Master_CashFlow/updateSettingFlow/'+cf_id+'/'+rlz_id;
        }else{
            alert("Can't use!");
            return false;
        }
    });
</script>