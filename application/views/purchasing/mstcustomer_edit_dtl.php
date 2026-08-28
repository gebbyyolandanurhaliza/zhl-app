<?php foreach ($cust as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>';
           echo '<a class="btn-sm btn-warning" href="'.site_url('purchasing/customer_edit?cust='.$r->customer_code).'"><i class="fa fa-pencil"></i></a>';?>
           <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/customer_delete?cust='.$r->customer_code);?>" onclick="javasciprt: return confirm('Are you sure delete Company <?php echo $r->customer_name;?> ?')"><i class="fa fa-trash"></i></a>
        <?php echo '</td>';
        echo '<td nowrap>'.$r->customer_code.'</td>';
        echo '<td nowrap>'.$r->customer_name.'</td>';
        echo '<td nowrap>'.$r->customer_company_name.'</td>';
        echo '<td nowrap>'.$r->customer_contact_name.'</td>';
        echo '<td nowrap>'.$r->customer_address.'</td>';
        echo '<td nowrap>'.$r->customer_phone.'</td>';
        echo '<td nowrap>'.$r->customer_mobilephone.'</td>';
        echo '<td nowrap>'.$r->customer_fax.'</td>';
        echo '<td nowrap>'.$r->customer_email.'</td>';
        echo '<td nowrap>'.$r->customer_term.'</td>';
        echo '<td nowrap>'.$r->created_by.'</td>';
        echo '<td nowrap>'.$r->created_date.'</td>';
        echo '<td nowrap>'.$r->updated_by.'</td>';
        echo '<td nowrap>'.$r->updated_date.'</td>';
    echo '</tr>';
}
?>