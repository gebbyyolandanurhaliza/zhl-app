<?php foreach ($supp as $r){
    echo '<tr ondblclick="clickdbsupp(this)" style="cursor: pointer;">';
        echo '<td nowrap>'.$r->vendorid.'</td>';
        echo '<td nowrap>'.$r->vendorcompany.'</td>';
        echo '<td nowrap>'.$r->contactperson.'</td>';
        echo '<td hidden>'.$r->taxcode.'</td>';
        echo '<td hidden>'.$r->taxprice.'</td>';
   echo '</tr>';
} 
?>