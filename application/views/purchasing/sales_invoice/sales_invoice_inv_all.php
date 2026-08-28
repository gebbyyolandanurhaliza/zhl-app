<?php foreach ($inv as $r){
    $sty='';
    if($r->status == 2){
        $sty='success';
    } else if($r->status == 3){
        $sty = 'danger';
    }
    echo '<tr class="'.$sty.'">';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('purchasing_inv/sales_invoice_show?inv='.$r->invno).'"><i class="fa fa-pencil"></i></a>'; ?>
            <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->invno;?>')"><i class="fa fa-trash"></i></a>
              <!-- <div class="btn-group">
                <button id="btn-print" style="padding-top:2px;padding-bottom:2px;padding-left:7px;padding-right:7px;" type="button" class="btn-sm btn-info dropdown-toggle" data-toggle="dropdown"><i class="fa fa-print"></i></button>
                <ul class="dropdown-menu" role="menu" aria-labelledby="btn-print">
                    <li>
                        <a href="<?php // echo site_url('purchasing_inv/sales_invoice_print/'.str_replace("/", ".slash",$r->invno));?>" target="blank">Sales Invoice</a>
                    </li>
                    <li>
                        <a href="<?php // echo site_url('purchasing_inv/sales_contract_print/'.str_replace("/", ".slash",$r->invno));?>" target="blank">Sales Contract</a>
                    </li>
                </ul>
            </div>-->
        <?php 
            echo '<a type="button" title="Print" class="btn-sm btn-info" href="'.site_url('purchasing_inv/sales_invoice_print?inv='.$r->invno).'" target="_blank"><i class="fa fa-print"></i></a>';
        echo '</td>';
        echo '<td nowrap>'.$r->invno.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->docdate)).'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->shipdate)).'</td>';
        if ($r->status == 2){
            echo '<td nowrap>Close</td>';
        } else if ($r->status == 3){
            echo '<td nowrap>Cancel</td>';
        } else {
            echo '<td nowrap>Open</td>';
        }
        echo '<td nowrap>'.$r->custcompany.'</td>';
        echo '<td nowrap>'.$r->custcontact.'</td>';
        echo '<td>'.$r->mainpo.'</td>';
        echo '<td nowrap>'.number_format($r->totaldue,2).'</td>';
        echo '<td nowrap>'.$r->currency.'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'. $r->createddate.'</td>';
        echo '<td nowrap>'. $r->lastupdatedby.'</td>';
        echo '<td nowrap>'. $r->lastupdateddate.'</td>';
    echo '</tr>';
} 
?>
