<?php foreach ($po as $r){
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" name="chk[]"></td>';
        echo '<td nowrap>'.$r->sono.'</td>';
        echo '<td nowrap>'.date("d-m-Y", strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td hidden>'.$r->pmcode.'</td>';
        echo '<td nowrap>'.$r->uomname.'</td>';
        echo '<td hidden nowrap class="text-right">'.number_format($r->qtywhs,2,'.','').'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qty,2,'.','').'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->unitprice,4,'.','').'</td>';
        echo '<td nowrap>'.$r->currency.'</td>';
        echo '<td nowrap>'.$r->taxcode.'</td>';
        echo '<td hidden nowrap>'.$r->categoryid.'</td>';
        echo '<td nowrap>'.$r->pono.'</td>';
        echo '<td hidden>'.$r->docno_gr.'</td>';
        echo '<td hidden>'.$r->per1000.'</td>';
        echo '<td hidden>'.number_format($r->vendorpo,2,'.','').'</td>';
        echo '<td hidden>'.$r->mainpo.'</td>';
        
        echo '</tr>';
    }
