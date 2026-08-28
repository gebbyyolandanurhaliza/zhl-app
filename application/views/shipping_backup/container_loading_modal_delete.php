<?php 
    foreach ($loading as $r){
        $headerid=$r->headerid;
        $date=date("d-m-Y",  strtotime($r->docdate));
        $to=$r->to;
        $attn=$r->attn;
        $from=$r->from;
    }
?>

<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-body">
            <table cellspacing="0" style="width: 100%;">
                <tr><td style="width: 35%;">
                        <table cellspacing="0" style="width: 100%;">
                            <tr>
                                <td style="width: 10%;">Date</td>
                                <td style="width: 50%;"> : <?php echo $date;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">To</td>
                                <td style="width: 50%;"> : <?php echo $to;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">ATTN</td>
                                <td style="width: 50%;"> : <?php echo $attn;?></td>
                            </tr>
                            <tr>
                                <td style="width: 10%;">From</td>
                                <td style="width: 50%;"> : <?php echo $from;?></td>
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
                            <th nowrap>Container</th>
                            <th nowrap>Booking Ref</th>
                            <th nowrap>Vessel / Voyage</th>
                            <th nowrap>Port Of Disch</th>
                            <th nowrap>Destination</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i=1;
                        foreach ($loading as $r){ 
                            echo '<tr>';
                                echo '<td nowrap>'.$i.'</td>';
                                echo '<td nowrap>'.$r->container.'</td>';
                                echo '<td nowrap>'.$r->reff.'</td>';
                                echo '<td nowrap>'.$r->vessel.'</td>';
                                echo '<td nowrap>'.$r->port.'</td>';
                                echo '<td nowrap>'.$r->destination.'</td>';
                            echo '</tr>';
                        $i++;}
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer">
            <a class="btn btn-danger" href="<?php echo site_url('shipping/container_loading_delete?load='.$headerid); ?>" onclick="javasciprt: return confirm('Are you sure delete this Data ?')">Delete</a>
            <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        </div>	
    </div>
</div>