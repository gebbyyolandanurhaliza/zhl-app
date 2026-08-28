                                    <?php
                                    if(!empty($_dataparse)){ 

                                        $bukadatasolas = json_decode($_dataparse);

                                        $no = 1;
                                        foreach ($bukadatasolas as $x){?>
                                            <tr>
                                                <td align='center' style='vertical-align: top;'>
                                                    <a class="btn btn-success" id="btn-excel" name="action" target="_blank" href="<?php echo site_url('Solas/PrintSolas?Id='.$x->transID.'&Fac=PSG'); ?>"><i class="fa fa-eye"> View Solas Detail</i></a>
                                                    <a class="btn btn-primary" id="btn-excel" name="action" target="_blank" href="<?php echo site_url('Solas/PrintSolasPDF?Id='.$x->transID.'&Fac=PSG'); ?>"><i class="fa fa-print"> Print Solas</i></a>
                                                </td>
                                                <td align='center' style='vertical-align: top;'><?=$no; ?></td>                        
                                                <td align='center' style='vertical-align: top;'><?=$x->transID; ?></td>
                                                <td align='center' style='vertical-align: top;'><?=$x->doNumber; ?></td>
                                                <td align='center' style='vertical-align: top;'><?=$x->vesselName; ?></td>
                                                <td align='center' style='vertical-align: top;'><?=$x->voyage; ?></td>
                                                <td align='center' style='vertical-align: top;'><?=$x->signedBy; ?></td>
                                                <td align='center' style='vertical-align: top;'><?=$x->signedDate; ?></td>
                                            </tr>
                                    <?php 
                                        
                                    $no++;

                                    } 

                                }
                                
                                ?>