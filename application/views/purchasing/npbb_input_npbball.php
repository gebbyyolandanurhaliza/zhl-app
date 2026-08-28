<?php foreach ($npbb as $r){
    echo '<tr>';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-warning" title="Edit" href="'.site_url('purchasing_npbb/npbb_edit/'.str_replace("/",".slash",$r->npbbno).'/'.$r->companyid).'"><i class="fa fa-pencil"></i></a>';?>
            <a data-toggle="modal" title="Delete" data-target="#modal_delete" class="btn-sm btn-danger" onclick="modal_delete('<?php echo str_replace("/",".slash",$r->npbbno).'/'.$r->companyid;?>')"><i class="fa fa-trash"></i></a>
        <?php
        echo '</td>';
        echo '<td nowrap>'.$r->npbbno.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->transdate)).'</td>';
        echo '<td nowrap>'.$r->companyfullname.'</td>';
        echo '<td nowrap>'.$r->currencyid.'</td>';
        echo '<td nowrap>'.$r->itemid.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->qnty,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->unitprice,2).'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->newunitprice,2).'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'.$r->createddate.'</td>';
        echo '<td nowrap>'.$r->lastupdatedby.'</td>';
        echo '<td nowrap>'.$r->lastupdateddate.'</td>';
    echo '</tr>';
} ?>