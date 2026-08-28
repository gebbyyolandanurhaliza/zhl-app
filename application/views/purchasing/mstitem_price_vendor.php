<?php foreach ($vendor as $r){
    echo '<tr ondblclick="clickdbvendor(this)">';
        echo '<td nowrap>'.$r->vendorid.'</td>';
        echo '<td nowrap>'.$r->vendorcompany.'</td>';
        echo '<td nowrap>'.$r->contactperson.'</td>';
    echo '</tr>';
}
