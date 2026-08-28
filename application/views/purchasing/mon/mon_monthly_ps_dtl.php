<?php 
$i=0;
foreach ($dtl as $r){
    
    
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>'.$r->lrno.'</td>';
        echo '<td nowrap>'.date('d-m-Y', strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.date('d-m-Y', strtotime($r->shipdate)).'</td>';
        echo '<td nowrap>'.$r->customercompany.'</td>';
        echo '<td nowrap><div>'.$r->itemid.'<br><span>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</span></div></td>';
        echo '<td nowrap>'.$r->grossweight.'</td>';
        echo '<td nowrap>'.$r->neetweight.'</td>';

    echo '</tr>';
    
    
}

?>

