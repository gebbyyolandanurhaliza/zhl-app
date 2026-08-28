<?php
    if (isset($dtl)) {
    foreach ($dtl as $val) { ?>
        <tr>
        <td>
            <?php
            $disable = "disabled";
            if ($val->status != 'Complete') {
            $disable = "";
            echo '<button class="btn red" onclick="hapus_baris(this,event)" data-id="' . $val->id_job_dtl . '" ><i class="fa fa-trash"></i></button>';
            }else{
            echo '<button class="btn btn-warning" onclick="restore_baris(this,event)" data-id="' . $val->id_job_dtl . '" title="Restore Data" ><i class="fa fa-refresh"></i></button>';
            }
            ?>
            <input type="hidden" name="id_job_dtl[]" value="<?= $val->id_job_dtl ?>" class="id_job_dtl txt" <?= $disable ?> required>
        </td>
        <td>
            <select name="client_id[]" class="form-control clients select2" <?= $disable ?> required>
            <option value="">Choose </option>
            <?php
            foreach ($customers as $cus) { ?>
                <option value="<?= $cus->customer_code ?>" <?= $cus->customer_code == $val->client_id ? 'selected' : '' ?>><?= $cus->customer_name ?></option>
            <?php
            }
            ?>
            </select>
        </td>
        <td>
            <select name="status_cont[]" class="form-control select2">
            <option value="">Choose Status</option>
            <option value="Laden" <?= $val->status_cont == "Laden" ? 'selected' : '' ?>>Laden</option>
            <option value="Empty" <?= $val->status_cont == "Empty" ? 'selected' : '' ?>>Empty</option>
            </select>
        </td>
        <td>
            <input type="text" name="job[]" value="<?= $val->job ?>" class="form-control job txt" <?= $disable ?> placeholder="Input Job Here" required>
        </td>
        <td>
            <select name="id_vehicle[]" class="form-control select2" <?= $disable ?> required>
            <option value="">Choose Vehicle</option>
            <?php
            foreach ($vehicle as $ve) { ?>
                <option value="<?= $ve->id_vehicle ?>" <?= $ve->id_vehicle == $val->id_vehicle ? 'selected' : '' ?>><?= $ve->vehicle_no . "(" . $ve->driver_name . ")" ?></option>
            <?php
            }
            ?>
            </select>
        </td>
        <td>
            <input type="time" name="time[]" value="<?= $val->time ?>" class="form-control time txt" <?= $disable ?> required>
        </td>
        <td>
            <input type="text" name="send_to[]" value="<?= $val->send_to ?>" class="form-control send_to txt" <?= $disable ?> placeholder="Input Send To" required>
        </td>
        </tr>
    <?php
    }
    }
    ?>