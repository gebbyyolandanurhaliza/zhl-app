<?php
$nofaktur='';
foreach ($po as $r){
       echo '<tr>';
        if($nofaktur != $r->nofaktur){
            echo '<td nowrap><a class="btn-sm btn-default" target="_blank" href="'.site_url('Receivable_recognition_tims/edit?id='.$r->nofaktur).'"><i class="fa fa-eye"></i></a></td>';
            echo '<td nowrap>'.$r->nofaktur.'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->tanggal_invoice)).'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->tanggal)).'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->shipmentdate)).'</td>';
            echo '<td nowrap>'.$r->customer_name.'</td>';
        } else{
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
        }
        echo '<td nowrap>'.$r->no_po.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->Items,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->NoCOA.'-'.$r->dept_code.'-002</td>';
        echo '<td nowrap class="text-right">'.number_format($r->Qty,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->Harga,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->Qty * $r->Harga, 2, '.', ',').'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->Qty * $r->Harga * $r->rate, 2, '.', ',').'</td>';
        echo '<td nowrap>'.$r->gst_type.'</td>';
        echo '<td nowrap>'.number_format($r->gst_value,2).'</td>';
    echo '</tr>';

    $nofaktur = $r->nofaktur;
    
}
?>