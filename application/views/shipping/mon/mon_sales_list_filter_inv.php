<?php foreach ($inv as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>'.date("d-m-Y", strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.$r->invno.'</td>';
        echo '<td nowrap>'.$r->ponumber.'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td nowrap>'.date("d-m-Y", strtotime($r->shipdate)).'</td>';
        echo '<td nowrap class="text-right">'.$r->termdays.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->tax,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->total * $r->rate ,2).'</td>';
    echo '</tr>';
}?>
