<?php foreach ($npbb_temp as $r){
    echo '<tr ondblclick="clickdbnpbb(this)">';
        echo '<td nowrap>'.$r->npbbno.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->transdate)).'</td>';
        echo '<td nowrap>'.$r->companyfullname.'</td>';
        echo '<td nowrap>'.$r->currencyid.'</td>';
        echo '<td hidden>'.str_replace("/",".slash",$r->npbbno).'</td>';
    echo '</tr>';
} ?>