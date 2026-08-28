                                <?php
                                $start = 0;
                                foreach ($freight as $xx)
                                {
                                ?>

                                <?php if ($xx->kadaluarsa <= '0'){?>
                                <tr style="color: green; cursor: pointer; font-size: 12px" onclick="pilih(this)">
                                <?php } elseif ($xx->kadaluarsa <= '7'){ ?>
                                <tr style="color: blue; cursor: pointer; font-size: 12px" onclick="pilih(this)">
                                <?php } else { ?>
                                <tr onclick="pilih(this)" style="cursor: pointer;">
                                <?php } ?>
                                    <td style="text-align:center" width="100px" style="font-size: 12px">
                                                    <a class="btn-sm btn-warning" href="<?php echo site_url('master-freight/edit/'.$xx->freight_charges_id); ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn-sm btn-danger" href="<?php echo site_url('master-freight/delete/'.$xx->freight_charges_id); ?>" onclick="javasciprt: return confirm('Are you sure delete Master Freight <?php echo $xx->container_name; ?> Port <?php echo $xx->port_name; ?> (<?php echo $xx->country_name; ?>) validity from <?php echo date('d-m-Y', strtotime($xx->validity_from));?> to <?php echo date('d-m-Y', strtotime($xx->validity_till));?>?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <td class="center" style="font-size: 12px"><?php echo ++$start ?></td>
                                    <td align="center" style="font-size: 12px"><b><?php echo $xx->kadaluarsa ?> Days </b></td>
                                    <?php if ($xx->kadaluarsa <= '7'){
                                        $exp = 'Please Update Rate and Validity...!';
                                    }else{
                                        $exp = '';
                                    }
                                    ?>
                                    <td align="center"><b><a style="color: green; font-size: 12px;"><?php echo $exp; ?></a></b></td>
                                    <td width='6%' style="font-size: 12px"><?php echo $xx->container_name ?></td>
                                    <td width='6%' style="font-size: 12px"><?php echo $xx->port_name ?></td>
                                    <!-- <td width='6%'><?php echo $xx->country_name ?></td> -->
                                    <td width='6%' style="font-size: 12px"><?php echo $xx->trading_term_name.' ('.$xx->trading_term_remark.')' ?></td>
                                    <td width='6%' style="font-size: 12px"><?php echo date('d-m-Y', strtotime($xx->validity_from)) ?></td>
                                    <td width='6%' style="font-size: 12px"><?php echo date('d-m-Y', strtotime($xx->validity_till)) ?></td>
<!--                                     <td width='6%'><?php echo $xx->shipping_line1 ?></td>
                                    <td width='6%'><?php echo $xx->vendor_rates ?></td>
                                    <td width='6%'><?php echo $xx->shipping_line2 ?></td>
                                    <td width='6%'><?php echo $xx->vendor_rates2 ?></td>
                                    <td width='6%'><?php echo $xx->shipping_line3 ?></td>
                                    <td width='6%'><?php echo $xx->vendor_rates3 ?></td> -->
                                    <td width='6%' style="font-size: 12px"><?php echo $xx->customer_name ?></td>
                                    <!-- <td width='6%'><?php echo $xx->consignee1 ?></td> -->
                                    <td width='6%' style="font-size: 12px"><?php echo $xx->cust_rates ?></td>
                                    <!-- <td width='6%'><?php echo $xx->consignee2 ?></td> -->
                                    <!-- <td width='6%'><?php echo $xx->cust_rates2 ?></td> -->
                                    <!-- <td width='6%'><?php echo $xx->consignee3 ?></td> -->
                                    <!-- <td width='6%'><?php echo $xx->cust_rates3 ?></td> -->
                                    <td width='6%' hidden=""><?php echo $xx->freight_charges_id ?></td>
                                </tr>
                            <?php
                                }
                            ?>