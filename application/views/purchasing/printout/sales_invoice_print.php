<?php
    foreach ($_getInv as $r){
        $invno=$r->invno;
        $custid=$r->custid;
        $docdate=date("m/d/Y",  strtotime($r->docdate));
        $shipdate=date("m/d/Y",  strtotime($r->shipdate));
        $createdby=$r->createdby;
        $via=$r->via;
        $remark=$r->remark;
        $maintotal=$r->maintotal;
        $freight=$r->freight;
        $tax=$r->tax;
        $disc=$r->discount;
        $totaldue=$r->totaldue;
    }
?>

<page style="font-size: 12px; font-family: freeserif;" backtop="119mm" backbottom="30mm">
    <page_header style="font-size: 12px; font-family: freeserif;">
        <table cellspacing="0" style="width: 100%; border-top: 1px;border-left: 1px;border-right: 1px;" class="page_header">
            <tr>
                <td style="width: 100%; border-bottom: 1px;" colspan="2">
                    <img src="<?php echo base_url();?>assets/pss-header.png" width="700" alt="rsup-logo"/>
                </td>
            </tr>
            <tr>
                <td style="width: 50%;">&nbsp;</td>
                <td style="width: 50%; font-size: 25px; text-align: center;font-weight: bold;">INVOICE</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;">
                    <table style="width: 100%;" cellspacing="0">
                        <tr>
                            <td style="width: 50%;"></td>
                            <td style="width: 50%;">
                                <table style="width: 100%;" cellspacing="0">
                                    <tr>
                                        <td style="width: 33.33%; text-align: right;">&nbsp;</td>
                                        <td style="width: 33.33%; text-align: right; border: 1px; padding-top: 5px; padding-bottom: 5px;">Invoice No.</td>
                                        <td style="width: 33.33%; text-align: left; border-top: 1px;border-bottom: 1px; border-right: 1px;"><?php echo $invno ;?></td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td style="width: 33.33%; text-align: right; border-bottom: 1px; border-left: 1px;border-right: 1px; padding-top: 5px; padding-bottom: 5px;">Customer No.</td>
                                        <td style="width: 33.33%; text-align: left; border-bottom: 1px; border-right: 1px;"><?php echo $custid ;?></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;">
                    <table style="width: 100%;" cellspacing="0">
                        <tr>
                            <td style="width: 50%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td colspan="2" style="width: 100%; text-align: center; border: 1px;"> Bill To :</td>
                                    </tr>
                                    <tr><td style="padding-left: 15px;font-weight: bold;"><?php echo $customer->customercompany; ?></td></tr>
                                    <tr>
                                        <td style="padding-left: 15px;">
                                            <?php echo $customer->address; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 50%;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td colspan="2" style="width: 100%; text-align: center; border: 1px;"> Ship To :</td>
                                    </tr>
                                    <tr><td style="padding-left: 15px;font-weight: bold;"><?php echo $customer->customercompany; ?></td></tr>
                                    <tr>
                                        <td style="padding-left: 15px;">
                                            <?php echo $customer->address; ?>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>

            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2" style="width: 100%;">
                    <table style="width: 100%;" cellspacing="0">
                        <tr>
                            <td style="width: 50%; text-align: center;">
                                <span style="font-weight: bold;">Telephone</span> : <?php echo $customer->telephone; ?><br>
                                <span style="font-weight: bold;">Contact</span> : <?php echo strtoupper($customer->contactperson); ?>
                            </td>
                            <td style="width: 50%; text-align: center;">
                                <span style="font-weight: bold;">Telephone</span> : <?php echo $customer->telephone; ?><br>
                                <span style="font-weight: bold;">Contact</span> : <?php echo strtoupper($customer->contactperson); ?>
                            </td>
                        </tr>
                    </table>
                </td>  
            </tr>
            <tr>
                <td colspan="2">&nbsp;</td>
            </tr>

            <tr>
                <td colspan="2" style="width: 100%;">
                    <table style="width: 100%; border: 1px;" cellspacing="0">
                        <tr style="font-weight: bold;">
                            <td style="width: 50%; border-bottom: 1px;border-right: 1px;text-align: center;">Ship Via</td>
                            <td style="width: 50%; border-bottom: 1px;text-align: center;">Payment Terms</td>
                        </tr>
                        <tr>
                            <td style="width: 50%; border-right: 1px;"><?php echo $via; ?>&nbsp;</td>
                            <td style="width: 50%;"><?php echo $customer->term; ?>&nbsp;</td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="width: 100%;">
                    <table style="width: 100%; border: 1px;" cellspacing="0">
                        <tr style="font-weight: bold;">
                            <td style="width: 12.5%; border-bottom: 1px;border-right: 1px;text-align: center;">Invoice Date</td>
                            <td style="width: 12.5%; border-bottom: 1px;border-right: 1px;text-align: center;">Ship Date</td>
                            <td style="width: 25%; border-bottom: 1px;border-right: 1px;text-align: center;">SO #</td>
                            <td style="width: 50%; border-bottom: 1px;text-align: center;">Remark</td>
                        </tr>
                        <tr>
                            <td style="border-right: 1px;text-align: center;"><?php echo $docdate; ?></td>
                            <td style="border-right: 1px;text-align: center;"><?php echo $shipdate; ?></td>
                            <td style="border-right: 1px;text-align: center;">&nbsp;</td>
                            <td><?php echo $remark; ?></td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        
        <table style="width: 100%; border: 1px;" cellspacing="0">
            <tr style="font-weight: bold;">
                <td style="width: 62.5%; border-right: 1px;border-bottom: 1px;text-align: center;">Item Number</td>
                <td rowspan="2" style="width: 12.5%; border-right: 1px;text-align: center;">Quantity</td>
                <td rowspan="2" style="width: 12.5%; border-right: 1px;text-align: center;">Unit Price</td>
                <td rowspan="2" style="width: 12.5%;text-align: center;">Extended Price</td>
            </tr>
            <tr style="font-weight: bold;">
                <td style="border-right: 1px;text-align: center;text-align: center;">Item Description</td>
            </tr>
        </table>
    </page_header>
    
    <page_footer style="font-size: 12px; font-family: freeserif;">
        <table cellspacing="0" style="width: 100%; border: 1px;" class="page_footer">
             <!--footer--> 
            <tr>
                <td style="width: 30%; vertical-align: top;">
                    <table cellspacing="0" style="width: 90%;">
                        <tr>
                            <td style="text-align: right;">&nbsp;</td>
                            <td style="text-align: left;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">&nbsp;</td>
                            <td style="text-align: left;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">&nbsp;</td>
                            <td style="text-align: left;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="text-align: center;">&nbsp;</td>
                        </tr>
                        <tr>
                            <td style="width: 35%; text-align: right;">Printed By :</td>
                            <td style="width: 65%; text-align: left;"><?php echo $this->session->userdata('firstname'); ?></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Page # :</td>
                            <td style="text-align: left;">[[page_cu]]/[[page_nb]]</td>
                        </tr>
                    </table>
                </td>

                <td style="width: 35%; vertical-align: top;">
                    &nbsp;
                </td>
                <td style="width: 35%; text-align-last: right;">
                    &nbsp;
                </td>
            </tr>
        </table>
    </page_footer>
    
    
    <?php 
    $numItems = count($_getInv);
    $i = 0;
    foreach ($_getInv as $row): 
        $df = ++$i?>
        <?php if($df === $numItems || $df === 8 || $df === 16): ?>
            <table style="width: 100%; border-right: 1px; border-left: 1px; border-bottom: 1px;" cellspacing="0">
                <tr style=" vertical-align: top;">
                    <td style="width: 62.5%; border-right: 1px;">
                        <?php  echo $row->itemid;?><br/>
                        <?php  echo $row->itemname;?>
                    </td>
                    <td style="width: 12.5%; border-right: 1px; height: 54px; text-align: right;">
                        <?php  echo number_format($row->qty,2);?> &nbsp;
                    </td>
                    <td style="width: 12.5%; border-right: 1px; text-align: right;">
                        <?php  echo number_format($row->unitprice,2);?>
                    </td>
                    <td style="width: 12.5%; text-align: right;">
                        <?php  echo number_format($row->unitprice * $row->qty,2);?>
                    </td>
                </tr>
            </table>
            
            <?php if($df === $numItems): ?>
