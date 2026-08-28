<?php foreach ($npbb as $r){
    echo '<tr>';
        echo '<td nowrap>'.$r->npbbno.'</td>';
        echo '<td nowrap>'.date("m-d-Y", strtotime($r->transdate)).'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.$r->itemname.'</td>';
        echo '<td nowrap class="text-right">'.$r->qnty.'</td>';
        echo '<td nowrap>'.$r->uom.'</td>';
        echo '<td nowrap>'.$r->currencyid.'</td>';
        echo '<td nowrap class="text-right">'.$r->exchangerate.'</td>';
        echo '<td nowrap class="text-right">'.$r->unitprice.'</td>';
        echo '<td nowrap>'.$r->remark.'</td>';
    echo '</tr>';
 } ?>
            