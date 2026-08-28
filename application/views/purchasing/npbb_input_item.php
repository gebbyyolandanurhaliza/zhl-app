<?php foreach($item as $r){ 
    echo '<tr ondblclick="clickdbitem(this)" style="cursor: pointer;">';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->pmcode.'</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td nowrap>'.$r->itemremark.'</td>';
    echo '</tr>';
} ?>