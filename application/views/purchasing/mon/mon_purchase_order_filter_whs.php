<?php foreach ($whs as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.date("d-m-Y", strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.date("d-m-Y", strtotime($r->duedate)).'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qtywhs,2).'</td>';
    echo '</tr>';
}?>

