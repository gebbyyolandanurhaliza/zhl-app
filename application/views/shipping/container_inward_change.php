<?php foreach ($container as $r){?>
        <tr onclick="deleterow(this)">
            <td
                <?php 
                if ($r->proses != 1){
                    echo '><button class="btn btn-sm btn-danger" type="button" id="btn-delete"><i class="fa fa-trash" ></i></button>';
                    
                } else {
                    echo 'nowrap onclick="event.stopPropagation();return false;">';
                }
                ?>
            </td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 50px;" name="urut[]" value="<?php echo $r->urut; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="po[]" value="<?php echo $r->po_number; ?>" disabled></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="carrier[]" value="<?php echo $r->shipping_liner; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 110px;" name="fcl[]" value="<?php echo $r->container_name; ?>" disabled></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="final[]" value="<?php echo $r->destination; ?>" ></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="reff[]" value="<?php echo $r->reff; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="vessel[]" value="<?php echo $r->vessel; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 150px;" name="convessel[]" value="<?php echo $r->convessel; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><select name="stuffing[]" readonly=""><option><?php echo $r->stuffing; ?></option> 
            <!--    <option value="Export Container">Export Container<option> <option value="Local Container">Local Container<option> -->
            </select></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="depot[]" value="<?php echo $r->depot; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="pod[]" value="<?php echo $r->pod; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 80px;" name="opcode[]" value="<?php echo $r->opcode; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" data-date="02-12-2012" name="etdsin[]" value="<?php echo $r->etdsin; ?>" ></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input ondblclick="fnDialogContainerChange(<?=$r->detail_id;?>, <?php echo "'".$r->container."'"; ?>)" type="text" class="form-control input-sm" style="width: 150px;" name="container[]" value="<?php echo $r->container; ?>" readonly=""></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="seal[]" value="<?php echo $r->seal; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="actual_seal[]" value="<?php echo $r->actual_seal; ?>"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm text-right" style="width: 80px;" name="weight[]" value="<?php echo $r->weight; ?>" onkeypress="return isNumber(event)"></td>
            <td nowrap onclick="event.stopPropagation();return false;"><input type="text" class="form-control input-sm" style="width: 100px;" name="etasin[]" value="<?php echo $r->etasin; ?>" ></td>
            <td hidden><input type="text" class="form-control input-sm" name="shipid[]" value="<?php echo $r->shipid; ?>"></td>
            <td hidden><input type="text" class="form-control input-sm" name="outward[]" value="<?php echo $r->flag; ?>"></td>
            <td hidden><input type="text" class="form-control input-sm" name="id[]" value="<?php echo $r->id; ?>"></td>
      
    </tr>

   <?php } ?>