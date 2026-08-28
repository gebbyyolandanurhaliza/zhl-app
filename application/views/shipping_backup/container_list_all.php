<?php
    foreach ($cont as $r){
        if($r->tipe == 1){
            $cont='Container Outward';
            $where='container_outward_excel';
        } else {
            $cont='Container Inward';
            $where='container_inward_excel';
        }
        $etddateTemp=$r->etddate;
        $etadateTemp=$r->etadate;
        
        if ($etddateTemp != '0000-00-00'){
            $etddate=date("d/m/Y",  strtotime($etddateTemp));
        } else {
            $etddate='';
        }
        
        if ($etadateTemp != '0000-00-00'){
            $etadate=date("d/m/Y",  strtotime($etadateTemp));
        } else {
            $etadate='';
        }
        
        
        echo '<tr>';
            echo '<td nowrap>';
                echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('shipping/container_show?cont='.$r->contid.'&tipe='.$r->tipe).'"><i class="fa fa-pencil"></i></a>'; ?>
                <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo $r->contid;?>')"><i class="fa fa-trash"></i></a>
                <a class="btn-sm btn-success" title="Excel" href="<?php echo site_url('shipping/'.$where.'?cont='.$r->contid);?>" ><i class="fa fa-file-excel-o"></i></a>
                <?php
                echo '<a class="btn-sm btn-info" title="Print" href="'.site_url('shipping/container_print?cont='.$r->contid.'&tipe='.$r->tipe).'" target="_blank"><i class="fa fa-print"></i></a>';
            echo '</td>';
            echo '<td>'.$cont.'</td>';
            echo '<td>'.date("d-m-Y",  strtotime($r->shipmentdate)).'</td>';
            echo '<td>'.$r->barge.'</td>';
            echo '<td>'.$r->voyage.'</td>';
            echo '<td>'.$r->etd.'</td>';
            echo '<td>'.$etddate.'</td>';
            echo '<td>'.$r->eta.'</td>';
            echo '<td>'.$etadate.'</td>';
            echo '<td>'.$r->from.'</td>';
            echo '<td>'.$r->to.'</td>';
            echo '<td>'.$r->createdby.'</td>';
            echo '<td>'.$r->createddate.'</td>';
            echo '<td>'.$r->lastupdatedby.'</td>';
            echo '<td>'.$r->lastupdateddate.'</td>';
        echo '</tr>';
    }
?>