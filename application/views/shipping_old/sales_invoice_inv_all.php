<?php foreach ($inv as $r){
    $sty = '';
    if($r->status == 2){
        $sty = 'success';
    } else if ($r->status == 3){
        $sty = 'danger';
    }
    echo '<tr class="'.$sty.'">';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('shipping_inv/sales_invoice_show?inv='.$r->invno).'"><i class="fa fa-pencil"></i></a>'; ?>
            <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->invno;?>')"><i class="fa fa-trash"></i></a>
            <a class="btn-sm btn-success" title="Excel" href="<?php echo site_url('shipping_inv/sales_invoice_excel?inv='.$r->invno);?>" ><i class="fa fa-file-excel-o"></i></a>
        <?php 
            echo '<a type="button" title="Print" class="btn-sm btn-info" href="'.site_url('shipping_inv/sales_invoice_print?inv='.$r->invno).'" target="_blank"><i class="fa fa-print"></i></a>';
        echo '</td>';
        echo '<td nowrap>'.$r->invno.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->docdate)).'</td>';
        if ($r->status == 2){
            echo '<td nowrap>Close</td>';
        }else if ($r->status == 3){
            echo '<td nowrap>Cancel</td>';
        } else {
            echo '<td nowrap>Open</td>';
        }
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td nowrap>'.$r->custcontact.'</td>';
        echo '<td nowrap>'.$r->ponumber.'</td>';
        echo '<td nowrap>'.$r->cust_ref.'</td>';
        echo '<td nowrap>'.number_format($r->totaldue,2).'</td>';
        echo '<td nowrap>'.$r->currency.'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'. $r->createddate.'</td>';
        echo '<td nowrap>'. $r->lastupdatedby.'</td>';
        echo '<td nowrap>'. $r->lastupdateddate.'</td>';
    echo '</tr>';
} 
?>
