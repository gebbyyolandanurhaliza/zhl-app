<?php $invno='';foreach ($inv as $r){
    echo '<tr style="cursor: pointer;">';
        if($invno != $r->invno){
            echo '<td nowrap><a class="btn-sm btn-default" target="_blank" href="'.site_url('shipping_inv/sales_invoice_print?inv='.$r->invno).'"><i class="fa fa-eye"></i></a></td>';
            echo '<td nowrap>'.$r->invno.'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->docdate)).'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->duedate)).'</td>';
            echo '<td nowrap>'.date("d-m-Y", strtotime($r->shipdate)).'</td>';
            echo '<td nowrap>'.$r->custcompany.'</td>';
            if ($r->status == 2){
                echo '<td nowrap>Close</td>';
            } elseif($r->status == 3){
                echo '<td nowrap>Cancel</td>';
            } else {
                echo '<td nowrap>Open</td>';
            }
        } else{
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
            echo '<td></td>';
        }
        echo '<td nowrap>'.$r->ponumber.'</td>';
        echo '<td nowrap>'.$r->productcode.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->productname,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->currency.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qty,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->unitprice,4).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->total ,2).'</td>';
    echo '</tr>';
    $invno=$r->invno;
}?>
