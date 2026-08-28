<?php foreach ($supp as $r){
    echo '<tr style="cursor: pointer;">';
        echo '<td nowrap>';
            echo '<a class="btn-sm btn-warning" href="'.site_url('purchasing/vendor_edit?vendor='.$r->supplierid).'"><i class="fa fa-pencil"></i></a>';?>
            <a class="btn-sm btn-danger" href="<?php echo site_url('purchasing/vendor_delete?vendor='.$r->supplierid);?>" onclick="javasciprt: return confirm('Are you sure delete Company <?php echo $r->suppliercompany;?> ?')"><i class="fa fa-trash"></i></a>
        <?php echo '</td>';
        echo '<td nowrap>'.$r->supplierid.'</td>';
        echo '<td nowrap>'.$r->suppliercompany.'</td>';
        echo '<td nowrap>'.$r->address.'</td>';
        echo '<td nowrap>'.$r->telephone.'</td>';
        echo '<td nowrap>'.$r->mobilephone.'</td>';
        echo '<td nowrap>'.$r->did.'</td>';
        echo '<td nowrap>'.$r->fax.'</td>';
        echo '<td nowrap>'.$r->postalcode.'</td>';
        echo '<td nowrap>'.$r->group.'</td>';
        echo '<td nowrap>'.$r->contactperson.'</td>';
        echo '<td nowrap>'.$r->email.'</td>';
        echo '<td nowrap>'.$r->website.'</td>';
        echo '<td nowrap>'.$r->paymentterm.'</td>';
        echo '<td nowrap>'.$r->taxcode.'</td>';
        echo '<td nowrap>'.$r->taxprice.'</td>';
        echo '<td nowrap>'.$r->createdby.'</td>';
        echo '<td nowrap>'.$r->createddate.'</td>';
        echo '<td nowrap>'.$r->lastupdatedby.'</td>';
        echo '<td nowrap>'.$r->lastupdateddate.'</td>';
    echo '</tr>';
}
?>