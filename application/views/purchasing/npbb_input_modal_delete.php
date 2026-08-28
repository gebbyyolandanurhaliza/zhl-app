<?php 
    foreach ($npbb as $r){
        $npbbno=$r->npbbno;
        $date=date("d-m-Y",  strtotime($r->transdate));
        $companyid=$r->companyid;
        $companyname=$r->companyfullname;
    }
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <table cellspacing="0" style="width: 100%;">
                <tr><td style="width: 35%;">
                        <table cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="width: 10%;">NPBB</td>
                                <td style="width: 50%;"> : <?php echo $npbbno;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Date</td>
                                <td style="width: 50%;"> : <?php echo $date;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Factory</td>
                                <td style="width: 50%;"> : <?php echo $companyname;?></td>
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
                            <th>PM Code</th>
                            <th>UOM</th>
                            <th>Qty</th>
                            <th>Price</th>
                            <th>New Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach ($npbb as $r){ 
                            echo '<tr>';
                                echo '<td>'.$i.'</td>';
                                echo '<td>'.$r->itemid.'</td>';
                                echo '<td>'.htmlspecialchars($r->itemname,ENT_QUOTES).'</td>';
                                echo '<td>'.$r->pmcode.'</td>';
                                echo '<td>'.$r->uomname.'</td>';
                                echo '<td>'.number_format($r->qnty,2).'</td>';
                                echo '<td>'.number_format($r->unitprice,2).'</td>';
                                echo '<td>'.number_format($r->newunitprice,2).'</td>';
                            echo '</tr>';
                        $i++;}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="<?php echo site_url('purchasing_npbb/npbb_delete/'.str_replace("/",".slash",$npbbno).'/'.$companyid); ?>" onclick="javasciprt: return confirm('Are you sure delete NPBB <?php echo $npbbno; ?> ?')">Delete</a>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        </div>	
    </div>
</div>