<!--                <page_footer style="font-size: 12px; font-family: freeserif;">
                    <table cellspacing="0" style="width: 100%; border-bottom: 1px;" class="page_footer">
                         footer 
                        <tr>
                            <td style="width: 30%; vertical-align: top;">
                                <table cellspacing="0" style="width: 90%;">
                                    <tr>
                                        <td style="width: 50%; border-top: 1px; text-align: right;">&nbsp;</td>
                                        <td style="width: 50%; border-top: 1px; text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; text-align: right;">&nbsp;</td>
                                        <td style="width: 50%; text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; text-align: right;">&nbsp;</td>
                                        <td style="width: 50%; text-align: left;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 35%; vertical-align: top;">
                                <table cellspacing="0" style="width: 90%;">
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; border-top: 1px; text-align: right;">Total Praid</td>
                                        <td style="width: 50%; border-right: 1px; border-top: 1px; text-align: right;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">&nbsp;</td>
                                        <td style="width: 50%; border-right: 1px; text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; border-bottom: 1px; text-align: right;">Balance Due</td>
                                        <td style="width: 50%; border-right: 1px; border-bottom: 1px; text-align: right;">&nbsp;</td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 35%; text-align-last: right;">
                                <table cellspacing="0" style="width: 100%;">
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; border-top: 1px; text-align: right;">Sub Total</td>
                                        <td style="width: 50%; border-top: 1px; text-align: right;"><?php echo number_format($maintotal,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">Freight</td>
                                        <td style="width: 50%; text-align: right;"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">Sales Tax</td>
                                        <td style="width: 50%; text-align: right;"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">&nbsp;</td>
                                        <td style="width: 50%; text-align: right;"></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; border-left: 1px; border-right: 1px; border-bottom: 1px; text-align: right;">Invoice Total</td>
                                        <td style="width: 50%; border-bottom: 1px; text-align: right;"><?php echo number_format($maintotal,2); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%;">&nbsp;</td>
                                        <td style="width: 50%;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 50%; border-bottom: 1px;">&nbsp;</td>
                                        <td style="width: 50%; border-bottom: 1px;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="font-weight: bold;">Approved By</td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </page_footer>-->
    
                <page_footer style="font-size: 12px; font-family: freeserif;">
                    <table cellspacing="0" style="width: 100%; border-left: 1px; border-right: 1px; border-bottom: 1px;" class="page_footer">
                        <!-- footer -->
                        <tr>
                            <td style="width: 30%; vertical-align: top;">
                                <table cellspacing="0" style="width: 90%;">
                                    <tr>
                                        <td style="text-align: right;">&nbsp;</td>
                                        <td style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">&nbsp;</td>
                                        <td style="text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td style="border-bottom: 1px; text-align: right;">&nbsp;</td>
                                        <td style="border-bottom: 1px; text-align: left;">&nbsp;</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="text-align: center; font-weight: bold;">Approved By</td>
                                    </tr>
                                    <tr>
                                        <td style="width: 35%; text-align: right;">Printed By :</td>
                                        <td style="width: 65%; text-align: left;"><?php echo $this->session->userdata('firstname'); ?></td>
                                    </tr>
                                    <tr>
                                        <td style="text-align: right;">Page # :</td>
                                        <td style="text-align: left;">[[page_cu]]/[[page_nb]]</td>
                                    </tr>
                                </table>
                            </td>
                                <td style="width: 35%; vertical-align: top;">
                                    <table cellspacing="0" style="width: 90%;">
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">Total Praid</td>
                                            <td style="width: 50%; border-right: 1px; text-align: right;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">&nbsp;</td>
                                            <td style="width: 50%; border-right: 1px; text-align: left;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; border-bottom: 1px; text-align: right;">Balance Due</td>
                                            <td style="width: 50%; border-right: 1px; border-bottom: 1px; text-align: right;">&nbsp;</td>
                                        </tr>
                                    </table>
                                </td>
                                <td style="width: 35%; text-align-last: right;">
                                    <table cellspacing="0" style="width: 100%;">
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">Sub Total</td>
                                            <td style="width: 50%; border-right: 1px; text-align: right;"><?php echo number_format($maintotal,2); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">Discount</td>
                                            <td style="width: 50%; border-right: 1px; text-align: right;"><?php echo number_format($disc,2); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">Freight</td>
                                            <td style="width: 50%; border-right: 1px; text-align: right;"><?php echo number_format($freight,2); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">Sales Tax</td>
                                            <td style="width: 50%; border-right: 1px; text-align: right;"><?php echo number_format($tax,2); ?></td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; text-align: right;">&nbsp;</td>
                                            <td style="width: 50%; border-right: 1px; text-align: right;">&nbsp;</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 50%; border-left: 1px; border-right: 1px; border-bottom: 1px; text-align: right;">Grand Total</td>
                                            <td style="width: 50%; border-right: 1px; border-bottom: 1px; text-align: right;"><?php echo number_format($totaldue,2); ?></td>
                                        </tr>
                                    </table>
                                </td>
                        </tr>
                    </table>
                </page_footer>
            <?php endif; ?>
        <?php else: ?>
            <table style="width: 100%; border-right: 1px; border-left: 1px;" cellspacing="0">
                <tr style=" vertical-align: top;">
                    <td style="width: 62.5%; border-right: 1px;">
                        <?php  echo $row->itemid;?><br/>
                        <?php  echo $row->itemname;?>
                    </td>
                    <td style="width: 12.5%; border-right: 1px; height: 54px; text-align: right;">
                        <?php  echo number_format($row->qty,2);?> &nbsp;
                    </td>
                    <td style="width: 12.5%; border-right: 1px; text-align: right;">
                        <?php  echo number_format($row->unitprice,2);?>
                    </td>
                    <td style="width: 12.5%; text-align: right;">
                        <?php  echo number_format($row->unitprice * $row->qty,2);?>
                    </td>
                </tr>
            </table>
        <?php endif; ?>
    
    <?php  endforeach;?>
    
</page>