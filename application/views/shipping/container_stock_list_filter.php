							<?php
								$start = 0;
								foreach ($container_number as $country)
								{

							    $awal  = strtotime($country->free_time_expiry);
							    $tempo = time();

							    $count_down = floor(($awal - $tempo) / (86400)) ;
								?>

								<tr>
									<td style="text-align:center" width="100px">
                                                    <a class="btn-sm btn-primary" href="<?php echo site_url('shipping/container_stock_transfer?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure Transfer Container <?php echo $country->container_number; ?> ?')"><i class="fa fa-arrows-h"></i></a>
                                                    <a class="btn-sm" href="<?php echo site_url('shipping/container_stock_return?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure return Container <?php echo $country->container_number; ?> to Singapore?')"><i class="fa fa-refresh"></i></a>
                                                    <a class="btn-sm btn-warning" href="<?php echo site_url('shipping/container_stock_edit?stock='.$country->stock_id_hdr); ?>"><i class="fa fa-pencil"></i></a>
                                                    <a class="btn-sm btn-danger" href="<?php echo site_url('shipping/container_stock_delete?stock='.$country->stock_id_dtl); ?>" onclick="javasciprt: return confirm('Are you sure delete Container <?php echo $country->container_number; ?> ?')"><i class="fa fa-trash"></i></a>
									</td>
									<td class="center"><?php echo ++$start ?></td>
									<td align="center"><?php 
									if($country->status_note=='0'){
										echo "<b style='color : red;'>Stock Ready</b>";
									}else{
										echo "Stock Has Been Used";
									}
									?></td>
									<td align="center"><b><?php echo $count_down ?> Day </b></td>
									<td><?php echo $country->container_number ?></td>
									<td><?php  
									if ($country->container_id=='1'){
										echo "20ft Standard Container (s)";
									}elseif ($country->container_id=='2') {
										echo "20ft Reefer Container (s)";
									}elseif ($country->container_id=='3') {
										echo "40ft Standard Container (s)";
									}elseif ($country->container_id=='4') {
										echo "40ft High Cube Container (s)";
									}elseif ($country->container_id=='5') {
										echo "40ft Reefer Container (s)";
									}elseif ($country->container_id=='6') {
										echo "Loose Cargo";
									}elseif ($country->container_id=='7') {
										echo "40ft High Cube Reefer Container (s)";
									}elseif ($country->container_id=='8') {
										echo "See Remarks";
									}else{
										echo "Bulk shipment";
									}
									?></td>
									<td><?php echo $country->Remark ?></td>
 									<td><?php echo $country->loading_port ?></td>
									<td><?php echo $country->eta ?></td>
									<td><?php echo $country->arrival_date ?></td>
									<td><?php echo $country->free_time ?></td>
									<td><?php 
									if($country->factory=='RSUP'){
										echo "Riau Sakti Unites Plantations";
									}elseif($country->factory=='PSG'){
										echo "Pulau Sambu Guntung";
									}else{
										echo "Insert Factory...!!!";
									}
									?></td>
									<td><?php echo $country->supplier ?></td>
									<td><?php echo $country->import_bl_no ?></td>
									<td><?php echo $country->free_time_expiry ?></td>
 								</tr>
							<?php
								}
							?>