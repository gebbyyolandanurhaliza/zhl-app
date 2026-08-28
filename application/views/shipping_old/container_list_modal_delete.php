<?php 
    foreach ($cont as $r){
        $contid=$r->contid;
        $barge=$r->barge;
        $voyage=$r->voyage;
        $etd=$r->etd;
        $etddateTemp=$r->etddate;
        $eta=$r->eta;
        $etadateTemp=$r->etadate;
        
        $tipe=$r->tipe;
        
        if ($tipe == 1){
            $ward='Container Outward';
        } else {
            $ward='Container Inward';
        }
        
        if ($etddateTemp != '0000-00-00'){
            $etddate=date("d/m/Y",  strtotime($etddateTemp));
        } else {
            $etddate='';
        }
        
        if ($etadateTemp != '0000-00-00'){
            $etadate=date("d/m/Y",  strtotime($etadateTemp));
        } else {
            $etadate='';
        }
    }
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <table cellspacing="0" style="width: 100%;">
                <tr><td style="width: 35%;">
                        <table cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="width: 10%;">Tipe</td>
                                <td style="width: 50%;"> : <?php echo $ward;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Vessel (Barge)</td>
                                <td style="width: 50%;"> : <?php echo $barge;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">Voyage</td>
                                <td style="width: 50%;"> : <?php echo $voyage;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">ETD <?php echo $etd; ?></td>
                                <td style="width: 50%;"> : <?php echo $etddate;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">ETA <?php echo $eta; ?></td>
                                <td style="width: 50%;"> : <?php echo $etadate;?></td>
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
                            <th nowrap>PO Number</th>
                            <th nowrap>Shipper/Carrier</th>
                            <th nowrap>FCL</th>
                            <th nowrap>Destination</th>
                            <th nowrap>Booking Ref</th>
                            <th nowrap>Vessel/Voyage</th>
                            <th nowrap>Conecting Vessel</th>
                            <th nowrap>Depot</th>
                            <th nowrap>POD</th>
                            <th nowrap>OP Code</th>
                            <th nowrap>ETD Sin</th>
                            <th nowrap>ETA</th>
                            <?php 
                                if ($tipe == 2){
                                    echo '<th nowrap>Container</th>';
                                    echo '<th nowrap>Seal</th>';
                                    echo '<th nowrap>Weight</th>';
                                }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach ($cont as $r){
                            echo '<tr>';
                                echo '<td nowrap>'.$i.'</td>';
                                echo '<td nowrap>'.$r->po_number.'</td>';
                                echo '<td nowrap>'.$r->shipping_liner.'</td>';
                                echo '<td nowrap>'.$r->container_name.'</td>';
                                echo '<td nowrap>'.$r->destination.'</td>';
                                echo '<td nowrap>'.$r->reff.'</td>';
                                echo '<td nowrap>'.$r->vessel.'</td>';
                                echo '<td nowrap>'.$r->convessel.'</td>';
                                echo '<td nowrap>'.$r->depot.'</td>';
                                echo '<td nowrap>'.$r->pod.'</td>';
                                echo '<td nowrap>'.$r->opcode.'</td>';
                                echo '<td nowrap>'.$r->etdsin.'</td>';
                                echo '<td nowrap>'.$r->etasin.'</td>';
                                if ($tipe == 2){
                                    echo '<td nowrap>'.$r->container.'</td>';
                                    echo '<td nowrap>'.$r->seal.'</td>';
                                    echo '<td nowrap>'.$r->weight.'</td>';
                                }
                            echo '</tr>';
                        $i++;}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="<?php echo site_url('shipping/container_delete?cont='.$contid); ?>" onclick="javasciprt: return confirm('Are you sure delete this data ?')">Delete</a>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        </div>	
    </div>
</div>