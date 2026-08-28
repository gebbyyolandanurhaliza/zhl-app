<?php foreach ($so as $r){
    echo '<tr>';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-info" title="Copy" href="'.site_url('purchasing_inv/sales_invoice_edit_copy?sono='.$r->sono).'"><i class="fa fa-copy"></i></a>';
        echo '</td>';
        echo '<td nowrap>'.$r->sono.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.$r->itemname.'</td>';
        echo '<td nowrap>'.$r->uomname. '</td>';
       // echo '<td nowrap>'.number_format($r->totaldue,2).'</td>';
        echo '<td nowrap>'.$r->qty.'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'. $r->createddate.'</td>';
        echo '<td nowrap>'. $r->lastupdatedby.'</td>';
        echo '<td nowrap>'. $r->lastupdateddate.'</td>';
    echo '</tr>';
} 
?>
