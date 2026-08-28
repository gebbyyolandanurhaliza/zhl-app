                                <?php
                                $start = 0;
                                foreach ($freight as $xx)
                                {
                                ?>

                                <?php if ($xx->kadaluarsa <= '0'){?>
                                <tr style="color: green; cursor: pointer;" onclick="pilih(this)">
                                <?php } elseif ($xx->kadaluarsa <= '7'){ ?>
                                <tr style="color: blue; cursor: pointer;" onclick="pilih(this)">
                                <?php } else { ?>
                                <tr onclick="pilih(this)" style="cursor: pointer;">
                                <?php } ?>
                                    <td style="text-align:center" width="100px">
                                                    <a class="btn-sm btn-warning" href="<?php echo site_url('master-freight-new/edit/'.$xx->freight_charges_id); ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn-sm btn-danger" href="<?php echo site_url('master-freight-new/delete/'.$xx->freight_charges_id); ?>" onclick="javasciprt: return confirm('Are you sure delete Master Freight <?php echo $xx->container_name; ?> Port <?php echo $xx->port_name; ?> (<?php echo $xx->country_name; ?>) validity from <?php echo date('d-m-Y', strtotime($xx->validity_from));?> to <?php echo date('d-m-Y', strtotime($xx->validity_till));?>?')"><i class="fa fa-trash"></i></a>
                                    </td>
                                    <td class="center"><?php echo ++$start ?></td>
                                    <td align="center"><b><?php echo $xx->kadaluarsa ?> Days </b></td>
                                    
                                    <?php 

                                    if ($xx->need_comfirm >= '1' || $xx->need_comfirm <= '30'){
                                        if($xx->comfirm == '0'){
                                            $comf = '<a style="color: red">Please Comfirm Rates...!<a/>';
                                        }else{
                                            $comf = '';
                                        }
                                    }else{
                                        $comf = '';                                        
                                    }



                                    if($xx->kadaluarsa <= '7'){
                                        $exp = 'Please Update Rate and Validity...!';
                                    }else{
                                        $exp = '';
                                    }



                                    if ($xx->shipping_term_id == 3){
                                        $trading = "CIF / CFR ";
                                    }else{
                                        $trading = $xx->trading_term_name.' ('.$xx->trading_term_remark.')';
                                    }

                                    

                                    ?>
                                    <td align="center"><b><a style="color: green"><?php echo $exp.' '.$comf; ?></a></b></td>
                                    <td width='6%'><?php echo $xx->container_name ?></td>
                                    <td width='6%'><?php echo $xx->port_name ?></td>
                                    <td width='6%'><?php echo $xx->country_name ?></td>
                                    <td width='6%'><?php echo $trading ?></td>
                                    <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_from)) ?></td>
                                    <td width='6%'><?php echo date('d-m-Y', strtotime($xx->validity_till)) ?></td>
                                    <td width='6%'><?php echo $xx->customer_name ?></td>
                                    <td width='6%'><?php echo $xx->cust_rates ?></td>
                                    <td width='6%' hidden=""><?php echo $xx->freight_charges_id ?></td>
                                </tr>
                            <?php
                                }
                            ?>