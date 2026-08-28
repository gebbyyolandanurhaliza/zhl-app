<?php 
    foreach ($gr as $r){
        $docno=  $r->docno;
        $docdate= date("d-m-Y",  strtotime($r->docdate));
        $duedate=  date("d-m-Y",  strtotime($r->duedate));
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
                                <td style="width: 10%;">Doc Date</td>
                                <td style="width: 50%;"> : <?php echo $docdate;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Delivery Date</td>
                                <td style="width: 50%;"> : <?php echo $duedate;?></td>
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
                            <th>Qty Order</th>
                            <th>Qty Recv</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach ($gr as $r){ 
                            echo '<tr>';
                                echo '<td>'.$i.'</td>';
                                echo '<td>'.$r->itemid.'</td>';
                                echo '<td>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
                                echo '<td>'.$r->uomname.'</td>';
                                echo '<td>'.number_format($r->qtypo,2).'</td>';
                                echo '<td>'.number_format($r->qtywhs,2).'</td>';
                            echo '</tr>';
                        $i++;}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="<?php echo site_url('purchasing_gr/good_receipt_delete?gr='.$docno); ?>" onclick="javasciprt: return confirm('Are you sure delete Doc No <?php echo $docno; ?> ?')">Delete</a>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        </div>	
    </div>
</div>