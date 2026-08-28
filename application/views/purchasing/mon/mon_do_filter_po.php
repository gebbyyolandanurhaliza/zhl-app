<?php $reff='';foreach ($do as $r){
    echo '<tr style="cursor: pointer;">';
        if($reff != $r->docno){
           echo '<td nowrap>'.$r->docno.'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->docdate)).'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->duedate)).'</td>';
        } else{
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
        }
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qtypo,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qtywhs,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->unitprice,4).'</td>';
        echo '<td nowrap>'.$r->vendorid.'</td>';
        echo '<td nowrap>'.$r->vendorcompany.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td hidden>'.$r->npbbno.'</td>';
    echo '</tr>';
    $reff=$r->docno;
}?>

