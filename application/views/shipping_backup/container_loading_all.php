<?php
    foreach ($loading as $r){
        echo '<tr>';
            echo '<td nowrap>';
                echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('shipping/container_loading_show?load='.$r->headerid).'"><i class="fa fa-pencil"></i></a>'; ?>
                <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->headerid;?>')"><i class="fa fa-trash"></i></a>
                <a class="btn-sm btn-success" title="Excel" href="<?php echo site_url('shipping/container_loading_excel?load='.$r->headerid);?>" ><i class="fa fa-file-excel-o"></i></a>
                <?php
                echo '<a class="btn-sm btn-info" title="Print" href="'.site_url('shipping/container_loading_print?load='.$r->headerid).'" target="_blank"><i class="fa fa-print"></i></a>';
            echo '</td>';
            echo '<td>'.date("d-m-Y",  strtotime($r->docdate)).'</td>';
            echo '<td>'.$r->carrier.'</td>';
            echo '<td>'.$r->voyage.'</td>';
            echo '<td>'.$r->to.'</td>';
            echo '<td>'.$r->attn.'</td>';
            echo '<td>'.$r->from.'</td>';
            echo '<td>'.date("d-m-Y",  strtotime($r->etasin)).'</td>';
            echo '<td>'.$r->createdby.'</td>';
            echo '<td>'.$r->createddate.'</td>';
            echo '<td>'.$r->lastupdatedby.'</td>';
            echo '<td>'.$r->lastupdateddate.'</td>';
        echo '</tr>';
    }
?>