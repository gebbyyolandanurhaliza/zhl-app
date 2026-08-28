<?php foreach ($packdo as $r){
    echo '<tr>';
        echo '<td nowrap>';
             ?>
            <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger"><i class="fa fa-trash"></i></a>
            <?php
            echo '<a class="btn-sm btn-info" title="Print" href="'.site_url('Packing_do/print_report?hdr_id='.$r->hdr_id.'&type='.$r->type).'" target="_blank"><i class="fa fa-print"></i></a>';
        echo '</td>';
        echo '<td nowrap>'.$r->type.'</td>';
       
        foreach ($_factory as $cr) {
            if ($cr->customerid == $r->factory_id) {
                 echo '<td nowrap>'.$cr->customercompany.'</td>';} 
        }
        echo '<td nowrap>'.$r->hdr_id.'</td>';
        echo '<td nowrap>'.$r->ship_via.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->ship_date)).'</td>';
    echo '</tr>';
} 
?>
