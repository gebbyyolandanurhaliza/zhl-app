<?php 
$no=1;
foreach ($shipping_liner as $r){
    $awal  = strtotime($r->free_time_expiry);
    $tempo = time();

    $count_down = floor(($awal - $tempo) / (86400)) ;


    echo '<tr  onclick="clickdb(this);" style="cursor: pointer;">';
        echo '<td nowrap>'.$no++.'</td>';
        //echo '<td nowrap>'.$r->status.'</td>';
        if($r->status_note=='0'){
        echo '<td nowrap>Ready</td>';
        }elseif($r->status_note=='1'){
        echo '<td nowrap>Has Been Used</td>';
        }elseif($r->status_note=='2'){
        echo '<td nowrap>Return To Singapore</td>';
        }elseif($r->status_note=='3'){
        echo '<td nowrap>Transfer From Container Stock</td>';
        }

        if ($r->status_note == '0'){
        echo '<td nowrap align="center">'.$count_down.' Day </td>';
        }else{
        echo '<td nowrap align="center">  </td>';
        }

        echo '<td nowrap>'.$r->container_number.'</td>';
        echo '<td nowrap>'.$r->container_name.'</td>';
        echo '<td nowrap>'.$r->carrier.'</td>';
        echo '<td nowrap>'.$r->loading_port.'</td>';
        echo '<td nowrap>'.date("d/m/Y", strtotime($r->eta)).'</td>';
        echo '<td nowrap>'.date("d/m/Y", strtotime($r->arrival_date)).'</td>';
        echo '<td nowrap>'.$r->free_time. ' Day </td>';
        echo '<td nowrap>'.$r->factory.'</td>';
        echo '<td nowrap>'.$r->supplier.'</td>';
        echo '<td nowrap>'.$r->import_bl_no.'</td>';

        echo '<td nowrap>'.date("d/m/Y", strtotime($r->free_time_expiry)).'</td>';
        echo '<td nowrap>'.$r->Remark.'</td>';
    echo '</tr>';
}?>