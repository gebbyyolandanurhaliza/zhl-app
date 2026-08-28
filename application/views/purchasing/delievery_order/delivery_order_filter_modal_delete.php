<?php 
    foreach ($do as $r){
        $docno=  $r->docno;
        $docdate= date("d-m-Y",  strtotime($r->docdate));
        $duedate=  date("d-m-Y",  strtotime($r->duedate));
    }
?>

<div class="modal-dialog modal-lg">
    <form action="<?php echo site_url('Purchasing_do/delivery_order_delete'); ?>" method="post" class="form-horizontal" role="form">
    <div class="modal-content">
        <div class="modal-body">
            <input type="hidden" class="form-control input-sm" name="docno" value="<?php echo $docno; ?>" readonly>
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
                            <th>Qty Warehouse</th>
                            <th>Qty Out</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach ($do as $r){  ?>
                            <tr>
                                <td><input type="hidden" name="MainPO[]" value="<?php echo $r->mainpo; ?>"><?php echo $i++; ?></td>
                                <td><input type="hidden" name="ItemID[]" value="<?php echo $r->itemid; ?>"><?php echo $r->itemid; ?></td>
                                <td><input type="hidden" name="custid[]" value="<?php echo $r->custidbyorder; ?>"><?php echo htmlspecialchars($r->itemname,ENT_QUOTES); ?></td>
                                <td><input type="hidden" name="NPBB[]" value="<?php echo $r->npbbno; ?>"><?php echo $r->uomname; ?></td>
                                <td><input type="hidden" name="docno_gr[]" value="<?php echo $r->docno_gr; ?>"><?php echo number_format($r->qtypo,2); ?></td>
                                <td><?php echo number_format($r->qtywhs,2); ?></td>
                                <td><?php echo number_format($r->qtyout,2); ?></td>
                            </tr>
                           
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <button  type="submit" class="col-md-2 btn btn-danger right">Delete</button>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        </div>	
    </div>
</div>