<div style="padding-top: 10px;" class="load-data">
    <?php if (isset($excel_data)) : ?>
        <form id="form-data">
            <div class="row">
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="vessel" class="">Vessal (Barge)</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" name="vessel" class="txt vessel" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['vessel'] ?>" readonly>
                            <input type="hidden" name="customer" class="txt" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['customer'] ?>" readonly>
                            <input type="hidden" name="tipe" class="txt" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['tipe'] ?>" readonly>
                            <input type="hidden" name="eta" class="txt" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['eta'] ?>" readonly>
                            <input type="hidden" name="etd" class="txt" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['etd'] ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="voyage" class="form-label">Voyage</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="txt" name="voyage" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['voyage'] ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="voyage" class="form-label">ETD <?= $excel_data['dataHeader']['etd'] ?></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="txt" name="etd_date" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['etdDate'] ?>" readonly>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <label for="voyage" class="form-label">ETA <?= $excel_data['dataHeader']['eta'] ?></label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="txt" name="eta_date" style="margin-bottom: 3px;" value="<?= $excel_data['dataHeader']['etaDate'] ?>" readonly>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <h4><strong><?= $excel_data['dataHeader']['customer'] ?></strong></h4>
                    <h4 style="padding-top: 15px;"><strong><?= getInOutward($excel_data['dataHeader']['tipe']) ?></strong></h4>
                    <h4><strong>Shipment Date : <?= setDateFormat($excel_data['dataHeader']['shipmentDate'], 'd F Y') ?></strong></h4>
                    <input type="hidden" name="shipment_date" id="" value="<?= setDateFormat($excel_data['dataHeader']['shipmentDate'], 'Y-m-d') ?>">
                </div>
                <div class="col-md-4" style="text-align: center;">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="voyage" class="form-label">To </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="txt" style="margin-bottom: 3px;" name="to" value="<?= $excel_data['dataHeader']['to'] ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <label for="voyage" class="form-label">From</label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="txt" style="margin-bottom: 3px;" name="from" value="<?= $excel_data['dataHeader']['from'] ?>" readonly>
                        </div>
                    </div>

                </div>

            </div>

            <div class="table-responsive" style="height: 400px;">
                <table class="table table-bordered" id="tabel">
                    <thead>
                        <tr style="position: sticky; top:0px; background-color:darkslategray; color: white">
                            <td>No </td>
                            <td>Shipper / Carrier</td>
                            <td>Vessel / Voyage</td>
                            <td>20'</td>
                            <td>40'</td>
                            <td>CT</td>
                            <td>Seal Number</td>
                            <td>Booking Ref</td>
                            <td>Depot</td>
                            <td>POD</td>
                            <td>Final Dest</td>
                            <td>OP Code</td>
                            <td><?= $excel_data['dataHeader']['tipe'] == 1 ? "Etd" : "Eta" ?> SIN</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($excel_data['detail'] as $item) {

                            if (isset($show)) {
                                $no = $item->urut;
                                $carrier = $item->shipping;
                                $vessel = $item->vessel;
                                $type20 = $item->container_size_20;
                                $type40 = $item->container_size_40;
                                $ct = $item->container_type;
                                $seal_number = $item->seal_number;
                                $booking_ref = $item->reff;
                                $depot = $item->depot;
                                $pod = $item->pod;
                                $final_dest = $item->destination;
                                $op_code = $item->opcode;
                                $eta_sin = $item->eta_sin;
                            } else {

                                // if (isset($item['G'])) {
                                switch ($excel_data['dataHeader']['customer']) {
                                    case 'ZHENGHE LOGISTICS PTE LTD':
                                        $no = $item['A'];
                                        $carrier = $item['B'];
                                        $vessel = $item['C'];
                                        $type20 = $item['D'];
                                        $type40 = $item['E'];
                                        $ct = $item['F'];
                                        $seal_number = null;
                                        $booking_ref = $item['G'];
                                        $depot = $item['H'];
                                        $pod = $item['I'];
                                        $final_dest = $item['J'];
                                        $op_code = $item['K'];
                                        $eta_sin = $item['L'];
                                        break;
                                    case 'Fairteck Holdings Pte Ltd':
                                        $no = $item['B'];
                                        $carrier = $item['C'];
                                        $vessel = $excel_data['dataHeader']['tipe'] == 1 ? $item['G'] : $item['H'];
                                        $type20 = $excel_data['dataHeader']['tipe'] == 1  ? $item['I'] : $item['K'];
                                        $type40 = $excel_data['dataHeader']['tipe'] == 1 ? $item['J'] : $item['M'];
                                        $ct = $excel_data['dataHeader']['tipe'] == 1 ? $item['M'] : $item['N'];
                                        $seal_number = $excel_data['dataHeader']['tipe'] == 1 ? $item['P'] : $item['Q'];
                                        $booking_ref = NULL;
                                        $depot = NULL;
                                        $pod = $excel_data['dataHeader']['tipe'] == 1 ? $item['T'] : $item['S'];
                                        $final_dest = $excel_data['dataHeader']['tipe'] == 1 ? $item['X'] : $item['W'];
                                        $op_code = NULL;
                                        $eta_sin = setDateFormat2($excel_data['dataHeader']['tipe'] == 1 ? $item['H'] : $item['I'], 'Y-m-d');
                                        break;
                                    case 'KARA MARKETING (M) SDN BHD':
                                        $no = $item['A'];
                                        $carrier = $excel_data['dataHeader']['tipe'] == 1 ? $item['B'] : $item['M'];
                                        $vessel = $excel_data['dataHeader']['tipe'] == 1 ? $item['C'] : $item['H'];
                                        $type20 = $excel_data['dataHeader']['tipe'] == 1 ? $item['D'] : $item['E'];
                                        $type40 = $excel_data['dataHeader']['tipe'] == 1 ? $item['E'] : $item['F'];
                                        $ct = $excel_data['dataHeader']['tipe'] == 1 ? $item['F'] : $item['G'];
                                        $seal_number = $excel_data['dataHeader']['tipe'] == 1 ? NULL : $item['D'];
                                        $booking_ref = $excel_data['dataHeader']['tipe'] == 1 ? $item['G'] : $item['N'];
                                        $depot = NULL;
                                        $pod = $excel_data['dataHeader']['tipe'] == 1 ? $item['I'] : $item['J'];
                                        $final_dest = $excel_data['dataHeader']['tipe'] == 1 ? $item['J'] : $item['K'];
                                        $op_code = $excel_data['dataHeader']['tipe'] == 1 ? $item['K'] : $item['L'];
                                        $eta_sin = $excel_data['dataHeader']['tipe'] == 1 ? $item['L'] : NULL;
                                        break;
                                    case 'BEST BONANZA SDN BHD':
                                        $no = $item['A'];
                                        $carrier = $item['B'];
                                        $vessel = $item['D'];
                                        $type20 = $excel_data['dataHeader']['tipe'] == 1 ? $item['G'] : $item['F'];
                                        $type40 = $excel_data['dataHeader']['tipe'] == 1 ? $item['H'] : $item['G'];
                                        $ct = $item['C'];
                                        $seal_number = $item['I'];
                                        $booking_ref = NULL;
                                        $depot = NULL;
                                        $pod = $item['K'];
                                        $final_dest = $item['L'];
                                        $op_code = NULL;
                                        $tanggal_objek = DateTime::createFromFormat('d/m/y', $item['E']);
                                        date_format($tanggal_objek, 'Y-m-d');

                                        $eta_sin = date_format($tanggal_objek, 'Y-m-d');
                                        break;
                                    case 'First Grade Agency Pte Ltd':
                                        $no = $item['B'];
                                        $carrier = $item['C'];
                                        $vessel = $excel_data['dataHeader']['tipe'] == 1 ? $item['G'] : $item['H'];
                                        $type20 = $excel_data['dataHeader']['tipe'] == 1 ? $item['L'] : $item['K'];
                                        $type40 = $excel_data['dataHeader']['tipe'] == 1 ? $item['J'] : $item['M'];
                                        $ct = $excel_data['dataHeader']['tipe'] == 1 ? $item['M'] : $item['N'];
                                        $seal_number = $excel_data['dataHeader']['tipe'] == 1 ? $item['O'] :  $item['Q'];
                                        $booking_ref = $excel_data['dataHeader']['tipe'] == 1 ? $item['P'] : NULL;
                                        $depot = NULL;
                                        $pod = $excel_data['dataHeader']['tipe'] == 1 ? $item['T'] : $item['S'];
                                        $final_dest = $excel_data['dataHeader']['tipe'] == 1 ? $item['X'] : $item['W'];
                                        $op_code = NULL;
                                        $tanggal_objek = DateTime::createFromFormat('d/m/Y', $excel_data['dataHeader']['tipe'] == 1 ? $item['H'] :  $item['I']);
                                        date_format($tanggal_objek, 'Y-m-d');

                                        $eta_sin = date_format($tanggal_objek, 'Y-m-d');
                                        break;
                                }
                            }



                            if ($no > 0) {
                                if ($type20 > 0  || $type40 > 0) {
                                    echo "<tr>";
                                    echo "<td width='50px'><input name='no_urut[]' type='text' id='noUrut' class='txt' style='margin-bottom: 3px;' value='" . $no . "' readonly></td>";
                                    echo "<td width='AUTO'><textarea name='ship[]' class='txt' style='margin-bottom: 3px;' readonly>" . $carrier . "</textarea></td>";
                                    echo "<td width='auto'><input type='text' name='voyage_vessel[]' id='voyage input' class='txt' style='margin-bottom: 3px;' value='" . $vessel . "' readonly></td>";
                                    echo "<td width='40px'><input type='text' name='container_type_20[]' id='voyage input' class='txt' style='margin-bottom: 3px;' value='" . $type20 . "' readonly></td>";
                                    echo "<td width='40px'><input name='container_type_40[]' type='text' id='voyage input' class='txt' style='margin-bottom: 3px;' value='" . $type40 . "' readonly></td>";
                                    echo "<td width='60PX'><input name='ct[]' type='text' id='voyage input' class='txt' style='margin-bottom: 3px;' value='" . $ct . "' readonly></td>";
                                    echo "<td width='200PX'><input name='seal_number[]' type='text' id='voyage input' class='txt' style='margin-bottom: 3px;' value='" . $seal_number . "' readonly></td>";
                                    echo "<td  width='200px'><input type='text' name='booking_ref[]' id='voyage input' class='txt' style='margin-bottom: 3px;' value='" . $booking_ref . "' readonly></td>";
                                    echo "<td width='200px'><input type='text' id='voyage input' name='depot[]' class='txt' style='margin-bottom: 3px;' value='" . $depot . "' readonly></td>";
                                    echo "<td><input type='text' id='voyage input' name='pod[]' class='txt' style='margin-bottom: 3px;' value='" . $pod . "' readonly></td>";
                                    echo "<td><input type='text' id='voyage input' name='final_dest[]' class='txt' style='margin-bottom: 3px;' value='" . $final_dest . "' readonly></td>";
                                    echo "<td><input type='text' id='voyage input' name='op_code[]' class='txt' style='margin-bottom: 3px;' value='" . $op_code . "' readonly></td>";
                                    echo "<td><input type='text' id='voyage input name = 'eta_sin[]' class='txt' style='margin-bottom: 3px;' value='" . setDateFormat($eta_sin, 'd/m/Y') . "' readonly></td>";
                                    echo "</tr>";
                                }
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
            <hr>
            <div>
                <button type="button" class="btn blue btn-save"><i class="fa fa-save"></i> Save</button>
                <button type="button" class="btn btn green btn-print" onclick="downloadExcel('<?= $this->encryption->encrypt($excel_data['dataHeader']['contid']) ?>')" <?= $disabled_button ?>><i class="fa fa-file-excel-o"></i> Excel</button>
                <button type="button" class="btn btn-danger btn-delete" onclick="deleted(<?= $excel_data['dataHeader']['contid'] ?>)" <?= $disabled_button ?>><i class=" fa fa-trash"></i> Delete</button>
                <!-- <button type="submit" class="btn green btn-sm" style="margin-left: 14px;"><i class="fa fa-file-excel-o"></i> Import</button> -->
            </div>
        </form>

    <?php endif; ?>

</div>