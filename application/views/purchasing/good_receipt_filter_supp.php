<?php foreach ($supp as $r){
    echo '<tr ondblclick="clickdbsupp(this)">';
        echo '<td nowrap>'.$r->supplierid.'</td>';
        echo '<td nowrap>'.$r->suppliercompany.'</td>';
        echo '<td nowrap>'.$r->contactperson.'</td>';
        echo '<td hidden>'.$r->taxcode.'</td>';
        echo '<td hidden>'.$r->taxprice.'</td>';
    echo '</tr>';
 } 
 ?>