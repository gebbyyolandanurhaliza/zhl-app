<?php foreach ($vendor as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>'.$r->supplierid.'</td>';
        echo '<td nowrap>'.$r->suppliercompany.'</td>';
        echo '<td nowrap>'.$r->contactperson.'</td>';
    echo '</tr>';
}?>

