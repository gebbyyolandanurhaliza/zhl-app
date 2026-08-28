<?php 
    foreach ($inv as $r){
        $name=  $r->custcompany;
        $currency=  $r->currency;
        $status=  $r->status;
        
        if($status != '1'){
            $status='Close';
        } else {
            $status='Open';
        }
        
        $docdate=  date("d-m-Y",  strtotime($r->docdate));
        $invno=  $r->invno;
    }
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <table cellspacing="0" style="width: 100%;">
                <tr>
                    <td style="width: 35%;">
                        <table cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="width: 10%;">Inv No</td>
                                <td style="width: 50%;"> : <?php echo $invno;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Date</td>
                                <td style="width: 50%;"> : <?php echo $docdate;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Status</td>
                                <td style="width: 50%;"> : <?php echo $status;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Customer</td>
                                <td style="width: 50%;"> : <?php echo $name;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Currency</td>
                                <td style="width: 50%;"> : <?php echo $currency;?></td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            <hr>
            
            <div class="v-scroll">
                <table class="table table-condensed table-hover table-fixed">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ItemID</th>
                            <th>ItemName</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach ($inv as $r){ 
                            echo '<tr>';
                                echo '<td>'.$i.'</td>';
                                echo '<td>'.$r->itemid.'</td>';
                                echo '<td>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
                                echo '<td>'.$r->uomname.'</td>';
                                echo '<td>'.number_format($r->qty,2).'</td>';
                                echo '<td>'.number_format($r->unitprice,2).'</td>';
                            echo '</tr>';
                        $i++;}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="<?php echo site_url('purchasing_inv/sales_invoice_direct_delete?inv='.$invno); ?>" onclick="javasciprt: return confirm('Are you sure delete Invoice <?php echo $invno; ?> ?')">Delete</a>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        </div>	
    </div>
</div>