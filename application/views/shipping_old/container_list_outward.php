<?php
    foreach ($cont as $r){
        echo '<tr>';
            echo '<td nowrap>';
                echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('shipping/container_show_copy?cont='.$r->contid).'"><i class="fa fa-pencil"></i></a>';
            echo '</td>';
            if($r->tipe == 1){
                echo '<td>Container Outward</td>';
            } else {
                echo '<td>Container Inward</td>';
            }
            echo '<td>'.date("d-m-Y",  strtotime($r->shipmentdate)).'</td>';
            echo '<td>'.$r->barge.'</td>';
            echo '<td>'.$r->voyage.'</td>';
            echo '<td>'.$r->etd.'</td>';
            echo '<td>'.date("d-m-Y",  strtotime($r->etddate)).'</td>';
            echo '<td>'.$r->eta.'</td>';
            echo '<td>'.date("d-m-Y",  strtotime($r->etadate)).'</td>';
            echo '<td>'.$r->from.'</td>';
            echo '<td>'.$r->to.'</td>';
            echo '<td>'.$r->createdby.'</td>';
            echo '<td>'.$r->createddate.'</td>';
            echo '<td>'.$r->lastupdatedby.'</td>';
            echo '<td>'.$r->lastupdateddate.'</td>';
        echo '</tr>';
    }
?>