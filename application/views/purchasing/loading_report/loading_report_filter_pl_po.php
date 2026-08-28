<?php foreach ($po as $r) {
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->descriptions,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qty,3,'.','').'</td>';
        echo '<td nowrap>'.$r->npbbno.'</td>';
        echo '<td nowrap>'.$r->grossweight.'</td>';
        echo '<td nowrap>'.$r->neetweight.'</td>';
        echo '<td hidden>'.$r->pl_no.'</td>';
        echo '<td hidden>'.$r->ppbid.'</td>';
    echo '</tr>';
 }
