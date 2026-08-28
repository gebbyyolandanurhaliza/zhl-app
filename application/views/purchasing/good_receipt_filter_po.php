<?php foreach ($po as $r) {
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->shipdate)).'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qtypo,2,'.','').'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qtywhs,2,'.','').'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qtypo - $r->qtywhs,2,'.','').'</td>'; 
        echo '<td nowrap>'; ?>
        <button class="btn-sm btn-danger" title="Edit" onclick="close_status('<?php echo $r->mainpo; ?>')"><i class="fa fa-pencil"></i></button>
        <?php echo '</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->unitprice,2,'.','').'</td>';
        echo '<td nowrap hidden>'.$r->npbbno.'</td>';
        echo '<td nowrap>'.$r->vendorcompany.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td hidden>'.$r->custid.'</td>';
        echo '<td hidden>'.$r->sono.'</td>';
    echo '</tr>';
} ?>
