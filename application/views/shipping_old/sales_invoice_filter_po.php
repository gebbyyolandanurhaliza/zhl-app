<?php foreach ($po as $r) {
    echo '<tr>';
        echo '<td style="width: 5px;"><input type="checkbox" onclick="cek_cont(this)" name="chk[]" value="'.$r->contid_dtl.'"></td>';
        echo '<td nowrap>'.$r->po_number.'</td>';
        echo '<td nowrap>'.date("d-m-Y",  strtotime($r->po_date)).'</td>';
        echo '<td nowrap>'.$r->factory_name.'</td>';
        echo '<td nowrap>'.$r->product_code.'</td>';
        echo '<td nowrap>'.htmlspecialchars($r->product_name,ENT_QUOTES).'</td>';
        echo '<td nowrap>'.$r->uom_quantity_name.'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->quantity,0,'.','').'</td>';
        echo '<td nowrap class="text-right">'.number_format($r->invoice_price,2,'.','').'</td>';
        echo '<td hidden>'.$r->contid_dtl.'</td>';
        echo '<td hidden>'.$r->po_hdr_id.'</td>';
        echo '<td hidden>'.$r->product_id.'</td>';
        echo '<td hidden>'.$r->payment_terms.'</td>';
        echo '<td hidden>'.$r->client_ref_no.'</td>';
    echo '</tr>';
 } 
 ?>