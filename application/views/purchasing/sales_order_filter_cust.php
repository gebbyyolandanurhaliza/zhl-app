<?php foreach ($cust as $r){
    echo '<tr ondblclick="clickdbcust(this)" style="cursor: pointer;">';
        echo '<td nowrap>'.$r->customer_code.'</td>';
        echo '<td nowrap>'.$r->customer_company_name.'</td>';
        echo '<td nowrap>'.$r->customer_contact_name.'</td>';
        echo '<td hidden>'.$r->customer_term.'</td>';
    echo '</tr>';
}
