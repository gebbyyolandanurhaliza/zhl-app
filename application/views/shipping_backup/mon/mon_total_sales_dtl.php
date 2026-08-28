<?php 
foreach ($total as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>'.$r->tmp_product.'</td>';
        echo '<td nowrap>'.$r->tmp_unit.'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty_tot == 0 ? '' : number_format($r->tmp_qty_tot,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us_tot == 0 ? '' : number_format($r->tmp_us_tot,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty_tot == 0 ? '' : number_format($r->tmp_us_tot/$r->tmp_qty_tot,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty1 == 0 ? '' : number_format($r->tmp_qty1,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us1 == 0 ? '' : number_format($r->tmp_us1,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty1 == 0 ? '' : number_format($r->tmp_us1/$r->tmp_qty1,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty2 == 0 ? '' : number_format($r->tmp_qty2,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us2 == 0 ? '' : number_format($r->tmp_us2,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty2 == 0 ? '' : number_format($r->tmp_us2/$r->tmp_qty2,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty3 == 0 ? '' : number_format($r->tmp_qty3,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us3 == 0 ? '' : number_format($r->tmp_us3,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty3 == 0 ? '' : number_format($r->tmp_us3/$r->tmp_qty3,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty4 == 0 ? '' : number_format($r->tmp_qty4,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us4 == 0 ? '' : number_format($r->tmp_us4,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty4 == 0 ? '' : number_format($r->tmp_us4/$r->tmp_qty4,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty5 == 0 ? '' : number_format($r->tmp_qty5,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us5 == 0 ? '' : number_format($r->tmp_us5,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty5 == 0 ? '' : number_format($r->tmp_us5/$r->tmp_qty5,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty6 == 0 ? '' : number_format($r->tmp_qty6,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us6 == 0 ? '' : number_format($r->tmp_us6,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty6 == 0 ? '' : number_format($r->tmp_us6/$r->tmp_qty6,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty7 == 0 ? '' : number_format($r->tmp_qty7,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us7 == 0 ? '' : number_format($r->tmp_us7,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty7 == 0 ? '' : number_format($r->tmp_us7/$r->tmp_qty7,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty8 == 0 ? '' : number_format($r->tmp_qty8,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us8 == 0 ? '' : number_format($r->tmp_us8,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty8 == 0 ? '' : number_format($r->tmp_us8/$r->tmp_qty8,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty9 == 0 ? '' : number_format($r->tmp_qty9,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us9 == 0 ? '' : number_format($r->tmp_us9,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty9 == 0 ? '' : number_format($r->tmp_us9/$r->tmp_qty9,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty10 == 0 ? '' : number_format($r->tmp_qty10,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us10 == 0 ? '' : number_format($r->tmp_us10,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty10 == 0 ? '' : number_format($r->tmp_us10/$r->tmp_qty10,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty11 == 0 ? '' : number_format($r->tmp_qty11,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us11 == 0 ? '' : number_format($r->tmp_us11,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty11 == 0 ? '' : number_format($r->tmp_us11/$r->tmp_qty11,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty12 == 0 ? '' : number_format($r->tmp_qty12,0)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_us12 == 0 ? '' : number_format($r->tmp_us12,2)).'</td>';
        echo '<td nowrap class="text-right">'.($r->tmp_qty12 == 0 ? '' : number_format($r->tmp_us12/$r->tmp_qty12,2)).'</td>';
    echo '</tr>';
    
}

?>

