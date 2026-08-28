<?php foreach ($item as $r) {
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td hidden>'.$r->per1000.'</td>';
    echo '</tr>';
 } 
 ?>