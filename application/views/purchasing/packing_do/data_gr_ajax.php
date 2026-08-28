<?php foreach ($_datagr as $r) {
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]" ></td>';
        echo '<td nowrap>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.$r->companyid.'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->uom.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qty,0,'.','').'</td>';
        echo '<td nowrap>'.$r->npbbno.'</td>';
        echo '<td hidden>'.$r->id.'</td>';
        echo '<td hidden>'.$r->docno.'</td>';
    echo '</tr>';
 } 
 ?>